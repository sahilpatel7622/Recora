<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\User\DashboardController as UserDashboardController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use App\Http\Controllers\Admin\MaintenanceController;
use App\Http\Controllers\Admin\AdminNotificationController;
use App\Http\Controllers\Admin\SendNotificationController;
use App\Http\Controllers\Admin\ProjectSettingController;
use App\Http\Controllers\Admin\MailSettingController;
use App\Http\Controllers\User\NotificationController;

Route::middleware(['guest', 'maintenance.check'])->group(function () {
    Route::get('/', [AuthController::class, 'showLogin']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->name('login.store');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->name('register.store');
});

Route::middleware('auth')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('/dashboard', [UserDashboardController::class, 'index'])->middleware('maintenance.check')->name('dashboard');
    Route::get('/user/dashboard', [UserDashboardController::class, 'index'])->middleware('maintenance.check')->name('user.dashboard');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');
    Route::get('/notifications', [NotificationController::class, 'index'])->name('user.notifications');

    

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
    Route::get('/maintenance/status', [MaintenanceController::class, 'status'])->name('admin.maintenance.status');
    Route::post('/maintenance/toggle', [MaintenanceController::class, 'toggle'])->name('admin.maintenance.toggle');
    Route::get('/admin/notifications/fetch', [AdminNotificationController::class, 'index'])->name('admin.notifications');
    Route::post('/admin/notifications/read-all', [AdminNotificationController::class, 'readAll'])->name('admin.notifications.readAll');
    Route::get('/admin/notifications/send-notification', [SendNotificationController::class, 'create'])->name('admin.send-notification');
    Route::post('/admin/notifications/send-notification', [SendNotificationController::class, 'store'])->name('admin.send-notification.store');
    Route::get('/admin/notifications', [SendNotificationController::class, 'index'])->name('admin.notifications.index');
    Route::delete('/admin/notifications/{id}', [SendNotificationController::class, 'destroy'])->name('admin.notifications.destroy');
    Route::patch('/admin/notifications/{id}/restore', [SendNotificationController::class, 'restore'])->name('admin.notifications.restore');
    Route::delete('/admin/notifications/{id}/force-delete', [SendNotificationController::class, 'forceDelete'])->name('admin.notifications.force-delete');
    Route::get('/admin/settings', [ProjectSettingController::class, 'index'])->name('admin.settings.index');
    Route::put('/admin/settings', [ProjectSettingController::class, 'update'])->name('admin.settings.update');
    Route::get('/admin/settings/mail', [MailSettingController::class, 'index'])->name('admin.settings.mail');
    Route::put('/admin/settings/mail', [MailSettingController::class, 'update'])->name('admin.settings.mail.update');
    Route::post('/admin/settings/mail/test', [MailSettingController::class, 'testEmail'])->name('admin.settings.mail.test');



});