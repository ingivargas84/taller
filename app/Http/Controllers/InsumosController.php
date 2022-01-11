<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Events\ActualizacionBitacora;
use App\User;
use App\Insumo;

class InsumosController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.insumos.index');
    }

    /**
     * Get the forma de pago json 
     */

     public function getJson() {
        $api_result['data'] = Insumo::where('estado_id', '1')->get();
        return response()->json($api_result);
     }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.insumos.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();
        $data["user_id"] = Auth::user()->id;
        $data["estado_id"] = 1;
        $data["existencias"] = 0;
        $insumos = Insumo::create($data);
       
        event(new ActualizacionBitacora($insumos->id, Auth::user()->id,'Creación','', $insumos,'insumos'));

        return redirect()->route('insumos.index')->withFlash('El insumo ha sido creado exitosamente!');
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
    public function edit(Insumo $insumo)
    {
        return view('admin.insumos.edit', compact('insumo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Insumo $insumo)
    {
        $insumo->update($request->all());
      
        return redirect()->route('insumos.index', $insumo)->with('flash','El insumo se ha sido actualizado!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $insumo = Insumo::where('id',$request->id)->first();
        $insumo->estado_id = 2;
        $insumo->save();
        
        event(new ActualizacionBitacora($insumo->id, Auth::user()->id,'Inactivación', '', '', 'Insumo'));
        
        return response()->json(['success'=>'Éxito']);
    }


    public function activar(Insumo $insumo)
    {
       $insumo->estado_id = 1;
       $insumo->save();
       event(new ActualizacionBitacora($insumo->id, Auth::user()->id,'Activación','','','Insumo'));
       return response()->json(['success' => 'Éxito']);        
    }
}
