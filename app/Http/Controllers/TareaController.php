<?php

namespace App\Http\Controllers;

use App\Http\Requests\TareaRequest;
use App\Models\Cliente;
use App\Models\Estado;
use App\Models\Prioridad;
use App\Models\Sucursal;
use App\Models\Tarea;
use App\Models\TareaAsignada;
use App\Models\User;
use Illuminate\Http\Request;

class TareaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('can:tareas.index');
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
    public function store(TareaRequest $request)
    {
        //
        
        $tarea = new Tarea();
        $tarea->tipo_de_tarea = $request->tipo_de_tarea;
        $tarea->ticket = $request->ticket;
        $tarea->atm = $request->atm;
        $tarea->cliente_id = $request->cliente_id;
        $tarea->sucursal_id = $request->sucursal_id;
        $tarea->fecha_mail = $request->fecha_mail;
        $tarea->fecha_cerrado = $request->fecha_cerrado;
        $tarea->estado_id = $request->estado_id;
        $tarea->prioridad_id = $request->prioridad_id;
        $tarea->user_id = $request->user_id;
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
        Tarea::destroy($id);
        return redirect()->route('tareas.index')->with('exito', "La tarea ha sido eliminada con exito!");
    }
}
