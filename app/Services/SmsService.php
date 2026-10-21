<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    public static function send($number, $message, &$errorMessage = null)
    {
        try {
            if (strpos($number, '0') === 0) {
                $number = '88'.$number;
            }

            $url = setting('sms_url') ?: config('services.sms.url') ?: env('SMS_API_URL') ?: 'https://bulksmsbd.net/api/smsapi';
            $apiKey = setting('sms_api_key') ?: config('services.sms.key') ?: env('SMS_API_KEY') ?: env('BULKSMSBD_API_KEY');
            $senderId = setting('sms_sender_id') ?: config('services.sms.sender') ?: env('SMS_SENDER_ID') ?: env('BULKSMSBD_SENDER_ID');

            if (! $url || ! $apiKey) {
                $errorMessage = 'Missing SMS API URL or API Key in settings/env.';
                Log::warning('SMS gateway skipped: ' . $errorMessage . ' Target: ' . $number);
                return false;
            }

            $response = Http::timeout(15)->get($url, [
                'api_key' => $apiKey,
                'senderid' => $senderId,
                'type' => 'text',
                'number' => $number,
                'message' => $message,
            ]);

            if ($response->successful()) {
                $data = $response->json();
                if (is_array($data) && isset($data['response_code'])) {
                    $code = (int) $data['response_code'];
                    if ($code === 200 || $code === 1000) {
                        return true;
                    }
                    $errorMessage = $data['error_message'] ?? ('Gateway response code ' . $code);
                    Log::error('SMS Gateway rejected message: ' . $errorMessage, ['code' => $code, 'target' => $number]);
                    return false;
                }
                return true;
            }

            $errorMessage = 'HTTP ' . $response->status();
            Log::error('SMS gateway request failed.', ['status' => $response->status(), 'body' => $response->body()]);

            return false;

        } catch (\Exception $e) {
            $errorMessage = $e->getMessage();
            Log::error('SMS gateway connection failed: ' . $errorMessage);

            return false;
        }
    }
}
