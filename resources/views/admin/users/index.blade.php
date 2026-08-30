@extends('layouts.admin')

@section('title', 'Users')

@section('page-title', 'User Management')

@section('page-description', 'View and manage registered users')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/admin-users.css') }}?v={{ time() }}">
@endpush

@section('content')

<div class="users-stats-grid">

    <a href="{{ route('admin.users.index', ['filter' => 'all']) }}"
       class="user-stat-card {{ $filter === 'all' ? 'active' : '' }}">

        <div class="user-stat-icon stat-purple">
            <i class="fa-solid fa-users"></i>
        </div>

        <div class="user-stat-content">
            <span>Total Users</span>
            <strong>{{ $totalUsers }}</strong>
        </div>

    </a>

    <a href="{{ route('admin.users.index', ['filter' => 'active']) }}"
       class="user-stat-card {{ $filter === 'active' ? 'active' : '' }}">

        <div class="user-stat-icon stat-green">
            <i class="fa-solid fa-user-check"></i>
        </div>

        <div class="user-stat-content">
            <span>Active Users</span>
            <strong>{{ $activeUsers }}</strong>
        </div>

    </a>

    <a href="{{ route('admin.users.index', ['filter' => 'inactive']) }}"
       class="user-stat-card {{ $filter === 'inactive' ? 'active' : '' }}">

        <div class="user-stat-icon stat-red">
            <i class="fa-solid fa-user-xmark"></i>
        </div>

        <div class="user-stat-content">
            <span>Inactive Users</span>
            <strong>{{ $inactiveUsers }}</strong>
        </div>

    </a>

    <a href="{{ route('admin.users.index', ['filter' => 'deleted']) }}"
       class="user-stat-card {{ $filter === 'deleted' ? 'active' : '' }}">

        <div class="user-stat-icon stat-orange">
            <i class="fa-solid fa-trash-can"></i>
        </div>

        <div class="user-stat-content">
            <span>Deleted Users</span>
            <strong>{{ $deletedUsers }}</strong>
        </div>

    </a>

</div>

