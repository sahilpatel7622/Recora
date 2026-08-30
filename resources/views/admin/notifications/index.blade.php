@extends('layouts.admin')

@section('title', 'Notifications')
@section('page-title', 'Notifications')
@section('page-description', 'View notifications sent to users')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/admin-users.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="{{ asset('css/admin-notifications.css') }}?v={{ time() }}">
@endpush

@section('content')

<div class="users-stats-grid">

    <a href="{{ route('admin.notifications.index', ['filter' => 'all']) }}"
       class="user-stat-card {{ $filter === 'all' ? 'active' : '' }}">

        <div class="user-stat-icon stat-purple">
            <i class="fa-solid fa-bell"></i>
        </div>

        <div class="user-stat-content">
            <span>Total Notifications</span>
            <strong>{{ $totalNotifications ?? 0 }}</strong>
        </div>

    </a>

    <a href="{{ route('admin.notifications.index', ['filter' => 'read']) }}"
       class="user-stat-card {{ $filter === 'read' ? 'active' : '' }}">

        <div class="user-stat-icon stat-green">
            <i class="fa-solid fa-check-double"></i>
        </div>

        <div class="user-stat-content">
            <span>Read Notifications</span>
            <strong>{{ $readNotifications ?? 0 }}</strong>
        </div>

    </a>

    <a href="{{ route('admin.notifications.index', ['filter' => 'unread']) }}"
       class="user-stat-card {{ $filter === 'unread' ? 'active' : '' }}">

        <div class="user-stat-icon stat-orange">
            <i class="fa-solid fa-envelope"></i>
        </div>

        <div class="user-stat-content">
            <span>Unread Notifications</span>
            <strong>{{ $unreadNotifications ?? 0 }}</strong>
        </div>

    </a>

    <a href="{{ route('admin.notifications.index', ['filter' => 'deleted']) }}"
       class="user-stat-card {{ $filter === 'deleted' ? 'active' : '' }}">

        <div class="user-stat-icon stat-red">
            <i class="fa-solid fa-trash-can"></i>
        </div>

        <div class="user-stat-content">
            <span>Deleted Notifications</span>
            <strong>{{ $deletedNotifications ?? 0 }}</strong>
        </div>

    </a>

</div>

