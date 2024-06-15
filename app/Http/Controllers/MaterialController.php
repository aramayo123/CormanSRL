<?php

namespace App\Http\Controllers;

use App\Http\Requests\MaterialRequest;
use App\Imports\MaterialImport;
use App\Models\Material;
use App\Models\MaterialGastado;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct()
    {
        $this->middleware('can:materiales.index');
    }
     
    public function index()
    {
        //
        $materiales = Material::all();
        return view('materiales.index', compact('materiales'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('materiales.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MaterialRequest $request)
    {
        //
        Material::create($request->all());
        return redirect()->route('materiales.index')->with('exito', "El material ha sido creado con exito!");
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
        $material = Material::findOrFail($id);
        return view('materiales.edit', compact('material'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MaterialRequest $request, $id)
    {
        //
        $material = Material::findOrFail($id);
        $material->zona = $request->zona;
        $material->descripcion = $request->descripcion;
        $material->unidad = $request->unidad;
        return redirect()->route('materiales.index')->with('exito', "El material ha sido actualizado con exito!");
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
        Material::destroy($id);
        return redirect()->route('materiales.index')->with('exito', "El material ha sido eliminado con exito!");
    }
    public function CargarExcel(Request $request){
        $request->validate([
            'archivo' => 'required|mimes:xlsx'
        ]);
        try{
            $file = $request->file('archivo');
            Excel::import(new MaterialImport, $file);
            return redirect()->route('materiales.index')->with('exito', "Se ha cargado el EXCEL con exito!");
        }catch(\Exception $e){
            return redirect()->route('materiales.index')->with('error', $e->getMessage());
        }
    }
}
