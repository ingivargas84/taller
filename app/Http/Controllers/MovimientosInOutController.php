<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Events\ActualizacionBitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\User;
use App\CajaDetalle;
use App\CajaMaestro;
use DateTime;

class MovimientosInOutController extends Controller
{
    public function __construct() {

         $this->middleware('auth');

    }

    public function previous()
    {
        return view('admin.movimientosInOut.previous');
    }

        //
    public function getPreviousJson() {

        $api_result['data'] = CajaMaestro::where('estado_caja_id', '2')->get();

        return response()->json($api_result);
    }

    //

     public function index()
    {
        $cajaActual = CajaMaestro::where('fecha', Carbon::today())->get();
        if(isset($cajaActual[0])) { 
            if($cajaActual[0] != '') {
                //Comprueba si ya existe una caja hoy 

                if($cajaActual[0]->estado_caja_id == 1) {
                    //Si la caja de hoy aun no está cerrada, mostrar index normal 
                    $isClosed = false;
                        $ultimoSaldo = $cajaActual[0]->saldo;
                        $id = $cajaActual[0]->id;
                        return view('admin.movimientosInOut.index', compact('isClosed', 'ultimoSaldo', 'id'));
                
                } else {
                    //Si la caja de hoy ya fue cerrada
                    $isClosed = true;
                   // $last = DB::table('caja_maestros')->latest('fecha')->where('estado_caja_id', 2)->first();
                    $ultimoSaldo =  $cajaActual[0]->saldo;
                    $id = null;
                    return view('admin.movimientosInOut.index', compact('isClosed', 'ultimoSaldo', 'id'));
                    
                }
            } else {
                //Aun no existe la caja de hoy
                $isClosed = null;
                $id = null;
                $saldoToday = $cajaActual[0]->saldo;
                return view('admin.movimientosInOut.index', compact('isClosed', 'saldoToday', 'id'));

            }
        } else {
              //Aun no existe la caja de hoy
                $isClosed = null;
                $last = DB::table('caja_maestros')->latest('fecha')->where('estado_caja_id', 2)->first();
                if(isset($last)) {
                    if($last->fecha != Carbon::today()->toDateString()) {
                        $id = null;
                        $ultimoSaldo = $last->saldo;
                        $records = true;
                        return view('admin.movimientosInOut.index', compact('isClosed', 'id', 'ultimoSaldo', 'records'));
                    } else {
                        $isClosed = false;
                        $ultimoSaldo = $cajaActual[0]->saldo;
                        return view('admin.movimientosInOut.index', compact('isClosed', 'ultimoSaldo'));
                    }
                } else {
                    $id = null;
                    $records = false;
                    $ultimoSaldo = 0;
                    return view('admin.movimientosInOut.index', compact('isClosed','id', 'ultimoSaldo', 'records'));

                }
                
        }
       
    }

    public function getJson() {

        $c = CajaMaestro::where('fecha', Carbon::today()->toDateString())->get();
        if(isset($c[0])) {

            $api_result['data'] = CajaDetalle::where([['caja_maestro_id', $c[0]->id],['isDeleted', 0]])->get();
            return response()->json($api_result);
        } else {          
            $api_result['data'] = array("no" =>"...", "fecha"=> "...", "descripcion"=> "...", "total"=> "...", "receptor"=> "...", "tipo_movimiento_id"=> 'dd', "Acciones"=> "...");

            return $api_result;
        }
    }

    //Obtener el primer registro de caja Chica
    public function getData() {
        $inicial = CajaMaestro::first();
        $final = DB::table('caja_maestros')->latest('fecha')->first();
        $fechas = array($inicial, $final);
        return response()->json($fechas);

    }

