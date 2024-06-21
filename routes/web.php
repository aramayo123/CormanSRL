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
use App\Models\Imagen;
use App\Models\Material;
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
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use \Madzipper\Zipper;
use Madnest\Madzipper\Madzipper;

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
        $materiales = Material::all();
        $materialesGastados = [];
        $ra = MaterialGastado::all();
        foreach($ra as $material){
            if(!$material->Tarea->fecha_cerrado)
                continue;
            
            $mes = explode("-",$material->Tarea->fecha_cerrado);
            if($mes[1] == now()->month)
                array_push($materialesGastados, $material);
        }
        $all_tareas = Tarea::whereMonth('fecha_cerrado', now()->month)->where('estado_id', '2')->get();

        $total_correctivos = count(Tarea::whereMonth('fecha_cerrado', now()->month)->where('atm', NULL)->where('estado_id', '2')->get());
        $total_atm = count(Tarea::whereMonth('fecha_cerrado', now()->month)->where('atm', '1')->where('estado_id', '2')->get());
        $total_altas = count(Tarea::whereMonth('fecha_cerrado', now()->month)->where('prioridad_id', '1')->where('estado_id', '2')->get());
        $total_medias = count(Tarea::whereMonth('fecha_cerrado', now()->month)->where('prioridad_id', '2')->where('estado_id', '2')->get());
        $total_bajas = count(Tarea::whereMonth('fecha_cerrado', now()->month)->where('prioridad_id', '3')->where('estado_id', '2')->get());
        return view('index', compact(
            'tareasAsignadas', 
            'tareas', 'clientes',
            'sucursales', 'prioridades',
            'users', 'estados', 
            'total_correctivos', 
            'total_atm',
            'total_altas',
            'total_medias',
            'total_bajas',
            'all_tareas',
            'materiales',
            'materialesGastados',
        ));
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
    Route::post('/tareas/imagenes', function (Request $request){
        $imagenes = Imagen::where('tarea_id', $request->tarea_id)->get();
        return response()->json(['message' => $imagenes]);
    });
    Route::post('tareas/eliminar', function (Request $request){
        $imagen = Imagen::findOrFail($request->imagen_id);
       
        if(Storage::exists("public/".substr($imagen->url, 8)))
            Storage::delete("public/".substr($imagen->url, 8));
        
        Imagen::destroy($request->imagen_id);
        return response()->json(['message' => "exito"]);
    });
    Route::post('/download', function (Request $request) {
        if(!Storage::exists("public/$request->folder")){
            return response()->json([
                'success' => 'ERROR',
                'url' => 'La descarga no se pudo completar debido a que la carpeta no contiene archivos.',
            ]);
        }
        $folderPath = $request->folder;
        $zip = new Madzipper();
        $zip->make('zips/'.$request->remedit.'.zip')->addDir('storage/'.$folderPath);
        $url = asset(asset('zips/'.$request->remedit.'.zip'));
        return response()->json([
            'success' => 'Archivo ZIP creado y guardado correctamente.',
            'url' => $url,
        ]);
    });

    Route::post('/materiales_gastados', [TareaController::class, 'ObtenerMateriales']);  
    
    Route::post('/sucursales/importar', [SucursalController::class, 'CargarExcel']);
    Route::post('/clientes/importar', [ClienteController::class, 'CargarExcel']);
    Route::post('/materiales/importar', [MaterialController::class, 'CargarExcel']); 
    Route::post('/tareas/importar', [TareaController::class, 'CargarExcel']); 
    
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::post('/profile', [ProfileController::class, 'UpdateAvatar'])->name('profile.updateavatar');
});

require __DIR__.'/auth.php';
