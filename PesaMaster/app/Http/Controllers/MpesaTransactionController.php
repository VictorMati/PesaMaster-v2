<?php

namespace App\Http\Controllers;

use App\Models\MpesaTransaction;
use App\Models\Transaction;
use App\Services\MpesaService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MpesaTransactionController extends Controller
{
    protected $mpesaService;

    public function __construct(MpesaService $mpesaService)
    {
        $this->mpesaService = $mpesaService;
    }

    /**
     * Initiate STK Push to customer's phone
     */

     public function stkPush(Request $request)
     {
         // In MpesaTransactionController.php
            $validated = $request->validate([
                'phone' => [
                    'required',
                    'regex:/^254[1]\d{8}$/' // Allow 2547... and 2541... numbers
                ],
                'amount' => 'required|numeric|min:1|max:150000',
                'transaction_id' => 'required|exists:transactions,id'
            ]);

         try {
             $transaction = Transaction::findOrFail($validated['transaction_id']);

             if ($transaction->user_id != Auth::id()) {
                 return back()->with('error', 'Unauthorized action');
             }

             $response = $this->mpesaService->stkPushRequest(
                 $validated['amount'],
                 $validated['phone'],
                 $validated['transaction_id'],
                 $transaction->description ?? 'Payment for services'
             );

             // Handle service-level errors
             if (isset($response['error'])) {
                 Log::error('MPESA Service Error', ['response' => $response]);
                 return back()->with('error', $response['error']);
             }

             // Handle API response errors
             if (!isset($response['ResponseCode']) || $response['ResponseCode'] != '0') {
                 $errorMessage = $response['errorMessage'] ??
                                 $response['ResultDesc'] ??
                                 'Payment initiation failed';

                 Log::error('MPESA STK Error', ['response' => $response]);
                 return back()->with('error', $errorMessage);
             }

             // Create M-Pesa transaction record
             MpesaTransaction::create([
                 'transaction_id' => $validated['transaction_id'],
                 'merchant_request_id' => $response['MerchantRequestID'],
                 'checkout_request_id' => $response['CheckoutRequestID'],
                 'phone_number' => $validated['phone'],
                 'amount' => $validated['amount'],
                 'status' => 'pending'
             ]);

             return back()->with('success', 'Payment request sent. Check your phone to complete.');

         } catch (\Exception $e) {
             Log::error('STK Push Exception', ['error' => $e->getMessage()]);
             return back()->with('error', 'Service temporarily unavailable. Please try again.');
         }
     }
    /**
     * Process M-Pesa callback
     */
    public function mpesaCallback(Request $request)
    {

        // Verify the callback origin
        if (config('services.mpesa.env') === 'production') {
            $ip = $request->ip();
            if (!in_array($ip, ['196.201.214.200', '196.201.214.206'])) {
                Log::warning('Invalid MPesa Callback IP', ['ip' => $ip]);
                abort(403, 'Unauthorized');
            }
        }
        Log::info('MPESA Callback Received', $request->all());

        try {
            $result = $this->mpesaService->processCallback($request->all());

            if (!$result['success']) {
                Log::error('M-Pesa Callback Processing Error', $result);
                return response()->json(['status' => 'error', 'message' => $result['message'] ?? 'Processing error'], 400);
            }

            // Find the M-Pesa transaction
            $mpesaTransaction = MpesaTransaction::where('checkout_request_id', $result['checkout_request_id'])->first();

            if (!$mpesaTransaction) {
                Log::error('M-Pesa Transaction Not Found', ['checkout_request_id' => $result['checkout_request_id']]);
                return response()->json(['status' => 'error', 'message' => 'Transaction not found'], 404);
            }

            // Update M-Pesa transaction
            $mpesaTransaction->update([
                'result_code' => 0, // Success
                'result_desc' => $result['result_desc'],
                'mpesa_receipt_number' => $result['payment_details']['receipt_number'] ?? null,
                'status' => 'completed',
                'response_data' => json_encode($request->all())
            ]);

            // Update related transaction
            $transaction = Transaction::findOrFail($mpesaTransaction->transaction_id);
            $transaction->update([
                'status' => 'completed',
                'transaction_date' => now()
            ]);

            // Send SMS notification if enabled
            if (config('services.africas_talking.enabled')) {
                $this->sendSms(
                    $mpesaTransaction->phone_number,
                    "Payment of KES {$transaction->amount} received successfully!"
                );
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Callback Handling Error', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    /**
     * Send SMS notification
     */
    protected function sendSms($phone, $message)
    {
        try {
            $response = Http::withHeaders([
                'apiKey' => config('services.africas_talking.api_key'),
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Accept' => 'application/json'
            ])->asForm()->post('https://api.africasTalking.com/version1/messaging', [
                'username' => config('services.africas_talking.username'),
                'to' => $phone,
                'message' => $message,
                'from' => config('app.name')
            ]);

            if (!$response->successful()) {
                Log::error('SMS Send Failed', ['response' => $response->json()]);
            }

            return $response->successful();

        } catch (\Exception $e) {
            Log::error('SMS Send Exception', ['error' => $e->getMessage()]);
            return false;
        }
    }
}
