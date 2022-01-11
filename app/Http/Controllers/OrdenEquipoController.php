<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Events\ActualizacionBitacora;
use Illuminate\Support\Facades\Response;
use DB;
use Carbon\Carbon;
use App\Garantia;
use App\OrdenEquipo;
use App\Cliente;
use App\Equipo;
use App\TipoTrabajo;
use App\Empleado;
use App\Bitacora;
use App\Taller;
use App\Diagnostico;
use App\UbicacionEquipo;
use App\User;
use App\CuentaPorCobrarMaestro;
use App\CuentaPorCobrarDetalle;
use App\FormaPago;
use App\Pago;
use App\TipoEnvio;
use App\OrdenEquipoLlamada;
use Barryvdh\DomPDF\Facade as PDF;


class OrdenEquipoController extends Controller
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
        return view('admin.ordenequipo.index');
    }


    public function getJson()
    {
        $query = "SELECT oe.id AS id, oe.fecha_orden, oe.has_guarantee, oe.no_orden_trabajo, oe.no_comprobante, cl.nombre_comercial AS cliente, eq.equipo, ue.ubicacion, eot.estado_orden_trabajo AS estado, CONCAT(emp.nombres,' ',emp.apellidos) as asesor, tt.nombre as tipo_trabajo
        FROM ordenequipo oe
        INNER JOIN clientes cl ON oe.cliente_id=cl.id
        INNER JOIN equipos eq ON oe.equipo_id=eq.id
        INNER JOIN ubicaciones_equipo ue ON oe.ubicacion_id=ue.id
        INNER JOIN empleados emp ON cl.empleado_id = emp.id
        INNER JOIN estado_ordenes_trabajo eot ON oe.estado_orden_trabajo_id = eot.id
        INNER JOIN tipo_trabajos tt ON oe.tipo_trabajo_id = tt.id
        WHERE oe.estado_id = 1";
        $api_result['data'] = DB::select($query);

        return response()->json($api_result);
    }


    public function OTDisponible()
    {
        $dato = Input::get("no_orden_trabajo");
        $query = OrdenEquipo::where("no_orden_trabajo",$dato)
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

    public function ComprobanteDisponible()
    {
        $dato = Input::get("no_comprobante");
        $query = OrdenEquipo::where("no_comprobante",$dato)
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

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $cliente = Cliente::all();
        $equipo = Equipo::all();
        $tipo_trabajo = TipoTrabajo::all();
        return view("admin.ordenequipo.create", compact('cliente', 'equipo', 'tipo_trabajo'));
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


        for ($i=6; $i < sizeof($arr) ; $i++) {
            $ordenequipo = OrdenEquipo::create([
                'fecha_orden'               => date("Y/m/d"),
                'no_orden_trabajo'          => 0,
                'no_comprobante'            => $arr[1]["value"]."-".($i-5),
                'has_guarantee'             => 0,
                'cliente_id'                => $arr[2]["value"],
                'equipo_id'                 => $arr[$i]["equipo_id"],
                'tipo_trabajo_id'           => $arr[$i]["tipo_trabajo_id"],
                'ubicacion_id'              => 1,
                'estado_id'                 => 1,
                'estado_orden_trabajo_id'   => 1,
                'total_cobrar'              => 0,
                'user_id'                   => Auth::user()->id,
                'observaciones'             => $arr[1]["value"],
            ]);
        }

        event(new ActualizacionBitacora($ordenequipo->id, Auth::user()->id, 'Creación', '', $ordenequipo, 'orden de equipo'));

        return Response::json(['success' => 'Éxito']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    //PASO NUMERO 1 CREACION
        $orden = OrdenEquipo::where('id', $id)->get();
        
        //No, Orden, No comprobante, equipo, cliente, tipo de trabajo, observaciones, usuario que creó la orden. y Fecha  y hora de creación
        //Buscar en la bitacora quien envío

    //PASO NUMERO 2 ENVIO AL TALLER

        

        if (!empty($orden[0]->user_envia_ataller_p12)){
            $enviado = User::where("id","=",$orden[0]->user_envia_ataller_p12)->get();
        }else{
            $enviado = null;
        }

        //Buscar en la bitacora quien recibió
        

        if (!empty($orden[0]->user_recibe_taller_p23)){
            $recibido = User::where("id","=",$orden[0]->user_recibe_taller_p23)->get();
        }else{
            $recibido = null;
        }

    //PASO NUMERO 3 GENERACIÓN DIAGNOSTICO
                //Mostrar una tabla con los detalles del diagnóstico
                //Nombre, cantidad, subtotal
                //Mostrar la sumatoria del diagnóstico
                //Usuario que realizó el diagnóstico
                //Fecha y hora del diagnóstico

        $detalles = Diagnostico::where('ordenequipo_id', $id)->get();
        $taller = Taller::where('ordenequipo_id', $id)->get();
        $llamadas = OrdenEquipoLlamada::where('ordenequipo_id', $id)->get();

        if (!empty($llamadas[0])){
            $usuarioLlamadas = User::where("id","=",$llamadas[0]->user_id)->get();
        }else{
            $usuarioLlamadas = null;
        }

        if (!empty($taller[0]->user_reparacion_id)){
            $usuarioDiagnostico = User::where("id","=",$taller[0]->user_reparacion_id)->get();
        }else{
            $usuarioDiagnostico = null;
        }

        if (!empty($orden[0]->user_envia_asesor_p34)){
            $usuarioEnviaAsesor = User::where("id","=",$orden[0]->user_envia_asesor_p34)->get();
        }else{
            $usuarioEnviaAsesor = null;
        }
        

        //PASO NUMERO 4 RECEPCION DE ORDEN DE TALLER

        if (!empty($orden[0]->user_recibe_asesor_p45)){
            $usuarioReceptorAsesor = User::where("id","=",$orden[0]->user_recibe_asesor_p45)->get();
        }else{
            $usuarioReceptorAsesor = null;
        }


        //
        //PASO NUMERO 5 Introducir Pago y Registro de Llamada Telefónica

        if (!empty($orden[0]->user_envia_llamada_p56)){
            $usuarioEnviaLlamadas = User::where("id","=",$orden[0]->user_envia_llamada_p56)->get();
        }else{
            $usuarioEnviaLlamadas = null;
        }

        if (!empty($orden[0]->user_recibe_llamada_p67)){
            $usuarioRecibeLlamadas = User::where("id","=",$orden[0]->user_recibe_llamada_p67)->get();
        }else{
            $usuarioRecibeLlamadas = null;
        }

        if (!empty($orden[0]->user_envia_taller2_p78)){
            $usuarioEnviaTaller2 = User::where("id","=",$orden[0]->user_envia_taller2_p78)->get();
        }else{
            $usuarioEnviaTaller2 = null;
        }

        if (!empty($orden[0]->user_envia_taller2_p78)){
            $usuarioEnviaTaller2 = User::where("id","=",$orden[0]->user_envia_taller2_p78)->get();
        }else{
            $usuarioEnviaTaller2 = null;
        }

        if (!empty($orden[0]->user_recibe_taller2_p89)){
            $usuarioRecibeTaller2 = User::where("id","=",$orden[0]->user_recibe_taller2_p89)->get();
        }else{
            $usuarioRecibeTaller2 = null;
        }

        if (!empty($orden[0]->user_envia_recepcion3_p910)){
            $usuarioEnviaRecepcion2 = User::where("id","=",$orden[0]->user_envia_recepcion3_p910)->get();
        }else{
            $usuarioEnviaRecepcion2 = null;
        }

        if (!empty($orden[0]->user_recibe_recepcion3_p1011)){
            $ordenFinalUsuario = User::where("id","=",$orden[0]->user_recibe_recepcion3_p1011)->get();
        }else{
            $ordenFinalUsuario = null;
        }

        $tipo = TipoEnvio::where('ordenequipo_id', $id)->get();
        $pago = Pago::where('ordenequipo_id', $id)->get();

        
        event(new ActualizacionBitacora($orden[0]->id, Auth::user()->id,'Orden entregada al cliente ', '', '', ' Orden de Recepción'));


        return view('admin.ordenequipo.show', compact('orden', 'enviado', 'recibido', 'detalles', 'usuarioEnviaAsesor', 'usuarioReceptorAsesor', 'taller', 'usuarioDiagnostico', 'usuarioEnviaLlamadas', 'usuarioRecibeLlamadas', 'usuarioEnviaTaller2', 'usuarioRecibeTaller2', 'llamadas', 'usuarioLlamadas', 'ordenFinalUsuario', 'usuarioEnviaRecepcion2', 'tipo', 'pago' ));
    }


    // Envío de recepción a taller - traslado a estado 2
    public function ttaller(OrdenEquipo $ordenequipo)
    {
        $ordenequipo->ubicacion_id = 2;
        $ordenequipo->estado_orden_trabajo_id = 2;
        $ordenequipo->fecha_envia_ataller_p12 = Carbon::now();
        $ordenequipo->user_envia_ataller_p12 = Auth::user()->id;
        $ordenequipo->save();

        $tt["ordenequipo_id"] = $ordenequipo->id;
        $taller = Taller::create($tt);
        

        event(new ActualizacionBitacora($ordenequipo->id, Auth::user()->id,'Traslado a Taller ', '', '', ' Orden de Taller'));

        return redirect()->route('ordenequipo.index')->withFlash('La orden ha sido enviada a taller exitosamente!');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(OrdenEquipo $ordenequipo)
    {
        $cliente = Cliente::all();
        $equipo = Equipo::all();
        $tipo_trabajo = TipoTrabajo::all();
        return view("admin.ordenequipo.edit", compact('ordenequipo','cliente', 'equipo', 'tipo_trabajo'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(OrdenEquipo $ordenequipo, Request $request)
    {

        $nuevos_datos = array(
            'equipo_id' => $request->equipo_id,
            'cliente_id' => $request->cliente_id,
            'tipo_trabajo_id' => $request->tipo_trabajo_id,
            'observaciones' => $request->observaciones,
            );
        $json = json_encode($nuevos_datos);

        event(new ActualizacionBitacora($ordenequipo->id, Auth::user()->id,'Edición',$ordenequipo, $json,' orden de trabajo'));

        $ordenequipo->update($request->all());

        return redirect()->route('ordenequipo.index', $ordenequipo)->with('flash','La orden de trabajo ha sido actualizada!');
    }



    public function recibirorden2(OrdenEquipo $ordenequipo)
    {
        $ordenequipo->estado_orden_trabajo_id = 7;
        $ordenequipo->fecha_recibe_llamada_p67 = Carbon::now();
        $ordenequipo->user_recibe_llamada_p67 = Auth::user()->id;
        $ordenequipo->save();

        event(new ActualizacionBitacora($ordenequipo->id, Auth::user()->id,'Recepción de Orden desde Taller ', '', '', ' Orden de Taller'));

        return redirect()->route('ordenequipo.index')->withFlash('La orden ha sido recibida desde taller exitosamente!');
    }


    public function recibirorden3(OrdenEquipo $ordenequipo)
    {
        $ordenequipo->estado_orden_trabajo_id = 12;
        $ordenequipo->fecha_recibe_recepcion3_p1011 = Carbon::now();
        $ordenequipo->user_recibe_recepcion3_p1011 = Auth::user()->id;
        $ordenequipo->save();

        event(new ActualizacionBitacora($ordenequipo->id, Auth::user()->id,'Recepción de Orden desde Taller Finalizada ', '', '', ' Orden de Taller'));

        return redirect()->route('ordenequipo.index')->withFlash('La orden ha sido recibida desde taller exitosamente!');
    }

    public function enviataller2(OrdenEquipo $ordenequipo)
    {
        $ordenequipo->estado_orden_trabajo_id = 8;
        $ordenequipo->ubicacion_id = 2;
        $ordenequipo->fecha_envia_taller2_p78 = Carbon::now();
        $ordenequipo->user_envia_taller2_p78 = Auth::user()->id;
        $ordenequipo->save();

        event(new ActualizacionBitacora($ordenequipo->id, Auth::user()->id,'Recepción envia Orden a Taller para trabajar o sellar ', '', '', ' Orden de Equipo'));

        return redirect()->route('ordenequipo.index')->withFlash('La orden ha sido enviada a taller exitosamente!');
    }

    public function recibirorden4(OrdenEquipo $ordenequipo, Request $request)
    {
        $arr = json_decode($request->getContent(), true);
        if ($arr[3]["value"] === "") {
          $contador = 7;
        }else {
          $contador = 8;
        }

        for ($i=$contador; $i < sizeof($arr) ; $i++){


            $id = Pago::create([
            'documento' => $arr[$i]["documento"],
            'cantidad' => $arr[$i]["cantidad"],
            'tipo_pago' =>$arr[$i]["pago"],
            'ordenequipo_id' => $ordenequipo->id,
            ]);
            if($arr[2]["value"] == '1') {
                $tipo  = 'Recoge Cliente';
            } else {
                 $tipo  = $arr[2]["value"];
            }

        if($arr[$i]["pago"] == '5') {
                //Agregar cuenta por Cobrar a Orden Equipo.
            //Se obtienen la cuenta por cobrar segun el cliente
            $cuenta = CuentaPorCobrarMaestro::where([['estado_id', '1'],['cliente_id', $ordenequipo->cliente_id]])->get();

            //Intero cada cuenta para obtener el cliente
                //Si encuentra una relacion entre el id de cuenta Cobrar y el de OrdenEquipo
                if(!empty($cuenta[0])) {
                    //Solo crear un nuevo cargo. Registro Detalle Cuentas Por Cobrar
                    //Falta comprobar el total
                    //Obtengo el ultimo saldo del ultimo registro detalle
                    $last = CuentaPorCobrarDetalle::latest()->where([['estado_id', 1],['cuenta_cobrar_maestro_id', $cuenta[0]->id]])->first();

                    $cuentaDetalle = CuentaPorCobrarDetalle::create([
                        'cuenta_cobrar_maestro_id' => $cuenta[0]->id,
                        'tipo_transaccion_id' => 1,
                        'fecha_transaccion' => $ordenequipo->fecha_orden,
                        'credito_id' => $ordenequipo->id,
                        'total' => $arr[$i]["cantidad"],
                        'saldo' => $last['saldo'] + $arr[$i]["cantidad"],
                        'user_id' => Auth::user()->id,
                    ]);
                } else {

                    //Sino, creara tabla maestro y cargo, detalle.
                     $cuentaMaestro = CuentaPorCobrarMaestro::create([
                        'cliente_id' => $ordenequipo->cliente_id,
                        'user_id' => Auth::user()->id,
                        'total' =>  $arr[$i]["cantidad"]
                    ]);
                    //Agregar tabla Cuenta Por Cobrar Maestro a Bitácora
                    event(new ActualizacionBitacora($cuentaMaestro->id, Auth::user()->id, 'Creación', '', $cuentaMaestro,'CuentaPorCobrarMaestro'));

                    //Detalle cargo
                    $cuentaDetalle = CuentaPorCobrarDetalle::create([
                        'cuenta_cobrar_maestro_id' => $cuentaMaestro->id,
                        'tipo_transaccion_id' => 1,
                        'fecha_transaccion' => $ordenequipo->fecha_orden,
                        'credito_id' => $ordenequipo->id,
                        'total' => $arr[$i]["cantidad"],
                        'saldo' => $arr[$i]["cantidad"],
                        'user_id' => Auth::user()->id,
                    ]);
                    $cuentaMaestro->total = $arr[$i]["cantidad"];

                }
                //Agregar tabla Cuenta Por Cobrar Detalle a Bitácora
                    event(new ActualizacionBitacora($cuentaDetalle->id, Auth::user()->id, 'Creación', '', $cuentaDetalle,'CuentaPorCobrarDetalle'));

            }

        }


            /*    if (sizeof($arr) < 8) {
                  $persona = null;
                  }else {

                    $persona = $arr[2]["value"];

                  }*/
                    $persona = $arr[3]["value"];
        $id1 = TipoEnvio::create([
          'persona_recibe' => $persona,
          'tipo_envio'  => $tipo,
          'ordenequipo_id' => $ordenequipo->id,

        ]);

        $ordenequipo->estado_orden_trabajo_id = 13;
        $ordenequipo->save();
        event(new ActualizacionBitacora($ordenequipo->id, Auth::user()->id,'Orden entregada al cliente ', '', '', ' Orden de Recepción'));

            return Response::json(['success' => 'Éxito']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $ordenequipo = OrdenEquipo::where('id',$request->id)->first();
        $ordenequipo->estado_id = 2;
        $ordenequipo->save();

        event(new ActualizacionBitacora($ordenequipo->id, Auth::user()->id,'Eliminación ', '', '', ' Orden de Taller'));

        return response()->json(['success'=>'Éxito']);
    }

    public function create2(OrdenEquipo $ordenequipo)
    {

        $equipo = Equipo::where('id',$ordenequipo->equipo_id)->get()->first();
        $cliente = Cliente::where('id',$ordenequipo->cliente_id)->get()->first();
        $taller = Taller::where('ordenequipo_id',$ordenequipo->id)->get()->first();
        $usuario = User::where('id',$taller->user_reparacion_id)->get()->first();
        
        return view("admin.ordenequipo.create2", compact('ordenequipo','equipo','cliente','taller','usuario'));
    }

    public function create3(OrdenEquipo $ordenequipo)
    {

        $equipo = Equipo::where('id',$ordenequipo->equipo_id)->get()->first();
        $cliente = Cliente::where('id',$ordenequipo->cliente_id)->get()->first();
        $taller = Taller::where('ordenequipo_id',$ordenequipo->id)->get()->first();
        $usuario = User::where('id',$taller->user_diagnostico_id)->get()->first();
        $pago = FormaPago::all();

        return view("admin.ordenequipo.create3", compact('ordenequipo','equipo','cliente','taller','usuario','pago'));
    }

    public function store2(OrdenEquipo $ordenequipo, Request $request)
    {
              $arr = json_decode($request->getContent(), true);

        if ($arr[3]["value"] != "") {

          for ($i=5; $i < sizeof($arr) ; $i++){
            $id = OrdenEquipoLlamada::create([
              'fecha' => $arr[$i]["fecha"],
              'hora' => $arr[$i]["hora"],
              'descripcion' => $arr[$i]["descripcion"],
              'user_id' => Auth::user()->id,
              'ordenequipo_id' =>$ordenequipo->id,
            ]);
          }


          $taller = Taller::where("ordenequipo_id",$ordenequipo->id)->get()->first();
          $taller->fecha_autoriza_rechaza = date("Y/m/d h:m:s");
          $taller->autoriza_rechaza = $request->autorizado_id;
          $taller->user_llamada_id = Auth::user()->id;
          $taller->detalle_llamada = $request->detalle_llamada;
          $taller->save();

          event(new ActualizacionBitacora($ordenequipo->id, Auth::user()->id,'Envío de Orden de Recepción a Taller, registro de llamada y total de cobro ', '', '', 'Orden Taller'));

          return Response::json(['success' => 'Éxito']);
        }else {
          for ($i=5; $i < sizeof($arr) ; $i++){
            $id = OrdenEquipoLlamada::create([
              'fecha' => $arr[$i]["fecha"],
              'hora' => $arr[$i]["hora"],
              'descripcion' => $arr[$i]["descripcion"],
              'user_id' => Auth::user()->id,
              'ordenequipo_id' =>$ordenequipo->id,
            ]);
          }
        return Response::json(['success' => 'Éxito']);
        }

    }

    public function pdf($id) {


        $equipo = DB::table('ordenequipo')
                ->join('clientes', 'ordenequipo.cliente_id', '=' , 'clientes.id')
                ->where('ordenequipo.id', '=',  $id)
                ->select('ordenequipo.no_orden_trabajo as orden', 'clientes.nombre_comercial as cliente')
                ->get();

        $detalle =  DB::table('diagnosticos')
                  ->join('ordenequipo', 'diagnosticos.ordenequipo_id', '=', 'ordenequipo.id')
                  ->where('ordenequipo.id', '=', $id)
                  ->select('diagnosticos.id', 'diagnosticos.codigo', 'diagnosticos.precio', 'diagnosticos.cantidad', 'diagnosticos.subtotal', 'diagnosticos.tipo', 'diagnosticos.nombre')
                  ->get();
        $total =      DB::table('ordenequipo')
                  ->where('ordenequipo.id', '=', $id)
                  ->select('ordenequipo.total_cobrar as total')
                  ->get();

        $empleado =     DB::table('ordenequipo')
        ->select('empleados.nombres as nombre', 'empleados.apellidos as apellido', 'puestos.nombre as puesto', 'tipo_envios.persona_recibe as persona')
                      ->join('clientes', 'ordenequipo.cliente_id', '=', 'clientes.id')
                      ->join('empleados', 'clientes.empleado_id', '=', 'empleados.id')
                      ->join('puestos', 'puestos.id', '=', 'empleados.puesto_id')
                      ->join('tipo_envios', 'tipo_envios.ordenequipo_id', '=', 'ordenequipo.id')
                      ->where('ordenequipo.id', '=', $id)
                      ->get();

        $pdf = \PDF::loadView('admin.ordenequipo.pdf', compact('equipo', 'detalle', 'empleado', 'total'));
        return $pdf->download('cobro.pdf');

    }

    public function envioPDF($id) {
        $envio  = RegistroEnvioEquipo::where('id', $id)->get();
        $envio[0]->ordenEquipo;
        $envio[0]->empleado;
        //, ['cheque' => $cheque, 'letras' => $texto, 'voucher' => $voucher, 'mes' => $monthName, 'cuenta' => $cuenta, 'empleado' => $empleado]
        $pdf = \PDF::loadView('admin.registroEnvios.envioPDF', ['envio' => $envio]);
        return $pdf->download('envio' . "00" . $envio[0]->no_envio ."-" . $envio[0]->anio . '.pdf');

    }

    public function getLlamadasJson($id){
      $detalles = OrdenEquipoLlamada::where('ordenequipo_id', $id)->get();
      $detalles->created_at = date("Y/m/d h:m:s");
      $api_result['data'] = $detalles;
      return response()->json($api_result);
    }

    //metodo para guardar los datos de garantia
    public function garantia(Request $request) {

        $data = $request->all();
        $fecha = Carbon::parse($_POST["fecha"]);
        $ordenequipo = OrdenEquipo::where('id', $data["ordenid"])->first();
        $year = Carbon::today()->year;
        
        //
        //Condicionar que numero corresponde
        $today = Carbon::today()->format('Y-m-d');

        $last = DB::table('garantias')->latest('created_at')->first();
        if(isset($last)) {
                
            $newYear = $last->anio . '-01-01';
            
            if($today == $newYear && $last->anio != $year) {
                //Si hoy es anio nuevo y el ultimo registro es del anio pasado
                $garantia = Garantia::create([
                    "no_garantia" => 1,
                    "anio" => $year,
                    "fecha" => $fecha,
                    "estado_id" => 1,
                    "cliente_id" => $ordenequipo->cliente_id,
                    "orden_equipo_id" => $ordenequipo->id
                ]);

                

            } else if($today == $newYear && $last->anio == $year) {
                //Aun es 1 de enero pero ya hay registros del anio nuevo
                $garantia = Garantia::create([
                    "no_garantia" => $last->no_garantia + 1,
                    "anio" => $year,
                    "fecha" => $fecha,
                    "estado_id" => 1,
                    "cliente_id" => $ordenequipo->cliente_id,
                    "orden_equipo_id" => $ordenequipo->id
                ]);
            } else {
                //Cualquier otro dia del anio
                $garantia = Garantia::create([
                    "no_garantia" => $last->no_garantia + 1,
                    "anio" => $year,
                    "fecha" => $fecha,
                    "estado_id" => 1,
                    "cliente_id" => $ordenequipo->cliente_id,
                    "orden_equipo_id" => $ordenequipo->id
                ]);
            }
        } else {
            //Es el primer registro
                $garantia = Garantia::create([
                    "no_garantia" => 1,
                    "anio" => $year,
                    "fecha" => $fecha,
                    "estado_id" => 1,
                    "cliente_id" => $ordenequipo->cliente_id,
                    "orden_equipo_id" => $ordenequipo->id
                ]);
        }
        
        if($garantia!= null) {
                    $ordenequipo->has_guarantee = 1;
                    $ordenequipo->save();
        }
        //
       
        event(new ActualizacionBitacora($garantia->id, Auth::user()->id, 'Creación', '', $garantia, 'garantia'));
        return redirect()->route('ordenequipo.index')->withFlash('La garantía ha sido creada exitosamente!');

    }

    public function getpdfguarantee($ordenid) {
        $garantia  = Garantia::where('orden_equipo_id', $ordenid)->get();
        $garantia[0]->cliente;
        $orden = OrdenEquipo::where('id', $ordenid)->get();
        $orden[0]->equipo;
        $pdf = \PDF::loadView('admin.ordenequipo.garantiaPDF', ['garantia' => $garantia, 'orden' => $orden]);
        return $pdf->download('garantia-' . "00" . $garantia[0]->no_garantia ."-" . $garantia[0]->anio . '.pdf');

    }


}

