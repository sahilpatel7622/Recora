@extends('layouts.admin')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard Overview')

@section(
    'page-description',
    'Welcome back, ' . session('admin_name', 'Admin')
)

@section('content')

<div class="dashboard-heading">

    <div>
        <h1>Dashboard Overview</h1>

        <p>
            Manage users, folders, invoices and system settings.
        </p>
    </div>

</div>

<div class="dashboard-cards">

    <div class="dashboard-card card-purple">

        <div class="dashboard-card-content">

            <span>Total Users</span>

            <h2>
                {{ $totalUsers ?? 0 }}
            </h2>

            <p>Registered users</p>

        </div>

        <div class="dashboard-card-icon">
            <i class="fa-solid fa-users"></i>
        </div>

    </div>

    <div class="dashboard-card card-blue">

        <div class="dashboard-card-content">

            <span>Total Folders</span>

            <h2>
                {{ $totalFolders ?? 0 }}
            </h2>

            <p>Created folders</p>

        </div>

        <div class="dashboard-card-icon">
            <i class="fa-solid fa-folder-open"></i>
        </div>

    </div>

    <div class="dashboard-card card-green">

        <div class="dashboard-card-content">

            <span>Total Invoices</span>

            <h2>
                {{ $totalInvoices ?? 0 }}
            </h2>

            <p>Generated invoices</p>

        </div>

        <div class="dashboard-card-icon">
            <i class="fa-solid fa-file-invoice"></i>
        </div>

    </div>

    <div class="dashboard-card card-orange">

        <div class="dashboard-card-content">

            <span>Active Users</span>

            <h2>
                {{ $activeUsers ?? 0 }}
            </h2>

            <p>Currently active users</p>

        </div>

        <div class="dashboard-card-icon">
            <i class="fa-solid fa-user-check"></i>
        </div>

    </div>

</div>

<div class="dashboard-small-cards">

    <div class="small-stat-card">

        <div class="small-stat-icon icon-green">
            <i class="fa-solid fa-user-check"></i>
        </div>

        <div class="small-stat-details">

            <span>Active Users</span>

            <strong>
                {{ $activeUsers ?? 0 }}
            </strong>

        </div>

    </div>

    <div class="small-stat-card">

        <div class="small-stat-icon icon-red">
            <i class="fa-solid fa-user-xmark"></i>
        </div>

        <div class="small-stat-details">

            <span>Inactive Users</span>

            <strong>
                {{ $inactiveUsers ?? 0 }}
            </strong>

        </div>

    </div>

    <div class="small-stat-card">

        <div class="small-stat-icon icon-blue">
            <i class="fa-solid fa-file-circle-plus"></i>
        </div>

        <div class="small-stat-details">

            <span>Today Invoices</span>

            <strong>
                {{ $todayInvoices ?? 0 }}
            </strong>

        </div>

    </div>

    <div class="small-stat-card">

        <div class="small-stat-icon icon-purple">
            <i class="fa-solid fa-folder-plus"></i>
        </div>

        <div class="small-stat-details">

            <span>Today Folders</span>

            <strong>
                {{ $todayFolders ?? 0 }}
            </strong>

        </div>

    </div>

</div>

<div class="dashboard-sections">

    <div class="dashboard-panel recent-users-panel">

        <div class="panel-header">

            <div>
                <h2>Recent Users</h2>
                <p>Recently registered users</p>
            </div>

            <a href="#"
               class="view-all-btn">

                View All

                <i class="fa-solid fa-arrow-right"></i>

            </a>

        </div>

        <div class="panel-body table-container">

            <table class="dashboard-table">

                <thead>

                    <tr>
                        <th>User</th>
                        <th>Device</th>
                        <th>Browser</th>
                        <th>Status</th>
                        <th>Joined</th>
                    </tr>

                </thead>

                <tbody>

                    @forelse(($recentUsers ?? []) as $user)

                        <tr>

                            <td>

                                <div class="table-user">

                                    <div class="table-user-avatar">
                                        {{ strtoupper(substr($user->name ?? 'U', 0, 1)) }}
                                    </div>

                                    <div class="table-user-info">

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
                                {{ $user->device ?? 'Unknown' }}
                            </td>

                            <td>
                                {{ $user->browser ?? 'Unknown' }}
                            </td>

                            <td>

                                @if((int) $user->status === 1)

                                    <span class="status-badge status-active">
                                        Active
                                    </span>

                                @else

                                    <span class="status-badge status-inactive">
                                        Inactive
                                    </span>

                                @endif

                            </td>

                            <td>
                                {{ optional($user->created_at)->format('d M Y') }}
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5">

                                <div class="table-empty-state">

                                    <div class="table-empty-icon">
                                        <i class="fa-solid fa-users"></i>
                                    </div>

                                    <h3>No users found</h3>

                                    <p>
                                        Registered users will appear here.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

    <div class="dashboard-panel quick-actions-panel">

        <div class="panel-header">

            <div>
                <h2>Quick Actions</h2>
                <p>Common admin actions</p>
            </div>

        </div>

        <div class="panel-body">

            <div class="quick-actions">

                <a href="#"
                   class="quick-action-item">

                    <div class="quick-action-icon quick-blue">
                        <i class="fa-solid fa-users"></i>
                    </div>

                    <div class="quick-action-details">

                        <strong>Manage Users</strong>

                        <span>
                            View and manage all users
                        </span>

                    </div>

                    <i class="fa-solid fa-chevron-right quick-action-arrow"></i>

                </a>

                <a href="#"
                   class="quick-action-item">

                    <div class="quick-action-icon quick-purple">
                        <i class="fa-solid fa-folder-open"></i>
                    </div>

                    <div class="quick-action-details">

                        <strong>Manage Folders</strong>

                        <span>
                            View all user folders
                        </span>

                    </div>

                    <i class="fa-solid fa-chevron-right quick-action-arrow"></i>

                </a>

                <a href="#"
                   class="quick-action-item">

                    <div class="quick-action-icon quick-green">
                        <i class="fa-solid fa-file-invoice"></i>
                    </div>

                    <div class="quick-action-details">

                        <strong>Manage Invoices</strong>

                        <span>
                            View all user invoices
                        </span>

                    </div>

                    <i class="fa-solid fa-chevron-right quick-action-arrow"></i>

                </a>

                <a href="#"
                   class="quick-action-item">

                    <div class="quick-action-icon quick-orange">
                        <i class="fa-solid fa-envelope"></i>
                    </div>

                    <div class="quick-action-details">

                        <strong>Mail Settings</strong>

                        <span>
                            Configure SMTP settings
                        </span>

                    </div>

                    <i class="fa-solid fa-chevron-right quick-action-arrow"></i>

                </a>

            </div>

        </div>

    </div>

</div>

@endsection