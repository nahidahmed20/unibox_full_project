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

            if (! config('services.sms.url') || ! config('services.sms.key')) {
                return false;
            }
            $response = Http::timeout(15)->get(config('services.sms.url'), [
                'api_key' => config('services.sms.key'),
                'senderid' => config('services.sms.sender'),
                'type' => 'text',
                'number' => $number,
                'message' => $message,
            ]);

            if ($response->successful()) {
                return true;
            }

            Log::error('SMS gateway request failed.', ['status' => $response->status()]);

            return false;

        } catch (\Exception $e) {
            Log::error('SMS gateway connection failed.');

            return false;
        }
    }
}
