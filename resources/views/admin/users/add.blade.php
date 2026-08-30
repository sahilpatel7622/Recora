@extends('layouts.admin')

@section('title', 'Add User')

@section('page-title', 'Add New User')

@section('page-description', 'Create a new registered user account')

@push('styles')
    <link rel="stylesheet"
          href="{{ asset('css/admin-users.css') }}?v={{ time() }}">
@endpush

@section('content')

<div class="user-form-topbar">

    <a href="{{ route('admin.users.index') }}"
       class="user-back-btn">

        <i class="fa-solid fa-arrow-left"></i>
        Back to Users

    </a>

</div>

<div class="user-form-card">

    <div class="user-form-header">

        <div class="user-form-heading-icon">
            <i class="fa-solid fa-user-plus"></i>
        </div>

        <div>
            <h3>Create User Account</h3>
            <p>Enter the required information to add a new user</p>
        </div>

    </div>

    <form action="{{ route('admin.users.store') }}"
          method="POST"
          class="admin-user-form"
          id="addUserForm"
          novalidate>

        @csrf

        <div class="user-form-section">

            <div class="form-section-title">

                <i class="fa-solid fa-address-card"></i>

                <div>
                    <h4>Personal Information</h4>
                    <p>Enter the user's basic details</p>
                </div>

            </div>

            <div class="user-form-grid">

                <div class="user-form-group">

                    <label for="name">
                        Full Name
                        <span>*</span>
                    </label>

                    <div class="user-input-wrapper">

                        <i class="fa-regular fa-user"></i>

                        <input type="text"
                               id="name"
                               name="name"
                               value="{{ old('name') }}"
                               maxlength="50"
                               placeholder="Enter full name"
                               oninput="this.value = this.value.replace(/[^a-zA-Z\s]/g, '')"
                               class="{{ $errors->has('name') ? 'input-error' : '' }}">

                    </div>

                    @error('name')
                        <span class="field-error" style="color:#ef4444; font-size:14px; margin-top:4px; display:block;">{{ $message }}</span>
                    @enderror
                    <span class="field-error js-field-error" style="display:none; color:#ef4444; font-size:14px; margin-top:4px;"></span>

                </div>

                <div class="user-form-group">

                    <label for="number">
                        Phone Number
                        <span>*</span>
                    </label>

                    <div class="user-input-wrapper">

                        <i class="fa-solid fa-phone"></i>

                        <input type="text"
                               id="number"
                               name="number"
                               value="{{ old('number') }}"
                               maxlength="10"
                               placeholder="Enter phone number"
                               oninput="this.value = this.value.replace(/[^0-9]/g, '')"
                               class="{{ $errors->has('number') ? 'input-error' : '' }}">

                    </div>

                    @error('number')
                        <span class="field-error" style="color:#ef4444; font-size:14px; margin-top:4px; display:block;">{{ $message }}</span>
                    @enderror
                    <span class="field-error js-field-error" style="display:none; color:#ef4444; font-size:14px; margin-top:4px;"></span>

                </div>

                <div class="user-form-group user-form-full-width">

                    <label for="email">
                        Email Address
                        <span>*</span>
                    </label>

                    <div class="user-input-wrapper">

                        <i class="fa-regular fa-envelope"></i>

                        <input type="email"
                               id="email"
                               name="email"
                               value="{{ old('email') }}"
                               maxlength="50"
                               placeholder="Enter email address"
                               class="{{ $errors->has('email') ? 'input-error' : '' }}">

                    </div>

                    @error('email')
                        <span class="field-error" style="color:#ef4444; font-size:14px; margin-top:4px; display:block;">{{ $message }}</span>
                    @enderror
                    <span class="field-error js-field-error" style="display:none; color:#ef4444; font-size:14px; margin-top:4px;"></span>

                </div>

            </div>

        </div>

        <div class="user-form-section">

            <div class="form-section-title">

                <i class="fa-solid fa-lock"></i>

                <div>
                    <h4>Security Information</h4>
                    <p>Create login and action passwords</p>
                </div>

            </div>

            <div class="user-form-grid">

                <div class="user-form-group">

                    <label for="password">
                        Login Password
                        <span>*</span>
                    </label>

                    <div class="user-input-wrapper password-input-wrapper">

                        <i class="fa-solid fa-lock"></i>

                        <input type="password"
                               id="password"
                               name="password"
                               minlength="6"
                               maxlength="15"
                               placeholder="Enter login password"
                               class="{{ $errors->has('password') ? 'input-error' : '' }}">

                        <button type="button"
                                class="password-visibility-btn"
                                onclick="toggleUserPassword('password', this)">

                            <i class="fa-regular fa-eye"></i>

                        </button>

                    </div>

                    @error('password')
                        <span class="field-error" style="color:#ef4444; font-size:14px; margin-top:4px; display:block;">{{ $message }}</span>
                    @enderror
                    <span class="field-error js-field-error" style="display:none; color:#ef4444; font-size:14px; margin-top:4px;"></span>

                </div>

                <!-- <div class="user-form-group">

                    <label for="password_confirmation">
                        Confirm Password
                        <span>*</span>
                    </label>

                    <div class="user-input-wrapper password-input-wrapper">

                        <i class="fa-solid fa-lock"></i>

                        <input type="password"
                               id="password_confirmation"
                               name="password_confirmation"
                               placeholder="Confirm login password"
                               required>

                        <button type="button"
                                class="password-visibility-btn"
                                onclick="toggleUserPassword('password_confirmation', this)">

                            <i class="fa-regular fa-eye"></i>

                        </button>

                    </div>

                </div> -->

                <!-- <div class="user-form-group">

                    <label for="action_pass">
                        Action Password
                        <span>*</span>
                    </label>

                    <div class="user-input-wrapper password-input-wrapper">

                        <i class="fa-solid fa-key"></i>

                        <input type="password"
                               id="action_pass"
                               name="action_pass"
                               placeholder="Enter action password"
                               class="{{ $errors->has('action_pass') ? 'input-error' : '' }}"
                               required>

                        <button type="button"
                                class="password-visibility-btn"
                                onclick="toggleUserPassword('action_pass', this)">

                            <i class="fa-regular fa-eye"></i>

                        </button>

                    </div>

                    @error('action_pass')
                        <small class="field-error">
                            {{ $message }}
                        </small>
                    @enderror

                </div>

                <div class="user-form-group">

                    <label for="action_pass_confirmation">
                        Confirm Action Password
                        <span>*</span>
                    </label>

                    <div class="user-input-wrapper password-input-wrapper">

                        <i class="fa-solid fa-key"></i>

                        <input type="password"
                               id="action_pass_confirmation"
                               name="action_pass_confirmation"
                               placeholder="Confirm action password"
                               required>

                        <button type="button"
                                class="password-visibility-btn"
                                onclick="toggleUserPassword('action_pass_confirmation', this)">

                            <i class="fa-regular fa-eye"></i>

                        </button>

                    </div>

                </div> -->

            </div>

        </div>

        <div class="user-form-section">

            <div class="form-section-title">

                <i class="fa-solid fa-sliders"></i>

                <div>
                    <h4>Account Settings</h4>
                    <p>Set the initial status of this user account</p>
                </div>

            </div>

            <div class="user-form-grid">

                <div class="user-form-group">

                    <label for="status">
                        Account Status
                        <span>*</span>
                    </label>

                    <div class="user-select-wrapper">

                        <i class="fa-solid fa-toggle-on"></i>

                        <select id="status"
                                name="status"
                                class="{{ $errors->has('status') ? 'input-error' : '' }}">

                            <option value="1"
                                    {{ old('status', '1') == '1' ? 'selected' : '' }}>
                                Active
                            </option>

                            <option value="0"
                                    {{ old('status') == '0' ? 'selected' : '' }}>
                                Inactive
                            </option>

                        </select>

                    </div>

                    @error('status')
                        <span class="field-error" style="color:#ef4444; font-size:14px; margin-top:4px; display:block;">{{ $message }}</span>
                    @enderror
                    <span class="field-error js-field-error" style="display:none; color:#ef4444; font-size:14px; margin-top:4px;"></span>

                </div>

                <div class="user-form-group">

                    <label>
                        User Role
                    </label>

                    <div class="readonly-role-box">

                        <i class="fa-solid fa-user"></i>

                        <span>
                            User
                        </span>

                    </div>

                    <input type="hidden"
                           name="role"
                           value="user">

                </div>

            </div>

        </div>

        <div class="user-form-actions">

            <a href="{{ route('admin.users.index') }}"
               class="cancel-user-btn">

                <i class="fa-solid fa-xmark"></i>
                Cancel

            </a>

            <button type="submit"
                    class="save-user-btn">

                <i class="fa-solid fa-floppy-disk"></i>
                Create User

            </button>

        </div>

    </form>

