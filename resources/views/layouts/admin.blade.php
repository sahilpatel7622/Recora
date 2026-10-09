<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') | {{ $projectSettings->project_name ?? 'Folder Management' }}</title>

    <link rel="stylesheet" href="{{ asset('css/admin.css') }}?v={{ time() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    @stack('styles')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>

<div class="admin-layout">

    <aside class="admin-sidebar">

        <div class="sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-brand">
                @if(isset($projectSettings) && $projectSettings->project_logo)
                    <img src="{{ asset('storage/' . $projectSettings->project_logo) }}" alt="Logo" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,0.1);">
                @else
                    <div class="sidebar-brand-icon">FM</div>
                @endif

                <div class="sidebar-brand-text">
                    <h3>{{ $projectSettings->project_name ?? 'Folder Management' }}</h3>
                    <span>Admin Panel</span>
                </div>
            </a>
        </div>

        <ul class="sidebar-menu">

            <li class="sidebar-menu-title">Main Menu</li>

            <li>
                <a href="{{ route('admin.dashboard') }}"
                   class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="{{ route('admin.users.index') }}"
                   class="{{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users"></i>
                    <span>Users</span>
                </a>
            </li>



            <li>
                <a href="#"
                   class="{{ request()->routeIs('admin.folders*') ? 'active' : '' }}">
                    <i class="fa-solid fa-folder-open"></i>
                    <span>Folders</span>
                </a>
            </li>

            <li>
                <a href="#"
                   class="{{ request()->routeIs('admin.invoices*') ? 'active' : '' }}">
                    <i class="fa-solid fa-file-invoice"></i>
                    <span>Invoices</span>
                </a>
            </li>

            <li class="sidebar-menu-title">System</li>

            <li>
                <a href="{{ route('admin.settings.index') }}"
                class="{{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                    <i class="fa-solid fa-gear"></i>
                    <span>Setting</span>
                </a>
            </li>

            <li>
                <a href="#"
                   class="{{ request()->routeIs('admin.profile*') ? 'active' : '' }}">
                    <i class="fa-solid fa-user-gear"></i>
                    <span>Profile Settings</span>
                </a>
            </li>

        </ul>

        <div class="sidebar-footer">
            <form action="{{ route('admin.logout') }}" method="POST" class="logout-form">
                @csrf

                <button type="submit" class="sidebar-logout-btn">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>

    </aside>

    <main class="admin-main">

    <header class="admin-navbar">

        

        <div class="navbar-heading">
            <h2>@yield('page-title', 'Dashboard Overview')</h2>
            <span>@yield('page-description', 'Manage your admin panel')</span>
        </div>

        <div class="navbar-right">

            <div class="navbar-datetime">
                <div class="datetime-icon">
                    <i class="fa-regular fa-calendar"></i>
                </div>

                <div class="datetime-info">
                    <span id="adminCurrentDate"></span>
                    <strong id="adminCurrentTime"></strong>
                </div>
            </div>

            @php
                $maintenanceStatus = \App\Models\Maintenance::first()?->is_active ?? 0;
            @endphp
            <button type="button"
                    class="maintenance-btn {{ $maintenanceStatus ? 'btn-live' : 'btn-maintenance' }}"
                    id="desktopMaintenanceBtn">
                @if($maintenanceStatus)
                    <i class="fa-solid fa-circle-check"></i>
                    <span>Live</span>
                @else
                    <i class="fa-solid fa-screwdriver-wrench"></i>
                    <span>Maintenance</span>
                @endif
            </button>

@php
    $adminNotifications = \App\Models\Notification::with('user')->latest()->take(10)->get();
    $unreadNotificationCount = \App\Models\Notification::where('is_read', false)->count();