    //Reporte PDF por fechas
    public function reportePDF(Request $request){
        //fechas 
        $inicio = Carbon::parse($request->fechaInicial);
        $final = Carbon::parse($request->fechaFinal);
        //Movimientos por dia
        $days = DB::table('caja_maestros')
        ->whereBetween('caja_maestros.fecha', [$inicio, $final])
        ->get();
        
        //ultimo movimiento
        $lastRecord = CajaMaestro::where('fecha', Carbon::parse($request->fechaFinal))->get();
        
        $movimientos = $lastRecord[0]->cajaDetalles->where('isDeleted', 0);
        
       //generar PDF
         $pdf = \PDF::loadView('admin.movimientosInOut.reportPDF', compact('days', 'inicio', 'final', 'lastRecord', 'movimientos'));
         return $pdf->download('reportes' . strftime($request->fechaInicial) . '/' . strftime($request->fechaFinal) . '.pdf');
    }

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
    //Imprimir movimientos de un solo dia
    public function singleReport(Request $request) {
        $movimientos = CajaDetalle::where([['caja_maestro_id', $request->id], ['isDeleted', '0']])->get();
        //Obtengo el mes en un array
        $arrayMonthNumber = DB::select('select month(fecha) mes from caja_maestros where id =?', [$request->id]);
        //Obtengo el numero mes
        $monthName = $this->obtenerMes($arrayMonthNumber[0]->mes);
        //Mes
        $caja = CajaMaestro::find($request->id);
        //Saldo inicial
        $last = DB::table('caja_maestros')->latest('fecha')->where([['estado_caja_id', 2],['id', ($request->id - 1)]])->first();
        $pdf = \PDF::loadView('admin.movimientosInOut.singleReportPDF', compact('last','movimientos', 'monthName', 'caja'));
        return $pdf->download('reporte'. $caja->fecha .'.pdf');
    }

      //Imprimir recibo
    public function getPDF($data) {
        
        if (strlen($data) == 3)
        {
            $maestro = $data[2];
            $detalle = $data[0];
        }
        else if (strlen($data) == 4)
        {
            $maestro = $data[3];
            $detalle = $data[0] . $data[1];
        }
        else if (strlen($data) == 5)
        {
            $maestro = $data[3] . $data[4] ;
            $detalle = $data[0] . $data[1];
        }
        
        $cajaD = CajaDetalle::where([['caja_maestro_id',$maestro],['id', $detalle], ['isDeleted', '0']])->get();
        
        $cajaD[0]->fecha;
        //Obtengo el mes en un array
        $arrayMonthNumber = DB::select('select month(fecha) mes from caja_detalles where id =? and caja_maestro_id=?', array($detalle, $maestro));
        //Obtengo el numero mes
        $monthName = $this->obtenerMes($arrayMonthNumber[0]->mes);
        $pdf = \PDF::loadView('admin.movimientosInOut.reciboPDF', compact('monthName', 'cajaD'));
        return $pdf->download('recibo-'. '00' . $cajaD[0]->numero .'-' . $cajaD[0]->anio . '.pdf');
    }

    //Validar el saldo de Caja Maestro anterior para las salidas
    public function isGreater() {
        $dato = Input::get('monto');
        $c = CajaMaestro::where('fecha', Carbon::today()->toDateString())->get();
        if(isset($c[0])) {
            if($dato > $c[0]->saldo) {
                return 'true';
            } else {
                return 'false';
            }
        } else {
            $last = DB::table('caja_maestros')->latest('fecha')->where('estado_caja_id', 2)->first();
            if($dato > $last->saldo) {
                return 'true';
            } else {
                return 'false';
            }
        }
    }


