<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\MailSetting;
use Illuminate\Http\Request;

class MailSettingController extends Controller
{
    public function index()
    {
        $settings = MailSetting::first();

        if (!$settings) {
            $settings = new MailSetting();
        }

        return view('admin.project-settings.mail', compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'mail_host' => 'required|string|max:50',
            'mail_port' => 'required|digits_between:1,5',
            'mail_username' => 'required|string|max:50',
            'mail_password' => 'required|string|min:14|max:20',
            'mail_encryption' => 'required|string|max:50',
            'mail_from_address' => 'required|email|max:50',
            'mail_from_name' => 'required|string|max:30',
        ]);

        $settings = MailSetting::first();

        if (!$settings) {
            $settings = new MailSetting();
        }

        $settings->mail_host = $request->mail_host;
        $settings->mail_port = $request->mail_port;
        $settings->mail_username = $request->mail_username;

        if ($request->filled('mail_password')) {
            $settings->mail_password = $request->mail_password;
        }

        $settings->mail_encryption = $request->mail_encryption;
        $settings->mail_from_address = $request->mail_from_address;
        $settings->mail_from_name = $request->mail_from_name;

        $settings->save();

        return redirect()
            ->route('admin.settings.mail')
            ->with('success', 'Mail settings updated successfully.');
    }

    public function testEmail(Request $request)
    {
        $request->validate([
            'test_email' => 'required|email',
        ]);

        $settings = MailSetting::first();

        if (!$settings) {
            return back()->with('error', 'Please save email settings first.');
        }

        try {
            config([
                'mail.default' => 'smtp',
                'mail.mailers.smtp.transport' => 'smtp',
                'mail.mailers.smtp.host' => $settings->mail_host,
                'mail.mailers.smtp.port' => $settings->mail_port,
                'mail.mailers.smtp.username' => $settings->mail_username,
                'mail.mailers.smtp.password' => $settings->mail_password,
                'mail.mailers.smtp.encryption' => $settings->mail_encryption,
                'mail.mailers.smtp.timeout' => 5,
                'mail.from.address' => $settings->mail_from_address,
                'mail.from.name' => $settings->mail_from_name,
            ]);

            \Illuminate\Support\Facades\Mail::purge('smtp');

            \Illuminate\Support\Facades\Mail::to($request->test_email)
                ->send(new \App\Mail\TestMail($settings->mail_from_name));

            return back()->with('success', 'Test email sent successfully.');
        } catch (\Throwable $e) {
            return back()->with('error', 'Test email failed: ' . $e->getMessage());
        }
    }

}