<div class="users-main-card">

    <div class="users-card-header">

        <div class="users-card-title">

            <h3>
                @if($filter === 'deleted')
                    Deleted Users
                @elseif($filter === 'active')
                    Active Users
                @elseif($filter === 'inactive')
                    Inactive Users
                @else
                    All Users
                @endif
            </h3>

            <p>
                @if($filter === 'deleted')
                    Restore or permanently delete user accounts
                @else
                    View and manage registered user accounts
                @endif
            </p>

        </div>

        <div class="users-header-actions">

            <form action="{{ route('admin.users.index') }}"
                  method="GET"
                  class="users-search-form">

                <input type="hidden"
                       name="filter"
                       value="{{ $filter }}">

                <div class="users-search-box">

                    <i class="fa-solid fa-magnifying-glass"></i>

                    <input type="text"
                           name="search"
                           id="usersSearchInput"
                           value="{{ $search }}"
                           placeholder="Search name, email, phone..."
                           maxlength="50">

                </div>

            </form>

            @if($filter !== 'deleted')

                <a href="{{ route('admin.users.create') }}"
                   class="add-user-btn">

                    <i class="fa-solid fa-user-plus"></i>
                    Add User

                </a>

            @endif

        </div>

    </div>

    <div class="users-table-wrapper">

        <table class="users-table">

            <thead>

                <tr>
                    <th>#</th>
                    <th>User</th>
                    <th>Phone</th>
                    <!-- <th>Device</th> -->
                    <!-- <th>Browser</th> -->
                    <!-- <th>Last Login</th> -->
                    <th>Status</th>
                    <th>Joined</th>
                    <th class="text-center">Actions</th>
                </tr>

            </thead>

            <tbody>

                @forelse($users as $user)

                    <tr>

                        <td style="color: green;">
                            #{{ $user->id }}
                        </td>

                        <td>

                            <div class="table-user-info">

                                <div class="table-user-avatar">
                                    {{ strtoupper(substr($user->name, 0, 1)) }}
                                </div>

                                <div class="table-user-text">

                                    <strong>
                                        {{ $user->name }}
                                    </strong>

                                    <span>
                                        {{ $user->email }}
                                    </span>

                                </div>

                            </div>

                        </td>

                        <td>
                            {{ $user->number ?: 'Not added' }}
                        </td>

                        <!-- <td>
                            {{ $user->device ?: 'Unknown' }}
                        </td>

                        <td>
                            {{ $user->browser ?: 'Unknown' }}
                        </td>

                        <td>

                            @if($user->last_login_time)

                                <div class="last-login-info">

                                    <strong>
                                        {{ $user->last_login_time->timezone('Asia/Kolkata')->format('d M Y') }}
                                    </strong>

                                    <span>
                                        {{ $user->last_login_time->timezone('Asia/Kolkata')->format('h:i A') }}
                                    </span>

                                </div>

                            @else

                                <span class="not-available">
                                    Never
                                </span>

                            @endif

                        </td> -->

                        <td>

                            @if($user->trashed())

                                <span class="user-status-badge deleted-status">
                                    <i class="fa-solid fa-trash"></i>
                                    Deleted
                                </span>

                            @else

                                <form action="{{ route('admin.users.status', $user->id) }}"
                                      method="POST"
                                      class="status-toggle-form">

                                    @csrf
                                    @method('PATCH')

                                    <button type="submit"
                                            class="status-toggle {{ $user->status ? 'status-active' : 'status-inactive' }}"
                                            title="{{ $user->status ? 'Click to deactivate' : 'Click to activate' }}">

                                        <span class="status-toggle-circle"></span>

                                    </button>

                                    <span class="status-toggle-text {{ $user->status ? 'active-text' : 'inactive-text' }}">
                                        {{ $user->status ? 'Active' : 'Inactive' }}
                                    </span>

                                </form>

                            @endif

                        </td>

                        <td>

                            <div class="joined-date">

                                <strong>
                                    {{ $user->created_at->timezone('Asia/Kolkata')->format('d M Y') }}
                                </strong>

                                <span>
                                    {{ $user->created_at->timezone('Asia/Kolkata')->format('h:i A') }}
                                </span>

                            </div>

                        </td>

                        <td>

                            <div class="user-action-buttons">

                                <a href="{{ route('admin.users.show', $user->id) }}"
                                   class="user-action-btn view-user-btn"
                                   title="View user">

                                    <i class="fa-regular fa-eye"></i>

                                </a>

                                @if($user->trashed())

                                    <form action="{{ route('admin.users.restore', $user->id) }}"
                                          method="POST"
                                          class="restore-user-form">

                                        @csrf
                                        @method('PATCH')

                                        <button type="submit"
                                                class="user-action-btn restore-user-btn"
                                                title="Restore user">

                                            <i class="fa-solid fa-rotate-left"></i>

                                        </button>

                                    </form>

                                    <form action="{{ route('admin.users.force-delete', $user->id) }}"
                                          method="POST"
                                          class="force-delete-user-form">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="user-action-btn hard-delete-user-btn"
                                                title="Permanently delete user">

                                            <i class="fa-solid fa-trash"></i>

                                        </button>

                                    </form>

                                @else

                                    <form action="{{ route('admin.users.destroy', $user->id) }}"
                                          method="POST"
                                          class="delete-user-form">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="user-action-btn delete-user-btn"
                                                title="Delete user">

                                            <i class="fa-regular fa-trash-can"></i>

                                        </button>

                                    </form>

                                @endif

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="9"
                            class="users-empty-state">

                            <div class="users-empty-icon">

                                @if($filter === 'deleted')
                                    <i class="fa-solid fa-trash-can"></i>
                                @else
                                    <i class="fa-solid fa-users-slash"></i>
                                @endif

                            </div>

                            <h3>
                                No users found
                            </h3>

                            <p>
                                No user records match your current search or filter.
                            </p>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

    @if($users->hasPages())

        <div class="users-pagination">
            {{ $users->links() }}
        </div>

    @endif

</div>

@push('scripts')
<script>
document.querySelectorAll('.delete-user-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Delete User?',
            text: 'Move this user to deleted users?',
            icon: 'warning',
            showCancelButton: true,
            showCloseButton: true,
            reverseButtons: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
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
            showCloseButton: true,
            reverseButtons: true,
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, restore'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
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
            showCloseButton: true,
            reverseButtons: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete permanently'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
});
</script>
@endpush

@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById('usersSearchInput');
        if (searchInput) {
            let typingTimer;
            const doneTypingInterval = 500;
            
            // Auto focus and set cursor to end if search is active
            if(searchInput.value.length > 0) {
                searchInput.focus();
                let val = searchInput.value;
                searchInput.value = '';
                searchInput.value = val;
            }

            searchInput.addEventListener('input', function () {
                clearTimeout(typingTimer);
                typingTimer = setTimeout(function() {
                    searchInput.form.submit();
                }, doneTypingInterval);
            });
        }
    });
</script>
@endpush