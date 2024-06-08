<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Validation\ValidationException;
use App\Models\User;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('logs', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

Route::middleware('auth')->group(function () {
    Route::get('/', function () {
        return view('index');
    })->name('dashboard');

    Route::get('/tareas', function () {
        return "tareas";
    })->name('tareas.index');

    Route::get('/clientes', function () {
        return "clientes";
    })->name('clientes.index');

    Route::get('/sucursales', function () {
        return "sucursales";
    })->name('sucursales.index');

    Route::get('/materiales', function () {
        return "materiales";
    })->name('materiales.index');
    
    Route::get('/roles', function () {
        return "roles";
    })->name('roles.index');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile', [ProfileController::class, 'UpdateAvatar'])->name('profile.updateavatar');

});

require __DIR__.'/auth.php';
