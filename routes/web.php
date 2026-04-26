<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Panel\SiteController;
use App\Models\Site;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard', [
        'siteCount' => Site::count(),
        'activeSiteCount' => Site::where('is_active', true)->count(),
    ]);
})->middleware('auth')->name('dashboard');

Route::middleware('auth')
    ->prefix('dashboard')
    ->name('dashboard.')
    ->group(function (): void {
        Route::resource('sites', SiteController::class)->except(['show']);
    });

Route::middleware('guest')->group(function (): void {
    Route::get('/login', [LoginController::class, 'show'])->name('login');
    Route::post('/login', [LoginController::class, 'store'])->name('login.store');
});

Route::post('/logout', [LoginController::class, 'destroy'])
    ->middleware('auth')
    ->name('logout');

Route::any('/register', fn () => abort(403, 'Registration is disabled.'));
