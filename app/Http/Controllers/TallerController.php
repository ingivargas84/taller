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

class TallerController extends Controller
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
        return view('admin.taller.index');
    }


    public function getJson()
    {
        $query = "SELECT oe.id AS id, oe.fecha_orden, oe.no_orden_trabajo, oe.no_comprobante, cl.nombre_comercial AS cliente, eq.equipo, ue.ubicacion, eot.estado_orden_trabajo AS estado
        FROM ordenequipo oe
        INNER JOIN clientes cl ON oe.cliente_id=cl.id
        INNER JOIN equipos eq ON oe.equipo_id=eq.id
        INNER JOIN ubicaciones_equipo ue ON oe.ubicacion_id=ue.id
        INNER JOIN estado_ordenes_trabajo eot ON oe.estado_orden_trabajo_id = eot.id
        WHERE oe.ubicacion_id = 2 AND oe.estado_orden_trabajo_id in (2,3,8,9)";
        
        $api_result['data'] = DB::select($query);

        return response()->json($api_result);
    }

    public function recibirorden(OrdenEquipo $ordenequipo)
    {
        $ordenequipo->estado_orden_trabajo_id = 3;
        $ordenequipo->fecha_recibe_taller_p23 = Carbon::now();
        $ordenequipo->user_recibe_taller_p23 = Auth::user()->id;
        $ordenequipo->save();

        event(new ActualizacionBitacora($ordenequipo->id, Auth::user()->id,'Recepción de Orden de Taller ', '', '', ' Orden de Taller'));

        return redirect()->route('taller.index')->withFlash('La orden ha sido recibida desde recepción exitosamente!');
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

        return view("admin.taller.create", compact('ordenequipo','equipo','cliente','taller','producto','servicio'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create1(OrdenEquipo $ordenequipo)
    {
        $equipo = Equipo::where('id',$ordenequipo->equipo_id)->get()->first();
        $cliente = Cliente::where('id',$ordenequipo->cliente_id)->get()->first();
        $taller = Taller::where('ordenequipo_id',$ordenequipo->id)->get()->first();
        $usuario = User::where('id',$taller->user_diagnostico_id)->get()->first();
        $usuario_llamada = User::where('id',$taller->user_llamada_id)->get()->first();
        $tipo_trabajo = TipoTrabajo::where('id',$ordenequipo->tipo_trabajo_id)->get()->first();


        return view("admin.taller.create2", compact('ordenequipo','equipo','cliente','taller', 'usuario','usuario_llamada', 'tipo_trabajo'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Taller $taller, Request $request)
    {
        $taller->fecha_diagnostico = date("Y/m/d h:m:s");
        $taller->user_diagnostico_id = Auth::user()->id;
        $taller->dias_reparacion = $request->dias_reparacion;
        $taller->save();

        $ordenequipo = OrdenEquipo::where("id",$taller->ordenequipo_id)->get()->first();
        $ordenequipo->total_cobrar = $request->total;
        $ordenequipo->save();

        event(new ActualizacionBitacora($ordenequipo->id, Auth::user()->id,'Revisión del Asesor finalizada ', '', '', 'Asesor'));

        return redirect()->route('asesor.index')->withFlash('La orden ha sido revisada por el asesor!');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store1(Taller $taller, Request $request)
    {
        $arr = json_decode($request->getContent(), true);
        
        $total = $arr[20]["value"];

        $taller->fecha_diagnostico = date("Y/m/d h:m:s");
        $taller->detalle_diagnostico = $request->detalle_diagnostico;
        $taller->user_diagnostico_id = Auth::user()->id;
        $taller->save();
        $ordenequipo = OrdenEquipo::where("id",$taller->ordenequipo_id)->get()->first();
        //$ordenequipo->estado_orden_trabajo_id = 4;
        //$ordenequipo->ubicacion_id = 1;
        if($total > 0){
          $ordenequipo->total_cobrar = $total;
        }else {
          $ordenequipo->total_cobrar = 0;
        }
        //$ordenequipo->total_cobrar = $total;
        $ordenequipo->save();





        if (json_decode($request->getContent(), true) ) {

            for ($i=21; $i < sizeof($arr) ; $i++){
              if ($arr[$i]["id"] != ""  ) {
              $id = Diagnostico::create([
                'codigo' => $arr[$i]["id"],
                'nombre' => $arr[$i]["nombre"],
                'tipo' => $arr[$i]["tipo"],
                'cantidad' =>$arr[$i]["cantidad"],
                'precio' => $arr[$i]["precio"],
                'subtotal' => $arr[$i]["subtotal"],
                'ordenequipo_id' =>   $ordenequipo->id,
              ]);
            }else {
              if ($arr[$i]["Eliminar"] != null) {
                $id = $arr[$i]["Eliminar"];
                $detalle = Diagnostico::find($id);
                $detalle->delete();
            }
          }
        }
        }





      event(new ActualizacionBitacora($ordenequipo->id, Auth::user()->id,'Envío de Orden de Taller a Recepcion ', '', '', 'Taller'));

      //  return view('admin.taller.index');
      return Response::json(['success' => 'Éxito']);
    }


    public function recibirorden3(OrdenEquipo $ordenequipo)
    {
        $ordenequipo->estado_orden_trabajo_id = 9;
        $ordenequipo->fecha_recibe_taller2_p89 = Carbon::now();
        $ordenequipo->user_recibe_taller2_p89 = Auth::user()->id;
        $ordenequipo->save();

        event(new ActualizacionBitacora($ordenequipo->id, Auth::user()->id,'Recepción de Orden en Taller para registrar reparación o cierre ', '', '', 'Taller'));

        return redirect()->route('taller.index')->withFlash('La orden ha sido recibida en taller exitosamente!');
    }



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function create3(OrdenEquipo $ordenequipo)
    {
        $equipo = Equipo::where('id',$ordenequipo->equipo_id)->get()->first();
        $cliente = Cliente::where('id',$ordenequipo->cliente_id)->get()->first();
        $taller = Taller::where('ordenequipo_id',$ordenequipo->id)->get()->first();
        $producto = Producto::where('estado_id',1)->get();
        $servicio = Servicio::where('estado_id',1)->get();
        $tipo_trabajo = TipoTrabajo::where('id',$ordenequipo->tipo_trabajo_id)->get()->first();

        return view("admin.taller.create2", compact('ordenequipo','equipo','cliente','taller','producto','servicio','tipo_trabajo'));
    }


    public function store3(Request $request)
    {

      $arr = json_decode($request->getContent(), true);
      
      $total = 0;

        $taller = Taller::where("ordenequipo_id",$arr[1]["value"])->get()->first();
        $taller->fecha_reparacion = date("Y/m/d h:m:s");
        $taller->dias_reparacion = $arr[2]["value"];
        $taller->trabajos_realizados = $arr[3]["value"];
        $taller->observaciones = $arr[4]["value"];
        $taller->user_reparacion_id = Auth::user()->id;
        $taller->save();        

        for ($i=15; $i < sizeof($arr) ; $i++){

          $diagnostico = Diagnostico::Where("codigo",$arr[$i]["servicio_id"])->Where("subtotal",$arr[$i]["subtotal"])->Where("tipo",$arr[$i]["tipo"])->Where("nombre",$arr[$i]["servicio"])->Where("ordenequipo_id",$arr[1]["value"])->get();

          if (count($diagnostico) == 0) 
          {
            $id = Diagnostico::create([
              'codigo' => $arr[$i]["servicio_id"],
              'nombre' => $arr[$i]["servicio"],
              'tipo' => $arr[$i]["tipo"],
              'cantidad' =>$arr[$i]["cantidad"],
              'precio' => $arr[$i]["precio_unitario"],
              'subtotal' => $arr[$i]["subtotal"],
              'ordenequipo_id' => $arr[1]["value"],
            ]);
  
          }
                    
          $total = $total + $arr[$i]["subtotal"];
        }

        $orden = OrdenEquipo::where("id",$arr[1]["value"])->get()->first();
        $orden->total_cobrar = $total;
        $orden->save();

        event(new ActualizacionBitacora($arr[1]["value"], Auth::user()->id,'Registro de Diagnóstico de Taller ', '', '', 'Taller'));

        return Response::json(['success' => 'Éxito']);
    }


    public function create5(OrdenEquipo $ordenequipo)
    {
      $equipo = Equipo::where('id',$ordenequipo->equipo_id)->get()->first();
      $cliente = Cliente::where('id',$ordenequipo->cliente_id)->get()->first();
      $taller = Taller::where('ordenequipo_id',$ordenequipo->id)->get()->first();
      $usuario = User::where('id',$taller->user_diagnostico_id)->get()->first();
      $usuario_llamada = User::where('id',$taller->user_llamada_id)->get()->first();

      return view("admin.taller.create5", compact('ordenequipo','equipo','cliente','taller', 'usuario','usuario_llamada'));
        
    }


    public function store5(OrdenEquipo $ordenequipo, Request $request)
    {
        $taller = Taller::where("ordenequipo_id",$ordenequipo->id)->get()->first();
        $taller->fecha_diagnostico = date("Y/m/d h:m:s");
        $taller->detalle_diagnostico = $request->detalle_diagnostico;
        $taller->user_diagnostico_id = Auth::user()->id;
        $taller->save();

        event(new ActualizacionBitacora($taller->id, Auth::user()->id,'Registro de Trabajos en Taller, luego de reparar ', '', '', 'Taller'));

        return view('admin.taller.index');
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
    public function edit()
    {

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

    public function getdiagnostico($id)
    {
        $api_result = Diagnostico::Select(
            'diagnosticos.id',
            'diagnosticos.codigo',
            'diagnosticos.nombre',
            'diagnosticos.cantidad',
            'diagnosticos.precio',
            'diagnosticos.subtotal',
            'diagnosticos.tipo'            
        )->Where(
            'diagnosticos.ordenequipo_id',
            '=',
            $id
        )->get();  

        return Response::json($api_result);
    }


    public function getServicioData($id){
        $api_result = Servicio::select(
            'servicios.*'
        )->where(
            'servicios.id',
            '=',
            $id
        )->get();

        return Response::json($api_result);
    }



    public function getProductoData($id){
        $api_result = Producto::select(
            'productos.*'
        )->where(
            'productos.id',
            '=',
            $id
        )->get();

        return Response::json($api_result);
    }

    public function getProductoData1($id){
        $api_result = Producto::select(
            'productos.*'
        )->where(
            'productos.nombre',
            '=',
            $id
        )->get();

        return Response::json($api_result);
    }



    public function getEditarJson($id){
      $detalles = Diagnostico::where('ordenequipo_id', $id)->get();
      $api_result['data'] = $detalles;
      return response()->json($api_result);
    }

    

    //envio de taller hacia el asesor

    public function Envio1(OrdenEquipo $ordenequipo){
      $ordenequipo->estado_orden_trabajo_id = 4;
      $ordenequipo->ubicacion_id = 2;
      $ordenequipo->fecha_envia_asesor_p34 = Carbon::now();
      $ordenequipo->user_envia_asesor_p34 = Auth::user()->id;
      $ordenequipo->save();

      return view('admin.taller.index')->withFlash('La orden de trabajo, fue trasladada a su asesor');
    
    }


    public function irreparable(OrdenEquipo $ordenequipo){
        $ordenequipo->estado_orden_trabajo_id = 14;
        $ordenequipo->ubicacion_id = 1;
        $ordenequipo->save();
  
        return view('admin.taller.index')->withFlash('La orden de trabajo, fue declarada irreparable');
      
      }


    public function enviorecepcion3(OrdenEquipo $ordenequipo)
    {
        $ordenequipo->estado_orden_trabajo_id = 10;
        $ordenequipo->ubicacion_id = 1;
        $ordenequipo->fecha_envia_recepcion3_p910 = Carbon::now();
        $ordenequipo->user_envia_recepcion3_p910 = Auth::user()->id;
        $ordenequipo->save();

        event(new ActualizacionBitacora($ordenequipo->id, Auth::user()->id,'Envio de Orden a Recepción para entrega y cobro ', '', '', ' Orden de Equipo'));

        return redirect()->route('taller.index')->withFlash('La orden ha sido enviada a recepción exitosamente!');
    }
}
