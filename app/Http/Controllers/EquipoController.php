<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Events\ActualizacionBitacora;
use App\Equipo;
use App\UbicacionEquipo;
use App\User;

class EquipoController extends Controller
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
      
       return view('admin.equipos.index');
    }

     /**
     * Obteniendo los equipos json 
     */

     public function getJson() {
        
        $api_result['data'] = Equipo::where('estado_id', '1')->get();
        foreach($api_result['data'] as $e) {
            $e->ubicacion;
        }
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

        $equipo = new Equipo;
        $equipo->equipo = $data['nombre'];
        $equipo->descripcion = $data['descripcion'];
        $equipo->ubicacion_id = $data['ubicaciones'];
        $equipo->save();

        event(new ActualizacionBitacora($equipo->id, Auth::user()->id, 'Creación', '', $equipo, 'Equipos'));

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
        $query = Equipo::where('equipo', $dato)->where('estado_id', '1')->get();
        $counter = count($query);
        if($counter === 0) {
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
       
       
        $query = Equipo::where('equipo',$dato)
                    ->where('id','!=', $id)->where('estado_id', '1')->get();
        $counter = count($query);
        if ($counter == 0)
        {
            return 'false';
        } else {
            
            return 'true';
        }
    
    }

    /**
     * 
     */

     public function getUbicaciones() {
         $ubicaciones = UbicacionEquipo::where('estado_id', 1)->get();

          return response()->json($ubicaciones);
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
    public function update(Request $request, Equipo $equipo)
    {
        $new = $request->all();
        event(new ActualizacionBitacora($equipo->id, Auth::user()->id,'Edicion',$equipo, json_encode($new),'Equipo'));
        $equipo->equipo = $request->equipo;
        $equipo->descripcion = $request->descripcion;
        $equipo->ubicacion_id = $request->locations;
        $equipo->save();

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
        $equipo = Equipo::where('id',$request->id)->first();
        $equipo->estado_id = 2;
        $equipo->save();
        
        event(new ActualizacionBitacora($equipo->id, Auth::user()->id,'Inactivación', '', '', 'Equipo'));
        
        return response()->json(['success'=>'Éxito']);
    }

    /**
     * 
     */

    public function activar(Equipo $equipo) {
        
        $equipo->estado_id = 1;
        $equipo->save();

        event(new ActualizacionBitacora($equipo->id, Auth::user()->id,'Activación', '', '', 'Equipo'));
        return response()->json(['success'=>'Éxito']);
    }
}
