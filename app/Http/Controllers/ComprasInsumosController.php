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
use App\Proveedor;
use App\InsumosMaestro;
use App\InsumosDetalle;
use App\MovimientosInsumo;

class ComprasInsumosController extends Controller
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
        return view('admin.compra_insumos.index');
    }


    public function getJson(Request $params)
    {
       $api_Result['data'] = InsumosMaestro::select(
           'insumo_maestro.id',
           'insumo_maestro.fecha_compra',
           DB::raw('CONCAT(insumo_maestro.serie_factura," ",insumo_maestro.num_factura) as factura'),
           'proveedores.nombre_comercial as proveedor',
           'insumo_maestro.total',
           'insumo_maestro.estado_id',
           'estados.estado',
           'insumo_maestro.created_at'
        )->join(
            'estados',
            'insumo_maestro.estado_id',
            '=',
            'estados.id'
        )->join(
            'proveedores',
            'insumo_maestro.proveedor_id',
            '=',
            'proveedores.id'
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
        $proveedores = Proveedor::where('estado',1)->get();
        $insumos = Insumo::where('estado_id',1)->get();
        
        return view("admin.compra_insumos.create", compact('proveedores','insumos'));
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

        $user_id             = Auth::user()->id;
        $fecha_compra        = date_format(date_create($arr[2]["value"]), "Y/m/d");
        $fecha_factura       = date_format(date_create($arr[2]["value"]), "Y/m/d");
        $proveedor_id        = $arr[1]["value"];
        $serie_factura       = $arr[3]["value"];
        $num_factura         = $arr[4]["value"];
        $total               = $arr[8]["value"];
        $estado_id           = 1;


        $im = InsumosMaestro::create([
            'user_id'              => $user_id,
            'fecha_compra'         => $fecha_compra,
            'fecha_factura'        => $fecha_factura,
            'proveedor_id'         => $proveedor_id,
            'serie_factura'        => $serie_factura,
            'num_factura'          => $num_factura,
            'total'                => $total,
            'estado_id'            => $estado_id
            ]);


        for ($i=9; $i < sizeof($arr) ; $i++) {

            $mi = MovimientosInsumo::create([
                'fecha_ingreso'   => $fecha_compra,
                'insumo_id'       => $arr[$i]["insumo_id"],
                'existencias'     => $arr[$i]["cantidad"],
                'estado_id'       => 1,
            ]);


            $md = InsumosDetalle::create([
                'insumo_maestro_id'       => $im->id,
                'insumo_id'               => $arr[$i]["insumo_id"],
                'precio_compra'           => $arr[$i]["precio_compra"],
                'cantidad'                => $arr[$i]["cantidad"],
                'subtotal'                => $arr[$i]["subtotal"],
                'movimiento_insumo_id'    => $mi->id,
                'estado_id'               => 1,
            ]);

            $insumo = Insumo::Where("id",$arr[$i]["insumo_id"])->get();
            $insumo[0]->existencias = $insumo[0]->existencias + $arr[$i]["cantidad"];
            $insumo[0]->save();

            
        }

        //writes the new purchase to log
        event(new ActualizacionBitacora($im->id, Auth::user()->id, 'Creación', '', $im, 'compra insumos maestro'));

        return Response::json(['success' => 'Éxito']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(InsumosMaestro $insumos_maestros)
    {
        $insumosmaestro = InsumosMaestro::select(
            'insumo_maestro.id',
            'insumo_maestro.fecha_factura',
            'insumo_maestro.serie_factura',
            'insumo_maestro.num_factura',
            'insumo_maestro.total',
            'proveedores.nombre_comercial',
            'insumo_maestro.estado_id',
            'estados.estado',
            'users.name',
            'insumo_maestro.created_at'
         )->join(
             'estados',
             'insumo_maestro.estado_id',
             '=',
             'estados.id'
         )->join(
             'proveedores',
             'insumo_maestro.proveedor_id',
             '=',
             'proveedores.id'
         )->join(
            'users',
            'insumo_maestro.user_id',
            '=',
            'users.id'
        )->where(
            'insumo_maestro.id',
            '=',
            $insumos_maestros->id
        )->get();


        $insumosdetalle = InsumosDetalle::select(
            'insumo_detalle.id',
            'insumo_detalle.precio_compra',
            'insumo_detalle.cantidad',
            'insumo_detalle.subtotal',
            'insumos.nombre_insumo',
            'insumos.tipo_insumo'
        )->join(
            'insumos',
            'insumo_detalle.insumo_id',
            '=',
            'insumos.id'
        )->where(
            'insumo_detalle.insumo_maestro_id',
            '=',
            $insumos_maestros->id
        )->get();

        return view('admin.compra_insumos.show', compact('insumosmaestro', 'insumosdetalle'));
        
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
    public function anular(InsumosMaestro $insumos_maestros, Request $request )
    {        
        $id = InsumosDetalle::Where("insumo_maestro_id",$insumos_maestros->id)->get();

        for ($i=0; $i < count($id); $i++) {

            $insumo = Insumo::Where("id",$id[$i]->insumo_id)->get();
            $insumo[0]->existencias = $insumo[0]->existencias - $id[$i]->cantidad;

            $mov_insumo = MovimientosInsumo::Where("id",$id[$i]->movimiento_insumo_id)->get();
            $mov_insumo[0]->existencias = 0;
            $mov_insumo[0]->estado_id = 2;

            $mov_insumo[0]->save();
            $insumo[0]->save();
        }

        $insumos_maestros->estado_id = 3;
        $insumos_maestros->save();

        event(new ActualizacionBitacora($insumos_maestros->id, Auth::user()->id, 'Eliminación', '', '', 'Compra de Insumos'));

        return Response::json(['success' => 'Éxito']);
    }
}
