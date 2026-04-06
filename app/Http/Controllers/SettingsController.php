<?php

namespace App\Http\Controllers;

use App\Models\UserSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingsController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        $settings = UserSetting::firstOrCreate(
            ['user_id' => $user->id],
            [
                'email_notifications' => true,
                'push_notifications' => true,
                'sms_alerts' => false,
                'digest_frequency' => 'Daily Summary',
                'text_size' => 100,
                'high_contrast' => false,
                'reduce_motion' => true,
            ]
        );

        return view('pages.settings', compact('settings'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'digest_frequency' => 'required|string',
            'text_size' => 'required|integer|min:80|max:150',
        ]);

        UserSetting::updateOrCreate(
            ['user_id' => $user->id],
            [
                'email_notifications' => $request->has('email_notifications'),
                'push_notifications' => $request->has('push_notifications'),
                'sms_alerts' => $request->has('sms_alerts'),
                'digest_frequency' => $request->digest_frequency,
                'text_size' => $request->text_size,
                'high_contrast' => $request->has('high_contrast'),
                'reduce_motion' => $request->has('reduce_motion'),
            ]
        );

        return redirect()->route('settings')->with('success', 'Settings updated successfully.');
    }
}