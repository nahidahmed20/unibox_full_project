<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('backend.setting.index', compact('settings'));
    }

    public function save(Request $request)
    {
        $fileKeys = ['header_logo', 'footer_logo', 'favicon', 'nav_icon'];

        foreach ($request->except('_token') as $key => $input) {

            if (in_array($key, $fileKeys) && !$request->hasFile($key)) {
                continue;
            }

            $value = $input;

            if ($request->hasFile($key)) {

                $file = $request->file($key);
                $fileName = time().'_'.$file->getClientOriginalName();
                $file->move(public_path('uploads/settings'), $fileName);

                $value = 'uploads/settings/'.$fileName;

                $old = Setting::where('key', $key)->first();

                if ($old && $old->value) {
                    $oldPath = public_path($old->value);

                    // 🔐 SAFE CHECK
                    if (file_exists($oldPath) && is_file($oldPath)) {
                        unlink($oldPath);
                    }
                }
            }

            Setting::updateOrCreate(
                ['key' => $key],
                ['value' => $value]
            );

            // Synchronize legacy aliases so old views never break
            if ($key === 'header_logo') {
                Setting::updateOrCreate(['key' => 'logo'], ['value' => $value]);
            }
            if ($key === 'favicon') {
                Setting::updateOrCreate(['key' => 'nav_icon'], ['value' => $value]);
            }
        }

        // Clear settings cache if any
        if (function_exists('cache')) {
            cache()->forget('unibox_global_settings');
        }

        return back()->with('success', 'Settings updated successfully!');
    }

    // Get setting
    public function get($key)
    {
        $setting = Setting::where('key', $key)->first();

        return $setting ? $setting->value : null;
    }
}
