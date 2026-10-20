<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SmsService
{
    public static function send($number, $message)
    {
        try {
            if (strpos($number, '0') === 0) {
                $number = '88'.$number;
            }

            $url = setting('sms_url') ?: config('services.sms.url');
            $apiKey = setting('sms_api_key') ?: config('services.sms.key');
            $senderId = setting('sms_sender_id') ?: config('services.sms.sender');

            if (! $url || ! $apiKey) {
                Log::info('SMS gateway skipped: Missing SMS API URL or API Key in settings/config.');
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
                return true;
            }

            Log::error('SMS gateway request failed.', ['status' => $response->status(), 'body' => $response->body()]);

            return false;

        } catch (\Exception $e) {
            Log::error('SMS gateway connection failed: ' . $e->getMessage());

            return false;
        }
    }
}
