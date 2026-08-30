<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>@yield('title', 'Dashboard') | {{ $projectSettings->project_name ?? 'Folder Management' }}</title>

    <link rel="stylesheet" href="{{ asset('css/user.css') }}?v={{ time() }}">

    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
</head>

<body>

<div class="user-layout">

    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    <aside class="user-sidebar" id="userSidebar">

        <div class="sidebar-header">
            <a href="{{ route('dashboard') }}" class="sidebar-brand">
                @if(isset($projectSettings) && $projectSettings->project_logo)
                    <img src="{{ asset('storage/' . $projectSettings->project_logo) }}" alt="Logo" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(255,255,255,0.1);">
                @else
                    <div class="sidebar-brand-icon">FM</div>
                @endif

                <div class="sidebar-brand-text">
                    <h3>{{ $projectSettings->project_name ?? 'Folder Management' }}</h3>
                    <span>User Panel</span>
                </div>
            </a>

            <button type="button" class="sidebar-close" id="sidebarClose">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>

        <ul class="sidebar-menu">

            <li>
                <a href="{{ route('dashboard') }}"
                   class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie"></i>
                    <span>Dashboard</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="fa-solid fa-folder-open"></i>
                    <span>Folders</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="fa-solid fa-file-invoice"></i>
                    <span>Invoices</span>
                </a>
            </li>

            <li>
                <a href="#">
                    <i class="fa-solid fa-user"></i>
                    <span>Profile</span>
                </a>
            </li>

        </ul>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST">
                @csrf

                <button type="submit" class="sidebar-logout-btn">
                    <i class="fa-solid fa-right-from-bracket"></i>
                    <span>Logout</span>
                </button>
            </form>
        </div>

    </aside>

    <main class="user-main">

        <header class="user-navbar">

            <div class="navbar-brand-section">

                <button type="button"
                        class="sidebar-toggle"
                        id="sidebarToggle">
                    <i class="fa-solid fa-bars"></i>
                </button>

                <a href="{{ route('dashboard') }}" class="desktop-brand">
                    @if(isset($projectSettings) && $projectSettings->project_logo)
                        <img src="{{ asset('storage/' . $projectSettings->project_logo) }}" alt="Logo" style="width: 50px; height: 50px; border-radius: 50%; object-fit: cover; border: 2px solid rgba(0,0,0,0.05);">
                    @else
                        <div class="desktop-brand-icon">FM</div>
                    @endif

                    <div class="desktop-brand-text">
                        <strong>{{ $projectSettings->project_name ?? 'Folder Management' }}</strong>
                        <span>User Panel</span>
                    </div>
                </a>

            </div>

            <nav class="desktop-menu">

                <a href="{{ route('dashboard') }}"
                   class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-chart-pie"></i>
                    Dashboard
                </a>

                <a href="#">
                    <i class="fa-solid fa-folder-open"></i>
                    Folders
                </a>

                <a href="#">
                    <i class="fa-solid fa-file-invoice"></i>
                    Invoices
                </a>

            </nav>

        <div class="user-navbar-right">

            {{-- Date & Time --}}
            <div class="navbar-datetime">
                <div class="datetime-icon">
                    <i class="fa-regular fa-calendar"></i>
                </div>

                <div class="datetime-info">
                    <span id="userCurrentDate"></span>
                    <strong id="userCurrentTime"></strong>
                </div>
            </div>


            {{-- Notification --}}
            <div class="user-notification">

                <button type="button"
                        class="user-notification-button"
                        id="userNotificationButton">

                    <i class="fa-regular fa-bell"></i>

                    <span class="user-notification-badge"
                        id="userNotificationBadge"
                        style="display:none;">
                        0
                    </span>

                </button>

                <div class="user-notification-dropdown"
                    id="userNotificationDropdown">

                    <div class="user-notification-header">

                        <strong>Notifications</strong>

                        <div class="user-notification-header-right">

                            <span id="userNotificationTotal">
                                0
                            </span>

                            <button type="button"
                                    id="userMarkAllRead"
                                    class="user-read-all-btn"
                                    style="display:none;">
                                Read All
                            </button>

                        </div>

                    </div>

                    <div class="user-notification-list"
                        id="userNotificationList">

                        <div class="user-notification-empty">
                            <i class="fa-regular fa-bell-slash"></i>
                            <p>No notifications</p>
                        </div>

                    </div>

                    <div class="user-notification-footer">
                        <a href="{{ route('user.notifications') }}">Show All</a>
                    </div>

                </div>

            </div>


            {{-- Profile --}}
            <div class="profile-dropdown">

                <button type="button"
                        class="profile-button"
                        id="profileButton">

                    <div class="navbar-user-avatar">
                        {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                    </div>

                    <div class="navbar-user-info">
                        <strong>{{ auth()->user()->name ?? 'User' }}</strong>
                    </div>

                    <i class="fa-solid fa-chevron-down profile-arrow"></i>

                </button>


                <div class="profile-dropdown-menu"
                    id="profileDropdownMenu">

                    <div class="dropdown-user">

                        <div class="dropdown-avatar">
                            {{ strtoupper(substr(auth()->user()->name ?? 'U', 0, 1)) }}
                        </div>

                        <div>
                            <strong>{{ auth()->user()->name ?? 'User' }}</strong>
                            <span>{{ auth()->user()->email ?? '' }}</span>
                        </div>

                    </div>


                    <div class="dropdown-divider"></div>


                    <a href="#">
                        <i class="fa-solid fa-user"></i>
                        My Profile
                    </a>

                    <a href="#">
                        <i class="fa-solid fa-key"></i>
                        Action Pass
                    </a>

                    <a href="#">
                        <i class="fa-solid fa-lock"></i>
                        Change Password
                    </a>


                    <div class="dropdown-divider"></div>


                    <form action="{{ route('logout') }}" method="POST">
                        @csrf

                        <button type="submit" class="dropdown-logout">
                            <i class="fa-solid fa-right-from-bracket"></i>
                            Logout
                        </button>

                    </form>

                </div>

            </div>

        </div>

        </header>

        <section class="user-content">

            <div class="page-heading">
                <h1>@yield('page-title', 'Dashboard Overview')</h1>
                <p>@yield('page-subtitle', 'Manage your folders and invoices')</p>
            </div>

            @yield('content')

        </section>

    </main>

</div>

<script>
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebarClose = document.getElementById('sidebarClose');
    const userSidebar = document.getElementById('userSidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');

    const profileButton = document.getElementById('profileButton');
    const profileDropdownMenu = document.getElementById('profileDropdownMenu');

    function openSidebar() {
        userSidebar.classList.add('show');
        sidebarOverlay.classList.add('show');
        document.body.classList.add('sidebar-open');
    }

    function closeSidebar() {
        userSidebar.classList.remove('show');
        sidebarOverlay.classList.remove('show');
        document.body.classList.remove('sidebar-open');
    }

    sidebarToggle.addEventListener('click', openSidebar);
    sidebarClose.addEventListener('click', closeSidebar);
    sidebarOverlay.addEventListener('click', closeSidebar);

    profileButton.addEventListener('click', function (event) {
        event.stopPropagation();
        
        const userNotificationDropdown = document.getElementById('userNotificationDropdown');
        if (userNotificationDropdown) {
            userNotificationDropdown.classList.remove('show');
        }
        
        profileDropdownMenu.classList.toggle('show');
        profileButton.classList.toggle('active');
    });

    document.addEventListener('click', function (event) {
        if (!event.target.closest('.profile-dropdown')) {
            profileDropdownMenu.classList.remove('show');
            profileButton.classList.remove('active');
        }
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth > 991) {
            closeSidebar();
        }
    });
