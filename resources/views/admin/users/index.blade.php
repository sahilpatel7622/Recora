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

<style>
    /* Force remove the bottom border on the last row of the table to prevent double lines */
    .users-table tbody tr:last-child,
    .users-table tbody tr:last-child td {
        border-bottom: 0px !important;
    }
</style>

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

        <div class="users-header-actions" style="display: flex; gap: 10px; align-items: center;">

            @if($users->total() > 0)
                <div class="header-middle-section" style="margin-left: auto; margin-right: 15px;">
                    <form action="{{ route('admin.users.index') }}" method="GET" id="perPageForm" style="margin: 0;">
                        <input type="hidden" name="filter" value="{{ $filter }}">
                        <input type="hidden" name="search" value="{{ $search }}">
                        <div style="display: flex; align-items: center; gap: 8px; font-size: 14px; color: #475569; font-weight: 500;">
                            Show 
                            <div style="position: relative;">
                                <select name="per_page" id="per_page" onchange="document.getElementById('perPageForm').submit()" style="appearance: none; padding: 8px 32px 8px 14px; border: 1px solid #cbd5e1; border-radius: 8px; outline: none; background: linear-gradient(to bottom, #ffffff, #f8fafc); color: #0f172a; font-size: 14px; cursor: pointer; font-weight: 600; box-shadow: 0 1px 2px rgba(0,0,0,0.05); transition: all 0.2s;">
                                    <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                    <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                    <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                    <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>
                                </select>
                                <i class="fa-solid fa-angle-down" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); font-size: 12px; color: #64748b; pointer-events: none;"></i>
                            </div>
                        </div>
                    </form>
                </div>

                <a href="{{ route('admin.users.export.pdf', ['filter' => request('filter'), 'search' => request('search')]) }}" class="export-pdf-btn" style="display: inline-flex; align-items: center; gap: 8px; padding: 10px 18px; background: #fef2f2; color: #dc2626; border: 1px solid #fca5a5; font-size: 14px; font-weight: 600; border-radius: 10px; text-decoration: none; transition: all 0.2s ease;">
                    <i class="fa-solid fa-file-pdf"></i>
                    Export PDF
                </a>
            @endif

            @if($users->total() > 0 || $search !== '')
                <form action="{{ route('admin.users.index') }}"
                  method="GET"
                  class="users-search-form"
                  style="margin: 0;">

                <input type="hidden"
                       name="filter"
                       value="{{ $filter }}">
                <input type="hidden" name="per_page" value="{{ request('per_page', 10) }}">

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
            @endif

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

                        <td style="color: #64748b; font-weight: 500;">
                            {{ $users->firstItem() + $loop->index }}
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

    @if($users->total() > 0)
        <div class="users-pagination-wrapper" style="display: flex; justify-content: space-between; align-items: center; padding: 2px 24px 2px 24px; background: #fff; border-bottom-left-radius: 16px; border-bottom-right-radius: 16px; width: 100%;">
            <div class="users-pagination" style="display: block; width: 100%; margin: 0;">
            @if($users->hasPages())
                {{ $users->links() }}
            @else
                <nav role="navigation" aria-label="Pagination Navigation" style="display: flex; align-items: center; justify-content: space-between; width: 100%;">
                    <div>
                        <p style="font-size: 0.875rem; color: #374151; line-height: 1.25rem; margin: 0;">
                            Showing <span style="font-weight: 600;">1</span> to <span style="font-weight: 600;">{{ $users->count() }}</span> of <span style="font-weight: 600;">{{ $users->total() }}</span> results
                        </p>
                    </div>
                    <div>
                        <span style="position: relative; z-index: 0; display: inline-flex; box-shadow: 0 1px 2px 0 rgba(0, 0, 0, 0.05); border-radius: 0.375rem;">
                            <span aria-disabled="true" aria-label="&laquo; Previous">
                                <span style="position: relative; display: inline-flex; align-items: center; padding: 0.5rem 0.75rem; font-size: 0.875rem; font-weight: 500; color: #9ca3af; background-color: #ffffff; border: 1px solid #d1d5db; cursor: not-allowed; border-top-left-radius: 0.375rem; border-bottom-left-radius: 0.375rem; line-height: 1.25rem;" aria-hidden="true">
                                    <svg style="width: 1.25rem; height: 1.25rem;" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M12.707 5.293a1 1 0 010 1.414L9.414 10l3.293 3.293a1 1 0 01-1.414 1.414l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                            </span>
                            <span aria-current="page">
                                <span style="position: relative; display: inline-flex; align-items: center; padding: 0.5rem 1rem; margin-left: -1px; font-size: 0.875rem; font-weight: 600; color: #2563eb; background-color: #eff6ff; border: 1px solid #d1d5db; cursor: default; line-height: 1.25rem;">1</span>
                            </span>
                            <span aria-disabled="true" aria-label="Next &raquo;">
                                <span style="position: relative; display: inline-flex; align-items: center; padding: 0.5rem 0.75rem; margin-left: -1px; font-size: 0.875rem; font-weight: 500; color: #9ca3af; background-color: #ffffff; border: 1px solid #d1d5db; cursor: not-allowed; border-top-right-radius: 0.375rem; border-bottom-right-radius: 0.375rem; line-height: 1.25rem;" aria-hidden="true">
                                    <svg style="width: 1.25rem; height: 1.25rem;" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                                    </svg>
                                </span>
                            </span>
                        </span>
                    </div>
                </nav>
            @endif
        </div>
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
            
            // Prevent form submission to avoid page reload and URL change
            if(searchInput.form) {
                searchInput.form.addEventListener('submit', function(e) {
                    e.preventDefault();
                });
            }

            // Client-side instant filtering
            searchInput.addEventListener('input', function () {
                const val = this.value.toLowerCase().trim();
                const rows = document.querySelectorAll('.users-table tbody tr');
                
                rows.forEach(row => {
                    const text = row.innerText.toLowerCase();
                    if (text.includes(val)) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            });
        }
    });
</script>
@endpush
