<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SucursalController;
use App\Http\Controllers\TareaController;
use App\Http\Controllers\UserController;
use App\Http\Requests\MaterialesGastadosRequest;
use App\Models\Cliente;
use App\Models\Estado;
use App\Models\MaterialGastado;
use App\Models\Prioridad;
use App\Models\Sucursal;
use App\Models\Tarea;
use App\Models\TareaAsignada;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Validation\ValidationException;
use App\Models\User;
use Illuminate\Http\Request;

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
        $re = TareaAsignada::where('user_id', Auth::user()->id)->get();
        $tareasAsignadas = [];
        foreach($re as $tarea){
            if($tarea->Tarea->Estado->numero == 2)
                continue;
            else
                array_push($tareasAsignadas, $tarea);
        }
        $tareas = Tarea::all();
        $clientes = Cliente::all();
        $sucursales = Sucursal::all();
        $prioridades = Prioridad::all();
        $estados = Estado::all();
        $users = User::all();
        return view('index', compact('tareasAsignadas', 'tareas', 'clientes', 'sucursales', 'prioridades', 'users', 'estados'));
    })->name('dashboard');
   
    Route::resource('/clientes', ClienteController::class);
    Route::resource('/users', UserController::class);
    Route::resource('/sucursales', SucursalController::class);
    Route::resource('/materiales', MaterialController::class);

    Route::resource('/tareas', TareaController::class);
    Route::get('/tareas/{id}/completar', [TareaController::class, 'CompletarTarea']);
    Route::post('/tareas/{id}/cerrar', [TareaController::class, 'CerrarTarea']);
    Route::post('/tareas/materiales', [TareaController::class, 'CargarMaterial']);
    Route::delete('/tareas/materiales/{id}', [TareaController::class, 'EliminarMaterial']);
    Route::post('/tareas/foto_antes', [TareaController::class, 'FotoAntes']);
    Route::post('/tareas/foto_despues', [TareaController::class, 'FotoDespues']);
    Route::post('/tareas/foto_ot', [TareaController::class, 'FotoOt']);
    Route::post('/tareas/foto_boleta', [TareaController::class, 'FotoBoleta']);
    Route::post('/tareas/fotos_preventivo', [TareaController::class, 'FotosPreventivo']);
    Route::post('/tareas/fotos_observaciones', [TareaController::class, 'FotosObervaciones']);
    Route::post('/tareas/fotos_boleta', [TareaController::class, 'FotosBoleta']);
    Route::post('/tareas/fotos_ot_combustible', [TareaController::class, 'FotosOtCombustible']);
    Route::post('/tareas/fotos_planilla', [TareaController::class, 'FotosPlanillaPreventivo']);

    Route::post('/materiales_gastados', [TareaController::class, 'ObtenerMateriales']);  
    
    Route::post('/sucursales/importar', [SucursalController::class, 'CargarExcel']);
    Route::post('/clientes/importar', [ClienteController::class, 'CargarExcel']);
    Route::post('/materiales/importar', [MaterialController::class, 'CargarExcel']); 
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile', [ProfileController::class, 'UpdateAvatar'])->name('profile.updateavatar');
});

require __DIR__.'/auth.php';
