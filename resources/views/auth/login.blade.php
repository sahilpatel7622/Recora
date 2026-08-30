<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | {{ $projectSettings->project_name ?? 'Folder Management' }}</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
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

                    @if(session('success'))
                        <div class="alert alert-success">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif

                    <form action="{{ route('login.store') }}" method="POST" class="auth-form">
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
                                maxlength="100"
                                autocomplete="email"
                                autofocus
                            >

                            @error('email')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
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

                    <p class="auth-switch">
                        Don't have an account?
                        <a href="{{ route('register') }}">Create account</a>
                    </p>
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
                    let errorSpan = formGroup.querySelector('.error-message');
                    if (errorSpan) {
                        errorSpan.style.display = 'none';
                    }
                }
            }
        });
    </script>
</body>
</html>