         /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function open(Request $request)
     { 
         $data = $request->all();
         $saldo = Input::get("saldo");
         if(isset($saldo)) {
            //Crear cajaMaestro
            $cajaToday = CajaMaestro::create([
                'fecha' => Carbon::today(),
                'saldo' => (float) $saldo,
                'estado_caja_id' => 1,
            ]);

         } else {
            //Crear cajaMaestro
            $cajaToday = CajaMaestro::create([
                'fecha' => Carbon::today(),
                'saldo' => $data['monto'],
                'estado_caja_id' => 1,
            ]);
         }
        
        if(isset($data['tipo_mov'])) {    
                //Agregar el movimiento
                if($data['tipo_mov'] =='1') {
                    $cajaDetalle = CajaDetalle::create([
                        'fecha' => Carbon::now(),
                        'descripcion' => 'No aplica',
                        'anio' => Carbon::today()->year,
                        'total' => $data['monto'],
                        'receptor' => 'No aplica',
                        'caja_maestro_id' => $cajaToday->id,
                        'tipo_movimiento_id' => '1'
                    ]);

                    //Actualizar el saldo
                    $saldoFinal = (float) $data['monto'] + (float) $saldo;
                    $cajaToday->saldo = $saldoFinal;
                    $cajaToday->save();
                } else {

            //Condicionar que numero corresponde
            $salidas = CajaDetalle::where('tipo_movimiento_id', 2)->orderBy('id', 'DESC')->get();
            $today = Carbon::today()->format('Y-m-d');
            $year = Carbon::today()->year;

            $last = end($salidas);            
            if(isset($last) && $last != null) {
                    
                $newYear = $last[0]['anio'] . '-01-01';
                
                if($today == $newYear && $last[0]['anio'] != $year) {
                    //Si hoy es anio nuevo y el ultimo registro es del anio pasado
                   $cajaDetalle = CajaDetalle::create([
                        'fecha' => Carbon::now(),
                        'descripcion' => $data['desc'],
                        'numero' => 1,
                        'anio' => $year,
                        'total' => $data['monto'],
                        'receptor' => $data['receptor'],
                        'caja_maestro_id' => $cajaToday->id,
                        'tipo_movimiento_id' => '2'
                    ]);
                } else if($today == $newYear && $last[0]['anio'] == $year) {
                    //Aun es 1 de enero pero ya hay registros del anio nuevo
                    $cajaDetalle = CajaDetalle::create([
                        'fecha' => Carbon::now(),
                        'descripcion' => $data['desc'],
                        'numero' => $last[0]['numero'] + 1,
                        'anio' => $year,
                        'total' => $data['monto'],
                        'receptor' => $data['receptor'],
                        'caja_maestro_id' => $cajaToday->id,
                        'tipo_movimiento_id' => '2'
                    ]);
                } else {
                    //Cualquier otro dia del anio
                     $cajaDetalle = CajaDetalle::create([
                        'fecha' => Carbon::now(),
                        'descripcion' => $data['desc'],
                        'numero' => $last[0]['numero'] + 1,
                        'anio' => $year,
                        'total' => $data['monto'],
                        'receptor' => $data['receptor'],
                        'caja_maestro_id' => $cajaToday->id,
                        'tipo_movimiento_id' => '2'
                    ]);
                }
            } else {
                //Es el primer registro
                   $cajaDetalle = CajaDetalle::create([
                        'fecha' => Carbon::now(),
                        'descripcion' => $data['desc'],
                        'numero' => 1,
                        'anio' => $year,
                        'total' => $data['monto'],
                        'receptor' => $data['receptor'],
                        'caja_maestro_id' => $cajaToday->id,
                        'tipo_movimiento_id' => '2'
                    ]);
            }
                    //Actualizar el saldo
                    $saldoFinal = (float) $saldo - $data['monto'];
                    $cajaToday->saldo = $saldoFinal;
                    $cajaToday->save();
                }
       } else {
            $cajaDetalle = CajaDetalle::create([
                        'fecha' => Carbon::now(),
                        'descripcion' => 'Apertura de caja, ' . Carbon::today()->format('d/m/Y'),
                        'total' => $data['monto'],
                        'anio' => Carbon::today()->year,
                        'receptor' => 'No aplica',
                        'caja_maestro_id' => $cajaToday->id,
                        'tipo_movimiento_id' => '1'
                    ]);

                    //Actualizar el saldo
                    $saldoFinal = (float) $data['monto'];
                    $cajaToday->saldo = $saldoFinal;
                    $cajaToday->save();
       }
        event(new ActualizacionBitacora($cajaDetalle->id, Auth::user()->id, 'Creación', '', $cajaDetalle,'CajaDetalle'));
        event(new ActualizacionBitacora($cajaToday->id, Auth::user()->id, 'Creación', '', $cajaToday,'CajaMaestro'));

        return response()->json(['success'=> 'exito']);
     }


