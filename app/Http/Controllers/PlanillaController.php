<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Events\ActualizacionBitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Empleado;
use App\PlanillaMaestro;
use App\PlanillaDetalle;
use App\PlanillaMedio;
use App\IngresoEgreso;
use DateTime;

class PlanillaController extends Controller{
    /***
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.planilla.index');
    }

    public function __construct() {

         $this->middleware('auth');
    }

    public function getJson() {
        $api_result['data'] = PlanillaMaestro::get();
        foreach($api_result['data'] as $p) {
            $p->estado;
        }
        return response()->json($api_result);
    }
    
    public function getHeader() {
        $header = array('Colaborador','Sueldo Base');
        $egresos = array();
        //Obtengo Ingresos/Egresos
        $movs = IngresoEgreso::where('estado_id', '1')->orderBy('tipo_movimiento_id', 'asc')->orderBy('tipo_calculo_id', 'desc')->get();
        
        
        foreach($movs as $n){
            if($n->tipo_movimiento_id == 1) {
                array_push($header, $n->nombre);
            } else {
                array_push($egresos, $n->nombre);
            }
        }

        array_push($header, 'Ingreso total', 'Sueldo Total');
        //
        foreach($egresos as $n){
                array_push($header, $n);
        }
        //
        array_push($header, 'Egreso total', 'Total');
        // $data['colaboradores'] = Empleado::where('estado_id', '1')->get();
        $api_result['data'] = $header;
        return response()->json($api_result);
    }
    
    
    public function getMovs() {
        $employeeData = array();
        //Guardar los empleados en diferentes arrays
        $cols = Empleado::where('estado_id',1)->get();
        //
        $movs = IngresoEgreso::where('estado_id', '1')->orderBy('tipo_movimiento_id', 'asc')->orderBy('tipo_calculo_id', 'desc')->get();
        //Haga el ciclo, y obtengo el salario y los ingresos fijos
        //los sumo
        //los agrego
        foreach($cols as $c) {
            $ingresos = array();
            $egresos = array();
            $movimientos = array();

            $empleadoIngresoFijo = array();
            $empleadoIngresoFijo = 0;
            foreach($movs as $m) {
                if ($m->tipo_movimiento_id == 1) {
                    //
                    array_push($movimientos, $m);
                    //
                        switch ($m->tipo_calculo_id) {
                            case 1: 
                                break;
                            case 2: 
                                break;
                            case 3:
                                # Fijo...
                                $empleadoIngresoFijo += $m->cantidad_ingreso_fijo;
                                break;                    
                            default:
                                # code...
                            break;
                        }

                } else {
                    array_push($egresos, $m);
                }
            }
            //
            array_push($movimientos, ['ingresoT' => 0]);
            array_push($movimientos, ['sueldoT' => 0]);
            array_push($egresos, ['egresoT' => 0]);
            
            foreach($egresos as $e) {
                array_push($movimientos, $e);
            }
            array_push($employeeData, ['id' => $c->id,'nombre' =>$c->nombres . " " . $c->apellidos, 'salario'=>$c->salario, 'movimientos' => $movimientos, 'fijo_ingreso' => $empleadoIngresoFijo]);
            // array_push($employeeData, ['id' => $c->id,'nombre' =>$c->nombres . " " . $c->apellidos, 'salario'=>$c->salario, 'movimientos' => $movs, 'fijo_ingreso' => $empleadoIngresoFijo]);
        }

        $api_result['data'] = $employeeData;
        return response()->json($api_result);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.planilla.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        //Empleado id 4 su total 
        //$tableData[3]['total']
        if(isset($request->datos)) {
            $tableData = json_decode($request->datos,TRUE);
            //dd($tableData[0]);
            //Condicionar que numero corresponde
            $today = Carbon::today()->format('Y-m-d');
            $year = Carbon::today()->year;
            $total = $request->total;
            $titulo = $request->titulo;
            $last = DB::table('planilla_maestros')->latest('created_at')->first();
            
            if(isset($last)) {
                    
                $newYear = $last->anio . '-01-01';
                
                if($today == $newYear && $last->anio != $year) {
                    //Si hoy es anio nuevo y el ultimo registro es del anio pasado
                     $planillaMaestro = PlanillaMaestro::create([
                           'no_planilla' => 1,
                           'titulo' => $titulo,
                           'anio' => $year,
                           'contador_id' => Auth::user()->id,
                           'total' => $total,
                           'estado_planilla_id' => 1,
                           'fecha_planilla' => $today
                     ]);

                } else if($today == $newYear && $last->anio == $year) {
                    //Aun es 1 de enero pero ya hay registros del anio nuevo
                     $planillaMaestro = PlanillaMaestro::create([
                           'no_planilla' => $last->no_planilla + 1,
                           'titulo' => $titulo,
                           'anio' => $year,
                           'contador_id' => Auth::user()->id,
                           'total' => $total,
                           'estado_planilla_id' => 1,
                           'fecha_planilla' => $today
                     ]);
                } else {
                    //Cualquier otro dia del anio
                    $planillaMaestro = PlanillaMaestro::create([
                           'no_planilla' => $last->no_planilla + 1,
                           'titulo' => $titulo,
                           'anio' => $year,
                           'contador_id' => Auth::user()->id,
                           'total' => $total,
                           'estado_planilla_id' => 1,
                           'fecha_planilla' => $today
                    ]);
                }
            } else {
                //Es el primer registro
                    $planillaMaestro = PlanillaMaestro::create([
                           'no_planilla' => 1,
                           'titulo' => $titulo,
                           'anio' => $year,
                           'contador_id' => Auth::user()->id,
                           'total' => $total,
                           'estado_planilla_id' => 1,
                           'fecha_planilla' => $today
                    ]);
            }
            //Guardar Planilla Medio
            foreach($tableData as $employee) {

                $planillaMedio = PlanillaMedio::create([
                    'planilla_maestro_id' => $planillaMaestro->id,
                    'empleado_id' => $employee['idEmpleado'],
                    'total_ingresos' => $employee['ingresoTotal'],
                    'total_egresos' => $employee['egresoTotal'],
                    'total_liquido' => $employee['total']
                ]);
                    //
                foreach($employee['movimientos'] as $mov) {
                    
                    $planillaDetalle = PlanillaDetalle::create([
                        'planilla_medio_id' => $planillaMedio->id,
                        'movimiento_id' => $mov[0],
                        'subtotal' => $mov[1]
                    ]);
                    event(new ActualizacionBitacora($planillaDetalle->id, Auth::user()->id, 'Creación', '', $planillaDetalle,'PlanillaDetalle'));
                } 

                event(new ActualizacionBitacora($planillaMedio->id, Auth::user()->id, 'Creación', '', $planillaMedio,'PlanillaMedio'));
            }
            
            //Bitacora para PlanillaMaestro creada
            event(new ActualizacionBitacora($planillaMaestro->id, Auth::user()->id, 'Creación', '', $planillaMaestro,'PlanillaMaestro'));
            //return redirect()->route('planilla.index')->withFlash('¡Planilla creada exitosamente!');
            //return route('planilla.index', ['id' => $result]);
            return response()->json(['success' => 'Éxito']);        

        }


    }

    //
    public function nombreUnico()
    {
        $dato = Input::get("titulo");
        $query = PlanillaMaestro::where("titulo",$dato)
                        ->where('estado_planilla_id', 1)->get();
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

    //

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
