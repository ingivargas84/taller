<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Events\ActualizacionBitacora;
use Carbon\Carbon;
use App\User;
use App\Servicio;

class ServicioController extends Controller
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


    public function index()
    {
        return view ("admin.servicios.index");
    }

    public function getJson(Request $params)
    {
        $api_Result['data'] = Servicio::all();

        return Response::json( $api_Result );
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

        $servicio = new Servicio;
        $servicio->nombre = $data['nombre'];
        $servicio->precio = $data['precio'];
        $servicio->save();                       

        event(new ActualizacionBitacora($servicio->id, Auth::user()->id,'Creación','',$servicio,'servicios'));

        return Response::json(['success' => 'Éxito']);
    }

    public function nombreDisponible()
    {
        $dato = Input::get("nombre");
        $query = Servicio::where("nombre",$dato)
                        ->where('estado_id', 1)->get();
        $contador = count($query);
        if ($contador == 0)
        {
            return 'false';
        }
        else
        {
            return 'true';
        }
    }

    public function nombreDisponibleEdit()
    {
        $dato = Input::get("nombre");
        $id = Input::get('id');

        $query = Servicio::where("nombre",$dato)
                        ->where('estado_id', 1)
                        ->where('id','!=', $id)->get();
        $contador = count($query);

        if ($contador == 0)
        {
            return 'false';
        }
        else
        {
            return 'true';
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Servicio $servicio, Request $request)
    {
       $respuesta = array(
           'nombre' => $request->nombre,
           'precio' => $request->precio,
       );

       $new = json_encode($respuesta);
        event(new ActualizacionBitacora($servicio->id, Auth::user()->id,'Edición',$servicio, $new,'servicios'));
        $servicio->nombre = $request->nombre;
        $servicio->precio = $request->precio;
        $servicio->save();

        return Response::json(['success' => 'Éxito']);
    }

     public function destroy(Request $request)
    {
        
        $ser = Servicio::where('id', $request->id)->first();
        $ser->estado_id = 2;
        $ser->save();
         event(new ActualizacionBitacora($ser->id, Auth::user()->id,'Inactivación','','','servicios'));
        return Response::json(['success' => 'Éxito']);
    }

    /**
     *  Active a seller
     */
    public function activar(Servicio $servicio)
     {
        $servicio->estado_id = 1;
        $servicio->save();
        event(new ActualizacionBitacora($servicio->id, Auth::user()->id,'Activación','','','servicios'));
        return Response::json(['success' => 'Éxito']);       
     }

}