              /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function store(Request $request)
     {   
        $saldo = Input::get("saldo");
        $id = Input::get("idCaja");
        $data = $request->all();
        $cajaToday = CajaMaestro::where('id', $id)->get();
         //Crear cajaMaestro
        //Agregar el movimiento
        if($data['tipo_mov'] =='1') {
            $cajaDetalle = CajaDetalle::create([
                'fecha' => Carbon::now(),
                'descripcion' => 'No aplica',
                'anio' => Carbon::today()->year,
                'total' => $data['monto'],
                'receptor' => 'No aplica',
                'caja_maestro_id' => $id,
                'tipo_movimiento_id' => '1'
            ]);

            //Actualizar el saldo
            $saldoFinal = (float) $data['monto'] + (float) $saldo;
            $cajaToday[0]->saldo = $saldoFinal;
            $cajaToday[0]->save();
        } else {
            
            //Condicionar que numero corresponde
            $salidas = CajaDetalle::where('tipo_movimiento_id', 2)->orderBy('id', 'DESC')->get();
            $today = Carbon::today()->format('Y-m-d');
            $year = Carbon::today()->year;
            $last = end($salidas);
             if(isset($last) && $last != null) {
                    
                $newYear = $last[0]['anio'] . '-01-01';
                
                if($today == $newYear && $last[0]['anio'] != $year) {
                    //Si hoy es anio nuevo y el ultimo registro es del anio pasado
                   $cajaDetalle = CajaDetalle::create([
                        'fecha' => Carbon::now(),
                        'descripcion' => $data['desc'],
                        'numero' => 1,
                        'anio' => $year,
                        'total' => $data['monto'],
                        'receptor' => $data['receptor'],
                        'caja_maestro_id' => $cajaToday[0]->id,
                        'tipo_movimiento_id' => '2'
                    ]);
                } else if($today == $newYear && $last[0]['anio'] == $year) {
                    //Aun es 1 de enero pero ya hay registros del anio nuevo
                    $cajaDetalle = CajaDetalle::create([
                        'fecha' => Carbon::now(),
                        'descripcion' => $data['desc'],
                        'numero' => $last[0]['numero'] + 1,
                        'anio' => $year,
                        'total' => $data['monto'],
                        'receptor' => $data['receptor'],
                        'caja_maestro_id' => $cajaToday[0]->id,
                        'tipo_movimiento_id' => '2'
                    ]);
                } else {
                    //Cualquier otro dia del anio
                     $cajaDetalle = CajaDetalle::create([
                        'fecha' => Carbon::now(),
                        'descripcion' => $data['desc'],
                        'numero' =>$last[0]['numero'] + 1,
                        'anio' => $year,
                        'total' => $data['monto'],
                        'receptor' => $data['receptor'],
                        'caja_maestro_id' => $cajaToday[0]->id,
                        'tipo_movimiento_id' => '2'
                    ]);
                }
            } else {
                //Es el primer registro
                   $cajaDetalle = CajaDetalle::create([
                        'fecha' => Carbon::now(),
                        'descripcion' => $data['desc'],
                        'numero' => 1,
                        'anio' => $year,
                        'total' => $data['monto'],
                        'receptor' => $data['receptor'],
                        'caja_maestro_id' => $cajaToday[0]->id,
                        'tipo_movimiento_id' => '2'
                    ]);
            }

            //Actualizar el saldo
            $saldoFinal = (float) $saldo - $data['monto'];
            $cajaToday[0]->saldo = $saldoFinal;
            $cajaToday[0]->save();
        }
       
        event(new ActualizacionBitacora($cajaDetalle->id, Auth::user()->id, 'Creación', '', $cajaDetalle,'CajaDetalle'));
        event(new ActualizacionBitacora($cajaToday[0]->id, Auth::user()->id, 'Actualizacion', '', $cajaToday,'CajaMaestro'));

        return response()->json(['success'=> 'exito']);
     }

