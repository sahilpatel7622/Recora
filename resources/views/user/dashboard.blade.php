@extends('layouts.user')

@section('title', 'Dashboard')

@section('page-title', 'Dashboard Overview')

@section('page-subtitle', 'Welcome back, ' . (auth()->user()->name ?? 'User') . '.')

@section('content')

<div class="dashboard-cards">

    <div class="dashboard-card card-purple">
        <div class="card-details">
            <h3>Total Folders</h3>
            <h2>0</h2>
            <p>Your created folders</p>
        </div>

        <div class="card-icon">
            <i class="fa-solid fa-folder-open"></i>
        </div>
    </div>

    <div class="dashboard-card card-blue">
        <div class="card-details">
            <h3>Total Records</h3>
            <h2>0</h2>
            <p>Records inside folders</p>
        </div>

        <div class="card-icon">
            <i class="fa-solid fa-file-lines"></i>
        </div>
    </div>

    <div class="dashboard-card card-green">
        <div class="card-details">
            <h3>Total Invoices</h3>
            <h2>0</h2>
            <p>Your generated invoices</p>
        </div>

        <div class="card-icon">
            <i class="fa-solid fa-file-invoice"></i>
        </div>
    </div>

    <div class="dashboard-card card-orange">
        <div class="card-details">
            <h3>Recent Activity</h3>
            <h2>0</h2>
            <p>Recent account activity</p>
        </div>

        <div class="card-icon">
            <i class="fa-solid fa-clock-rotate-left"></i>
        </div>
    </div>

</div>

<div class="dashboard-sections">

    <div class="dashboard-panel">

        <div class="panel-header">
            <div>
                <h2>Recent Folders</h2>
                <p>Your recently created folders</p>
            </div>

            <a href="#" class="view-all-btn">View All</a>
        </div>

        <div class="panel-body">
            <div class="empty-state">

                <div class="empty-icon">
                    <i class="fa-solid fa-folder-open"></i>
                </div>

                <h3>No folders found</h3>
                <p>Create your first folder to get started.</p>

                <a href="#" class="primary-btn">
                    <i class="fa-solid fa-plus"></i>
                    Create Folder
                </a>

            </div>
        </div>

    </div>

    <div class="dashboard-panel">

        <div class="panel-header">
            <div>
                <h2>Recent Invoices</h2>
                <p>Your recently created invoices</p>
            </div>

            <a href="#" class="view-all-btn">View All</a>
        </div>

        <div class="panel-body">
            <div class="empty-state">

                <div class="empty-icon">
                    <i class="fa-solid fa-file-invoice"></i>
                </div>

                <h3>No invoices found</h3>
                <p>Create your first invoice to get started.</p>

                <a href="#" class="primary-btn">
                    <i class="fa-solid fa-plus"></i>
                    Create Invoice
                </a>

            </div>
        </div>

    </div>

</div>

@endsection