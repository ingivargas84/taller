<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Events\ActualizacionBitacora;
use App\UbicacionEquipo;
use App\Equipo;
use App\User;

class UbicacionEquipoController extends Controller
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
        return view('admin.ubicacionEquipo.index');
    }

    /**
     * 
     */
    public function getJson() {
        $api_result['data'] = UbicacionEquipo::where('estado_id', '1')->get();
        return response()->json($api_result);
    }

    /**
     * 
     */

     public function getUbicaciones($id) {
        $objetos = []; 
        $ubicacion = UbicacionEquipo::where('id',$id)->get();
        $eqs = $ubicacion[0]->equipos->where('estado_id',1);
        $objetos['ubicacion'] = $ubicacion;
        $objetos['equiposUbi'] = $eqs; 
        $objetos['ubicaciones'] = UbicacionEquipo::where('id','!=',$id)->where('estado_id', '1')->get();

        return response()->json($objetos);
     }

     public function getEquipo($id) {
        $equipos = Equipo::where('ubicacion_id',$id)->where('estado_id','1')->get();
        return response()->json($equipos);
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

        $ubicacionEquipo = new UbicacionEquipo;
        $ubicacionEquipo->ubicacion = $data['nombre'];
        $ubicacionEquipo->save();

        event(new ActualizacionBitacora($ubicacionEquipo->id, Auth::user()->id, 'Creación', '', $ubicacionEquipo, 'UbicacionEquipo'));

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
        $query = UbicacionEquipo::where('ubicacion', $dato)->where('estado_id','1')->get();
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

        $query = UbicacionEquipo::where('ubicacion',$dato)
                    ->where('id','!=', $id)->where('estado_id','1')->get();
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
    public function update(Request $request, UbicacionEquipo $ubicacionEquipo)
    {
        $new = $request->all();
        event(new ActualizacionBitacora($ubicacionEquipo->id, Auth::user()->id,'Edicion',$ubicacionEquipo, $new['nombre'],'UbicacionEquipo'));
        $ubicacionEquipo->ubicacion = $request->nombre;
        $ubicacionEquipo->save();

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
        
        $equipos = Equipo::where('ubicacion_id', $request->idUbicacion)->get();
        
        if($request->nuevaU !=null) {
              
                $nueva = $request->nuevaU;
                foreach($equipos as $e) {
                    $e->ubicacion_id = $nueva;
                    event(new ActualizacionBitacora($e->id, Auth::user()->id,'UbicacionAnteriorDesactivada', '', '', 'Equipo'));
                    $e->save();
                 }

                $previousLocation = UbicacionEquipo::where('id',$request->idUbicacion)->first();
                $previousLocation->estado_id = 2;
                $previousLocation->save();
                return response()->json(['success'=>'Éxito']);
          
        } else {
                $location = UbicacionEquipo::where('id',$request->idUbicacion)->first();
                $location->estado_id = 2;
                $location->save();
                event(new ActualizacionBitacora($location->id, Auth::user()->id,'Inactivación', '', '', 'UbicacionEquipo'));
                return response()->json(['success'=>'Éxito']);
          
            
        }
        
       // event(new ActualizacionBitacora($ubicacionEquipo->id, Auth::user()->id,'Inactivación', '', '', 'UbicacionEquipo'));
        
        //
    }

    /**
     * 
     */

    public function activar(UbicacionEquipo $ubicacionEquipo) {
        
        $ubicacionEquipo->estado_id = 1;
        $ubicacionEquipo->save();

        event(new ActualizacionBitacora($ubicacionEquipo->id, Auth::user()->id,'Activación', '', '', 'UbicacionEquipo'));
        return response()->json(['success'=>'Éxito']);
    }
}
