<?php

namespace App\Http\Controllers;

use App\RutasVendedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use App\Events\ActualizacionBitacora;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Cliente;
use App\Vendedor;
use Carbon\Carbon;
use App\OrdenEquipo;
class RutasVendedorController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

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
        return view('admin.rutasVendedor.index');
    }

    public function getJson() {
        
        $api_result['data'] = RutasVendedor::where([['estado_id', '1'],['vendedor_id',Auth::user()->id]])->get();
        
        foreach($api_result['data'] as $r) {
            $r->cliente;
            $r->vendedor;
            $r->ordenEquipo;
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
        $clientes = Cliente::where('estado_id', '1')->get();
        $ordenEquipos = OrdenEquipo::all();
        return view('admin.rutasVendedor.create', compact('clientes', 'ordenEquipos'));
        
    }

    public function getCliente($id) {
          $cliente = Cliente::where('id', $id)->where('estado_id', 1)->get();
        
        return response()->json($cliente);   
    }
    
    public function getRuta($id) {
        $ruta = RutasVendedor::where('id', $id)->get();
        return response()->json($ruta);   
        
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
      
                    //Si hoy es anio nuevo y el ultimo registro es del anio pasado
                    $ruta = new RutasVendedor;
                    $ruta->cliente_id = $data['cliente_id'];
                    if($data['orden_equipo_id'] != '0') {
                        $ruta->orden_equipo_id = $data['orden_equipo_id'];
                    }
                    $ruta->fecha = Carbon::now();
                    $ruta->vendedor_id = Auth::user()->id;
                    $ruta->observaciones = $data['observaciones'];                    
                    $ruta->save();
                    
        event(new ActualizacionBitacora($ruta->id, Auth::user()->id, 'Creación', '', $ruta, 'RutaVendedor'));

        return redirect()->route('rutas.index')->withFlash('¡La ruta ha sido registrada exitosamente!');
        //
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RutasVendedor  $rutasVendedor
     * @return \Illuminate\Http\Response
     */
    public function show(RutasVendedor $rutasVendedor)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RutasVendedor  $rutasVendedor
     * @return \Illuminate\Http\Response
     */
    public function edit(RutasVendedor $ruta)
    {
        $clientes = Cliente::where([['estado_id', '1'],['cliente_id', '!=', $ruta->cliente_id]])->get();
        return view('admin.rutasVendedor.create', compact('clientes', 'ruta'));

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RutasVendedor  $rutasVendedor
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RutasVendedor $ruta)
    {
        $info_nueva = $request->all();
        $new = json_encode($info_nueva);
        event(new ActualizacionBitacora($ruta->id, Auth::user()->id,'Edición',$ruta, $new,'RutaVendedor'));
        $ruta->observaciones = $request->observaciones_edit;
        $ruta->save();
        return response()->json(['success', 'exito']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RutasVendedor  $rutasVendedor
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $ruta = RutasVendedor::where('id', $id)->get();
        $ruta[0]->estado_id = 2;
        $ruta[0]->save();
        event(new ActualizacionBitacora($ruta[0]->id, Auth::user()->id,'Estado eliminado','','','RutaVendedor'));
        return response()->json(['success', 'exito']);
    }

    
    public function getFechas() {
        
        //Se obtiene el objeto con todos las rutas del vendedor loggeado
        //$rutas = RutasVendedor::where([['vendedor_id', Auth::user()->id],['estado_id', 1]])->get();
        $rutas = RutasVendedor::all();
        //Se convierte el objecto en array
        $arrayRutas = json_decode(json_encode($rutas), true);
        //Obtenemos el primer registro del vendedor
        $inicial = $arrayRutas[0]['fecha'];        
        //obtenemos el ultimo valor
        $ultimoValor = $arrayRutas[array_key_last($arrayRutas)];
        //Obtenemos el ultimo registro del
        $final = $ultimoValor['fecha'];
        $fechas = array($inicial, $final);
        return response()->json($fechas);
 

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

    //visita PDF
    public function visitaPDF(Request $request) {
        //fechas 
        $inicio = Carbon::parse($request->fechaInicial);
        $final = Carbon::parse($request->fechaFinal);
        //dd($final);
        //Visitas
        $visitas = RutasVendedor::whereBetween('fecha', [$inicio, $final])->where([['estado_id', 1],['vendedor_id', Auth::user()->id]])->get();
         foreach($visitas as $v) {
             $v->cliente;
             $v->ordenEquipo;
         }
        //dd($visitas);
        //generar PDF
        //dd($visitas);
        $pdf = \PDF::loadView('admin.rutasVendedor.visitaPDF', compact('visitas', 'inicio', 'final'))->setPaper('a4', 'landscape');;
        return $pdf->download('visitas' . strftime($request->fechaInicial) . '/' . strftime($request->fechaFinal) . '-' . Auth::user()->name . '.pdf');
        //$pdf = \PDF::loadView('admin.rutasVendedor.visitaPDF')->setPaper('a4', 'landscape');;
        //return $pdf->download('visitas.pdf');

    }
    
}
