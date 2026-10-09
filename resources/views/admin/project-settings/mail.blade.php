@extends('layouts.admin')

@section('title', 'Email Settings')
@section('page-title', 'Setting')
@section('page-subtitle', 'Manage your email configuration')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/project-settings.css') }}">
@endpush

@section('content')

<div class="settings-layout">

    <div class="settings-sidebar">

        <div class="settings-sidebar-title">
            Setting
        </div>

        <a href="{{ route('admin.settings.index') }}" class="settings-menu-item">
            <i class="fa-solid fa-gear"></i>
            <span>Website Setting</span>
        </a>

        <a href="{{ route('admin.settings.mail') }}" class="settings-menu-item active">
            <i class="fa-solid fa-envelope"></i>
            <span>Email Settings</span>
        </a>

    </div>

    <div class="settings-content">

        <div class="settings-card">

            <div class="settings-card-header">
                <div>
                    <h3>Email Settings</h3>
                    <p>Configure SMTP settings for sending emails.</p>
                </div>
            </div>

            <form action="{{ route('admin.settings.mail.update') }}" method="POST" novalidate>
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Mail Host <span class="text-danger" style="color: #dc3545;">*</span></label>
                    <input type="text"
                           name="mail_host"
                           id="mail_host"
                           value="{{ old('mail_host', $settings->mail_host) }}"
                           placeholder="Enter mail host"
                           maxlength="50">
                    @error('mail_host')
                        <span class="text-danger" style="color: #dc3545; font-size: 13px; font-weight: 500; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                    <span class="text-danger js-field-error" style="display:none; color: #dc3545; font-size: 13px; font-weight: 500; margin-top: 5px;"></span>
                </div>

                <div style="display: flex; gap: 15px; margin-bottom: 20px;">
                    <div class="form-group" style="flex: 1; margin-bottom: 0;">
                        <label>Encryption <span class="text-danger" style="color: #dc3545;">*</span></label>
                        <select name="mail_encryption" id="mail_encryption">
                            <option value="">Select Encryption</option>
                            <option value="tls" {{ old('mail_encryption', $settings->mail_encryption) === 'tls' ? 'selected' : '' }}>
                                TLS
                            </option>
                            <option value="ssl" {{ old('mail_encryption', $settings->mail_encryption) === 'ssl' ? 'selected' : '' }}>
                                SSL
                            </option>
                        </select>
                        @error('mail_encryption')
                            <span class="text-danger" style="color: #dc3545; font-size: 13px; font-weight: 500; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                        <span class="text-danger js-field-error" style="display:none; color: #dc3545; font-size: 13px; font-weight: 500; margin-top: 5px;"></span>
                    </div>

                    <div class="form-group" style="flex: 1; margin-bottom: 0;">
                        <label>Mail Port <span class="text-danger" style="color: #dc3545;">*</span></label>
                        <input type="text"
                               name="mail_port"
                               id="mail_port"
                               value="{{ old('mail_port', $settings->mail_port) }}"
                               placeholder="Enter mail port"
                               maxlength="5"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        @error('mail_port')
                            <span class="text-danger" style="color: #dc3545; font-size: 13px; font-weight: 500; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                        <span class="text-danger js-field-error" style="display:none; color: #dc3545; font-size: 13px; font-weight: 500; margin-top: 5px;"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label>Username <span class="text-danger" style="color: #dc3545;">*</span></label>
                    <input type="text"
                           name="mail_username"
                           id="mail_username"
                           value="{{ old('mail_username', $settings->mail_username) }}"
                           placeholder="Enter username"
                           maxlength="50">
                    @error('mail_username')
                        <span class="text-danger" style="color: #dc3545; font-size: 13px; font-weight: 500; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                    <span class="text-danger js-field-error" style="display:none; color: #dc3545; font-size: 13px; font-weight: 500; margin-top: 5px;"></span>
                </div>

                <div style="display: flex; gap: 15px; margin-bottom: 20px;">
                    <div class="form-group" style="flex: 1; margin-bottom: 0;">
                        <label>Password <span class="text-danger" style="color: #dc3545;">*</span></label>
                        <input type="password"
                               name="mail_password"
                               id="mail_password"
                               value="{{ old('mail_password', $settings->mail_password) }}"
                               placeholder="Enter password"
                               minlength="14"
                               maxlength="20">
                        @error('mail_password')
                            <span class="text-danger" style="color: #dc3545; font-size: 13px; font-weight: 500; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                        <span class="text-danger js-field-error" style="display:none; color: #dc3545; font-size: 13px; font-weight: 500; margin-top: 5px;"></span>
                    </div>

                    <div class="form-group" style="flex: 1; margin-bottom: 0;">
                        <label>From Email <span class="text-danger" style="color: #dc3545;">*</span></label>
                        <input type="email"
                               name="mail_from_address"
                               id="mail_from_address"
                               value="{{ old('mail_from_address', $settings->mail_from_address) }}"
                               placeholder="Enter from email"
                               maxlength="50">
                        @error('mail_from_address')
                            <span class="text-danger" style="color: #dc3545; font-size: 13px; font-weight: 500; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                        <span class="text-danger js-field-error" style="display:none; color: #dc3545; font-size: 13px; font-weight: 500; margin-top: 5px;"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label>From Name <span class="text-danger" style="color: #dc3545;">*</span></label>
                    <input type="text"
                           name="mail_from_name"
                           id="mail_from_name"
                           value="{{ old('mail_from_name', $settings->mail_from_name) }}"
                           placeholder="Enter from name"
                           maxlength="30">
                    @error('mail_from_name')
                        <span class="text-danger" style="color: #dc3545; font-size: 13px; font-weight: 500; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                    <span class="text-danger js-field-error" style="display:none; color: #dc3545; font-size: 13px; font-weight: 500; margin-top: 5px;"></span>
                </div>

                <button type="submit">
                    <i class="fa-solid fa-check"></i>
                    Save Changes
                </button>

            </form>

        </div>

        <div class="settings-card test-email-section" id="testEmailSection">
            <div class="settings-card-header">
                <div>
                    <h3>Test Email</h3>
                    <p>Send a test email to verify your SMTP configuration.</p>
                </div>
            </div>

            <form action="{{ route('admin.settings.mail.test') }}" method="POST" id="testEmailForm" novalidate>
                @csrf

                <div class="form-group">
                    <label>Email Address <span class="text-danger" style="color: #dc3545;">*</span></label>
                    <input type="email"
                        name="test_email"
                        id="test_email"
                        value="{{ old('test_email') }}"
                        placeholder="Enter email address"
                        maxlength="50"
                        style="width: 100%;">

                    @error('test_email')
                        <span class="text-danger" style="color: #dc3545; font-size: 13px; font-weight: 500; margin-top: 5px; display: block;">
                            {{ $message }}
                        </span>
                    @enderror
                    <span class="text-danger js-field-error" style="display:none; color: #dc3545; font-size: 13px; font-weight: 500; margin-top: 5px;"></span>
                </div>
                
                <button type="submit">
                    <i class="fa-solid fa-paper-plane"></i>
                    Send Test Email
                </button>
            </form>
        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>
    function showError(input, message) {
        input.classList.add('input-error');
        const errorSpan = input.closest('.form-group').querySelector('.js-field-error');
        if (errorSpan) {
            errorSpan.textContent = message;
            errorSpan.style.display = 'block';
        }
    }

    document.querySelector('form[action="{{ route('admin.settings.mail.update') }}"]').addEventListener('submit', function(e) {
        let isValid = true;
        
        // Clear previous errors
        document.querySelectorAll('form[action="{{ route('admin.settings.mail.update') }}"] .js-field-error').forEach(el => {
            el.style.display = 'none';
            el.textContent = '';
        });
        document.querySelectorAll('form[action="{{ route('admin.settings.mail.update') }}"] .input-error').forEach(el => el.classList.remove('input-error'));
        
        const fields = [
            { id: 'mail_host', msg: 'The mail host field is required.' },
            { id: 'mail_encryption', msg: 'The mail encryption field is required.' },
            { id: 'mail_port', msg: 'The mail port field is required.' },
            { id: 'mail_username', msg: 'The mail username field is required.', isEmail: true },
            { id: 'mail_password', msg: 'The mail password field is required.' },
            { id: 'mail_from_address', msg: 'The mail from address field is required.', isEmail: true },
            { id: 'mail_from_name', msg: 'The mail from name field is required.' }
        ];

        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

        fields.forEach(field => {
            const input = document.getElementById(field.id);
            if (!input.value.trim()) {
                showError(input, field.msg);
                isValid = false;
            } else if (field.isEmail && !emailRegex.test(input.value.trim())) {
                showError(input, 'The email must be a valid email address.');
                isValid = false;
            }
        });

        if (!isValid) {
            e.preventDefault();
        }
    });

    document.getElementById('testEmailForm').addEventListener('submit', function(e) {
        let isValid = true;
        
        // Clear previous errors
        document.querySelectorAll('#testEmailForm .js-field-error').forEach(el => {
            el.style.display = 'none';
            el.textContent = '';
        });
        document.querySelectorAll('#testEmailForm .input-error').forEach(el => el.classList.remove('input-error'));
        
        const testEmail = document.getElementById('test_email');
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        
        if (!testEmail.value.trim()) {
            showError(testEmail, 'The test email field is required.');
            isValid = false;
        } else if (!emailRegex.test(testEmail.value.trim())) {
            showError(testEmail, 'The test email must be a valid email address.');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
        }
    });
</script>
@if($errors->has('test_email'))
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const testSection = document.getElementById('testEmailSection');
        if (testSection) {
            testSection.scrollIntoView({ behavior: 'smooth', block: 'center' });
        }
    });
</script>
@endif
@endpush