@endphp
<div class="admin-notification-wrapper">

    <button type="button"
            class="navbar-notification-btn"
            id="desktopNotificationBtn">

        <i class="fa-regular fa-bell"></i>

        @if($unreadNotificationCount > 0)
        <span class="notification-count"
              id="desktopNotificationCount">
            {{ $unreadNotificationCount }}
        </span>
        @endif

    </button>

    <div class="admin-notification-dropdown"
         id="adminNotificationDropdown">

        <div class="notification-dropdown-header">

            <strong>Notifications</strong>

            <div class="notification-header-right">

                <span id="notificationTotal">
                    {{ $unreadNotificationCount > 0 ? $unreadNotificationCount . ' New' : '0' }}
                </span>

                <button type="button"
                        id="markAllNotificationsRead">
                    Read All
                </button>

            </div>

        </div>

        <div class="notification-list"
             id="adminNotificationList">

            @if($adminNotifications->isEmpty())
                <p class="no-notifications">
                    No notifications
                </p>
            @else
                @foreach($adminNotifications as $notification)
                    <a href="#" class="admin-notification-item {{ $notification->is_read ? '' : 'unread' }}" style="display: flex; gap: 12px; align-items: flex-start; text-decoration: none;">
                        <div class="notification-icon" style="flex-shrink: 0; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: {{ $notification->type === 'login' ? 'rgba(59, 130, 246, 0.1)' : ($notification->type === 'register' ? 'rgba(16, 185, 129, 0.1)' : ($notification->type === 'logout' ? 'rgba(239, 68, 68, 0.1)' : 'rgba(107, 114, 128, 0.1)')) }}; color: {{ $notification->type === 'login' ? '#3b82f6' : ($notification->type === 'register' ? '#10b981' : ($notification->type === 'logout' ? '#ef4444' : '#6b7280')) }}; font-size: 14px;">
                            @if($notification->type === 'login')
                                <i class="fa-solid fa-arrow-right-to-bracket"></i>
                            @elseif($notification->type === 'register')
                                <i class="fa-solid fa-user-plus"></i>
                            @elseif($notification->type === 'logout')
                                <i class="fa-solid fa-arrow-right-from-bracket"></i>
                            @else
                                <i class="fa-solid fa-bell"></i>
                            @endif
                        </div>
                        <div class="notification-content" style="flex: 1;">
                            <div class="notification-title">{{ $notification->title }}</div>
                            <div class="notification-message">{{ $notification->message }}</div>
                            <div class="notification-time">{{ $notification->created_at->diffForHumans() }}</div>
                        </div>
                    </a>
                @endforeach
            @endif

        </div>

        <div class="notification-dropdown-footer">
            <a href="#">Show All</a>
        </div>

    </div>

</div>

            <div class="admin-profile-dropdown">

                <button type="button"
                        class="admin-profile-button"
                        id="adminProfileButton">

                    <div class="navbar-admin-avatar">
                        {{ strtoupper(substr(session('admin_name', 'A'), 0, 1)) }}
                    </div>

                    <div class="navbar-admin-info">
                        <strong>{{ session('admin_name', 'Admin') }}</strong>
                    </div>

                    <i class="fa-solid fa-chevron-down profile-arrow"></i>

                </button>

                <div class="admin-dropdown-menu"
                    id="adminProfileDropdown">

                    <a href="#">
                        <i class="fa-solid fa-user-gear"></i>
                        <span>Profile</span>
                    </a>

                    <div class="dropdown-divider"></div>

                    <form action="{{ route('admin.logout') }}"
                        method="POST" class="logout-form">

                        @csrf

                        <button type="submit"
                                class="dropdown-logout-btn">

                            <i class="fa-solid fa-right-from-bracket"></i>
                            <span>Logout</span>

                        </button>

                    </form>

                </div>

            </div>

        </div>

    </header>

        <section class="admin-content">
            @yield('content')
        </section>

    </main>

</div>



@if(session('success') || session('error'))

<div class="admin-toast {{ session('success') ? 'toast-success' : 'toast-error' }}"
     id="adminToast">

    <div class="toast-icon">
        <i class="fa-solid {{ session('success') ? 'fa-circle-check' : 'fa-circle-exclamation' }}"></i>
    </div>

    <div class="toast-content">
        <strong>{{ session('success') ? 'Success' : 'Error' }}</strong>
        <span>{{ session('success') ?? session('error') }}</span>
    </div>

    <button type="button"
            class="toast-close"
            onclick="closeAdminToast()">
        <i class="fa-solid fa-xmark"></i>
    </button>

    <div class="toast-progress"></div>

</div>

@endif

<script>
function updateAdminDateTime() {
    const now = new Date();
    const isMobile = window.innerWidth <= 640;

    const dateOptions = isMobile
        ? {
            timeZone: 'Asia/Kolkata',
            day: '2-digit',
            month: 'short'
        }
        : {
            timeZone: 'Asia/Kolkata',
            weekday: 'short',
            day: '2-digit',
            month: 'short',
            year: 'numeric'
        };

    const timeOptions = isMobile
        ? {
            timeZone: 'Asia/Kolkata',
            hour: '2-digit',
            minute: '2-digit',
            hour12: true
        }
        : {
            timeZone: 'Asia/Kolkata',
            hour: '2-digit',
            minute: '2-digit',
            second: '2-digit',
            hour12: true
        };

    const dateElement = document.getElementById('adminCurrentDate');
    const timeElement = document.getElementById('adminCurrentTime');

    if (dateElement) {
        dateElement.textContent =
            now.toLocaleDateString('en-IN', dateOptions);
    }

    if (timeElement) {
        timeElement.textContent =
            now.toLocaleTimeString('en-IN', timeOptions);
    }
}

