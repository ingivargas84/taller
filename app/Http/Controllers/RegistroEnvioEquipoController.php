<?php

namespace App\Http\Controllers;

use App\RegistroEnvioEquipo;
use Illuminate\Http\Request;
use App\Empleado;
use App\OrdenEquipo;
use App\EstadoEnvio;
use App\Events\ActualizacionBitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;


class RegistroEnvioEquipoController extends Controller
{

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
        return view('admin.registroEnvios.index');
    }
    //Obtiene todos los registros
    public function getJson() {

        // $api_result['data'] = RegistroEnvioEquipo::all();
        // foreach($api_result['data'] as $r) {
        //     $ordenes = $r->ordenEquipo;
        //     // foreach($ordenes as $o) {
        //     //     $o->equipo;
        //     // }
        //     $r->empleado;
        //     $r->estadoEnvio;

        // }

        $query = "SELECT re.id AS id, re.no_envio, re.anio, oe.no_orden_trabajo, e.equipo, em.nombres, em.apellidos,
                re.direccion, re.observaciones, re.receptor, re.fecha_recepcion, estado.estado, estado.id as estado_envio_id
        FROM registro_envio_equipos re
        INNER JOIN empleados em ON re.empleado_id = em.id
        INNER JOIN estado_envios estado ON re.estado_envio_id = estado.id
        INNER JOIN ordenequipo oe ON re.orden_equipo_id = oe.id
        INNER JOIN equipos e ON oe.equipo_id =e.id";

        $api_result['data'] = DB::select($query);


        return response()->json($api_result);
    }

    //obtener una orden de equipo con su equipo
    public function getOrden($id) {
        $orden = OrdenEquipo::where('id', $id)->get();
        $orden[0]->equipo;
        return response()->json($orden);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $colaboradores = Empleado::where('estado_id', 1)->get();
        $equipos = OrdenEquipo::where('estado_orden_trabajo_id', 11)->get();
        return view('admin.registroEnvios.create', compact('colaboradores', 'equipos'));
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
        $data = $request->all();
        //Condicionar que numero corresponde
        $today = Carbon::today()->format('Y-m-d');
        $year = Carbon::today()->year;

        $last = DB::table('registro_envio_equipos')->latest('created_at')->first();
        if(isset($last)) {

                $newYear = $last->anio . '-01-01';

                if($today == $newYear && $last->anio != $year) {
                    //Si hoy es anio nuevo y el ultimo registro es del anio pasado
                    $envio = new RegistroEnvioEquipo;
                    $envio->receptor = $data['receptor'];
                    $envio->no_envio = 1;
                    $envio->anio = $year;
                    if($data['observaciones'] == null) {
                        $envio->observaciones = "No aplica";
                    } else {
                        $envio->observaciones = $data['observaciones'];
                    }                    $envio->direccion = $data['direccion'];
                    $envio->empleado_id = $data['empleado_genera_id'];
                    $envio->orden_equipo_id = $data['equipo_id'];
                    $envio->save();

                } else if($today == $newYear && $last->anio == $year) {
                    //Aun es 1 de enero pero ya hay registros del anio nuevo
                    $envio = new RegistroEnvioEquipo;
                    $envio->receptor = $data['receptor'];
                    $envio->no_envio = $last->no_envio + 1;
                    $envio->anio = $year;
                    if($data['observaciones'] == null) {
                        $envio->observaciones = "No aplica";
                    } else {
                        $envio->observaciones = $data['observaciones'];
                    }                    $envio->direccion = $data['direccion'];
                    $envio->empleado_id = $data['empleado_genera_id'];
                    $envio->orden_equipo_id = $data['equipo_id'];
                    $envio->save();
                } else {
                    //Cualquier otro dia del anio
                    $envio = new RegistroEnvioEquipo;
                    $envio->receptor = $data['receptor'];
                    $envio->no_envio = $last->no_envio + 1;
                    $envio->anio = $year;
                    if($data['observaciones'] == null) {
                        $envio->observaciones = "No aplica";
                    } else {
                        $envio->observaciones = $data['observaciones'];
                    }
                    $envio->direccion = $data['direccion'];
                    $envio->empleado_id = $data['empleado_genera_id'];
                    $envio->orden_equipo_id = $data['equipo_id'];
                    $envio->save();
                }
        } else {
                //Es el primer registro
                    $envio = new RegistroEnvioEquipo;
                    $envio->receptor = $data['receptor'];
                    $envio->no_envio = 1;
                    $envio->anio = $year;
                    if($data['observaciones'] == null) {
                        $envio->observaciones = "No aplica";
                    } else {
                        $envio->observaciones = $data['observaciones'];
                    }
                    $envio->direccion = $data['direccion'];
                    $envio->empleado_id = $data['empleado_genera_id'];
                    $envio->orden_equipo_id = $data['equipo_id'];
                    $envio->save();
            }

        //
        event(new ActualizacionBitacora($envio->id, Auth::user()->id, 'Creación', '', $envio, 'EnvioEquipo'));

        return redirect()->route('envios.index')->withFlash('¡El Envío ha sido registrado exitosamente!');
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RegistroEnvioEquipo  $registroEnvioEquipo
     * @return \Illuminate\Http\Response
     */
    public function show(RegistroEnvioEquipo $registroEnvioEquipo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RegistroEnvioEquipo  $registroEnvioEquipo
     * @return \Illuminate\Http\Response
     */
    public function edit(RegistroEnvioEquipo $envio)
    {
        $envio->ordenEquipo;
        $envio->empleado;
        $colaboradores = Empleado::where([['estado_id', 1],['id', '!=', $envio->empleado->id]])->get();
        $equipos = OrdenEquipo::where('id', '!=', $envio->ordenEquipo->id)->get();
        return view('admin.registroEnvios.edit', compact('envio', 'colaboradores', 'equipos'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RegistroEnvioEquipo  $registroEnvioEquipo
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RegistroEnvioEquipo $envio)
    {
        //
        $info_nueva = $request->all();
        $new = json_encode($info_nueva);
        event(new ActualizacionBitacora($envio->id, Auth::user()->id,'Edición',$envio, $new,'EnvioCheque'));
        $envio->receptor = $info_nueva['receptor_edit'];
        $envio->observaciones = $info_nueva['observaciones_edit'];
        $envio->direccion = $info_nueva['direccion_edit'];
        $envio->empleado_id = $info_nueva['empleado_id_edit'];
        $envio->orden_equipo_id = $info_nueva['equipo_id_edit'];
        $envio->save();
        return redirect()->route('envios.index', $envio)->withFlash('El envío ha sido actualizado correctamente');

        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RegistroEnvioEquipo  $registroEnvioEquipo
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $envio = RegistroEnvioEquipo::where('id', $request->id)->first();
        $envio->estado_envio_id = 6;
        $envio->save();
        event(new ActualizacionBitacora($envio->id, Auth::user()->id,'Estado anulado','','','Envio'));
        return response()->json(['success' => 'Éxito']);

    }

    //En camino
    public function enCamino($id) {
        $envio = RegistroEnvioEquipo::where('id', $id)->first();
        $envio->estado_envio_id = 2;
        $envio->save();
        event(new ActualizacionBitacora($envio->id, Auth::user()->id,'Estado en ruta','','','Envio'));
        return response()->json(['success' => 'Éxito']);
    }

    //Entregar
    public function entregar(Request $request, $id) {
        $envio = RegistroEnvioEquipo::where('id', $id)->first();
        $envio->receptor = $request->receptor_modal;
        $envio->fecha_recepcion = Carbon::now();
        $envio->estado_envio_id = 3;
        $envio->save();
        event(new ActualizacionBitacora($envio->id, Auth::user()->id,'Estado entregado','','','Envio'));
        return response()->json(['success' => 'Éxito']);

    }

    //Rechazar
    public function rechazar(Request $request, $id) {
        $envio = RegistroEnvioEquipo::where('id', $id)->first();
        $envio->estado_envio_id = 4;
        $envio->save();
        event(new ActualizacionBitacora($envio->id, Auth::user()->id,'Estado rechazado','','','Envio'));
        return response()->json(['success' => 'Éxito']);
    }

    //Recibir
    public function recibir(Request $request, $id) {
        $envio = RegistroEnvioEquipo::where('id', $id)->first();
        $envio->estado_envio_id = 5;
        $envio->save();
        event(new ActualizacionBitacora($envio->id, Auth::user()->id,'Estado rechazado','','','Envio'));
        return response()->json(['success' => 'Éxito']);
    }


        //Mes en espaniol
    public function obtenerMes($monthNumber) {
        switch($monthNumber)
            {
                case 1:
                    $monthName = "Enero";
                break;

                case 2:
                    $monthName = "Febrero";
                break;

                case 3:
                    $monthName = "Marzo";
                break;

                case 4:
                    $monthName = "Abril";
                break;

                case 5:
                    $monthName = "Mayo";
                break;

                case 6:
                    $monthName = "Junio";
                break;

                case 7:
                    $monthName = "Julio";
                break;

                case 8:
                    $monthName = "Agosto";
                break;

                case 9:
                    $monthName = "Septiembre";
                break;

                case 10:
                    $monthName = "Octubre";
                break;

                case 11:
                    $monthName = "Noviembre";
                break;

                case 12:
                    $monthName = "Diciembre";
                break;


            }
        return $monthName;
    }
    //envio PDF
    public function envioPDF($id) {
        $envio  = RegistroEnvioEquipo::where('id', $id)->get();
        $envio[0]->ordenEquipo;
        $envio[0]->empleado;
        //, ['cheque' => $cheque, 'letras' => $texto, 'voucher' => $voucher, 'mes' => $monthName, 'cuenta' => $cuenta, 'empleado' => $empleado]
        $pdf = \PDF::loadView('admin.registroEnvios.envioPDF', ['envio' => $envio]);
        return $pdf->download('envio' . "00" . $envio[0]->no_envio ."-" . $envio[0]->anio . '.pdf');

    }
}
