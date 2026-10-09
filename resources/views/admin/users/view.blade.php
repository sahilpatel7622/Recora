@extends('layouts.admin')

@section('title', 'User Details')

@section('page-title', 'User Details')

@section('page-description', 'View complete registered user information')

@push('styles')
    <link rel="stylesheet"
          href="{{ asset('css/admin-users.css') }}?v={{ time() }}">
@endpush

@section('content')

<div class="user-view-topbar">

    <a href="{{ route('admin.users.index') }}"
       class="user-back-btn">

        <i class="fa-solid fa-arrow-left"></i>
        Back to Users

    </a>

    <div class="user-view-top-actions">

        @if($user->trashed())

            <form action="{{ route('admin.users.restore', $user->id) }}"
                  method="POST"
                  class="restore-user-form">

                @csrf
                @method('PATCH')

                <button type="submit"
                        class="user-restore-main-btn">

                    <i class="fa-solid fa-rotate-left"></i>
                    Restore User

                </button>

            </form>

            <form action="{{ route('admin.users.force-delete', $user->id) }}"
                  method="POST"
                  class="force-delete-user-form">

                @csrf
                @method('DELETE')

                <button type="submit"
                        class="user-hard-delete-main-btn">

                    <i class="fa-solid fa-trash"></i>
                    Permanent Delete

                </button>

            </form>

        @else

            <form action="{{ route('admin.users.status', $user->id) }}"
                  method="POST"
                  class="status-user-form">

                @csrf
                @method('PATCH')

                <button type="submit"
                        class="{{ $user->status ? 'user-deactivate-main-btn' : 'user-activate-main-btn' }}">

                    @if($user->status)

                        <i class="fa-solid fa-user-lock"></i>
                        Deactivate User

                    @else

                        <i class="fa-solid fa-user-check"></i>
                        Activate User

                    @endif

                </button>

            </form>

            <form action="{{ route('admin.users.destroy', $user->id) }}"
                  method="POST"
                  class="delete-user-form">

                @csrf
                @method('DELETE')

                <button type="submit"
                        class="user-delete-main-btn">

                    <i class="fa-regular fa-trash-can"></i>
                    Delete User

                </button>

            </form>

        @endif

    </div>

</div>