updateAdminDateTime();
setInterval(updateAdminDateTime, 1000);
window.addEventListener('resize', updateAdminDateTime);



adminMobileActionsOverlay?.addEventListener(
    'click',
    closeAdminMobilePanel
);

function closeAdminToast() {
    const toast = document.getElementById('adminToast');

    if (!toast) return;

    toast.classList.add('toast-hide');

    setTimeout(function () {
        toast.remove();
    }, 200);
}

function showAdminToast(message, type = 'success') {
    let existingToast = document.getElementById('adminToast');
    if (existingToast) {
        existingToast.remove();
    }
    
    const toast = document.createElement('div');
    toast.className = `admin-toast toast-${type}`;
    toast.id = 'adminToast';
    
    const iconClass = type === 'success' ? 'fa-circle-check' : 'fa-circle-exclamation';
    const title = type === 'success' ? 'Success' : 'Error';
    const duration = type === 'success' ? 2000 : 10000;
    
    toast.innerHTML = `
        <div class="toast-icon">
            <i class="fa-solid ${iconClass}"></i>
        </div>
        <div class="toast-content">
            <strong>${title}</strong>
            <span>${message}</span>
        </div>
        <button type="button" class="toast-close" onclick="closeAdminToast()">
            <i class="fa-solid fa-xmark"></i>
        </button>
        <div class="toast-progress"></div>
    `;
    
    document.body.appendChild(toast);
    
    setTimeout(closeAdminToast, duration);
}

{
    const adminToastEl = document.getElementById('adminToast');
    if (adminToastEl) {
        const isError = adminToastEl.classList.contains('toast-error');
        const timeoutDuration = isError ? 10000 : 2000;
        setTimeout(closeAdminToast, timeoutDuration);
    }
}

window.addEventListener('pageshow', function (event) {
    if (event.persisted) {
        const toast = document.getElementById('adminToast');
        if (toast) toast.remove();
    }
});

// Extra fallback for browsers that load from disk cache instead of bfcache
if (window.performance && window.performance.getEntriesByType) {
    const navEntries = window.performance.getEntriesByType("navigation");
    if (navEntries.length > 0 && navEntries[0].type === "back_forward") {
        const toast = document.getElementById('adminToast');
        if (toast) toast.remove();
    }
}
</script>

<script>
var desktopMaintenanceBtn = document.getElementById('desktopMaintenanceBtn');


function updateMaintenanceUI(status) {
    const isActive = Number(status) === 1;

    if (desktopMaintenanceBtn) {
        if (isActive) {
            desktopMaintenanceBtn.innerHTML = '<i class="fa-solid fa-circle-check"></i><span>Live</span>';
            desktopMaintenanceBtn.className = 'maintenance-btn btn-live';
        } else {
            desktopMaintenanceBtn.innerHTML = '<i class="fa-solid fa-screwdriver-wrench"></i><span>Maintenance</span>';
            desktopMaintenanceBtn.className = 'maintenance-btn btn-maintenance';
        }
    }

     else {
            mobileMaintenanceBtn.innerHTML = '<i class="fa-solid fa-circle-check" style="width: 21px; text-align: center; font-size: 16px;"></i><span>Live</span>';
            mobileMaintenanceBtn.className = 'mobile-status-indicator mobile-btn-live';
        }
    }
}

