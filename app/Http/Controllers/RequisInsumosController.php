<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;
use App\Events\ActualizacionBitacora;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Insumo;
use App\RequisicionMaestro;
use App\RequisicionDetalle;
use App\MovimientosInsumo;

class RequisInsumosController extends Controller
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
        return view('admin.requi_insumos.index');
    }


    public function getJson(Request $params)
    {
       $api_Result['data'] = RequisicionMaestro::select(
           'requisicion_maestro.id',
           'requisicion_maestro.fecha_requisicion',
           'requisicion_maestro.estado_requisicion_id',
           'estado_requisicion.estado_requisicion',
           'users.name',
           'requisicion_maestro.created_at'
        )->join(
            'estado_requisicion',
            'requisicion_maestro.estado_requisicion_id',
            '=',
            'estado_requisicion.id'
        )->join(
            'users',
            'requisicion_maestro.user_id',
            '=',
            'users.id'
       )->get(); 


       return Response::json( $api_Result );
   }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $usuario = Auth::user()->name;
        $insumos = Insumo::where('estado_id',1)->get();
        $today = date("d/m/Y");
        
        return view("admin.requi_insumos.create", compact('usuario','insumos','today'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         $arr = json_decode($request->getContent(), true); 

        $rm = RequisicionMaestro::create([
            'user_id'                  => Auth::user()->id,
            'fecha_requisicion'        => date("Y/m/d H:m:s"),
            'estado_requisicion_id'    => 1,
            'justificacion'            => $arr[1]["value"]
            ]);


        for ($i=4; $i < sizeof($arr) ; $i++) {

            $rd = RequisicionDetalle::create([
                'requisicion_maestro_id'  => $rm->id,
                'insumo_id'               => $arr[$i]["insumo_id"],
                'cantidad'                => $arr[$i]["cantidad"]
            ]);
        }

        //writes the new purchase to log
        event(new ActualizacionBitacora($rm->id, Auth::user()->id, 'Creación', '', $rm, 'Requisición de Insumos'));

        return Response::json(['success' => 'Éxito']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(RequisicionMaestro $requisicion_maestros)
    {
        if($requisicion_maestros->estado_requisicion_id == 1)
        {
            $requisicionmaestro = RequisicionMaestro::select(
                'requisicion_maestro.id',
                'requisicion_maestro.fecha_requisicion',
                'requisicion_maestro.estado_requisicion_id',
                'estado_requisicion.estado_requisicion',
                'requisicion_maestro.justificacion',
                'users.name as user_crea',
                'requisicion_maestro.created_at'
            )->join(
                'users',
                'requisicion_maestro.user_id',
                '=',
                'users.id'
            )->join(
                'estado_requisicion',
                'requisicion_maestro.estado_requisicion_id',
                '=',
                'estado_requisicion.id'
            )->where(
                'requisicion_maestro.id',
                '=',
                $requisicion_maestros->id
            )->get();
        }
        else if($requisicion_maestros->estado_requisicion_id == 2)
        {
            $requisicionmaestro = RequisicionMaestro::select(
                'requisicion_maestro.id',
                'requisicion_maestro.fecha_requisicion',
                'requisicion_maestro.estado_requisicion_id',
                'estado_requisicion.estado_requisicion',
                'requisicion_maestro.justificacion',
                'users.name as user_crea',
                'requisicion_maestro.fecha_rechaza',
                'requisicion_maestro.razon_rechaza',
                'us_rechaza.name as user_rechaza',
                'requisicion_maestro.created_at'
            )->join(
                'users',
                'requisicion_maestro.user_id',
                '=',
                'users.id'
            )->join(
                'users as us_rechaza',
                'requisicion_maestro.user_rechaza',
                '=',
                'us_rechaza.id'
            )->join(
                'estado_requisicion',
                'requisicion_maestro.estado_requisicion_id',
                '=',
                'estado_requisicion.id'
            )->where(
                'requisicion_maestro.id',
                '=',
                $requisicion_maestros->id
            )->get();
        }
        else if($requisicion_maestros->estado_requisicion_id == 3)
        {
            $requisicionmaestro = RequisicionMaestro::select(
                'requisicion_maestro.id',
                'requisicion_maestro.fecha_requisicion',
                'requisicion_maestro.estado_requisicion_id',
                'estado_requisicion.estado_requisicion',
                'requisicion_maestro.justificacion',
                'users.name as user_crea',
                'requisicion_maestro.fecha_autoriza',
                'us_autoriza.name as user_autoriza',
                'requisicion_maestro.created_at'
            )->join(
                'users',
                'requisicion_maestro.user_id',
                '=',
                'users.id'
            )->join(
                'users as us_autoriza',
                'requisicion_maestro.user_autoriza',
                '=',
                'us_autoriza.id'
            )->join(
                'estado_requisicion',
                'requisicion_maestro.estado_requisicion_id',
                '=',
                'estado_requisicion.id'
            )->where(
                'requisicion_maestro.id',
                '=',
                $requisicion_maestros->id
            )->get();
        }
        else if($requisicion_maestros->estado_requisicion_id == 4)
        {
            $requisicionmaestro = RequisicionMaestro::select(
                'requisicion_maestro.id',
                'requisicion_maestro.fecha_requisicion',
                'requisicion_maestro.estado_requisicion_id',
                'estado_requisicion.estado_requisicion',
                'requisicion_maestro.justificacion',
                'users.name as user_crea',
                'requisicion_maestro.fecha_autoriza',
                'us_autoriza.name as user_autoriza',
                'requisicion_maestro.fecha_entrega',
                'us_entrega.name as user_entrega',
                'requisicion_maestro.created_at'
            )->join(
                'users',
                'requisicion_maestro.user_id',
                '=',
                'users.id'
            )->join(
                'users as us_autoriza',
                'requisicion_maestro.user_autoriza',
                '=',
                'us_autoriza.id'
            )->join(
                'users as us_entrega',
                'requisicion_maestro.user_entrega',
                '=',
                'us_entrega.id'
            )->join(
                'estado_requisicion',
                'requisicion_maestro.estado_requisicion_id',
                '=',
                'estado_requisicion.id'
            )->where(
                'requisicion_maestro.id',
                '=',
                $requisicion_maestros->id
            )->get();
        }



        
        $requisiciondetalle = RequisicionDetalle::select(
            'requisicion_detalle.id',
            'requisicion_detalle.cantidad',
            'insumos.nombre_insumo',
        )->join(
            'insumos',
            'requisicion_detalle.insumo_id',
            '=',
            'insumos.id'
        )->where(
            'requisicion_detalle.requisicion_maestro_id',
            '=',
            $requisicion_maestros->id
        )->get();


        return view('admin.requi_insumos.show', compact('requisicionmaestro', 'requisiciondetalle'));
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
    }


    public function getInsumo($id){
        
        $api_result = Insumo::WHERE("id",$id)->get();

        return Response::json($api_result);
    }

    public function rechazarequi(RequisicionMaestro $requisicion_maestro, Request $request )
    {        
        return view('admin.requi_insumos.rechazarequi', compact('requisicion_maestro'));
    }


    public function rechazar(Request $request )
    {        

        $requisicion_maestro = RequisicionMaestro::Where("id",$request->requi)->get();
    
        $requisicion_maestro[0]->estado_requisicion_id = 2;
        $requisicion_maestro[0]->user_rechaza = Auth::user()->id;
        $requisicion_maestro[0]->razon_rechaza = $request->razon;
        $requisicion_maestro[0]->fecha_rechaza = date("Y/m/d H:m:s");
        $requisicion_maestro[0]->save();

        event(new ActualizacionBitacora($requisicion_maestro[0]->id, Auth::user()->id, 'Rechazo de Requisición', '', '', 'Requisición de Insumos'));

        return redirect()->route('requi_insumos.index')->withFlash('La Requisición se ha rechazado de forma satisfactoria.');
    }


    public function autorizar(RequisicionMaestro $requisicion_maestro, Request $request )
    {        

        $requisicion_maestro->estado_requisicion_id = 3;
        $requisicion_maestro->user_autoriza = Auth::user()->id;
        $requisicion_maestro->fecha_autoriza = date("Y/m/d H:m:s");
        $requisicion_maestro->save();

        event(new ActualizacionBitacora($requisicion_maestro->id, Auth::user()->id, 'Autorización de Requisición', '', '', 'Requisición de Insumos'));

        return Response::json(['success' => 'Éxito']);
    }


    public function entregar(RequisicionMaestro $requisicion_maestro, Request $request )
    {        

        $requisicion_maestro->estado_requisicion_id = 4;
        $requisicion_maestro->user_entrega = Auth::user()->id;
        $requisicion_maestro->fecha_entrega = date("Y/m/d H:m:s");
        $requisicion_maestro->save();

        $reqd = RequisicionDetalle::Where("requisicion_maestro_id",$requisicion_maestro->id)->get();

        for ($i=0; $i < count($reqd); $i++) {

            $insumo = Insumo::Where("id",$reqd[$i]->insumo_id)->get();
            $insumo[0]->existencias = $insumo[0]->existencias - $reqd[$i]->cantidad;

            $mov_insumo = MovimientosInsumo::Where("insumo_id",$reqd[$i]->insumo_id)->get();
            $mov_insumo[0]->existencias = $mov_insumo[0]->existencias - $reqd[$i]->cantidad;

            $mov_insumo[0]->save();
            $insumo[0]->save();
        }

        event(new ActualizacionBitacora($requisicion_maestro->id, Auth::user()->id, 'Entrega de Requisición', '', '', 'Requisición de Insumos'));

        return Response::json(['success' => 'Éxito']);
    }



}

