<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ColocationController; // Assuming ColocationController exists

Route::view('/', 'welcome');

Route::get('dashboard', [\App\Http\Controllers\DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Admin Routes
Route::prefix('admin')->middleware(['auth'])->group(function () {
    Route::get('/', [\App\Http\Controllers\AdminController::class, 'index'])->name('admin.index');
    Route::post('/users/{user}/toggle-ban', [\App\Http\Controllers\AdminController::class, 'toggleBan'])->name('admin.users.ban');
});

Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('/colocations-ui', \App\Livewire\ColocationManagement::class)
    ->middleware(['auth'])
    ->name('colocations.ui');

// Add resource routes for Colocations
Route::resource('colocations', ColocationController::class)
    ->only(['index', 'show', 'store', 'update', 'destroy'])
    ->middleware(['auth']);

Route::post('colocations/{colocation}/leave', [\App\Http\Controllers\MembershipController::class, 'leave'])
    ->middleware(['auth'])
    ->name('colocations.leave');

Route::delete('colocations/{colocation}/members/{user}', [\App\Http\Controllers\MembershipController::class, 'remove'])
    ->middleware(['auth'])
    ->name('colocations.members.remove');

Route::resource('expenses', \App\Http\Controllers\ExpenseController::class)
    ->only(['store', 'destroy'])
    ->middleware(['auth']);

Route::post('/debts/{debt}/mark-paid', [\App\Http\Controllers\ExpenseController::class, 'markPaid'])
    ->middleware(['auth'])
    ->name('debts.mark-paid');

// Invitation Acceptance Flow
Route::post('/invitations', [\App\Http\Controllers\InvitationController::class, 'store'])
    ->middleware(['auth'])
    ->name('invitations.store');

Route::get('/invitations/{token}', [\App\Http\Controllers\InvitationController::class, 'show'])
    ->name('invitations.show');

Route::post('/invitations/{token}/accept', [\App\Http\Controllers\InvitationController::class, 'accept'])
    ->middleware(['auth'])
    ->name('invitations.accept');

Route::post('/invitations/{token}/deny', [\App\Http\Controllers\InvitationController::class, 'deny'])
    ->middleware(['auth'])
    ->name('invitations.deny');

require __DIR__.'/auth.php';
