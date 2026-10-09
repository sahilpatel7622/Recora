<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Illuminate\View\View;
use Throwable;
use App\Models\Notification;

class AuthController extends Controller
{
    public function showLogin(): \Illuminate\View\View|\Illuminate\Http\RedirectResponse|\Illuminate\Http\Response
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user());
        }

        return response()->view('auth.login')->withHeaders([
            'Cache-Control' => 'no-cache, no-store, must-revalidate',
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }

    public function login(LoginRequest $request): RedirectResponse
    {
        $credentials = [
            'email' => $request->string('email')->toString(),
            'password' => $request->password,
        ];

        $remember = $request->boolean('remember');

        if (! Auth::attempt($credentials, $remember)) {
            return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors([
                    'email' => 'Email address or password is incorrect.',
                ]);
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if (! $user || $user->role !== 'admin') {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors([
                    'email' => 'Email address or password is incorrect.',
                ]);
        }

        if (! $user->status) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return back()
                ->withInput($request->only('email', 'remember'))
                ->withErrors([
                    'email' => 'Your account is inactive. Please contact the administrator.',
                ]);
        }

        $parsed = $this->parseUserAgent((string) $request->userAgent(), (string) ($request->input('client_device') ?: $request->header('sec-ch-ua-model')));

        DB::table('users')->where('id', $user->id)->update([
            'last_login_time' => now(),
            'ip_address' => $request->ip(),
            'device' => $parsed['device'],
            'browser' => $parsed['browser'],
        ]);

        if ($user->role !== 'admin') {
            Notification::create([
                'user_id' => $user->id,
                'title' => 'User Login',
                'message' => $user->name . ' logged into the system.',
                'type' => 'login',
                'is_read' => false,
            ]);
        }

        if ($remember) {
            Cookie::queue('login_email', $credentials['email'], 60 * 24 * 30);
            Cookie::queue('login_password', $credentials['password'], 60 * 24 * 30);
        } else {
            Cookie::queue(Cookie::forget('login_email'));
            Cookie::queue(Cookie::forget('login_password'));
        }

        return $this->redirectByRole($user)->with('success', 'You have been logged in successfully.');
    }

    public function logout(Request $request): RedirectResponse
    {
        $user = Auth::user();

        if ($user && $user->role !== 'admin') {
            Notification::create([
                'user_id' => $user->id,
                'title' => 'User Logout',
                'message' => $user->name . ' logged out of the system.',
                'type' => 'logout',
                'is_read' => false,
            ]);
        }

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('success', 'You have been logged out successfully.')
            ->withHeaders([
                'Cache-Control' => 'no-cache, no-store, must-revalidate',
                'Pragma' => 'no-cache',
                'Expires' => '0',
            ]);
    }

    private function redirectByRole(User $user): RedirectResponse
    {
        if ($user->role === 'admin') {
            session(['admin_name' => $user->name]);

            return redirect()->route('admin.dashboard');
        }

        if ($user->role === 'user') {
            return redirect()->route('dashboard');
        }

        return $this->logoutUnknownRole();
    }

    private function logoutUnknownRole(): RedirectResponse
    {
        Auth::logout();

        request()->session()->invalidate();
        request()->session()->regenerateToken();

        return redirect()
            ->route('login')
            ->with('error', 'Invalid account role. Please contact the administrator.');
    }

    private function parseUserAgent(?string $userAgent, ?string $clientModel = null): array
    {
        $userAgent = (string) $userAgent;
        $clientModel = trim(str_replace('"', '', (string) $clientModel));

        if (class_exists(\Jenssegers\Agent\Agent::class)) {
            $agent = new \Jenssegers\Agent\Agent();
            $agent->setUserAgent($userAgent);

            // 1. Detect Browser & Version
            $browserName = $agent->browser() ?: 'Unknown Browser';
            $browserVersion = $agent->version($browserName);
            if ($browserVersion) {
                $parts = explode('.', $browserVersion);
                $shortVersion = count($parts) >= 2 ? $parts[0] . '.' . $parts[1] : $browserVersion;
                $browser = $browserName . ' ' . $shortVersion;
            } else {
                $browser = $browserName;
            }

            // 2. Detect OS / Platform
            $platform = $agent->platform() ?: 'Unknown OS';
            $platformVersion = $agent->version($platform);
            $osString = trim($platform . ' ' . ($platformVersion ?: ''));

            // 3. Detect Full Device Name & Type
            $deviceModel = $agent->device() ?: '';
            $type = 'Desktop';

            if ($agent->isTablet()) {
                $type = 'Tablet';
            } elseif ($agent->isMobile() || $agent->isPhone()) {
                $type = 'Mobile';
            }

            $brandName = $this->detectMobileBrand($clientModel, $deviceModel . ' ' . $userAgent);

            $genericModels = ['k', 'wv', 'build', 'linux', 'android', 'webkit', 'normal', 'unknown', 'desktop', 'general mobile device', 'general tablet device', 'generic'];

            if ($brandName) {
                $device = trim("{$brandName} / {$type} ({$osString})");
            } elseif ($deviceModel && !in_array(strtolower($deviceModel), $genericModels)) {
                $device = trim("{$deviceModel} / {$type} ({$osString})");
            } else {
                if ($agent->isAndroidOS() || stripos($userAgent, 'Android') !== false) {
                    $device = "Android Smartphone / Mobile ({$osString})";
                } elseif (stripos($userAgent, 'iPhone') !== false) {
                    $device = "Apple iPhone / Mobile ({$osString})";
                } elseif (stripos($userAgent, 'iPad') !== false) {
                    $device = "Apple iPad / Tablet ({$osString})";
                } elseif (stripos($userAgent, 'Macintosh') !== false) {
                    $device = "Apple Mac / Desktop ({$osString})";
                } elseif (stripos($userAgent, 'Windows NT 10.0') !== false) {
                    $device = "Windows 10/11 PC / Desktop";
                } elseif (stripos($userAgent, 'Windows') !== false) {
                    $device = "Windows PC / Desktop";
                } else {
                    $device = "{$osString} / {$type}";
                }
            }

            return [
                'browser' => trim($browser),
                'device' => trim($device),
            ];
        }

        // Fallback if package is not available
        return [
            'browser' => 'Chrome 132.0',
            'device' => 'Windows 10/11 PC / Desktop',
        ];
    }

    private function detectMobileBrand(?string $clientModel, ?string $rawInfo): ?string
    {
        $testString = trim($clientModel . ' ' . $rawInfo);

        if (stripos($testString, 'iPhone') !== false) {
            return 'Apple iPhone';
        }
        if (stripos($testString, 'iPad') !== false) {
            return 'Apple iPad';
        }
        if (stripos($testString, 'Samsung') !== false || stripos($testString, 'Galaxy') !== false || preg_match('/\b(SM-[A-Z0-9]+|GT-[A-Z0-9]+|SGH-[A-Z0-9]+|SCH-[A-Z0-9]+)\b/i', $testString, $m)) {
            $model = !empty($m[1]) ? ' ' . $m[1] : (!empty($clientModel) ? ' (' . $clientModel . ')' : '');
            return 'Samsung Galaxy' . $model;
        }
        if (stripos($testString, 'Redmi') !== false || stripos($testString, 'Xiaomi') !== false || stripos($testString, 'Poco') !== false || stripos($testString, 'Mi ') !== false || preg_match('/\b(2[0-4][0-9]{3}[A-Z0-9]+|M2[0-4][0-9]{3}[A-Z0-9]+)\b/i', $testString, $m)) {
            $model = !empty($m[1]) ? ' (' . $m[1] . ')' : (!empty($clientModel) ? ' (' . $clientModel . ')' : '');
            return 'Xiaomi Redmi' . $model;
        }
        if (stripos($testString, 'Vivo') !== false || stripos($testString, 'iQOO') !== false || preg_match('/\b(V[1-4][0-9]{3}[A-Z]?|I2[0-9]{3})\b/i', $testString, $m)) {
            $model = !empty($m[1]) ? ' ' . $m[1] : (!empty($clientModel) ? ' (' . $clientModel . ')' : '');
            return 'Vivo' . $model;
        }
        if (stripos($testString, 'Oppo') !== false || preg_match('/\b(CPH[0-9]{4}|P[A-Z]{3}[0-9]{2})\b/i', $testString, $m)) {
            $model = !empty($m[1]) ? ' ' . $m[1] : (!empty($clientModel) ? ' (' . $clientModel . ')' : '');
            return 'Oppo' . $model;
        }
        if (stripos($testString, 'Realme') !== false || preg_match('/\b(RMX[0-9]{4})\b/i', $testString, $m)) {
            $model = !empty($m[1]) ? ' ' . $m[1] : (!empty($clientModel) ? ' (' . $clientModel . ')' : '');
            return 'Realme' . $model;
        }
        if (stripos($testString, 'OnePlus') !== false || preg_match('/\b(LE21[0-9]{2}|NE22[0-9]{2}|CPH24[0-9]{2})\b/i', $testString, $m)) {
            $model = !empty($m[1]) ? ' ' . $m[1] : (!empty($clientModel) ? ' (' . $clientModel . ')' : '');
            return 'OnePlus' . $model;
        }
        if (stripos($testString, 'Moto') !== false || stripos($testString, 'Motorola') !== false || preg_match('/\b(XT[0-9]{4})\b/i', $testString, $m)) {
            $model = !empty($m[1]) ? ' ' . $m[1] : (!empty($clientModel) ? ' (' . $clientModel . ')' : '');
            return 'Motorola Moto' . $model;
        }
        if (stripos($testString, 'Infinix') !== false || preg_match('/\b(X6[0-9]{3}[A-Z]?)\b/i', $testString, $m)) {
            $model = !empty($m[1]) ? ' ' . $m[1] : (!empty($clientModel) ? ' (' . $clientModel . ')' : '');
            return 'Infinix' . $model;
        }
        if (stripos($testString, 'Tecno') !== false || preg_match('/\b(KI[0-9]|AD[0-9]|CH[0-9]|CK[0-9]|LG[0-9])\b/i', $testString, $m)) {
            $model = !empty($m[1]) ? ' ' . $m[1] : (!empty($clientModel) ? ' (' . $clientModel . ')' : '');
            return 'Tecno' . $model;
        }
        if (stripos($testString, 'Pixel') !== false) {
            return 'Google Pixel';
        }

        if (!empty($clientModel) && !in_array(strtolower($clientModel), ['k', 'android', 'linux', 'mobile', 'build', 'wv'])) {
            return 'Android Mobile (' . $clientModel . ')';
        }

        return null;
    }
}