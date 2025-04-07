<?php

namespace App\Http\Controllers;

use App\Models\MpesaTransaction;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MpesaTransactionController extends Controller
{
    protected $consumerKey;
    protected $consumerSecret;
    protected $shortcode;
    protected $passkey;
    protected $atUsername;
    protected $atApiKey;

    public function __construct()
    {
        $this->consumerKey = config('services.mpesa.consumer_key');
        $this->consumerSecret = config('services.mpesa.consumer_secret');
        $this->shortcode = config('services.mpesa.shortcode');
        $this->passkey = config('services.mpesa.passkey');
        $this->atUsername = config('services.africas_talking.username');
        $this->atApiKey = config('services.africas_talking.api_key');
    }

    private function getAccessToken()
    {
        try {
            $response = Http::withBasicAuth($this->consumerKey, $this->consumerSecret)
                ->get(config('services.mpesa.auth_url'));

            if (!$response->successful()) {
                Log::error('MPESA Auth Failed', ['response' => $response->body()]);
                return null;
            }

            return $response->json()['access_token'];
        } catch (\Exception $e) {
            Log::error('MPESA Auth Exception', ['error' => $e->getMessage()]);
            return null;
        }
    }

    public function stkPush(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|regex:/^0[1]\d{8}$/', // Validate Kenyan phone numbers
            'amount' => 'required|numeric|min:1|max:150000', // MPESA limit
            'transaction_id' => 'required|exists:transactions,id'
        ]);

        try {
            $accessToken = $this->getAccessToken();
            if (!$accessToken) {
                return back()->with('error', 'Payment service unavailable. Please try later.');
            }

            $timestamp = now()->format('YmdHis');
            $password = base64_encode($this->shortcode . $this->passkey . $timestamp);
            $phone = '254' . substr($validated['phone'], 1);

            $payload = [
                'BusinessShortCode' => $this->shortcode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount' => $validated['amount'],
                'PartyA' => $phone,
                'PartyB' => $this->shortcode,
                'PhoneNumber' => $phone,
                'CallBackURL' => route('mpesa.callback'),
                'AccountReference' => 'Transaction#' . $validated['transaction_id'],
                'TransactionDesc' => 'Payment for services',
                'CallBackURL' => route('mpesa.callback'),
            ];

            $response = Http::withToken($accessToken)
                ->timeout(30)
                ->retry(3, 100)
                ->post(config('services.mpesa.stk_push_url'), $payload);

            $responseData = $response->json();

            if ($response->successful() && isset($responseData['ResponseCode']) && $responseData['ResponseCode'] == '0') {
                MpesaTransaction::create([
                    'transaction_id' => $validated['transaction_id'],
                    'merchant_request_id' => $responseData['MerchantRequestID'],
                    'checkout_request_id' => $responseData['CheckoutRequestID'],
                    'phone_number' => $phone,
                    'amount' => $validated['amount'],
                    'status' => 'pending'
                ]);

                return back()->with('success', 'Payment request sent. Check your phone to complete.');
            }

            Log::error('MPESA STK Error', ['response' => $responseData]);
            return back()->with('error', $responseData['errorMessage'] ?? 'Payment initiation failed.');

        } catch (\Exception $e) {
            Log::error('STK Push Exception', ['error' => $e->getMessage()]);
            return back()->with('error', 'Service temporarily unavailable. Please try again.');
        }
    }

    public function mpesaCallback(Request $request)
    {
        Log::info('MPESA Callback Received', $request->all());

        try {

            $callbackData = $request->input('Body.stkCallback');

            if (!isset($callbackData['CheckoutRequestID'])) {
                throw new \Exception('Invalid callback format');
            }

            $mpesaTransaction = MpesaTransaction::where('checkout_request_id', $callbackData['CheckoutRequestID'])
                ->firstOrFail();

            $resultCode = $callbackData['ResultCode'];
            $success = $resultCode == 0;
            $status = $success ? 'completed' : 'failed';

            // Update MPESA transaction
            $mpesaTransaction->update([
                'result_code' => $resultCode,
                'result_desc' => $callbackData['ResultDesc'],
                'status' => $status,
                'response_data' => json_encode($callbackData)
            ]);

            // Update related transaction
            $transaction = Transaction::findOrFail($mpesaTransaction->transaction_id);
            $transaction->update(['status' => $status]);

            // Send SMS notification
            if (config('services.africas_talking.enabled')) {
                $message = $success ? "Payment of KES {$transaction->amount} received successfully!"
                                  : "Payment failed. Please try again.";
                $this->sendSms($mpesaTransaction->phone_number, $message);
            }

            return response()->json(['status' => 'success']);

        } catch (\Exception $e) {
            Log::error('Callback Handling Error', ['error' => $e->getMessage()]);
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 400);
        }
    }

    protected function sendSms($phone, $message)
    {
        try {
            $response = Http::withHeaders([
                'apiKey' => $this->atApiKey,
                'Content-Type' => 'application/x-www-form-urlencoded',
                'Accept' => 'application/json'
            ])->asForm()->post('https://api.africasTalking.com/version1/messaging', [
                'username' => $this->atUsername,
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
