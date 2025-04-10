<?php

use App\Http\Controllers\DeviceController;
use Inertia\Inertia;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use App\Http\Controllers\ProfileController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware(['auth', 'verified'])->group(function () {
    // Grup untuk Admin

    // Grup untuk User
    Route::middleware('role:2')->group(function () {
        Route::get('/dashboard', function () {
            return Inertia::render('Dashboard');
        })->name('dashboard');
        Route::get('/devices', [DeviceController::class, 'index'])->name('list.device');
        Route::get('/devices/monitoring/{id}', [DeviceController::class, 'monitoring'])->name('monitoring.device');
        Route::get('/devices/create', [DeviceController::class, 'create'])->name('devices.create');
        Route::delete('/devices/{id}', [DeviceController::class, 'destroy'])->name('devices.destroy');
        Route::post('/devices', [DeviceController::class, 'store'])->name('devices.store');

    });

    // Grup untuk Admin dan User

});


Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/components/buttons', function () {
    return Inertia::render('Components/Buttons');
})->middleware(['auth', 'verified'])->name('components.buttons');

require __DIR__ . '/auth.php';