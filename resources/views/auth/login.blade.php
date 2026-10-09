<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | {{ $projectSettings->project_name ?? 'Folder Management' }}</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    <style>
        .admin-toast {
            position: fixed; top: 24px; right: 24px; z-index: 9999;
            background: #fff; border-radius: 8px; padding: 16px 20px;
            box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1), 0 8px 10px -6px rgba(0,0,0,0.1);
            display: flex; align-items: flex-start; gap: 14px; min-width: 320px; max-width: 420px;
            animation: toastSlideIn 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275) forwards;
            border-left: 4px solid #10b981;
        }
        .admin-toast.toast-error { border-left-color: #ef4444; }
        .toast-icon { display: flex; align-items: center; justify-content: center; width: 24px; height: 24px; border-radius: 50%; }
        .toast-success .toast-icon { background: rgba(16, 185, 129, 0.1); color: #10b981; }
        .toast-error .toast-icon { background: rgba(239, 68, 68, 0.1); color: #ef4444; }
        .toast-content { flex: 1; display: flex; flex-direction: column; gap: 4px; }
        .toast-content strong { color: #111827; font-size: 15px; font-weight: 600; }
        .toast-content span { color: #6b7280; font-size: 14px; line-height: 1.4; }
        .toast-close { background: transparent; border: none; color: #9ca3af; cursor: pointer; padding: 4px; display: flex; align-items: center; justify-content: center; border-radius: 4px; transition: 0.2s; }
        .toast-close:hover { background: #f3f4f6; color: #4b5563; }
        .toast-progress { position: absolute; bottom: 0; left: 0; height: 3px; background: #10b981; border-radius: 0 0 0 8px; width: 100%; transform-origin: left; animation: toastTimer 2s linear forwards; }
        .toast-error .toast-progress { background: #ef4444; animation: toastTimer 10s linear forwards; }
        .admin-toast.toast-hide { animation: toastSlideOut 0.2s ease-in forwards; }
        @keyframes toastSlideIn { from { transform: translateX(100%) scale(0.9); opacity: 0; } to { transform: translateX(0) scale(1); opacity: 1; } }
        @keyframes toastSlideOut { from { transform: translateX(0) scale(1); opacity: 1; } to { transform: translateX(110%) scale(0.9); opacity: 0; } }
        @keyframes toastTimer { 100% { transform: scaleX(0); } }
    </style>
    @vite(['resources/js/app.js'])
</head>
<body>
    <main class="auth-page">
        <section class="auth-card login-card">
            <div class="auth-info">
                <a href="{{ route('login') }}" class="auth-logo-link" style="display: block !important; text-align: left !important; text-decoration: none !important; margin: 0 !important; padding: 0 !important;">
                    @if(isset($projectSettings) && $projectSettings->project_logo)
                        <img src="{{ asset('storage/' . $projectSettings->project_logo) }}" alt="Logo" style="display: inline-block !important; vertical-align: middle !important; width: 50px !important; height: 50px !important; border-radius: 50% !important; object-fit: cover !important; margin: 0 10px 0 0 !important; border: 2px solid rgba(255,255,255,0.2) !important;">
                    @else
                        <span class="brand-icon" style="display: inline-block !important; vertical-align: middle !important; margin: 0 10px 0 0 !important;">F</span>
                    @endif
                    <span style="display: inline-block !important; vertical-align: middle !important; font-size: 22px !important; font-weight: 700 !important; white-space: nowrap !important; margin: 0 !important; padding: 0 !important;">{{ $projectSettings->project_name ?? 'Folder Management' }}</span>
                </a>

                <div class="info-content">
                    <span class="info-badge">Welcome back</span>
                    <h1>Your records, organized and protected.</h1>
                    <p>
                        Login to manage your folders, documents, invoices
                        and profile from one secure dashboard.
                    </p>

                    <div class="feature-list">
                        <div class="feature-item">
                            <span>✓</span>
                            Secure account access
                        </div>

                        <div class="feature-item">
                            <span>✓</span>
                            Role-based dashboard
                        </div>

                        <div class="feature-item">
                            <span>✓</span>
                            Mobile-friendly interface
                        </div>
                    </div>
                </div>
            </div>

            <div class="auth-form-area">
                <div class="auth-form-container login-container">
                    <div class="auth-heading">
                        <span>Account access</span>
                        <h2>Login</h2>
                        <p>Enter your email and password to continue.</p>
                    </div>

                    @if(session('success') || session('error'))
                    <div class="admin-toast {{ session('success') ? 'toast-success' : 'toast-error' }}" id="adminToast">
                        <div class="toast-icon">
                            @if(session('success'))
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><path d="M20 6L9 17l-5-5"/></svg>
                            @else
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                            @endif
                        </div>
                        <div class="toast-content">
                            <strong>{{ session('success') ? 'Success' : 'Error' }}</strong>
                            <span>{{ session('success') ?? session('error') }}</span>
                        </div>
                        <button type="button" class="toast-close" onclick="closeAdminToast()">
                            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                        </button>
                        <div class="toast-progress"></div>
                    </div>
                    @endif

                    <form action="{{ route('login.store') }}" method="POST" class="auth-form" id="loginForm" novalidate>
                        @csrf
                        <input type="hidden" name="client_device" id="client_device" value="">

                        <div class="form-group">
                            <label for="email">Email address <span class="text-danger" style="color: #dc3545;">*</span></label>

                            <input
                                type="email"
                                id="email"
                                name="email"
                                value="{{ old('email', Cookie::get('login_email')) }}"
                                class="form-control @error('email') is-invalid @enderror"
                                placeholder="name@example.com"
                                maxlength="50"
                                autocomplete="email"
                                autofocus
                            >

                            @error('email')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                            <span class="error-message js-email-error" style="display:none;">The email field is required.</span>
                        </div>

                        <div class="form-group">
                            <div class="label-row">
                                <label for="password">Password <span class="text-danger" style="color: #dc3545;">*</span></label>
                            </div>

                            <div class="password-input-group">
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    value="{{ Cookie::get('login_password') }}"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Enter your password"
                                    minlength="6"
                                    maxlength="15"
                                    autocomplete="current-password"
                                >
                                <button type="button" class="password-toggle" onclick="togglePasswordVisibility('password', this)" aria-label="Toggle password visibility">
                                    <svg class="eye-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <svg class="eye-off-icon" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" style="display: none;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                    </svg>
                                </button>
                            </div>

                            @error('password')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                            <span class="error-message js-password-error" style="display:none;">The password field is required.</span>
                        </div>

                        <div class="login-options">
                            <label class="checkbox-label">
                                <input
                                    type="checkbox"
                                    name="remember"
                                    value="1"
                                    {{ old('remember') || Cookie::has('login_email') ? 'checked' : '' }}
                                >

                                <span>Remember me</span>
                            </label>
                            <a href="#" class="forgot-link">Forgot password?</a>
                        </div>

                        <button type="submit" class="auth-button">
                            Login
                        </button>
                    </form>
                </div>
            </div>
        </section>
    </main>
    <script>
        function togglePasswordVisibility(inputId, button) {
            const input = document.getElementById(inputId);
            const eye = button.querySelector('.eye-icon');
            const eyeOff = button.querySelector('.eye-off-icon');
            if (input.type === 'password') {
                input.type = 'text';
                eye.style.display = 'none';
                eyeOff.style.display = 'block';
            } else {
                input.type = 'password';
                eye.style.display = 'block';
                eyeOff.style.display = 'none';
            }
        }

        document.addEventListener('DOMContentLoaded', async function() {
            const input = document.getElementById('client_device');
            if (!input) return;
            if (navigator.userAgentData && navigator.userAgentData.getHighEntropyValues) {
                try {
                    const values = await navigator.userAgentData.getHighEntropyValues(['model', 'platformVersion']);
                    if (values && values.model && values.model.trim() !== '' && values.model !== 'K') {
                        input.value = values.model.trim();
                    }
                } catch(e) {}
            }
        });

        document.addEventListener('input', function(e) {
            if (['INPUT', 'TEXTAREA', 'SELECT'].includes(e.target.tagName)) {
                let formGroup = e.target.closest('.form-group');
                if (formGroup) {
                    let errorSpans = formGroup.querySelectorAll('.error-message');
                    errorSpans.forEach(span => span.style.display = 'none');
                }
                if (e.target.classList.contains('is-invalid')) {
                    e.target.classList.remove('is-invalid');
                }
            }
        });

        function closeAdminToast() {
            var toast = document.getElementById('adminToast');
            if (!toast) return;
            toast.classList.add('toast-hide');
            setTimeout(function () { toast.remove(); }, 200);
        }

        var adminToastEl = document.getElementById('adminToast');
        if (adminToastEl) {
            var isError = adminToastEl.classList.contains('toast-error');
            var timeoutDuration = isError ? 10000 : 2000;
            setTimeout(closeAdminToast, timeoutDuration);
        }

        var loginForm = document.getElementById('loginForm');
        if(loginForm) {
            loginForm.addEventListener('submit', function(e) {
                var emailInput = document.getElementById('email');
                var passwordInput = document.getElementById('password');
                
                var email = emailInput.value.trim();
                var password = passwordInput.value.trim();
                
                var emailError = document.querySelector('.js-email-error');
                var passwordError = document.querySelector('.js-password-error');
                
                var hasError = false;
                if(!email) {
                    emailError.style.display = 'block';
                    emailInput.classList.add('is-invalid');
                    hasError = true;
                }
                if(!password) {
                    passwordError.innerText = "The password field is required.";
                    passwordError.style.display = 'block';
                    passwordInput.classList.add('is-invalid');
                    hasError = true;
                } else if(password.length < 6) {
                    passwordError.innerText = "The password must be at least 6 characters.";
                    passwordError.style.display = 'block';
                    passwordInput.classList.add('is-invalid');
                    hasError = true;
                }

                if(hasError) {
                    e.preventDefault();
                }
            });
        }
    </script>
</body>
</html>