      /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $caja = CajaMaestro::where('id', $request->id)->first();
        $caja->estado_caja_id = 2;
        $caja->save();

        foreach($caja->cajaDetalles as $d) {
            $d->isOpen = 0;
            $d->estado_id = 2;
            $d->save();
            event(new ActualizacionBitacora($d->id, Auth::user()->id,'Inactivación','','','caja'));
        }
       event(new ActualizacionBitacora($caja->id, Auth::user()->id,'Inactivación','','','caja'));
        return response()->json(['success' => 'Éxito']);
    
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $caja = CajaMaestro::where('id', $id)->where('estado_caja_id', 2)->first();

        //Espaniol
        setlocale(LC_TIME, 'es_ES');
        //Obtengo el mes en un array
        $arrayMonthNumber = DB::select('select month(fecha) mes from caja_maestros where id =?', [$id]);
        //Obtengo el objeto fecha
        $dateObj   = DateTime::createFromFormat('!m', $arrayMonthNumber[0]->mes);
        //Este lo traduce
        $monthName = strftime('%B', $dateObj->getTimestamp());


       if(isset($caja)) {
           return view('admin.movimientosInOut.show', compact('caja', 'monthName'));
       } else {
           return view('notfound');
       }
    }

    public function getPreviousDetail($id) {
          $c = CajaMaestro::where('id', $id)->get();
        if(isset($c[0])) {

            $api_result['data'] = CajaDetalle::where([['caja_maestro_id', $c[0]->id],['isDeleted', '0']])->get();
            return response()->json($api_result);
        } else {          
            $api_result['data'] = array("no" =>"...", "fecha"=> "...", "descripcion"=> "...", "total"=> "...", "receptor"=> "...", "tipo_movimiento_id"=> 'dd', "Acciones"=> "...");

            return $api_result;
        }
    }


    //Eliminar una entrada o salida y actualizar el total de la cajaMaestro
    public function deleteDetail(Request $request) {
        $cajaActualizar = CajaMaestro::where('id', $request->caja)->get();

        $detalle = CajaDetalle::where([['id', $request->id],['caja_maestro_id', $request->caja]])->get();
        //Comparar si es una entrada
        if($detalle[0]->tipo_movimiento_id == 1) {
            //Debes restar el total al saldo
            $cajaActualizar[0]->saldo = (float) $cajaActualizar[0]->saldo - (float) $detalle[0]->total;
            $cajaActualizar[0]->save();
            $detalle[0]->estado_id = 2;
            $detalle[0]->isDeleted = 1;
            $detalle[0]->save();
        } else {
            //Si es una salida
            $cajaActualizar[0]->saldo = (float) $cajaActualizar[0]->saldo + (float) $detalle[0]->total;
            $cajaActualizar[0]->save();
            $detalle[0]->estado_id = 2;
            $detalle[0]->isDeleted = 1;
            $detalle[0]->save();
        }

        event(new ActualizacionBitacora($detalle[0]->id, Auth::user()->id,'Inactivación','','','cajaDetalle'));
        event(new ActualizacionBitacora($cajaActualizar[0]->id, Auth::user()->id, 'Actualizacion', '', $cajaActualizar,'CajaMaestro'));

    } 


}
