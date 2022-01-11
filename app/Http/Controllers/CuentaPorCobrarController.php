<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Events\ActualizacionBitacora;
use DB;
use Carbon\Carbon;
use App\CuentaPorCobrarMaestro;
use App\CuentaPorCobrarDetalle;
use App\Documento;
use App\Cliente;
use App\Abono;
class CuentaPorCobrarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.cuentaCobrar.index');
    }

    /**
     * Listado de Tabla Maestro en JSON
     */
    public function getJson() {

        $api_result['data'] = CuentaPorCobrarMaestro::where('estado_id', 1)->get();
        
        foreach($api_result['data'] as $cuenta) {
            $cuenta->cliente;
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
        //
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
        
        $cuenta = CuentaPorCobrarMaestro::where('id', $id)->get();
        $cuenta[0]->cliente;
        $tipos = Documento::all();
        return view('admin.cuentaCobrar.show', compact('cuenta', 'tipos'));
    }

    /**
     * Lista de cuentas Por Cobrar detalles
     */
    public function getDetalleJson(Request $request) {

        $api_result['data'] = CuentaPorCobrarDetalle::where('cuenta_cobrar_maestro_id', $request->id)->get();

        foreach($api_result['data'] as $d) {
            $d->credito;
            $d->abono;
            $d->tipoTransaccion;
        }

        return response()->json($api_result);
    }

    /**
     * Obtiene el ultimo saldo segun sea el caso
     */
    public function check($id) {
        $cuenta = CuentaPorCobrarDetalle::latest()->where('cuenta_cobrar_maestro_id', $id)->first();
        $abono = Input::get('abono');
        if($abono <= $cuenta->saldo) {
            return 'false';
        } else {
            return 'true';
        }
    }

    /**
     * Se agrega un abono a la cuenta por Cobrar
     */
    public function abonar($id, Request $request) {
        $data = $request->all();
        //Se ingresa el abono a su respectiva tabla
        
        //
        //Condicionar que numero corresponde
            $today = Carbon::today()->format('Y-m-d');
            $year = Carbon::today()->year;

            $last = DB::table('abonos')->latest('created_at')->where('anio', '!=', null)->first();
            if(isset($last)) {
                    
                $newYear = $last->anio . '-01-01';
                
                if($today == $newYear && $last->anio != $year) {
                    //Si hoy es anio nuevo y el ultimo registro es del anio pasado
                    $abono = new Abono;
                    $abono->no_recibo = 1;
                    $abono->anio = $year;
                    $abono->fecha = Carbon::parse($data['fecha']);
                    $abono->documento_id = $data['tipo'];
                    $abono->no_documento = $data['num'];
                    $abono->total = $data['abono'];
                    if($data['observaciones'] == null) {
                        $abono->observaciones = 'No aplica';
                    } else {
                        $abono->observaciones = $data['observaciones'];
                    }
                    $abono->user_id = Auth::user()->id;
                    $abono->save();


                } else if($today == $newYear && $last->anio == $year) {
                    //Aun es 1 de enero pero ya hay registros del anio nuevo
                    $abono = new Abono;
                    $abono->no_recibo = $last->no_recibo + 1;
                    $abono->anio = $year;
                    $abono->fecha = Carbon::parse($data['fecha']);
                    $abono->documento_id = $data['tipo'];
                    $abono->no_documento = $data['num'];
                    $abono->total = $data['abono'];
                    if($data['observaciones'] == null) {
                        $abono->observaciones == 'No aplica';
                    } else {
                        $abono->observaciones == $data['observaciones'];
                    }
                    $abono->user_id = Auth::user()->id;
                    $abono->save();
                } else {
                    //Cualquier otro dia del anio
                    $abono = new Abono;
                    $abono->no_recibo = $last->no_recibo + 1;
                    $abono->anio = $year;
                    $abono->fecha = Carbon::parse($data['fecha']);
                    $abono->documento_id = $data['tipo'];
                    $abono->no_documento = $data['num'];
                    $abono->total = $data['abono'];
                    if($data['observaciones'] == null) {
                        $abono->observaciones == 'No aplica';
                    } else {
                        $abono->observaciones == $data['observaciones'];
                    }
                    $abono->user_id = Auth::user()->id;
                    $abono->save();
                }
            } else {
                //Es el primer registro
                $abono = new Abono;            
                $abono->no_recibo = 1;
                $abono->anio = $year;
                $abono->fecha = Carbon::parse($data['fecha']);
                $abono->documento_id = $data['tipo'];
                $abono->no_documento = $data['num'];
                $abono->total = $data['abono'];
                if($data['observaciones'] == null) {
                    $abono->observaciones == 'No aplica';
                } else {
                    $abono->observaciones == $data['observaciones'];
                }
                $abono->user_id = Auth::user()->id;
                $abono->save();
               
            }
        
        
        //
        event(new ActualizacionBitacora($abono->id, Auth::user()->id, 'Creación', '', $abono,'Abono'));

        //Se obtiene el ultimo saldo
        $cuenta = CuentaPorCobrarDetalle::latest()->where('cuenta_cobrar_maestro_id', $id)->first();
        //Se crea el detalle cuenta por cobrar
        $cuentaDetalle = CuentaPorCobrarDetalle::create([
            'cuenta_cobrar_maestro_id' => $id,
            'tipo_transaccion_id' => '2',
            'fecha_transaccion' => Carbon::parse($data['fecha']),
            'abono_id' => $abono->id,
            'total' => $data['abono'],
            'saldo' => $cuenta->saldo - $data['abono'],
            'user_id' => Auth::user()->id,
        ]);

        event(new ActualizacionBitacora($cuentaDetalle->id, Auth::user()->id, 'Creación', '', $cuentaDetalle,'CuentaPorCobrarDetalle'));

        return response()->json(['success'=>'Éxito']);


    }


    public function revertirAbono($idA, $idC) {
        //dd($idA, $idC);
        //Primero cambiar estado del detalle Abono
        $detalle = CuentaPorCobrarDetalle::where([['estado_id',1],['cuenta_cobrar_maestro_id', $idC],['abono_id', $idA]])->get();
        $detalle[0]->estado_id = 2;
        $detalle[0]->save();
        //Se obtiene el ultimo saldo de cuenta
        $cuenta = CuentaPorCobrarDetalle::latest()->where('cuenta_cobrar_maestro_id', $idC)->first();
        //Crear un nuevo detalle de cuentas por cobrar
        $cuentaDetalle = CuentaPorCobrarDetalle::create([
            'cuenta_cobrar_maestro_id' => $idC,
            'tipo_transaccion_id' => '4',
            'fecha_transaccion' => Carbon::today(),
            'abono_id' => $idA,
            'total' => $detalle[0]->total,
            'saldo' => $cuenta->saldo + $detalle[0]->total,
            'user_id' => Auth::user()->id,
        ]);
            //Agregar evento
        event(new ActualizacionBitacora($cuentaDetalle->id, Auth::user()->id, 'Creacion', '', $cuentaDetalle,'CuentaPorCobrarDetalleRAbono'));

        return response()->json(['success'=>'Exito']);
    }

    /**
     * Imprimir PDF
     */
    public function print($id) {
        //dd($id);
        $cuenta = CuentaPorCobrarMaestro::where('id', $id)->get();
        $cuenta[0]->cliente;
        $tipos = Documento::all();

        //Detalle
        $transacciones = $cuenta[0]->detalles;
        foreach($transacciones as $d) {
            $d->credito;
            $d->abono;
            $d->tipoTransaccion;
        }
        //Se obtiene el ultimo saldo de cuenta
        $ultimo = CuentaPorCobrarDetalle::latest()->where('cuenta_cobrar_maestro_id', $id)->first();

        $saldoA = $ultimo->saldo;
        $pdf = \PDF::loadView('admin.cuentaCobrar.reportPDF', compact('cuenta', 'transacciones', 'saldoA'));
        
        return $pdf->download('reporteCuentaPorCobrar-' . $cuenta[0]->cliente->nombre_comercial .'.pdf');
    }

    //
    public function printRecibo($id) {
        $cli = substr($id, strpos($id, "-") + 1);    
        $idCuenta = explode("-", $id, 2);
        
        $cuenta = CuentaPorCobrarDetalle::where('id', $idCuenta[0])->get();
        //
        $cliente = Cliente::where('id', $cli)->get();
        $abono = Abono::where('id', $cuenta[0]->abono_id)->get();
        $pdf = \PDF::loadView('admin.cuentaCobrar.recibo', compact('cuenta', 'abono', 'cliente'));
        
        return $pdf->download('recibo.pdf');
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
}
