<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Response;
use App\Events\ActualizacionBitacora;
use DB;
use Carbon\Carbon;
use App\OrdenEquipo;
use App\Cliente;
use App\Equipo;
use App\TipoTrabajo;
use App\Empleado;
use App\Taller;
use App\Producto;
use App\Servicio;
use App\UbicacionEquipo;
use App\User;
use App\EstadoTaller;
use App\Diagnostico;

class AsesorController extends Controller
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
        return view('admin.asesor.index');
    }


    public function getJson()
    {
        $query = "SELECT oe.id AS id, oe.fecha_orden, oe.no_orden_trabajo, oe.no_comprobante, cl.nombre_comercial AS cliente, eq.equipo, ue.ubicacion, CONCAT(emp.nombres,' ',emp.apellidos) as asesor, eot.estado_orden_trabajo AS estado
        FROM ordenequipo oe
        INNER JOIN clientes cl ON oe.cliente_id=cl.id
        INNER JOIN equipos eq ON oe.equipo_id=eq.id
        INNER JOIN ubicaciones_equipo ue ON oe.ubicacion_id=ue.id
        INNER JOIN empleados emp ON cl.empleado_id = emp.id
        INNER JOIN estado_ordenes_trabajo eot ON oe.estado_orden_trabajo_id = eot.id
        WHERE oe.ubicacion_id in (1,2) AND oe.estado_orden_trabajo_id in (4,5,6,7)";

        $api_result['data'] = DB::select($query);

        return response()->json($api_result);
    }


    public function recibirordenasesor(OrdenEquipo $ordenequipo)
    {
        $ordenequipo->estado_orden_trabajo_id = 5;
        $ordenequipo->fecha_recibe_asesor_p45 = Carbon::now();
        $ordenequipo->user_recibe_asesor_p45 = Auth::user()->id;
        $ordenequipo->save();

        event(new ActualizacionBitacora($ordenequipo->id, Auth::user()->id,'Recepción de OT por Asesor ', '', '', ' Orden de Taller'));

        return redirect()->route('asesor.index')->withFlash('La orden ha sido recibida desde taller exitosamente!');
    }


    public function Envio($id){

        $ordenequipo = OrdenEquipo::where("id",$id)->get()->first();
        
        $ordenequipo->estado_orden_trabajo_id = 6;
        $ordenequipo->ubicacion_id = 1;
        $ordenequipo->fecha_envia_llamada_p56 = Carbon::now();
        $ordenequipo->user_envia_llamada_p56 = Auth::user()->id;
        $ordenequipo->save();

        event(new ActualizacionBitacora($ordenequipo->id, Auth::user()->id,'Envio de OT por Asesor', '', '', ' Orden de Taller'));
      
        return redirect()->route('asesor.index')->withFlash('La orden fue enviada a recepción de forma correcta');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(OrdenEquipo $ordenequipo)
    {
        $equipo = Equipo::where('id',$ordenequipo->equipo_id)->get()->first();
        $cliente = Cliente::where('id',$ordenequipo->cliente_id)->get()->first();
        $taller = Taller::where('ordenequipo_id',$ordenequipo->id)->get()->first();
        $producto = Producto::where('estado_id',1)->get();
        $servicio = Servicio::where('estado_id',1)->get();
        $diagnostico = Diagnostico::where('ordenequipo_id',$ordenequipo->id)->get();

        return view("admin.asesor.create", compact('ordenequipo','equipo','cliente','taller','producto','servicio','diagnostico'));

    }


    public function getdiagnostico($id)
    {
        $api_result = Diagnostico::Select(
            'id',
            'codigo',
            'precio',
            'cantidad',
            'subtotal',
            'nombre',
            'tipo'
        )->Where(
            'ordenequipo_id',
            '=',
            $id
        )->get();  

        return Response::json($api_result);
    }


    public function editdetalle(Diagnostico $diagnostico)
    {
    
        if ($diagnostico->tipo == "producto"){
            $producto = Producto::where('estado_id',1)->get();
        }elseif ($diagnostico->tipo == "servicio"){
            $producto = Servicio::where('estado_id',1)->get();
        }elseif ($diagnostico->tipo == "extra"){
            $producto = Servicio::where('estado_id',1)->get();
        }
        
        return view('admin.asesor.editdetalle', compact('producto', 'diagnostico'));
    }

    public function updatedetalle(Request $request, Diagnostico $diagnostico)
    {
        event(new ActualizacionBitacora($diagnostico->id, Auth::user()->id,'Edición del detalle del diagnostico',$diagnostico,'','diagnostico'));


        $diagnostico->update($request->all());

        $total = Diagnostico::select(
            DB::raw('SUM(subtotal) as total')
        )->Where(
            "ordenequipo_id",
            "=",
            $diagnostico->ordenequipo_id
        )->get();

        $ordenequipo = OrdenEquipo::Where("id","=",$diagnostico->ordenequipo_id)->get();
        $ordenequipo[0]->total_cobrar = $total[0]->total;
        $ordenequipo[0]->save();
      
        return redirect()->route('asesor.new', $diagnostico->ordenequipo_id)->with('flash','El Detalle ha sido actualizada!');
    }


    public function destroydetalle(Diagnostico $diagnostico, Request $request)
    {
        $diagnostico->delete();

        $total = Diagnostico::select(
            DB::raw('SUM(subtotal) as total')
        )->Where(
            "ordenequipo_id",
            "=",
            $diagnostico->ordenequipo_id
        )->get();

        $ordenequipo = OrdenEquipo::Where("id","=",$diagnostico->ordenequipo_id)->get();
        $ordenequipo[0]->total_cobrar = $total[0]->total;
        $ordenequipo[0]->save();

        event(new ActualizacionBitacora($diagnostico->id, Auth::user()->id, 'Eliminación', '', '', 'Diagnostico'));

        return redirect()->route('asesor.new', $diagnostico->ordenequipo_id)->with('flash','El Detalle ha sido eliminado!');
    }



    public function recibirorden2(OrdenEquipo $ordenequipo)
    {
        $ordenequipo->estado_orden_trabajo_id = 7;
        $ordenequipo->fecha_recibe_llamada_p67 = Carbon::now();
        $ordenequipo->user_recibe_llamada_p67 = Auth::user()->id;
        $ordenequipo->save();

        event(new ActualizacionBitacora($ordenequipo->id, Auth::user()->id,'Recepción de Orden desde Taller ', '', '', ' Orden de Taller'));

        return redirect()->route('asesor.index')->withFlash('La orden ha sido recibida desde taller exitosamente!');
    }


    public function enviataller2(OrdenEquipo $ordenequipo)
    {
        $ordenequipo->estado_orden_trabajo_id = 8;
        $ordenequipo->ubicacion_id = 2;
        $ordenequipo->fecha_envia_taller2_p78 = Carbon::now();
        $ordenequipo->user_envia_taller2_p78 = Auth::user()->id;
        $ordenequipo->save();

        event(new ActualizacionBitacora($ordenequipo->id, Auth::user()->id,'Recepción envia Orden a Taller para trabajar o sellar ', '', '', ' Orden de Equipo'));

        return redirect()->route('asesor.index')->withFlash('La orden ha sido enviada a taller exitosamente!');
    }




    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        
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
}