</script>

<script>
    function updateUserDateTime() {

        const now = new Date();

        // 640px or below = mobile
        const isMobile = window.innerWidth <= 640;

        let dateOptions;
        let timeOptions;

        if (isMobile) {

            // Mobile: 08 Aug
            dateOptions = {
                timeZone: 'Asia/Kolkata',
                day: '2-digit',
                month: 'short'
            };

            // Mobile: 05:51 PM
            timeOptions = {
                timeZone: 'Asia/Kolkata',
                hour: '2-digit',
                minute: '2-digit',
                hour12: true
            };

        } else {

            // Desktop: Sat, 08 Aug 2026
            dateOptions = {
                timeZone: 'Asia/Kolkata',
                weekday: 'short',
                day: '2-digit',
                month: 'short',
                year: 'numeric'
            };

            // Desktop: 05:51:57 PM
            timeOptions = {
                timeZone: 'Asia/Kolkata',
                hour: '2-digit',
                minute: '2-digit',
                second: '2-digit',
                hour12: true
            };
        }

        const date = now.toLocaleDateString('en-IN', dateOptions);
        const time = now.toLocaleTimeString('en-IN', timeOptions);

        const dateElement = document.getElementById('userCurrentDate');
        const timeElement = document.getElementById('userCurrentTime');

        if (dateElement) {
            dateElement.textContent = date;
        }

        if (timeElement) {
            timeElement.textContent = time;
        }
    }

    updateUserDateTime();

    setInterval(updateUserDateTime, 1000);

    window.addEventListener('resize', updateUserDateTime);
</script>

<script>
function checkMaintenance() {
    fetch('{{ route("maintenance.check") }}', {
        method: 'GET',
        headers: {
            'Accept': 'application/json'
        },
        cache: 'no-store'
    })
    .then(response => response.json())
    .then(data => {
        if (Number(data.status) === 1) {
            window.location.reload();
        }
    })
    .catch(error => {
        console.error('Maintenance check error:', error);
    });
}