<div class="users-main-card">

    <div class="users-card-header">

        <div class="users-card-title">

            <h3>
                @if($filter === 'deleted')
                    Deleted Notifications
                @elseif($filter === 'read')
                    Read Notifications
                @elseif($filter === 'unread')
                    Unread Notifications
                @else
                    All Notifications
                @endif
            </h3>

            <p>
                @if($filter === 'deleted')
                    View or permanently delete notifications
                @else
                    View and manage sent notifications
                @endif
            </p>

        </div>

        <div class="users-header-actions">

            <form action="{{ route('admin.notifications.index') }}"
                  method="GET"
                  class="users-search-form">

                <input type="hidden"
                       name="filter"
                       value="{{ $filter ?? 'all' }}">

                <div class="users-search-box">

                    <i class="fa-solid fa-magnifying-glass"></i>

                    <input type="text"
                           name="search"
                           id="notifSearchInput"
                           value="{{ $search ?? '' }}"
                           placeholder="Search title, message, user..."
                           maxlength="50">

                </div>


            </form>

            @if(($filter ?? 'all') !== 'deleted')

                <a href="{{ route('admin.send-notification') }}"
                   class="add-user-btn">

                    <i class="fa-solid fa-paper-plane"></i>
                    Send Notification

                </a>

            @endif

        </div>

    </div>


        <div class="notifications-table-wrapper">

            <table class="notifications-table">

                <thead>
                    <tr>
                        <th>#</th>
                        <th>Notification Title</th>
                        <th>Notification Msg</th>
                        <th>User Type</th>
                        <th>Status</th>

                        <th style="text-align: center;">Actions</th>
                    </tr>
                </thead>

                <tbody>

                    @forelse($notifications as $notification)

                            <tr>

                                {{-- ID --}}
                                <td data-label="#" style="color: green;">
                                    #{{ $notification->id }}
                                </td>

                                {{-- Title --}}
                                <td data-label="Notification Title">
                                    <div class="notification-title">
                                        {{ $notification->title }}
                                    </div>
                                </td>

                                {{-- Message --}}
                                <td data-label="Notification Msg">
                                    <div class="notification-message">
                                        {{ $notification->message }}
                                    </div>
                                </td>

                                {{-- User Type --}}
                                <td data-label="User Type">
                                    @if($notification->recipient_type === 'all')
                                        <div style="font-weight: 400; color: #4f46e5;">
                                            <i class="fa-solid fa-users" style="margin-right: 5px;"></i> All
                                        </div>
                                    @else
                                        <div style="font-weight: 400; color: #059669;">
                                            <i class="fa-solid fa-user" style="margin-right: 5px;"></i> Selected
                                        </div>
                                    @endif
                                </td>


                                {{-- Status --}}
                                <td data-label="Status">

                                    @if($notification->is_read)

                                        <span class="notification-status status-read">
                                            <i class="fa-solid fa-check-double"></i>
                                            Read
                                        </span>

                                    @else

                                        <span class="notification-status status-unread">
                                            <i class="fa-solid fa-circle"></i>
                                            Unread
                                        </span>

                                    @endif

                                </td>


                                {{-- Action --}}
                                <td data-label="Actions">
                                    <div class="user-action-buttons">
                                        <button type="button" 
                                                class="user-action-btn view-user-btn"
                                                title="View notification"
                                                onclick="viewNotification('{{ addslashes($notification->title) }}', '{{ addslashes($notification->message) }}', '{{ $notification->created_at->format('d M Y, h:i A') }}', '{{ $notification->recipient_type === 'all' ? 'All Active Users' : addslashes($notification->user->name ?? 'Unknown User') }}')">
                                            <i class="fa-regular fa-eye"></i>
                                        </button>
                                        @if($notification->trashed())
                                            <form action="{{ route('admin.notifications.restore', $notification->id) }}"
                                                  method="POST"
                                                  class="restore-notif-form">
                                                @csrf
                                                @method('PATCH')
                                                <button type="submit"
                                                        class="user-action-btn restore-user-btn"
                                                        title="Restore notification">
                                                    <i class="fa-solid fa-rotate-left"></i>
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.notifications.force-delete', $notification->id) }}"
                                                  method="POST"
                                                  class="force-delete-notif-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="user-action-btn hard-delete-user-btn"
                                                        title="Permanently delete notification">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        @else
                                            <form action="{{ route('admin.notifications.destroy', $notification->id) }}"
                                                  method="POST"
                                                  class="delete-notif-form">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit"
                                                        class="user-action-btn delete-user-btn"
                                                        title="Delete notification">
                                                    <i class="fa-regular fa-trash-can"></i>
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>

                            </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="users-empty-state">

                                <div class="users-empty-icon">

                                    @if($filter === 'deleted')
                                        <i class="fa-solid fa-trash-can"></i>
                                    @else
                                        <i class="fa-regular fa-bell"></i>
                                    @endif

                                </div>

                                <h3>
                                    No Notifications
                                </h3>

                                <p>
                                    No notifications have been sent to users yet.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        @if($notifications->hasPages())
            <div class="users-pagination mt-4" style="padding: 20px;">
                {{ $notifications->links() }}
            </div>
        @endif

</div>

@endsection

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const searchInput = document.getElementById('notifSearchInput');
        if (searchInput) {
            let typingTimer;
            const doneTypingInterval = 500;
            
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

@push('scripts')
<script>
document.querySelectorAll('.delete-notif-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Delete Notification?',
            text: 'Move this notification to deleted?',
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

document.querySelectorAll('.restore-notif-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Restore Notification?',
            text: 'Do you want to restore this notification?',
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

document.querySelectorAll('.force-delete-notif-form').forEach(form => {
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

function viewNotification(title, message, date, recipient) {
    Swal.fire({
        title: title,
        html: `<div style="text-align: left; background: #f3f4f6; padding: 10px; border-radius: 8px; margin-bottom: 15px; font-size: 14px;">
                  <strong style="color: #4f46e5;">To:</strong> ${recipient}
               </div>
               <p style="color: #4b5563; font-size: 15px; margin-top: 10px; text-align: left;">${message}</p>
               <div style="margin-top: 20px; font-size: 13px; color: #9ca3af; text-align: left;"><i class="fa-regular fa-clock"></i> Sent at: ${date}</div>`,
        iconHtml: '<div style="width: 80px; height: 80px; border: 4px solid #6366f1; border-radius: 50%; display: flex; align-items: center; justify-content: center;"><i class="fa-regular fa-bell" style="color: #6366f1; font-size: 35px;"></i></div>',
        customClass: {
            icon: 'no-border-icon',
            confirmButton: 'save-user-btn'
        },
        confirmButtonText: "Close"
    });
}
</script>

<style>
.no-border-icon {
    border: none !important;
}
.swal2-confirm.save-user-btn {
    background: #4f46e5 !important;
    color: white !important;
    border: none !important;
    box-shadow: none !important;
}
.swal2-confirm.save-user-btn:hover {
    background: #4338ca !important;
}
</style>
@endpush