async function getMaintenanceStatus() {
    try {
        const response = await fetch('{{ route("admin.maintenance.status") }}', {
            headers: {
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (window.lastAdminMaintenanceStatus === data.status) return;
        window.lastAdminMaintenanceStatus = data.status;

        updateMaintenanceUI(data.status);
    } catch (error) {
        console.error('Maintenance status error:', error);
    }
}

async function toggleMaintenance() {
    const isCurrentlyOn = desktopMaintenanceBtn && desktopMaintenanceBtn.classList.contains('btn-live');

    const titleText = isCurrentlyOn ? 'Make Website Live?' : 'Enable Maintenance Mode?';
    const textMsg = isCurrentlyOn 
        ? 'Are you sure you want to turn OFF maintenance mode and make the website live for everyone?' 
        : 'Are you sure you want to turn ON maintenance mode? Normal users will not be able to access the website.';
    const confirmBtnText = isCurrentlyOn ? 'Yes, Make Live' : 'Yes, Enable Maintenance';
    const confirmBtnColor = isCurrentlyOn ? '#198754' : '#d33';
    const iconType = isCurrentlyOn ? 'question' : 'warning';

    const result = await Swal.fire({
        title: titleText,
        text: textMsg,
        icon: iconType,
        showCancelButton: true,
        showCloseButton: true,
        reverseButtons: true,
        confirmButtonColor: confirmBtnColor,
        cancelButtonColor: '#3085d6',
        confirmButtonText: confirmBtnText
    });

    if (!result.isConfirmed) return;

    try {
        const response = await fetch('{{ route("admin.maintenance.toggle") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        });

        const data = await response.json();

        updateMaintenanceUI(data.status);
        
        Swal.fire({
            toast: true,
            position: 'top-end',
            icon: 'success',
            title: 'Maintenance mode updated',
            showConfirmButton: false,
            timer: 3000
        });
    } catch (error) {
        console.error('Maintenance toggle error:', error);
    }
}

desktopMaintenanceBtn?.addEventListener('click', toggleMaintenance);

getMaintenanceStatus();

setInterval(getMaintenanceStatus, 2000);
</script>

<script>
var adminProfileButton =
    document.getElementById('adminProfileButton');

var adminProfileDropdown =
    document.getElementById('adminProfileDropdown');

adminProfileButton?.addEventListener('click', function (e) {
    e.stopPropagation();

    if (typeof adminNotificationDropdown !== 'undefined' && adminNotificationDropdown) {
        adminNotificationDropdown.classList.remove('show');
    }

    adminProfileDropdown?.classList.toggle('show');
    adminProfileButton.classList.toggle('active');
});

document.addEventListener('click', function (e) {
    if (
        adminProfileDropdown &&
        adminProfileButton &&
        !adminProfileDropdown.contains(e.target) &&
        !adminProfileButton.contains(e.target)
    ) {
        adminProfileDropdown.classList.remove('show');
        adminProfileButton.classList.remove('active');
    }
});

document.querySelectorAll('.logout-form').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        Swal.fire({
            title: 'Logout?',
            text: 'Are you sure you want to logout?',
            icon: 'question',
            showCancelButton: true,
            showCloseButton: true,
            reverseButtons: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, Logout'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>

<script>
var desktopNotificationBtn =
    document.getElementById('desktopNotificationBtn');

var adminNotificationDropdown =
    document.getElementById('adminNotificationDropdown');

desktopNotificationBtn?.addEventListener('click', function (e) {
    e.stopPropagation();
    
    if (typeof adminProfileDropdown !== 'undefined' && adminProfileDropdown) {
        adminProfileDropdown.classList.remove('show');
        if (typeof adminProfileButton !== 'undefined' && adminProfileButton) {
            adminProfileButton.classList.remove('active');
        }
    }
    
    adminNotificationDropdown?.classList.toggle('show');
});

var mobileNotificationBtn = document.getElementById('mobileNotificationBtn');
mobileNotificationBtn?.addEventListener('click', function (e) {
    e.stopPropagation();
    // Close sidebar first if open
    closeAdminMobilePanel();
    
    if (typeof adminProfileDropdown !== 'undefined' && adminProfileDropdown) {
        adminProfileDropdown.classList.remove('show');
        if (typeof adminProfileButton !== 'undefined' && adminProfileButton) {
            adminProfileButton.classList.remove('active');
        }
    }
    
    adminNotificationDropdown?.classList.toggle('show');
});

document.addEventListener('click', function (e) {
    if (
        adminNotificationDropdown &&
        !adminNotificationDropdown.contains(e.target) &&
        (!desktopNotificationBtn || !desktopNotificationBtn.contains(e.target)) &&
        (!mobileNotificationBtn || !mobileNotificationBtn.contains(e.target))
    ) {
        adminNotificationDropdown.classList.remove('show');
    }
});

var markAllNotificationsReadBtn = document.getElementById('markAllNotificationsRead');
if (markAllNotificationsReadBtn) {
    markAllNotificationsReadBtn.addEventListener('click', async function(e) {
        e.preventDefault();
        try {
            const response = await fetch('{{ route('admin.notifications.readAll') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            });
            
            const data = await response.json();
            
            if (data.success) {
                const unreadItems = document.querySelectorAll('.admin-notification-item.unread');
                unreadItems.forEach(item => item.classList.remove('unread'));
                
                const countBadge = document.getElementById('desktopNotificationCount');
                if (countBadge) countBadge.remove();
                
                const totalSpan = document.getElementById('notificationTotal');
                if (totalSpan) totalSpan.innerText = '0';
                
                markAllNotificationsReadBtn.style.display = 'none'; // Optional: hide the button since everything is read
                
                if (typeof adminNotificationDropdown !== 'undefined' && adminNotificationDropdown) {
                    adminNotificationDropdown.classList.remove('show');
                }
                
                showAdminToast('All notifications marked as read', 'success');
            }
        } catch (error) {
            console.error('Error marking notifications as read:', error);
        }
    });
}

async function fetchNotifications() {
    try {
        const url = '{{ route('admin.notifications') }}?_t=' + new Date().getTime();
        const response = await fetch(url, {
            headers: {
                'Accept': 'application/json',
                'Cache-Control': 'no-cache, no-store, must-revalidate',
                'Pragma': 'no-cache',
                'Expires': '0'
            },
            cache: 'no-store'
        });
        const data = await response.json();
        
        const currentDataStr = JSON.stringify(data);
        if (window.lastAdminNotificationData === currentDataStr) return;
        window.lastAdminNotificationData = currentDataStr;
        
        const totalSpan = document.getElementById('notificationTotal');
        if (totalSpan) totalSpan.innerText = data.count > 0 ? data.count + ' New' : '0';

        let countBadge = document.getElementById('desktopNotificationCount');
        const desktopBtn = document.getElementById('desktopNotificationBtn');
        const readAllBtn = document.getElementById('markAllNotificationsRead');
        
        if (data.count > 0) {
            if (!countBadge && desktopBtn) {
                countBadge = document.createElement('span');
                countBadge.className = 'notification-count';
                countBadge.id = 'desktopNotificationCount';
                desktopBtn.appendChild(countBadge);
            }
            if (countBadge) countBadge.innerText = data.count;
            if (readAllBtn) readAllBtn.style.display = 'block';
        } else {
            if (countBadge) countBadge.remove();
            if (readAllBtn) readAllBtn.style.display = 'none';
        }

        const listContainer = document.getElementById('adminNotificationList');
        if (listContainer) {
            if (data.notifications.length === 0) {
                listContainer.innerHTML = '<p class="no-notifications">No notifications</p>';
            } else {
                let html = '';
                data.notifications.forEach(notif => {
                    const iconColor = notif.type === 'login' ? '#3b82f6' : (notif.type === 'register' ? '#10b981' : (notif.type === 'logout' ? '#ef4444' : '#6b7280'));
                    const iconBg = notif.type === 'login' ? 'rgba(59, 130, 246, 0.1)' : (notif.type === 'register' ? 'rgba(16, 185, 129, 0.1)' : (notif.type === 'logout' ? 'rgba(239, 68, 68, 0.1)' : 'rgba(107, 114, 128, 0.1)'));
                    
                    let iconClass = 'fa-bell';
                    if (notif.type === 'login') iconClass = 'fa-arrow-right-to-bracket';
                    if (notif.type === 'register') iconClass = 'fa-user-plus';
                    if (notif.type === 'logout') iconClass = 'fa-arrow-right-from-bracket';
                    
                    html += `
                        <a href="#" class="admin-notification-item ${notif.is_read ? '' : 'unread'}" style="display: flex; gap: 12px; align-items: flex-start; text-decoration: none;">
                            <div class="notification-icon" style="flex-shrink: 0; width: 32px; height: 32px; border-radius: 50%; display: flex; align-items: center; justify-content: center; background: ${iconBg}; color: ${iconColor}; font-size: 14px;">
                                <i class="fa-solid ${iconClass}"></i>
                            </div>
                            <div class="notification-content" style="flex: 1;">
                                <div class="notification-title">${notif.title}</div>
                                <div class="notification-message">${notif.message}</div>
                                <div class="notification-time">${notif.time}</div>
                            </div>
                        </a>
                    `;
                });
                listContainer.innerHTML = html;
            }
        }
    } catch (error) {
        console.error('Error fetching notifications:', error);
    }
}

setInterval(fetchNotifications, 5000);

document.addEventListener('input', function(e) {
    if (['INPUT', 'TEXTAREA', 'SELECT'].includes(e.target.tagName)) {
        let errorSpan = e.target.nextElementSibling;
        if (errorSpan && errorSpan.classList.contains('text-danger')) {
            errorSpan.style.display = 'none';
        }
    }
});

document.addEventListener('change', function(e) {
    if (['INPUT', 'TEXTAREA', 'SELECT'].includes(e.target.tagName)) {
        let errorSpan = e.target.nextElementSibling;
        if (errorSpan && errorSpan.classList.contains('text-danger')) {
            errorSpan.style.display = 'none';
        }
    }
});

</script>

@stack('scripts')

</body>
</html>
