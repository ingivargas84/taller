<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Events\ActualizacionBitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\User;
use App\MovIngresoEgreso;
use App\IngresoEgreso;
use App\TipoCalculo;
//use DateTime;

class IngresoEgresoController extends Controller
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
        $tipos = MovIngresoEgreso::all();
        $tiposC = TipoCalculo::all();

        return view('admin.movimientos.index', compact('tipos', 'tiposC'));
    }

    //
    public function getJson() {

        $movs = IngresoEgreso::where('estado_id', '1')->get();        
        $api_result['data'] = $movs;       
        
        foreach($api_result['data'] as $m) {
            $m->tipoMov;
            $m->tipoCalculo;
            $m->valorPC;
            $m->valorFijo;
        }
        return response()->json($api_result);
        
    }
    //
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
        $data = $request->all();
        
        if($data['isWhat'] == '1') {
            //Es Porcentaje
             
            $ingresoEgreso =  IngresoEgreso::create([
                'nombre' => $data['nombre'],
                'tipo_movimiento_id' => $data['tipoM'],
                'tipo_calculo_id' => $data['tipoC'],
                'campo_pc_id' => $data['valor_afecto_p'],
                'porcentaje' => $data['porcentaje'] / 100,
            ]);
        } else if($data['isWhat'] == '2') {
            //Es Calculado
            $ingresoEgreso =  IngresoEgreso::create([
                'nombre' => $data['nombre'],
                'tipo_movimiento_id' => $data['tipoM'],
                'tipo_calculo_id' => $data['tipoC'],
                'campo_pc_id' => $data['valor_afecto_c'],
                'cantidad_multiplicar' => $data['multip'],
            ]);
        } else {
            //Es Fijo
            if($data['valor_afecto_f'] == 1) {
               
                $ingresoEgreso =  IngresoEgreso::create([
                    'nombre' => $data['nombre'],
                    'tipo_movimiento_id' => $data['tipoM'],
                    'tipo_calculo_id' => $data['tipoC'],
                    'campo_am_id' => $data['valor_afecto_f'],   
                ]);
            
            } else {

                    $ingresoEgreso =  IngresoEgreso::create([
                    'nombre' => $data['nombre'],
                    'tipo_movimiento_id' => $data['tipoM'],
                    'tipo_calculo_id' => $data['tipoC'],
                    'campo_am_id' => $data['valor_afecto_f'],
                    'cantidad_ingreso_fijo' => $data['cantidad'],
                ]);
            }
        
        }
        //Ya ingresado
        event(new ActualizacionBitacora($ingresoEgreso->id, Auth::user()->id, 'Creación', '', $ingresoEgreso, 'IngresoEgreso'));

        return response()->json(['success'=>'Éxito']);

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\IngresoEgreso  $ingresoEgreso
     * @return \Illuminate\Http\Response
     */
    public function show(IngresoEgreso $ingresoEgreso)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\IngresoEgreso  $ingresoEgreso
     * @return \Illuminate\Http\Response
     */
    public function edit(IngresoEgreso $ingresoEgreso)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\IngresoEgreso  $ingresoEgreso
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, IngresoEgreso $ingresoEgreso)
    {
        $dataU = $request->all();

        $original = IngresoEgreso::where([['estado_id', '1'],['id',$dataU['id']]])->first();
        //Tengo que ver que tipo de c'alculo son
        //Porcentaje
        if($dataU['tipoCe'] == 1) {
            //dd($dataU['tipoCe']);
            $original->nombre = $dataU['nombreEdit']; 
            $original->tipo_movimiento_id = $dataU['tipoMe']; 
            $original->tipo_calculo_id = $dataU['tipoCe']; 
            $original->campo_pc_id = $dataU['valor_afecto_p_edit']; 
            $original->campo_am_id= null; 
            $original->porcentaje = $dataU['porcentajeEdit'] / 100; 
            $original->cantidad_multiplicar = null; 
            $original->cantidad_ingreso_fijo = null;
            $original->save(); 
        //Calculado
        } else if($dataU['tipoCe'] == 2) {
            //dd($dataU['tipoCe']);
            $original->nombre = $dataU['nombreEdit']; 
            $original->tipo_movimiento_id = $dataU['tipoMe']; 
            $original->tipo_calculo_id = $dataU['tipoCe']; 
            $original->campo_pc_id = $dataU['valor_afecto_c_edit']; 
            $original->campo_am_id= null; 
            $original->porcentaje = null; 
            $original->cantidad_multiplicar = $dataU['multipEdit']; 
            $original->cantidad_ingreso_fijo = null;
            $original->save(); 
        //Fijo
        } else {
            //dd($dataU['tipoCe']);
            $original->nombre = $dataU['nombreEdit']; 
            $original->tipo_movimiento_id = $dataU['tipoMe']; 
            $original->tipo_calculo_id = $dataU['tipoCe']; 
            $original->campo_pc_id = null; 
            $original->campo_am_id= $dataU['valor_afecto_f_edit']; 
            $original->porcentaje = null; 
            $original->cantidad_multiplicar = null; 
            $original->cantidad_ingreso_fijo = $dataU['cantidadEdit'];
            $original->save(); 
        }

        event(new ActualizacionBitacora($original->id, Auth::user()->id, 'Actualizacion', '', $original, 'IngresoEgreso'));
        return response()->json(['success'=> 'exito']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\IngresoEgreso  $ingresoEgreso
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        //
        $mov = IngresoEgreso::where('id', $request->id)->first();
        $mov->estado_id = 2;
        $mov->save();

        event(new ActualizacionBitacora($mov->id, Auth::user()->id,'Inactivación', '', '', 'IngresoEgreso'));
        
        return response()->json(['success'=>'Éxito']);
    }
}
