@extends('layouts.admin')

@section('title', 'Website Setting')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/project-settings.css') }}">
@endpush

@section('page-title', 'Website Setting')
@section('page-subtitle', 'Manage your website name and logo')

@section('content')

<div class="settings-layout">

    <!-- Settings Sidebar -->
    <div class="settings-sidebar">

        <a href="{{ route('admin.settings.index') }}" class="settings-menu-item active">
            <i class="fa-solid fa-gear"></i>
            <span>Website Setting</span>
        </a>

        <a href="{{ route('admin.settings.mail') }}" class="settings-menu-item">
            <i class="fa-solid fa-envelope"></i>
            <span>Email Settings</span>
        </a>

    </div>


    <!-- Settings Content -->
    <div class="settings-content">

        <!-- Project Name -->
        <div class="settings-card" id="project-name">

            <div class="settings-card-header">
                <div>
                    <h2>Website Setting</h2>
                    <p>Manage your website name and logo.</p>
                </div>
            </div>

            <form action="{{ route('admin.settings.update') }}"
                  method="POST"
                  enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Website Name <span class="text-danger" style="color: #dc3545;">*</span></label>

                    <input type="text"
                           name="project_name"
                           value="{{ old('project_name', $settings->project_name) }}"
                           placeholder="Enter website name"
                           maxlength="30">
                    @error('project_name')
                        <span class="text-danger" style="color: #dc3545; font-size: 13px; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label>
                        Website Logo
                        @if(!$settings->project_logo)
                            <span class="text-danger" style="color: #dc3545;">*</span>
                        @endif
                    </label>

                    <input type="file"
                           name="project_logo"
                           accept="image/*">
                    @error('project_logo')
                        <span class="text-danger" style="color: #dc3545; font-size: 13px; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                @if($settings->project_logo)
                    <div class="logo-preview">
                        <img src="{{ asset('storage/' . $settings->project_logo) }}"
                             alt="Project Logo">
                    </div>
                @endif

                <div class="form-group">
                    <label>Description</label>

                    <textarea name="project_description"
                              placeholder="Enter project description"
                              maxlength="150">{{ old('project_description', $settings->project_description) }}</textarea>
                    @error('project_description')
                        <span class="text-danger" style="color: #dc3545; font-size: 13px; margin-top: 5px; display: block;">{{ $message }}</span>
                    @enderror
                </div>

                <button type="submit">
                    <i class="fa-solid fa-check"></i>
                    Save Changes
                </button>

            </form>

        </div>

    </div>

</div>

@endsection