<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminAuthController extends Controller
{
    public function showLogin()
    {
        return view('admin.login');
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => ['required', 'email'],
            'code' => ['required', 'string'],
        ], [], [
            'email' => 'البريد الإلكتروني',
            'code' => 'الكود السري',
        ]);

        $expectedEmail = config('goldenperfume.admin_email');
        $expectedCode = config('goldenperfume.admin_code');
        $extraEmails = config('goldenperfume.admin_emails');

        $allowedEmails = [];
        if (is_string($expectedEmail) && $expectedEmail !== '') {
            $allowedEmails[] = $expectedEmail;
        }
        if (is_string($extraEmails) && $extraEmails !== '') {
            foreach (explode(',', $extraEmails) as $email) {
                $email = trim($email);
                if ($email !== '') {
                    $allowedEmails[] = $email;
                }
            }
        }

        if (empty($allowedEmails) || !is_string($expectedCode) || $expectedCode === '') {
            return back()->withErrors([
                'email' => 'إعدادات الأدمن غير مكتملة. تأكد من ضبط ADMIN_EMAIL أو ADMIN_EMAILS مع ADMIN_CODE.',
            ])->withInput(['email' => $validated['email']]);
        }

        $codeMatches = hash_equals((string) $expectedCode, (string) $validated['code']);

        if (!in_array($validated['email'], $allowedEmails, true) || !$codeMatches) {
            return back()->withErrors([
                'email' => 'بيانات الدخول غير صحيحة.',
            ])->withInput(['email' => $validated['email']]);
        }

        $request->session()->put('is_admin', true);

        return redirect()->route('admin')->with('success', 'تم تسجيل الدخول كأدمن.');
    }

    public function logout(Request $request)
    {
        $request->session()->forget('is_admin');
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home')->with('success', 'تم تسجيل الخروج من لوحة الإدارة. ستحتاج لإعادة تسجيل الدخول عند دخول لوحة الأدمن مرة أخرى.');
    }
}
