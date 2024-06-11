<?php

namespace App\Http\Controllers;

use App\Http\Requests\ClienteRequest;
use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Imports\ClienteImport;
use Maatwebsite\Excel\Facades\Excel;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('can:clientes.index');
    }
    public function index()
    {
        //
        $clientes = Cliente::all();
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('clientes.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClienteRequest $request)
    {
        //
        Cliente::create($request->all());
        return redirect()->route('clientes.index')->with('exito', "El cliente ha sido creado con exito!");
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
        $cliente = Cliente::findOrFail($id);
        return view('clientes.edit', compact('cliente'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ClienteRequest $request, $id)
    {
        $cliente = Cliente::findOrFail($id);
        $cliente->cliente = $request->cliente;
        $cliente->update();
        return redirect()->route('clientes.index')->with('exito', "El cliente ha sido actualizado con exito!");
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
        Cliente::destroy($id);
        return redirect()->route('clientes.index')->with('exito', "El cliente ha sido eliminado con exito!");
    }
    public function CargarExcel(Request $request){
        $request->validate([
            'archivo' => 'required|mimes:xlsx'
        ]);
        try{
            $file = $request->file('archivo');
            Excel::import(new ClienteImport, $file);
            return redirect()->route('clientes.index')->with('exito', "Se ha cargado el EXCEL con exito!");
        }catch(\Exception $e){
            return redirect()->route('clientes.index')->with('error', $e->getMessage());
        }
    }
}
