<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Events\ActualizacionBitacora;
use DB;
use Carbon\Carbon;
use App\CuentaPorPagarMaestro;
use App\CuentaPorPagarDetalle;
use App\Documento;
use App\Abono;
class CuentaPorPagarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        return view('admin.cuentaPagar.index');
    }

    /**
     * Listado de Tabla Maestro en JSON
     */
    public function getJson() {

        $api_result['data'] = CuentaPorPagarMaestro::where('estado_id', 1)->get();
        
        foreach($api_result['data'] as $cuenta) {
            $cuenta->proveedor;
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
        $cuenta = CuentaPorPagarMaestro::where('id', $id)->get();
        $cuenta[0]->proveedor;
        $tipos = Documento::all();
        return view('admin.cuentaPagar.show', compact('cuenta', 'tipos'));
    }

    /**
     * Lista de cuentas Por pagar detalles
     */
    public function getDetalleJson(Request $request) {

        $api_result['data'] = CuentaPorPagarDetalle::where('cuenta_pagar_maestro_id', $request->id)->get();

        foreach($api_result['data'] as $d) {
            $d->compra;
            $d->abono;
            $d->tipoTransaccion;
        }

        return response()->json($api_result);
    }

    /**
     * Obtiene el ultimo saldo segun sea el caso
     */
    public function check($id) {
        $cuenta = CuentaPorPagarDetalle::latest()->where('cuenta_pagar_maestro_id', $id)->first();
        $abono = Input::get('abono');
        if($abono <= $cuenta->saldo) {
            return 'false';
        } else {
            return 'true';
        }
    }

    /**
     * Se agrega un abono a la cuenta por Pagar
     */
    public function abonar($id, Request $request) {
        $data = $request->all();
        //Se ingresa el abono a su respectiva tabla
        $abono = new Abono;
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

        event(new ActualizacionBitacora($abono->id, Auth::user()->id, 'Creación', '', $abono,'Abono'));

        //Se obtiene el ultimo saldo
        $cuenta = CuentaPorPagarDetalle::latest()->where('cuenta_pagar_maestro_id', $id)->first();
        //Se crea el detalle cuenta por pagar
        $cuentaDetalle = CuentaPorPagarDetalle::create([
            'cuenta_pagar_maestro_id' => $id,
            'tipo_transaccion_id' => '2',
            'fecha_transaccion' => Carbon::parse($data['fecha']),
            'abono_id' => $abono->id,
            'total' => $data['abono'],
            'saldo' => $cuenta->saldo - $data['abono'],
            'user_id' => Auth::user()->id,
        ]);

        event(new ActualizacionBitacora($cuentaDetalle->id, Auth::user()->id, 'Creación', '', $cuentaDetalle,'CuentaPorPagarDetalle'));

        return response()->json(['success'=>'Éxito']);


    }


    public function revertirAbono($idA, $idC) {
        //dd($idA, $idC);
        //Primero cambiar estado del detalle Abono
        $detalle = CuentaPorPagarDetalle::where([['estado_id',1],['cuenta_pagar_maestro_id', $idC],['abono_id', $idA]])->get();
        $detalle[0]->estado_id = 2;
        $detalle[0]->save();
        //Se obtiene el ultimo saldo de cuenta
        $cuenta = CuentaPorPagarDetalle::latest()->where('cuenta_pagar_maestro_id', $idC)->first();
        //Crear un nuevo detalle de cuentas por pagar
        $cuentaDetalle = CuentaPorPagarDetalle::create([
            'cuenta_pagar_maestro_id' => $idC,
            'tipo_transaccion_id' => '4',
            'fecha_transaccion' => Carbon::today(),
            'abono_id' => $idA,
            'total' => $detalle[0]->total,
            'saldo' => $cuenta->saldo + $detalle[0]->total,
            'user_id' => Auth::user()->id,
        ]);
            //Agregar evento
        event(new ActualizacionBitacora($cuentaDetalle->id, Auth::user()->id, 'Creacion', '', $cuentaDetalle,'CuentaPorPagarDetalleRAbono'));

        return response()->json(['success'=>'Exito']);
    }

    /**
     * Imprimir PDF
     */
    public function print($id) {
        //dd($id);
        $cuenta = CuentaPorPagarMaestro::where('id', $id)->get();
        $cuenta[0]->proveedor;
        $tipos = Documento::all();

        //Detalle
        $transacciones = $cuenta[0]->detalles;
        foreach($transacciones as $d) {
            $d->compra;
            $d->abono;
            $d->tipoTransaccion;
        }
        //Se obtiene el ultimo saldo de cuenta
        $ultimo = CuentaPorPagarDetalle::latest()->where('cuenta_pagar_maestro_id', $id)->first();

        $saldoA = $ultimo->saldo;
        $pdf = \PDF::loadView('admin.cuentaPagar.reportPDF', compact('cuenta', 'transacciones', 'saldoA'));
        
        return $pdf->download('reporteCuentaPorPagar' . $cuenta[0]->proveedor->nombre_comercial .'.pdf');
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
