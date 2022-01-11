<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Events\ActualizacionBitacora;
use App\TipoTrabajo;
use App\User;

class TipoTrabajoController extends Controller
{

    /**
     * 
     */
    public function __construct() {    
        $this->middleware('auth');
    
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.tipoTrabajo.index');
    }

    /**
     * 
     */
    public function getJson() {
        $api_result['data'] = TipoTrabajo::where('estado_id', '1')->get();
        return response()->json($api_result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //No aplica
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

        $tipoTr = new TipoTrabajo;
        $tipoTr->nombre = $data['nombre'];
        $tipoTr->save();

        event(new ActualizacionBitacora($tipoTr->id, Auth::user()->id, 'Creación', '', $tipoTr, 'TipoTrabajo'));

        return response()->json(['success'=>'Éxito']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //No aplica
    }

    /**
     * 
     */

    public function nombreDisponible() {
        $dato = Input::get('nombre');
        $query = TipoTrabajo::where('nombre', $dato)->where('estado_id', '1')->get();
        $counter = count($query);
        if($counter == 0) {
            return 'false';
        } else {
            return 'true';
        }
    }

    /**
     * 
     */
    public function nombreDisponibleEdit() {
        $dato = Input::get('nombre');
        $id = Input::get('id');

        $query = TipoTrabajo::where('nombre',$dato)
                    ->where('id','!=', $id)->where('estado_id', '1')->get();
        $counter = count($query);
        if ($counter == 0)
        {
            return 'false';
        }
        else
        {
            return 'true';
        }
    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //No aplica
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, TipoTrabajo $tipoTrabajo)
    {
        $new = $request->all();
        event(new ActualizacionBitacora($tipoTrabajo->id, Auth::user()->id,'Edicion',$tipoTrabajo, $new['nombre'],'TipoTrabajo'));
        $tipoTrabajo->nombre = $request->nombre;
        $tipoTrabajo->save();

        return response()->json(['success'=>'Éxito']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $tipoT = TipoTrabajo::where('id',$request->id)->first();
        $tipoT->estado_id = 2;
        $tipoT->save();
        
        event(new ActualizacionBitacora($tipoT->id, Auth::user()->id,'Inactivación', '', '', 'tipoTrabajo'));
        
        return response()->json(['success'=>'Éxito']);
    }

    /**
     * 
     */

    public function activar(TipoTrabajo $tipoT) {
        
        $tipoT->estado_id = 1;
        $tipoT->save();

        event(new ActualizacionBitacora($tipoT->id, Auth::user()->id,'Activación', '', '', 'tipoTrabajo'));
        return response()->json(['success'=>'Éxito']);
    }
}
