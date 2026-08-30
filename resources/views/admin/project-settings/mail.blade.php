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

            <form action="{{ route('admin.settings.mail.update') }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Mail Host <span class="text-danger" style="color: #dc3545;">*</span></label>
                    <input type="text"
                           name="mail_host"
                           value="{{ old('mail_host', $settings->mail_host) }}"
                           placeholder="smtp.gmail.com"
                           maxlength="50">
                    @error('mail_host')
                        <span class="text-danger" style="color: #dc3545; font-size: 13px; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div style="display: flex; gap: 15px; margin-bottom: 20px;">
                    <div class="form-group" style="flex: 1; margin-bottom: 0;">
                        <label>Encryption <span class="text-danger" style="color: #dc3545;">*</span></label>
                        <select name="mail_encryption">
                            <option value="">Select Encryption</option>
                            <option value="tls" {{ old('mail_encryption', $settings->mail_encryption) === 'tls' ? 'selected' : '' }}>
                                TLS
                            </option>
                            <option value="ssl" {{ old('mail_encryption', $settings->mail_encryption) === 'ssl' ? 'selected' : '' }}>
                                SSL
                            </option>
                        </select>
                        @error('mail_encryption')
                            <span class="text-danger" style="color: #dc3545; font-size: 13px; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group" style="flex: 1; margin-bottom: 0;">
                        <label>Mail Port <span class="text-danger" style="color: #dc3545;">*</span></label>
                        <input type="text"
                               name="mail_port"
                               value="{{ old('mail_port', $settings->mail_port) }}"
                               placeholder="587"
                               maxlength="5"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '');">
                        @error('mail_port')
                            <span class="text-danger" style="color: #dc3545; font-size: 13px; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>Username <span class="text-danger" style="color: #dc3545;">*</span></label>
                    <input type="text"
                           name="mail_username"
                           value="{{ old('mail_username', $settings->mail_username) }}"
                           placeholder="your@email.com"
                           maxlength="50">
                    @error('mail_username')
                        <span class="text-danger" style="color: #dc3545; font-size: 13px; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div style="display: flex; gap: 15px; margin-bottom: 20px;">
                    <div class="form-group" style="flex: 1; margin-bottom: 0;">
                        <label>Password <span class="text-danger" style="color: #dc3545;">*</span></label>
                        <input type="password"
                               name="mail_password"
                               value="{{ old('mail_password', $settings->mail_password) }}"
                               placeholder="Enter mail password"
                               minlength="14"
                               maxlength="20">
                        @error('mail_password')
                            <span class="text-danger" style="color: #dc3545; font-size: 13px; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>

                    <div class="form-group" style="flex: 1; margin-bottom: 0;">
                        <label>From Email <span class="text-danger" style="color: #dc3545;">*</span></label>
                        <input type="email"
                               name="mail_from_address"
                               value="{{ old('mail_from_address', $settings->mail_from_address) }}"
                               placeholder="noreply@recora.com"
                               maxlength="50">
                        @error('mail_from_address')
                            <span class="text-danger" style="color: #dc3545; font-size: 13px; margin-top: 5px; display: block;">{{ $message }}</span>
                        @enderror
                    </div>
                </div>

                <div class="form-group">
                    <label>From Name <span class="text-danger" style="color: #dc3545;">*</span></label>
                    <input type="text"
                           name="mail_from_name"
                           value="{{ old('mail_from_name', $settings->mail_from_name) }}"
                           placeholder="Recora"
                           maxlength="30">
                    @error('mail_from_name')
                        <span class="text-danger" style="color: #dc3545; font-size: 13px; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
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

            <form action="{{ route('admin.settings.mail.test') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label>Email Address <span class="text-danger" style="color: #dc3545;">*</span></label>
                    <input type="email"
                        name="test_email"
                        value="{{ old('test_email') }}"
                        placeholder="Enter email address"
                        maxlength="50"
                        style="width: 100%;">

                    @error('test_email')
                        <span class="text-danger" style="color: #dc3545; font-size: 13px; margin-top: 5px; display: block;">
                            {{ $message }}
                        </span>
                    @enderror
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