<div class="user-view-layout">

    <div class="user-profile-card">

        <div class="user-profile-cover"></div>

        <div class="user-profile-content">

            <div class="user-large-avatar">
                {{ strtoupper(substr($user->name, 0, 1)) }}
            </div>

            <h2>
                {{ $user->name }}
            </h2>

            <p>
                {{ $user->email }}
            </p>

            @if($user->trashed())

                <span class="profile-status-badge profile-deleted-status">

                    <i class="fa-solid fa-trash"></i>
                    Deleted

                </span>

            @elseif($user->status)

                <span class="profile-status-badge profile-active-status">

                    <i class="fa-solid fa-circle-check"></i>
                    Active

                </span>

            @else

                <span class="profile-status-badge profile-inactive-status">

                    <i class="fa-solid fa-circle-xmark"></i>
                    Inactive

                </span>

            @endif

            <div class="profile-basic-list">

                <div class="profile-basic-item">

                    <i class="fa-solid fa-phone"></i>

                    <div>
                        <span>Phone Number</span>
                        <strong>{{ $user->number ?: 'Not added' }}</strong>
                    </div>

                </div>

                <div class="profile-basic-item">

                    <i class="fa-solid fa-calendar-days"></i>

                    <div>
                        <span>Joined Date</span>
                        <strong>{{ $user->created_at->format('d M Y') }}</strong>
                    </div>

                </div>

                <div class="profile-basic-item">

                    <i class="fa-solid fa-user-shield"></i>

                    <div>
                        <span>Account Role</span>
                        <strong>{{ ucfirst($user->role) }}</strong>
                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="user-information-column">

        <div class="user-information-card">

            <div class="information-card-header">

                <div>
                    <h3>Personal Information</h3>
                    <p>Basic account and contact information</p>
                </div>

                <div class="information-header-icon">
                    <i class="fa-solid fa-address-card"></i>
                </div>

            </div>

            <div class="information-grid">

                <div class="information-item">
                    <span>User ID</span>
                    <strong style="color: green;">#{{ $user->id }}</strong>
                </div>

                <div class="information-item">
                    <span>Full Name</span>
                    <strong>{{ $user->name }}</strong>
                </div>

                <div class="information-item">
                    <span>Email Address</span>
                    <strong>{{ $user->email }}</strong>
                </div>

                <div class="information-item">
                    <span>Phone Number</span>
                    <strong>{{ $user->number ?: 'Not added' }}</strong>
                </div>

                <div class="information-item">
                    <span>Role</span>
                    <strong>{{ ucfirst($user->role) }}</strong>
                </div>

                <div class="information-item">
                    <span>Account Status</span>

                    <strong>

                        @if($user->trashed())
                            Deleted
                        @elseif($user->status)
                            Active
                        @else
                            Inactive
                        @endif

                    </strong>

                </div>

            </div>

        </div>

        <div class="user-information-card">

            <div class="information-card-header">

                <div>
                    <h3>Login and Device Information</h3>
                    <p>Latest device, browser and login activity</p>
                </div>

                <div class="information-header-icon">
                    <i class="fa-solid fa-laptop"></i>
                </div>

            </div>

            <div class="information-grid">

                <div class="information-item">
                    <span>Last Login</span>

                    <strong>
                        {{ $user->last_login_time
                            ? $user->last_login_time->timezone('Asia/Kolkata')->format('d M Y, h:i A')
                            : 'Never logged in' }}
                    </strong>
                </div>

                <div class="information-item">
                    <span>IP Address</span>
                    <strong>{{ $user->ip_address ?: 'Unknown' }}</strong>
                </div>

                <div class="information-item">
                    <span>Device</span>
                    <strong>{{ $user->device ?: 'Unknown' }}</strong>
                </div>

                <div class="information-item">
                    <span>Browser</span>
                    <strong>{{ $user->browser ?: 'Unknown' }}</strong>
                </div>

                <div class="information-item">
                    <span>Created At</span>
                    <strong>{{ $user->created_at->timezone('Asia/Kolkata')->format('d M Y, h:i A') }}</strong>
                </div>

                <div class="information-item">
                    <span>Updated At</span>
                    <strong>{{ $user->updated_at->timezone('Asia/Kolkata')->format('d M Y, h:i A') }}</strong>
                </div>

                @if($user->trashed())

                    <div class="information-item information-full-width">
                        <span>Deleted At</span>

                        <strong class="deleted-date-text">
                            {{ $user->deleted_at->timezone('Asia/Kolkata')->format('d M Y, h:i A') }}
                        </strong>
                    </div>

                @endif

            </div>

        </div>

    </div>

</div>

@endsection

@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function() {
    function submitFormWithoutHistory(form) {
        const btn = form.querySelector('button[type="submit"]');
        if(btn) {
            btn.style.opacity = '0.7';
            btn.style.pointerEvents = 'none';
        }
        
        fetch(form.action, {
            method: form.method || 'POST',
            body: new FormData(form)
        }).then(res => res.text()).then(html => {
            document.open();
            document.write(html);
            document.close();
        });
    }

    document.querySelectorAll('.status-user-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            submitFormWithoutHistory(form);
        });
    });

    document.querySelectorAll('.delete-user-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Delete User?',
                text: 'Move this user to deleted users?',
                icon: 'warning',
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonColor: '#ef4444',
                cancelButtonColor: '#3b82f6',
                confirmButtonText: 'Yes, delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    submitFormWithoutHistory(form);
                }
            });
        });
    });

    document.querySelectorAll('.force-delete-user-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Permanently Delete?',
                text: 'This action cannot be undone. Are you sure?',
                icon: 'error',
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonColor: '#b91c1c',
                cancelButtonColor: '#3b82f6',
                confirmButtonText: 'Yes, permanently delete',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    submitFormWithoutHistory(form);
                }
            });
        });
    });

    document.querySelectorAll('.restore-user-form').forEach(form => {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            Swal.fire({
                title: 'Restore User?',
                text: 'Do you want to restore this user account?',
                icon: 'question',
                showCancelButton: true,
                reverseButtons: true,
                confirmButtonColor: '#10b981',
                cancelButtonColor: '#3b82f6',
                confirmButtonText: 'Yes, restore',
                cancelButtonText: 'Cancel'
            }).then((result) => {
                if (result.isConfirmed) {
                    submitFormWithoutHistory(form);
                }
            });
        });
    });
});
</script>
@endpush