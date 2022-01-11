<?php

namespace App\Http\Controllers;

use App\CuentaBancaria;
use Illuminate\Http\Request;
use App\TipoCuenta;
use Illuminate\Support\Facades\Auth;
use App\Events\ActualizacionBitacora;

class CuentaBancariaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.cuentasBancarias.index');
    }

     /**
     * Obteniendo las cuentas bancarias json 
     */

     public function getJson() {
        
        $api_result['data'] = CuentaBancaria::all();
        foreach($api_result['data'] as $e) {
            $e->tipoCuenta;
            $e->banco;
        }
        return response()->json($api_result);
    }

     public function getTiposCuenta() {
         $tipos = TipoCuenta::all();

          return response()->json($tipos);
     }

     public function getTipos($id) {
         $tipo = TipoCuenta::where('id', '!=', $id)->get();

          return response()->json($tipo);
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

        $cuenta = new CuentaBancaria;
        $cuenta->nombre_cuenta = $data['nombre'];
        $cuenta->no_cuenta = $data['no_cuenta'];
        $cuenta->banco_id = $data['banco_id'];
        $cuenta->tipo_cuenta_id = $data['tipo_cuenta'];
        $cuenta->save();

        event(new ActualizacionBitacora($cuenta->id, Auth::user()->id, 'Creación', '', $cuenta, 'CuentaBancaria'));

        return response()->json(['success'=>'Éxito']);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CuentaBancaria  $cuentaBancaria
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CuentaBancaria $cuentaBancaria)
    {
        $new = $request->all();
        event(new ActualizacionBitacora($cuentaBancaria->id, Auth::user()->id,'Edicion',$cuentaBancaria, json_encode($new),'cuentaBancaria'));
        $cuentaBancaria->nombre_cuenta = $request->nombre_edit;
        $cuentaBancaria->no_cuenta = $request->no_cuenta_edit;
        $cuentaBancaria->banco_id = $request->banco_id_edit;
        $cuentaBancaria->tipo_cuenta_id = $request->tipo_cuenta_edit;
        $cuentaBancaria->save();

        return response()->json(['success'=>'Éxito']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CuentaBancaria  $cuentaBancaria
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $cuentaBancaria = CuentaBancaria::where('id',$request->id)->first();
        $cuentaBancaria->estado_id = 2;
        $cuentaBancaria->save();
        
        event(new ActualizacionBitacora($cuentaBancaria->id, Auth::user()->id,'Inactivación', '', '', 'cuentaBancaria'));
        
        return response()->json(['success'=>'Éxito']);
    }

    public function activate(CuentaBancaria $cuentaBancaria) {
        $cuentaBancaria->estado_id = 1;
        $cuentaBancaria->save();

        event(new ActualizacionBitacora($cuentaBancaria->id, Auth::user()->id,'Activación', '', '', 'cuentaBancaria'));
        return response()->json(['success'=>'Éxito']);
    }
}
