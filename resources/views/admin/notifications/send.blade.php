@extends('layouts.admin')

@section('title', 'Send Notification')
@section('page-title', 'Send Notification')
@section('page-description', 'Send a notification to one or more users')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-send-notification.css') }}?v={{ time() }}">
@endpush

@section('content')

<div class="send-notification-page">

    <div class="send-notification-card">

        <div class="send-notification-header">

            <div class="send-notification-icon">
                <i class="fa-solid fa-paper-plane"></i>
            </div>

            <div>
                <h1>Send Notification</h1>
                <p>
                    Send a notification directly to a selected user or all active users.
                </p>
            </div>

            <a href="{{ route('admin.notifications.index') }}" class="view-notifications-btn" style="margin-left: auto; display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; background: #eef2ff; color: #4f46e5; font-size: 14px; font-weight: 600; border-radius: 10px; text-decoration: none; transition: all 0.2s ease;">
                <i class="fa-solid fa-list-ul"></i>
                View Notifications
            </a>

        </div>

        <form action="{{ route('admin.send-notification.store') }}"
              method="POST"
              id="sendNotificationForm">

            @csrf

            {{-- Recipient Type --}}
            <div class="form-group">

                <label class="form-label">
                    <i class="fa-solid fa-users"></i>
                    Send To
                </label>

                <div class="recipient-options">

                    <label class="recipient-option {{ old('recipient_type', 'user') == 'user' ? 'active' : '' }}"
                           id="specificUserOption">

                        <input type="radio"
                               name="recipient_type"
                               value="user"
                               {{ old('recipient_type', 'user') == 'user' ? 'checked' : '' }}>

                        <div class="recipient-option-content">

                            <div class="recipient-option-icon">
                                <i class="fa-solid fa-user"></i>
                            </div>

                            <div>
                                <strong>Specific User</strong>
                                <span>Send to one selected user</span>
                            </div>

                        </div>

                    </label>

                    <label class="recipient-option {{ old('recipient_type') == 'all' ? 'active' : '' }}"
                           id="allUsersOption">

                        <input type="radio"
                               name="recipient_type"
                               value="all"
                               {{ old('recipient_type') == 'all' ? 'checked' : '' }}>

                        <div class="recipient-option-content">

                            <div class="recipient-option-icon all-users-icon">
                                <i class="fa-solid fa-users"></i>
                            </div>

                            <div>
                                <strong>All Active Users</strong>
                                <span>Send to all active users</span>
                            </div>

                        </div>

                    </label>

                </div>

            </div>

            {{-- User Selection --}}
            <div class="form-group"
                 id="userSelectionGroup">

                <label for="user_id" class="form-label">
                    <i class="fa-solid fa-user"></i>
                    Select User
                    <span>*</span>
                </label>

                <select name="user_id"
                        id="user_id"
                        class="form-control">

                    <option value="">Select User</option>

                    @foreach($users as $user)

                        <option value="{{ $user->id }}"
                            {{ old('user_id') == $user->id ? 'selected' : '' }}>

                            {{ $user->name }} — {{ $user->email }}

                        </option>

                    @endforeach

                </select>

                <span class="field-error" id="userError" style="display:none; color:#ef4444; font-size:14px; margin-top:4px; display:none;"></span>

            </div>

            {{-- All Users Info --}}
            <div class="all-users-info"
                 id="allUsersInfo">

                <div class="all-users-info-icon">
                    <i class="fa-solid fa-users"></i>
                </div>

                <div>
                    <strong>All Active Users</strong>
                    <p>
                        This notification will be sent to all currently active users.
                    </p>
                </div>

            </div>

            {{-- Title --}}
            <div class="form-group">

                <label for="title" class="form-label">
                    <i class="fa-solid fa-heading"></i>
                    Notification Title
                    <span>*</span>
                </label>

                <input type="text"
                       name="title"
                       id="title"
                       class="form-control"
                       value="{{ old('title') }}"
                       maxlength="70"
                       placeholder="Enter notification title">

                @error('title')
                    <span style="color:#ef4444; font-size:14px; margin-top:4px; display:block;">{{ $message }}</span>
                @enderror

                <div class="input-bottom">
                    <span id="titleCounter">0 / 70</span>
                </div>

            </div>

            {{-- Message --}}
            <div class="form-group">

                <label for="message" class="form-label">
                    <i class="fa-solid fa-message"></i>
                    Notification Message
                    <span>*</span>
                </label>

                <textarea name="message"
                          id="message"
                          class="form-control textarea-control"
                          maxlength="150"
                          placeholder="Enter notification message">{{ old('message') }}</textarea>

                @error('message')
                    <span style="color:#ef4444; font-size:14px; margin-top:4px; display:block;">{{ $message }}</span>
                @enderror

                <div class="input-bottom">
                    <span id="messageCounter">0 / 150</span>
                </div>

            </div>



            {{-- Actions --}}
            <div class="form-actions">

                <a href="{{ route('admin.dashboard') }}"
                   class="cancel-btn">

                    <i class="fa-solid fa-xmark"></i>
                    Cancel

                </a>

                <button type="submit"
                        class="send-btn">

                    <i class="fa-solid fa-paper-plane"></i>
                    Send Notification

                </button>

            </div>

        </form>

    </div>

