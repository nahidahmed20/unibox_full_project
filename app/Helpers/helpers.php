<?php

use App\Models\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

if (! function_exists('setting')) {
    /**
     * Get setting value by key
     *
     * @param  string  $key
     * @param  mixed  $default
     * @return mixed
     */
    function setting($key, $default = null, $fresh = false)
    {
        static $settings = null;

        if ($settings === null || $fresh) {
            $settings = Setting::pluck('value', 'key')->toArray();
        }

        $val = $settings[$key] ?? null;

        if (($val === null || $val === '') && $default !== null) {
            return $default;
        }

        return $val;
    }

    function getColorStock($productId, $colorId)
    {
        return DB::table('purchase_details')
            ->where('product_id', $productId)
            ->where('color_id', $colorId)
            ->sum('quantity');
    }

    if (! function_exists('sendSms')) {
        function sendSms($phone, $message)
        {
            $err = null;
            $sent = \App\Services\SmsService::send($phone, $message, $err);

            return [
                'success' => $sent,
                'response' => $sent ? 'Sent successfully' : ($err ?? 'Failed to send SMS'),
            ];
        }
    }
}
