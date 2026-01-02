<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MpesaService
{
    private $baseUrl;
    private $consumerKey;
    private $consumerSecret;
    private $passkey;
    private $shortcode;

    public function __construct()
    {
        $this->baseUrl = config('services.mpesa.env') === 'sandbox'
            ? 'https://sandbox.safaricom.co.ke'
            : 'https://api.safaricom.co.ke';

        $this->consumerKey = config('services.mpesa.consumer_key');
        $this->consumerSecret = config('services.mpesa.consumer_secret');
        $this->passkey = config('services.mpesa.passkey');
        $this->shortcode = config('services.mpesa.shortcode');
    }

    /**
     * Get M-Pesa API access token
     *
     * @return string|null
     */
    public function getAccessToken()
    {
        try {
            $response = Http::withBasicAuth($this->consumerKey, $this->consumerSecret)
                ->get($this->baseUrl . '/oauth/v1/generate?grant_type=client_credentials');

            if (!$response->successful()) {
                Log::error('M-Pesa Auth Failed', ['response' => $response->body()]);
                return null;
            }

            return $response->json()['access_token'] ?? null;
        } catch (\Exception $e) {
            Log::error('M-Pesa Auth Exception', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Initiate STK Push request
     *
     * @param float $amount
     * @param string $phone
     * @param string $transactionId
     * @param string $description
     * @return array
     */
    public function stkPushRequest($amount, $phone, $transactionId, $description = 'Payment for services')
{
    try {
        $accessToken = $this->getAccessToken();
        if (!$accessToken) {
            return ['error' => 'Unable to authenticate with MPesa service'];
        }

        $timestamp = now()->format('YmdHis');
        $password = base64_encode($this->shortcode . $this->passkey . $timestamp);

        $response = Http::withToken($accessToken)
            ->timeout(30)
            ->retry(3, 100)
            ->post($this->baseUrl . '/mpesa/stkpush/v1/processrequest', [
                'BusinessShortCode' => $this->shortcode,
                'Password' => $password,
                'Timestamp' => $timestamp,
                'TransactionType' => 'CustomerPayBillOnline',
                'Amount' => $amount,
                'PartyA' => $phone,
                'PartyB' => $this->shortcode,
                'PhoneNumber' => $phone,
                'CallBackURL' => route('mpesa.callback'),
                'AccountReference' => 'Transaction#' . $transactionId,
                'TransactionDesc' => $description
            ]);

        $responseData = $response->json();

        if (!$response->successful()) {
            Log::error('MPESA STK Push Failed', [
                'status' => $response->status(),
                'response' => $responseData
            ]);

            return [
                'error' => $responseData['errorMessage'] ??
                          $responseData['ResultDesc'] ??
                          'MPesa service unavailable'
            ];
        }

        return $responseData;

    } catch (\Exception $e) {
        Log::error('MPESA STK Push Exception', ['error' => $e->getMessage()]);
        return ['error' => 'Failed to process payment request'];
    }
}

    /**
     * Process M-Pesa callback data
     *
     * @param array $callbackData
     * @return array
     */
    public function processCallback($callbackData)
    {
        try {
            if (!isset($callbackData['Body']['stkCallback'])) {
                return [
                    'success' => false,
                    'message' => 'Invalid callback format'
                ];
            }

            $stkCallback = $callbackData['Body']['stkCallback'];
            $resultCode = $stkCallback['ResultCode'];
            $checkoutRequestId = $stkCallback['CheckoutRequestID'];
            $resultDesc = $stkCallback['ResultDesc'];

            // Process successful transaction
            if ($resultCode == 0) {
                // Extract payment details from callback metadata
                $callbackMetadata = $stkCallback['CallbackMetadata']['Item'];
                $paymentDetails = [];

                foreach ($callbackMetadata as $item) {
                    if ($item['Name'] == 'Amount') {
                        $paymentDetails['amount'] = $item['Value'];
                    } elseif ($item['Name'] == 'MpesaReceiptNumber') {
                        $paymentDetails['receipt_number'] = $item['Value'];
                    } elseif ($item['Name'] == 'TransactionDate') {
                        $paymentDetails['transaction_date'] = $item['Value'];
                    } elseif ($item['Name'] == 'PhoneNumber') {
                        $paymentDetails['phone_number'] = $item['Value'];
                    }
                }

                return [
                    'success' => true,
                    'checkout_request_id' => $checkoutRequestId,
                    'result_desc' => $resultDesc,
                    'payment_details' => $paymentDetails
                ];
            }

            // Failed transaction
            return [
                'success' => false,
                'checkout_request_id' => $checkoutRequestId,
                'result_code' => $resultCode,
                'result_desc' => $resultDesc
            ];
        } catch (\Exception $e) {
            Log::error('M-Pesa Callback Processing Exception', ['error' => $e->getMessage()]);
            return [
                'success' => false,
                'message' => 'Exception processing callback: ' . $e->getMessage()
            ];
        }
    }
}
