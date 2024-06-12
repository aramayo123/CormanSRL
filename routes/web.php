<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\UserController;
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
    Route::get('/roles', function () {
        return "roles";
    })->name('roles.index');

    Route::resource('/clientes', ClienteController::class);
    Route::resource('/users', UserController::class);
    Route::resource('/sucursales', SucursalController::class);
    Route::resource('/materiales', MaterialController::class);
    Route::resource('/tareas', TareaController::class);
    Route::post('/sucursales/importar', [SucursalController::class, 'CargarExcel']);
    Route::post('/clientes/importar', [ClienteController::class, 'CargarExcel']);
    Route::post('/materiales/importar', [MaterialController::class, 'CargarExcel']);
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile', [ProfileController::class, 'UpdateAvatar'])->name('profile.updateavatar');
});

require __DIR__.'/auth.php';