setInterval(checkMaintenance, 2000);
</script>

<script>

const userNotificationButton =
    document.getElementById('userNotificationButton');

const userNotificationDropdown =
    document.getElementById('userNotificationDropdown');

const userNotificationBadge =
    document.getElementById('userNotificationBadge');

const userNotificationTotal =
    document.getElementById('userNotificationTotal');

const userNotificationList =
    document.getElementById('userNotificationList');

const userMarkAllRead =
    document.getElementById('userMarkAllRead');

function loadUserNotifications() {

    fetch('{{ route("user.notifications") }}', {
        method: 'GET',
        headers: {
            'Accept': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        cache: 'no-store'
    })

    .then(response => {

        if (!response.ok) {
            throw new Error('Notification request failed');
        }

        return response.json();
    })

    .then(data => {

        const currentDataStr = JSON.stringify(data);
        if (window.lastUserNotificationData === currentDataStr) {
            return;
        }
        window.lastUserNotificationData = currentDataStr;

        const notifications = data.notifications || [];

        const unreadCount = Number(data.count || 0);

        if (unreadCount > 0) {

            userNotificationBadge.textContent =
                unreadCount > 99 ? '99+' : unreadCount;

            userNotificationBadge.style.display = 'flex';

        } else {

            userNotificationBadge.style.display = 'none';
        }

        userNotificationTotal.textContent =
            unreadCount > 0
                ? unreadCount + ' New'
                : '0';


        if (unreadCount > 0) {

            userMarkAllRead.style.display = 'block';

        } else {

            userMarkAllRead.style.display = 'none';
        }

        if (notifications.length === 0) {

            userNotificationList.innerHTML = `
                <div class="user-notification-empty">
                    <i class="fa-regular fa-bell-slash"></i>
                    <p>No notifications</p>
                </div>
            `;

            return;
        }

        userNotificationList.innerHTML = notifications.map(notification => {

            const unread =
                Number(notification.is_read) === 0;

            return `
                <div class="user-notification-item ${unread ? 'unread' : ''}" data-id="${notification.id}">
                    <div class="user-notification-icon">
                        <i class="fa-solid fa-bell"></i>
                    </div>
                    <div class="user-notification-content">
                        <div class="user-notification-title">${escapeNotificationText(notification.title)}</div>
                        <div class="user-notification-message">${escapeNotificationText(notification.message)}</div>
                        <div class="user-notification-time">${escapeNotificationText(notification.time)}</div>
                    </div>
                </div>
            `;

        }).join('');

        document
            .querySelectorAll('.user-notification-item')
            .forEach(item => {

                item.addEventListener('click', function () {

                    const id = this.dataset.id;

                    markNotificationAsRead(id);
                });

            });

    })

    .catch(error => {

        console.error(
            'User notification error:',
            error
        );

    });
}

function escapeNotificationText(text) {

    const div = document.createElement('div');

    div.textContent = text ?? '';

    return div.innerHTML;
}

function markNotificationAsRead(id) {

    fetch(
        '{{ url("/notifications") }}/' + id + '/read',
        {
            method: 'POST',

            headers: {
                'Accept': 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN':
                    '{{ csrf_token() }}'
            }
        }
    )

    .then(response => response.json())

    .then(data => {

        if (data.success) {

            loadUserNotifications();
        }

    })

    .catch(error => {

        console.error(
            'Mark notification read error:',
            error
        );

    });
}

userMarkAllRead.addEventListener(
    'click',
    function (event) {

        event.stopPropagation();

        fetch(
            '{{ route("notifications.read-all") }}',
            {
                method: 'POST',

                headers: {
                    'Accept': 'application/json',
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN':
                        '{{ csrf_token() }}'
                }
            }
        )

        .then(response => response.json())

        .then(data => {

            if (data.success) {

                loadUserNotifications();
                
                if (typeof userNotificationDropdown !== 'undefined' && userNotificationDropdown) {
                    userNotificationDropdown.classList.remove('show');
                }
            }

        })

        .catch(error => {

            console.error(
                'Mark all notifications error:',
                error
            );

        });

    }
);

userNotificationButton.addEventListener(
    'click',
    function (event) {

        event.stopPropagation();

        userNotificationDropdown.classList.toggle('show');

        if (
            typeof profileDropdownMenu !== 'undefined' &&
            profileDropdownMenu
        ) {

            profileDropdownMenu.classList.remove('show');

            if (
                typeof profileButton !== 'undefined' &&
                profileButton
            ) {

                profileButton.classList.remove('active');
            }
        }

    }
);

document.addEventListener(
    'click',
    function (event) {

        if (
            !event.target.closest('.user-notification')
        ) {

            userNotificationDropdown.classList.remove(
                'show'
            );
        }

    }
);

loadUserNotifications();

setInterval(
    loadUserNotifications,
    2000
);

</script>

</body>
</html>