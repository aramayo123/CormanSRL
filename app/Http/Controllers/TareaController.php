<?php

namespace App\Http\Controllers;

use App\Http\Requests\CerrarTarea;
use App\Http\Requests\FotoCorRequest;
use App\Http\Requests\FotoPrevRequest;
use App\Http\Requests\MaterialesGastadosRequest;
use App\Http\Requests\TareaRequest;
use App\Imports\TareaImport;
use App\Models\Cliente;
use App\Models\Estado;
use App\Models\Material;
use App\Models\MaterialGastado;
use App\Models\Prioridad;
use App\Models\Sucursal;
use App\Models\Tarea;
use App\Models\TareaAsignada;
use App\Models\User;
use App\Models\Imagen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('can:tareas.index')->only('index');
        $this->middleware('can:tareas.create')->only('create');
        $this->middleware('can:tareas.read')->only('show');
        $this->middleware('can:tareas.update')->only('edit');
        $this->middleware('can:tareas.destroy')->only('destroy');
        $this->middleware('can:tareas.completar')->only('CompletarTarea');
        $this->middleware('can:tareas.completar')->only('CompletarTarea');
    }
    public function index()
    {
        //
        $tareas = Tarea::all();
        return view("tareas.index", compact('tareas'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // 
        $clientes = Cliente::all();
        $sucursales = Sucursal::all();
        $prioridades = Prioridad::all();
        $estados = Estado::all();
        $users = User::all();
        return view('tareas.create', compact('clientes', 'sucursales', 'prioridades', 'users', 'estados'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        $validatorCorrectivo = Validator::make($request->all(), [
            'tipo_de_tarea' => 'required',
            'ticket' => 'required',
            'atm' => 'nullable',
            'cliente_id' => 'required',
            'sucursal_id' => 'required',
            'fecha_mail' => 'nullable',
            'fecha_cerrado' => 'nullable',
            'prioridad_id' => 'required',
            'estado_id' => 'required',
            'user_id' => 'required',
        ]);

        $validatorPreventivo = Validator::make($request->all(), [
            'tipo_de_tarea' => 'required',
            'ticket' => 'nullable',
            'atm' => 'nullable',
            'cliente_id' => 'required',
            'sucursal_id' => 'required',
            'fecha_mail' => 'required',
            'fecha_cerrado' => 'nullable',
            'prioridad_id' => 'nullable',
            'estado_id' => 'required',
            'user_id' => 'required',
        ]);
        if($request->tipo_de_tarea === "PREVENTIVO"){
            if ($validatorPreventivo->fails()) 
                return redirect('tareas/create')->withErrors($validatorPreventivo)->withInput();
        }else{
            if ($validatorCorrectivo->fails()) 
                return redirect('tareas/create')->withErrors($validatorCorrectivo)->withInput();
        }
        $tarea = new Tarea();
        $tarea->tipo_de_tarea = $request->tipo_de_tarea;
        if($tarea->tipo_de_tarea === "PREVENTIVO")
            $tarea->ticket = "preventivo_".Tarea::count()+1;
        else
            $tarea->ticket = $request->ticket;
        $tarea->atm = $request->atm;
        $tarea->cliente_id = $request->cliente_id;
        $tarea->sucursal_id = $request->sucursal_id;
        $tarea->fecha_mail = $request->fecha_mail;
        $tarea->fecha_cerrado = $request->fecha_cerrado;
        $tarea->estado_id = $request->estado_id;
        $tarea->prioridad_id = $request->prioridad_id;
        $tarea->user_id = $request->user_id;
        $tarea->descripcion = $request->descripcion;
        $tarea->elementos = $request->elementos;
        $tarea->diagnostico = $request->diagnostico;
        $tarea->acciones = $request->acciones;
        $tarea->observaciones = $request->observaciones;
        $tarea->save();
        
        $users = User::all();
        foreach($users as $user){
            if(!$user->hasRole('Corman') && !$user->hasRole('Corman')){
                $input = $request->input($user->username);
                if($input){
                    TareaAsignada::create([
                        'tarea_id' => $tarea->id,
                        'user_id' => $user->id
                    ]);
                }
            }
        }
        return redirect()->route('tareas.index')->with('exito', "La tarea ha sido creada con exito!");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        $tarea = Tarea::findOrFail($id);
        $imagenes = Imagen::where('tarea_id', $tarea->id)->get();
        $users = User::all();
        return view('tareas.show', compact('tarea', 'imagenes', 'users'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $tarea = Tarea::findOrFail($id);
        $clientes = Cliente::all();
        $sucursales = Sucursal::all();
        $prioridades = Prioridad::all();
        $estados = Estado::all();
        $users = User::all();
        return view('tareas.edit', compact('tarea', 'clientes', 'sucursales', 'prioridades', 'users', 'estados'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
        $validatorCorrectivo = Validator::make($request->all(), [
            'tipo_de_tarea' => 'required',
            'ticket' => 'required',
            'atm' => 'nullable',
            'cliente_id' => 'required',
            'sucursal_id' => 'required',
            'fecha_mail' => 'nullable',
            'fecha_cerrado' => 'nullable',
            'prioridad_id' => 'required',
            'estado_id' => 'required',
            'user_id' => 'required',
        ]);

        $validatorPreventivo = Validator::make($request->all(), [
            'tipo_de_tarea' => 'required',
            'ticket' => 'nullable',
            'atm' => 'nullable',
            'cliente_id' => 'required',
            'sucursal_id' => 'required',
            'fecha_mail' => 'required',
            'fecha_cerrado' => 'nullable',
            'prioridad_id' => 'nullable',
            'estado_id' => 'required',
            'user_id' => 'required',
        ]);

        if($request->tipo_de_tarea === "PREVENTIVO"){
            if ($validatorPreventivo->fails()) 
                return redirect("tareas/$id/edit")->withErrors($validatorPreventivo)->withInput();
        }else{
            if ($validatorCorrectivo->fails()) 
                return redirect("tareas/$id/edit")->withErrors($validatorCorrectivo)->withInput();
        }

        $tarea = Tarea::findOrFail($id);
        if($request->ticket != $tarea->ticket)
            $tarea->ticket = $request->ticket;

        $tarea->tipo_de_tarea = $request->tipo_de_tarea;
        $tarea->atm = $request->atm;
        $tarea->cliente_id = $request->cliente_id;
        $tarea->sucursal_id = $request->sucursal_id;
        $tarea->fecha_mail = $request->fecha_mail;
        $tarea->fecha_cerrado = $request->fecha_cerrado;
        $tarea->estado_id = $request->estado_id;
        $tarea->prioridad_id = $request->prioridad_id;        
        $tarea->descripcion = $request->descripcion;
        $tarea->elementos = $request->elementos;
        $tarea->diagnostico = $request->diagnostico;
        $tarea->acciones = $request->acciones;
        $tarea->observaciones = $request->observaciones;

        $users = User::all();
        foreach($users as $user){
            if(!$user->hasRole('Corman') && !$user->hasRole('Corman')){
                $input = $request->input($user->username);
                if($input){
                    if(count(TareaAsignada::where('tarea_id', '=', $tarea->id)->where('user_id', '=', $user->id)->get()))
                        continue;

                    // si no existe lo creamos
                    TareaAsignada::create([
                        'tarea_id' => $tarea->id,
                        'user_id' => $user->id
                    ]);
                }else
                    // eliminar
                    TareaAsignada::where('tarea_id','=', $tarea->id)->where('user_id', '=', $user->id)->delete();
            }
        }

        $tarea->update();
        return redirect()->route('tareas.index')->with('exito', "La tarea ha sido actualizada con exito!");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $tarea = Tarea::findOrFail($id);
        Tarea::destroy($id);
        if($tarea->tipo_de_tarea == "PREVENTIVO"){
            $mes = $this->ObtenerMes($tarea->fecha_mail);
            $carpeta = "public/PLANILLA PREVENTIVOS/".$mes."/".$tarea->Sucursal->numero." ".$tarea->Sucursal->sucursal;
        }else{
            if($tarea->atm)
                $carpeta = "public/ATM/".$tarea->ticket;
            else
                $carpeta = "public/OTS/".$tarea->ticket;
        }
        if(Storage::exists($carpeta))
            Storage::deleteDirectory($carpeta);


        return redirect()->route('tareas.index')->with('exito', "La tarea ha sido eliminada con exito!");
    }
    public function CompletarTarea($id){
        $tarea = Tarea::findOrFail($id);
        $materiales = Material::all();
        return view('tareas.completar', compact('tarea', 'materiales'));
    }
    public function CargarMaterial(Request $request){
        $errors = [
            "material_id" => "",
            "cantidad" => "",
            "precio" => "",
        ];
        $error = false;
        if(!$request->material_id){
            $errors["material_id"] = 'El material es obligatorio.';
            $error = true;
        }
           
        if(!$request->cantidad){
            $errors["cantidad"] = 'La cantidad es obligatoria.';
            $error = true;
        }
       
        if(!$request->precio){
            $errors["precio"] = 'El precio es obligatorio.';
            $error = true;
        }
    
        if($error)
            return response()->json([
            'message' => 'error',
            'errors' => $errors,
        ]);
    
        MaterialGastado::create([
            'material_id' => $request->material_id,
            'tarea_id' => $request->tarea_id,
            'cantidad' => $request->cantidad,
            'precio' => $request->precio,
        ]);
    
        return response()->json([
            'message' => 'exito'
        ]);
    }
    public function ObtenerMateriales(Request $request){
        $aux = MaterialGastado::where('tarea_id', '=', $request->tarea_id)->get();
        $materiales = [];
        foreach($aux as $material){
            array_push($materiales,  array(
                'id'  => $material->id,
                'nombre_material'  => $material->Material->descripcion,
                'precio'  => $material->precio,
                'cantidad'  => $material->cantidad,
                )
            );
        }
        return response()->json(['message' => $materiales]);
    }
    public function EliminarMaterial(Request $request){
        MaterialGastado::destroy($request->id);
        return response()->json(['message' => 'Material eliminado con exito!']);
    }
    public function CerrarTarea(Request $request, $id){
        $validator = Validator::make($request->all(), [
            'fecha_cerrado' => 'required',
        ]);

        $tarea = Tarea::findOrFail($id);
        if($tarea->tipo_de_tarea === "CORRECTIVO" && $validator->fails())
            return redirect("tareas/$id/completar")->withErrors($validator)->withInput();
        
        $tarea->fecha_cerrado = $request->fecha_cerrado;
        $tarea->estado_id = 2;
        $tarea->update();
        return redirect()->route('dashboard')->with('exito', "La tarea ha sido cerrada con exito!");
    }
    public function FotoAntes(FotoCorRequest $request){
        if($request->hasFile('file')){
            $imagen_name = $this->GuardarFotoCor($request, "ANTES", "file");
            return response()->json(['success' => $imagen_name]);
        }
        return response()->json(['message' => 'Archivo no recibido.'], 400);
    }
    public function FotoDespues(FotoCorRequest $request){
        if($request->hasFile('file')){
            $imagen_name = $this->GuardarFotoCor($request, "DESPUES", "file");
            return response()->json(['success' => $imagen_name]);
        }
        return response()->json(['message' => 'Archivo no recibido.'], 400);
    }
    public function FotoOt(FotoCorRequest $request){
        if($request->hasFile('file')){
            $imagen_name = $this->GuardarFotoCor($request, "OT", "file");
            return response()->json(['success' => $imagen_name]);
        }
        return response()->json(['message' => 'Archivo no recibido.'], 400);
    }
    public function FotoBoleta(FotoCorRequest $request){
        if($request->hasFile('file')){
            $imagen_name = $this->GuardarFotoCor($request, "BOLETA", "file");
            return response()->json(['success' => $imagen_name]);
        }
        return response()->json(['message' => 'Archivo no recibido.'], 400);
    }
    protected function GuardarFotoCor(Request $request, $subcarpeta, $input_file){
        if($request->atm)
            $carpeta = "ATM/".$request->ticket."/".$subcarpeta;
        else
            $carpeta = "OTS/".$request->ticket."/".$subcarpeta;

        if(strcasecmp($subcarpeta, 'BOLETA') == 0)
            $carpeta_local = $carpeta;
        else
            if($request->atm)
                $carpeta_local = "ATM/".$request->ticket;
            else
                $carpeta_local = "OTS/".$request->ticket;

        $file = $request->file($input_file);
        if(strcasecmp($subcarpeta, 'OT') == 0)
            $imagen_name = 'ot '.$request->ticket.'.'.$file->getClientOriginalExtension();
        else
            $imagen_name = time().'_'.$file->getClientOriginalName();
        
        $imagen = $file->storeAs($carpeta_local, $imagen_name, 'public');    
        $imagen = Storage::url($imagen);

        Imagen::create([
            'nombre' => $imagen_name, 
            'url' => substr($imagen, 1), 
            'tarea_id' => $request->tarea_id
        ]);

        return $imagen_name;
    }

    public function FotosPreventivo(FotoPrevRequest $request){
        if($request->hasFile('file')){
            $imagen_name = $this->GuardarFotoPrev($request, "", "file");
            return response()->json(['success' => $imagen_name]);
        }
        return response()->json(['message' => 'Archivo no recibido.'], 400);
    }
    public function FotosObervaciones(FotoPrevRequest $request){
        if($request->hasFile('file')){
            $imagen_name = $this->GuardarFotoPrev($request, "OBSERVACIONES", "file");
            return response()->json(['success' => $imagen_name]);
        }
        return response()->json(['message' => 'Archivo no recibido.'], 400);
    }
    public function FotosBoleta(FotoPrevRequest $request){
        if($request->hasFile('file')){
            $imagen_name = $this->GuardarFotoPrev($request, "BOLETA", "file");
            return response()->json(['success' => $imagen_name]);
        }
        return response()->json(['message' => 'Archivo no recibido.'], 400);
    }
    public function FotosOtCombustible(FotoPrevRequest $request){
        if($request->hasFile('file')){
            $imagen_name = $this->GuardarFotoPrev($request, "OT_COMBUSTIBLE", "file");
            return response()->json(['success' => $imagen_name]);
        }
        return response()->json(['message' => 'Archivo no recibido.'], 400);
    }
    public function FotosPlanillaPreventivo(FotoPrevRequest $request){
        if($request->hasFile('file')){
            $imagen_name = $this->GuardarFotoPrev($request, "PLANILLA PREVENTIVO", "file");
            return response()->json(['success' => $imagen_name]);
        }
        return response()->json(['message' => 'Archivo no recibido.'], 400);
    }
    protected function GuardarFotoPrev(Request $request, $subcarpeta, $input_file){
        $mesActual = $this->ObtenerMes($request->mes);

        $carpeta = "PLANILLA PREVENTIVOS/".$mesActual."/".$request->sucursal."/".$subcarpeta;
        $file = $request->file($input_file);
        $imagen_name = time().'_'.$file->getClientOriginalName();
        $imagen = $file->storeAs($carpeta, time().'_'.$file->getClientOriginalName(), 'public');
        $imagen = Storage::url($imagen);
        
        Imagen::create([
            'nombre' => $imagen_name, 
            'url' => substr($imagen, 1), 
            'tarea_id' => $request->tarea_id
        ]);

        return $imagen_name;
    }
    public function ObtenerMes($fecha){
        $arr1 = str_split($fecha);
        $mesInt = $arr1[5].$arr1[6];
        $meses = ["ENERO", "FEBRERO", "MARZO", "ABRIL", 
                    "MAYO", "JUNIO", "JULIO", "AGOSTO", 
                    "SEPTIEMBRE", "OCTUBRE", "NOVIEMBRE", "DICIEMBRE"];
        $mesActual = $meses[intval($mesInt)-1];
        return $mesActual;
    }
    public function CargarExcel(Request $request){
        $request->validate([
            'archivo' => 'required|mimes:xlsx'
        ]);
        try{
            $file = $request->file('archivo');
            Excel::import(new TareaImport, $file);
            return redirect()->route('tareas.index')->with('exito', "Se ha cargado el EXCEL con exito!");
        }catch(\Exception $e){
            return redirect()->route('tareas.index')->with('error', $e->getMessage());
        }
    }
}
