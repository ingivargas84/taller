<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Events\ActualizacionBitacora;
use App\EstadosTaller;
use App\User;

class EstadosTallerController extends Controller
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
        return view('admin.estadosTaller.index');
    }

    /**
     * 
     */
    public function getJson() {
        $api_result['data'] = EstadosTaller::where('estado_id','1')->get();
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

        $estadosTaller = new EstadosTaller;
        $estadosTaller->nombre = $data['nombre'];
        $estadosTaller->save();

        event(new ActualizacionBitacora($estadosTaller->id, Auth::user()->id, 'Creación', '', $estadosTaller, 'EstadosTaller'));

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
        $query = EstadosTaller::where('nombre', $dato)->where('estado_id', '1')->get();
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

        $query = EstadosTaller::where('nombre',$dato)
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
    public function update(Request $request, EstadosTaller $estadosTaller)
    {
        $new = $request->all();
        event(new ActualizacionBitacora($estadosTaller->id, Auth::user()->id,'Edicion',$estadosTaller, $new['nombre'],'EstadosTaller'));
        $estadosTaller->nombre = $request->nombre;
        $estadosTaller->save();

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
        $estadosTaller = EstadosTaller::where('id',$request->id)->first();
        $estadosTaller->estado_id = 2;
        $estadosTaller->save();
        
        event(new ActualizacionBitacora($estadosTaller->id, Auth::user()->id,'Inactivación', '', '', 'EstadosTaller'));
        
        return response()->json(['success'=>'Éxito']);
    }

    /**
     * 
     */

    public function activar(EstadosTaller $estadosTaller) {
        
        $estadosTaller->estado_id = 1;
        $estadosTaller->save();

        event(new ActualizacionBitacora($estadosTaller->id, Auth::user()->id,'Activación', '', '', 'EstadosTaller'));
        return response()->json(['success'=>'Éxito']);
    }
}