</div>

@endsection

@push('scripts')

<script>

document.addEventListener('DOMContentLoaded', function () {

    const specificOption =
        document.getElementById('specificUserOption');

    const allOption =
        document.getElementById('allUsersOption');

    const userSelectionGroup =
        document.getElementById('userSelectionGroup');

    const allUsersInfo =
        document.getElementById('allUsersInfo');

    const userSelect =
        document.getElementById('user_id');

    const titleInput =
        document.getElementById('title');

    const messageInput =
        document.getElementById('message');

    const titleCounter =
        document.getElementById('titleCounter');

    const messageCounter =
        document.getElementById('messageCounter');

    const form =
        document.getElementById('sendNotificationForm');


    function updateRecipientUI() {

        const selected =
            document.querySelector('input[name="recipient_type"]:checked')?.value;

        if (selected === 'all') {

            specificOption.classList.remove('active');
            allOption.classList.add('active');

            userSelectionGroup.style.display = 'none';
            allUsersInfo.classList.add('show');

            userSelect.value = '';

        } else {

            allOption.classList.remove('active');
            specificOption.classList.add('active');

            userSelectionGroup.style.display = 'block';
            allUsersInfo.classList.remove('show');

        }

    }


    document.querySelectorAll(
        'input[name="recipient_type"]'
    ).forEach(function (radio) {

        radio.addEventListener('change', updateRecipientUI);

    });


    function updateTitleCounter() {

        const length =
            titleInput.value.length;

        titleCounter.textContent =
            length + ' / 70';

    }


    function updateMessageCounter() {

        const length =
            messageInput.value.length;

        messageCounter.textContent =
            length + ' / 150';

    }


    titleInput.addEventListener(
        'input',
        updateTitleCounter
    );

    messageInput.addEventListener(
        'input',
        updateMessageCounter
    );


    updateRecipientUI();
    updateTitleCounter();
    updateMessageCounter();


    form.addEventListener('submit', function (e) {

        e.preventDefault();

        const selected =
            document.querySelector(
                'input[name="recipient_type"]:checked'
            )?.value;

        if (
            selected === 'user' &&
            !userSelect.value
        ) {

            const userError = document.getElementById('userError');
            userError.textContent = 'Please select a user first.';
            userError.style.display = 'block';
            userSelect.style.borderColor = '#ef4444';
            userSelect.scrollIntoView({ behavior: 'smooth', block: 'center' });

            userSelect.addEventListener('change', function () {
                userError.style.display = 'none';
                userSelect.style.borderColor = '';
            }, { once: true });

            return;

        }


        form.submit();

    });

});

</script>

@endpush