</div>

@endsection

@push('scripts')

<script>
    function toggleUserPassword(inputId, button) {
        const input = document.getElementById(inputId);
        const icon = button.querySelector('i');

        if (input.type === 'password') {
            input.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            input.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    }

    document.getElementById('addUserForm').addEventListener('submit', function(e) {
        let isValid = true;

        // Clear previous errors
        document.querySelectorAll('.js-field-error').forEach(el => {
            el.style.display = 'none';
            el.textContent = '';
        });
        document.querySelectorAll('.input-error').forEach(el => el.classList.remove('input-error'));

        const name = document.getElementById('name');
        if (!name.value.trim()) {
            showError(name, 'The name field is required.');
            isValid = false;
        }

        const number = document.getElementById('number');
        if (!number.value.trim()) {
            showError(number, 'The phone number field is required.');
            isValid = false;
        }

        const email = document.getElementById('email');
        if (!email.value.trim()) {
            showError(email, 'The email field is required.');
            isValid = false;
        }

        const password = document.getElementById('password');
        if (!password.value.trim()) {
            showError(password, 'The password field is required.');
            isValid = false;
        } else if (password.value.trim().length < 6) {
            showError(password, 'The password must be at least 6 characters.');
            isValid = false;
        }

        if (!isValid) {
            e.preventDefault();
        }
    });

    function showError(input, message) {
        input.classList.add('input-error');
        const errorSpan = input.closest('.user-form-group').querySelector('.js-field-error');
        if (errorSpan) {
            errorSpan.textContent = message;
            errorSpan.style.display = 'block';
        }
    }
</script>

@endpush