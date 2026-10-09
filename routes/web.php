<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\AdminNotificationController;

use App\Http\Controllers\Admin\ProjectSettingController;
use App\Http\Controllers\Admin\MailSettingController;

Route::middleware(['guest', 'maintenance.check'])->group(function () {
    Route::get('/', [AuthController::class, 'showLogin']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
});

Route::get('/maintenance/check', [MaintenanceController::class, 'check'])->name('maintenance.check');

Route::middleware('auth')->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::post('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::get('/admin/users/add-user', [AdminUserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users/add-user', [AdminUserController::class, 'store'])->name('admin.users.store');
    Route::get('/admin/users/{id}', [AdminUserController::class, 'show'])->name('admin.users.show');
    Route::patch('/admin/users/{id}/status', [AdminUserController::class, 'changeStatus'])->name('admin.users.status');
    Route::delete('/admin/users/{id}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');
    Route::patch('/admin/users/{id}/restore', [AdminUserController::class, 'restore'])->name('admin.users.restore');
    Route::delete('/admin/users/{id}/force-delete', [AdminUserController::class, 'forceDelete'])->name('admin.users.force-delete');
    Route::get('/admin/users-export-pdf', [AdminUserController::class, 'exportPdf'])->name('admin.users.export.pdf');
    Route::get('/maintenance/status', [MaintenanceController::class, 'status'])->name('admin.maintenance.status');
    Route::post('/maintenance/toggle', [MaintenanceController::class, 'toggle'])->name('admin.maintenance.toggle');
    Route::get('/admin/notifications/fetch', [AdminNotificationController::class, 'index'])->name('admin.notifications');
    Route::post('/admin/notifications/read-all', [AdminNotificationController::class, 'readAll'])->name('admin.notifications.readAll');

    Route::get('/admin/settings', [ProjectSettingController::class, 'index'])->name('admin.settings.index');
    Route::put('/admin/settings', [ProjectSettingController::class, 'update'])->name('admin.settings.update');
    Route::get('/admin/settings/mail', [MailSettingController::class, 'index'])->name('admin.settings.mail');
    Route::put('/admin/settings/mail', [MailSettingController::class, 'update'])->name('admin.settings.mail.update');
    Route::post('/admin/settings/mail/test', [MailSettingController::class, 'testEmail'])->name('admin.settings.mail.test');



});