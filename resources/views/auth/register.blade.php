<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register | {{ $projectSettings->project_name ?? 'Folder Management' }}</title>
    <link rel="stylesheet" href="{{ asset('css/auth.css') }}">
    @vite(['resources/js/app.js'])
</head>
<body>
    <main class="auth-page">
        <section class="auth-card register-card">
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
                    <span class="info-badge">Secure Workspace</span>

                    <h1>Organize your files and invoices securely.</h1>

                    <p>
                        Create folders, manage records and keep your important
                        information available on every device.
                    </p>

                    <div class="feature-list">
                        <div class="feature-item">
                            <span>✓</span>
                            Secure {{ strtolower($projectSettings->project_name ?? 'Folder Management') }}
                        </div>

                        <div class="feature-item">
                            <span>✓</span>
                            Invoice and document records
                        </div>

                        <div class="feature-item">
                            <span>✓</span>
                            Responsive on mobile and desktop
                        </div>
                    </div>
                </div>
            </div>

            <div class="auth-form-area">
                <div class="auth-form-container">
                    <div class="auth-heading">
                        <span>Create account</span>
                        <h2>Register</h2>
                        <p>Enter your details to create a new account.</p>
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

                    <form action="{{ route('register.store') }}" method="POST" class="auth-form">
                        @csrf
                        <input type="hidden" name="client_device" id="client_device" value="">

                        <div class="form-group">
                            <label for="name">Full name <span class="text-danger" style="color: #dc3545;">*</span></label>

                            <input
                                type="text"
                                id="name"
                                name="name"
                                value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Enter your full name"
                                minlength="3"
                                maxlength="50"
                                autocomplete="name"
                                oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')"
                                autofocus
                            >

                            @error('name')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="number">Mobile number <span class="text-danger" style="color: #dc3545;">*</span></label>

                                <input
                                    type="text"
                                    id="number"
                                    name="number"
                                    value="{{ old('number') }}"
                                    class="form-control @error('number') is-invalid @enderror"
                                    placeholder="Enter 10-digit number"
                                    minlength="10"
                                    maxlength="10"
                                    inputmode="numeric"
                                    autocomplete="tel"
                                    oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                                >

                                @error('number')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="email">Email address <span class="text-danger" style="color: #dc3545;">*</span></label>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    value="{{ old('email') }}"
                                    class="form-control @error('email') is-invalid @enderror"
                                    placeholder="name@example.com"
                                    maxlength="100"
                                    autocomplete="email"
                                >

                                @error('email')
                                    <span class="error-message">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="password">Password <span class="text-danger" style="color: #dc3545;">*</span></label>

                            <div class="password-input-group">
                                <input
                                    type="password"
                                    id="password"
                                    name="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    placeholder="Enter 6 to 15 character password"
                                    minlength="6"
                                    maxlength="15"
                                    autocomplete="new-password"
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

                        <p class="password-help">
                            Password must contain minimum 6 and maximum 15 characters.
                        </p>

                        <div class="terms-group">
                            <label class="checkbox-label">
                                <input
                                    type="checkbox"
                                    name="terms"
                                    value="1"
                                    {{ old('terms') ? 'checked' : '' }}
                                >

                                <span>
                                    I agree to the
                                    <a href="#">Terms & Conditions</a>
                                    and
                                    <a href="#">Privacy Policy</a>.
                                </span>
                            </label>

                            @error('terms')
                                <span class="error-message">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="auth-button">
                            Create account
                        </button>
                    </form>

                    <p class="auth-switch">
                        Already have an account?
                        <a href="{{ route('login') }}">Login</a>
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