<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\MembersController;
use App\Http\Controllers\BarangayController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    if (Auth::check()) {
        // User is authenticated, check their role and redirect accordingly
        if (Auth::user()->role == 1) {
            return redirect()->route('admin.dashboard');
        } else {
            return redirect()->route('moderator.dashboard');
        }
    }

    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// Profile Routes
Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit')->middleware('auth');
Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update')->middleware('auth');
Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy')->middleware('auth');

// Admin Dashboard and Members Routes
Route::get('/admin/dashboard', function() {
    return Inertia::render('Admin/AdminDashboard');
})->name('admin.dashboard')->middleware('auth'); // Only allow authenticated users

Route::get('/admin/members/list', [MembersController::class, 'index'])->name('admin.members.list')->middleware('auth');
Route::post('/admin/members/save', [MembersController::class, 'save'])->name('admin.members.save')->middleware('auth');
Route::get('/admin/members/enroll', [MembersController::class, 'enroll'])->name('admin.members.enroll')->middleware('auth');

Route::get('/admin/barangays/list', [BarangayController::class, 'index'])->name('barangays')->middleware('auth');
Route::post('/admin/barangays/save', [BarangayController::class, 'save'])->name('save')->middleware('auth');
Route::post('/admin/barangays/remove', [BarangayController::class, 'remove'])->name('remove')->middleware('auth');
Route::get('/admin/barangays/add', function() {
    return Inertia::render('Admin/Add');
})->name('addbarangay')->middleware('auth');

// Moderator Dashboard and Members Routes
Route::get('/moderator/dashboard', function() {
    return Inertia::render('Moderator/ModeratorDashboard');
})->name('moderator.dashboard')->middleware('auth');

Route::get('/moderator/members/list', [MembersController::class, 'index'])->name('moderator.members.list')->middleware('auth');
Route::get('/moderator/members/enroll', [MembersController::class, 'enroll'])->name('moderator.members.enroll')->middleware('auth');
Route::post('/moderator/members/save', [MembersController::class, 'save'])->name('moderator.members.save')->middleware('auth');

require __DIR__.'/auth.php';
