<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\OrmawaController;
use App\Http\Controllers\ActivityController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PhotoController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/ormawa', [HomeController::class, 'ormawa'])->name('public.ormawa');
Route::get('/ormawa/{slug}', [HomeController::class, 'ormawaDetail'])->name('public.ormawa.detail');
Route::get('/kegiatan', [HomeController::class, 'activities'])->name('public.activitie');
Route::get('/pengumuman', [HomeController::class, 'announcements'])->name('public.announcements');
Route::get('/login',[AuthController::class, 'showLogin'])->name('login');
Route::post('/login',[AuthController::class, 'login'])->name('login.post');
Route::get('/register',[AuthController::class, 'showRegister'])->name('register');
Route::post('/register',[AuthController::class, 'register'])->name('register.post');
Route::post('/logout',[AuthController::class, 'logout'])->name('logout');
    Route::get('/public/ormawa/{slug}/structure', [App\Http\Controllers\HomeController::class, 'ormawaStructure'])->name('public.ormawa.structure');

Route::get('/berita', [App\Http\Controllers\NewsController::class, 'publicIndex'])->name('public.news.index');
Route::get('/berita/{slug}', [App\Http\Controllers\NewsController::class, 'publicShow'])->name('public.news.show');

Route::get('/galeri', [PhotoController::class, 'publicGallery'])->name('gallery.index');
Route::get('/galeri/{photo}', [PhotoController::class, 'publicShow'])->name('gallery.show');


Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::resource('photos', PhotoController::class);
    Route::get('photos/album/{album}', [PhotoController::class, 'album'])->name('photos.album');
    Route::get('photos/{photo}/download', [PhotoController::class, 'download'])->name('photos.download');

     Route::get('/divisions', [App\Http\Controllers\DivisionController::class, 'index'])->name('divisions.index');
    Route::get('/divisions/create', [App\Http\Controllers\DivisionController::class, 'create'])->name('divisions.create');
    Route::post('/divisions', [App\Http\Controllers\DivisionController::class, 'store'])->name('divisions.store');
    Route::get('/divisions/{division}/edit', [App\Http\Controllers\DivisionController::class, 'edit'])->name('divisions.edit');
    Route::patch('/divisions/{division}', [App\Http\Controllers\DivisionController::class, 'update'])->name('divisions.update');
    Route::delete('/divisions/{division}', [App\Http\Controllers\DivisionController::class, 'destroy'])->name('divisions.destroy');
    
    // Organization Structure (Struktur Organisasi)
    Route::get('/organization', [App\Http\Controllers\OrganizationMemberController::class, 'index'])->name('organization.index');
    Route::get('/organization/create', [App\Http\Controllers\OrganizationMemberController::class, 'create'])->name('organization.create');
    Route::post('/organization', [App\Http\Controllers\OrganizationMemberController::class, 'store'])->name('organization.store');
    Route::get('/organization/{member}/edit', [App\Http\Controllers\OrganizationMemberController::class, 'edit'])->name('organization.edit');
    Route::patch('/organization/{member}', [App\Http\Controllers\OrganizationMemberController::class, 'update'])->name('organization.update');
    Route::delete('/organization/{member}', [App\Http\Controllers\OrganizationMemberController::class, 'destroy'])->name('organization.destroy');
    
     Route::get('/news', [App\Http\Controllers\NewsController::class, 'index'])->name('news.index');
    Route::get('/news/create', [App\Http\Controllers\NewsController::class, 'create'])->name('news.create');
    Route::post('/news', [App\Http\Controllers\NewsController::class, 'store'])->name('news.store');
    Route::get('/news/{news}', [App\Http\Controllers\NewsController::class, 'show'])->name('news.show');
    Route::get('/news/{news}/edit', [App\Http\Controllers\NewsController::class, 'edit'])->name('news.edit');
    Route::patch('/news/{news}', [App\Http\Controllers\NewsController::class, 'update'])->name('news.update');
    Route::delete('/news/{news}', [App\Http\Controllers\NewsController::class, 'destroy'])->name('news.destroy');
    Route::post('/news/{news}/publish', [App\Http\Controllers\NewsController::class, 'publish'])->name('news.publish');
    
    // Profile Routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Announcement Routes
    Route::resource('announcements', AnnouncementController::class);
    Route::post('/announcements/{announcement}/send', [AnnouncementController::class, 'send'])->name('announcements.send');
    Route::get('/announcements/{announcement}/read', [AnnouncementController::class, 'markAsRead'])->name('announcements.read');
    Route::get('/inbox', [AnnouncementController::class, 'inbox'])->name('announcements.inbox');
    
    // Activity Routes
    Route::resource('activities', ActivityController::class);
    
    // Admin Only Routes
    Route::middleware(['role:admin,ketua_bem'])->group(function () {
    Route::resource('ormawas', OrmawaController::class);
        Route::get('pengumumans', [App\Http\Controllers\AnnouncementController::class, 'manageAdmins'])->name('pengumumans.index');
        Route::patch('/ormawas/{ormawa}/toggle-status', [OrmawaController::class, 'toggleStatus'])->name('ormawas.toggle-status');
        
        // User Management
        Route::get('/users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
        Route::get('/users/create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
        Route::post('/users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
        Route::get('/users/{user}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
        Route::patch('/users/{user}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
        Route::delete('/users/{user}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
    });
});
