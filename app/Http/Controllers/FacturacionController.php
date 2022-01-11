<?php

namespace App\Http\Controllers;

use App\Facturacion;
use Illuminate\Http\Request;
use App\OrdenEquipo;
use App\Cliente;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Events\ActualizacionBitacora;
use DB;
class FacturacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $ordenesSinFactura = DB::select('SELECT o.*, e.equipo FROM ordenequipo o 
                                        INNER JOIN equipos e ON e.id = o.equipo_id WHERE o.estado_orden_trabajo_id = 13 AND o.id NOT IN (select orden_id from facturacions where estado_id = :estado_id)', ['estado_id' => 1]);
        return view('admin.facturacion.index',compact('ordenesSinFactura'));
    }

    /**

     * Listado de Tabla Facturacion en JSON
     */
    public function getJson() {

        $api_result['data'] = Facturacion::all();
        
    
        foreach($api_result['data'] as $fac) {    
            $fac->clienteR;
            $fac->orden;
            $fac->estado;
        }
        

        return response()->json($api_result);        
    
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
        $orden = OrdenEquipo::where('id', $data['ordenes'])->get();
        $factura = new Facturacion;
        $factura->no_factura = $data['no_factura'];
        $factura->serie = $data['serie'];
        $factura->direccion = $data['direccion'];
        if(isset($data['nit']) && isset($data['cliente'])) {
            if($data['nit'] != $orden[0]->clientes->nit) {
                    $factura->cliente = $data['cliente'];
                    $factura->nit = $data['nit'];
                } else if($data['nit'] == $orden[0]->clientes->nit){
                    $factura->cliente_id = $orden[0]->cliente_id;
            }
        } else{
            $factura->nit = "Consumidor Final";

        }
        $factura->fecha = Carbon::today();    
        $factura->monto = $orden[0]->total_cobrar;
        $factura->orden_id = $orden[0]->id;
        $factura->save();
        if($factura){
            return response()->json(array('success' => 'Exito'), 200);
        }       
        //bitacora
        event(new ActualizacionBitacora($factura->id, Auth::user()->id,'Creación','', $factura,'Facturacion'));

    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Facturacion  $facturacion
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, Request $request)
    {
        $data = $request->all();
        $o = Facturacion::where('id',$id)->get();
        $o[0]->eliminadaDesc = $data['razon'];
        $o[0]->estado_id = 2;
        $o[0]->save();
        event(new ActualizacionBitacora($o[0]->id, Auth::user()->id,'Anulación','','','Facturacion'));
        return response()->json(array('success' => 'Exito'), 200);

    }


    public function clienteOrden($id) {
        $orden = OrdenEquipo::where('id', $id)->get();
        $cliente = Cliente::where('id', $orden[0]->cliente_id)->get();

        return response()->json($cliente);
    }

    public function numDisponible() {
        $dato = Input::get('no_factura');
        $query = Facturacion::where('no_factura', $dato)->get();
        $counter = count($query);
        if($counter === 0) {
            return 'false';
        } else {
            return 'true';
        }
    }

    //
    public function facturaDisponible() {
        $dato = Input::get('serie=');
        $dato2 = Input::get('no_factura=');
        $query = Facturacion::where([['serie', $dato],['no_factura', $dato2]])->get();
        $counter = count($query);
        if($counter === 0) {
            return 'false';
        } else {
            return 'true';
        }
    }

    public function printBill($id) {
          //try { 
                  //Obtener cheque
                $factura = Facturacion::where('id', $id)->get();
               
                include 'Num2Txt.php';
                $o = new  \Alp3476\Num2Txt();
                $number = $factura[0]->monto;
                //Formatea a solo dos centavos el numero completo
                $n = number_format((float)$number, 2, '.', '');
                //Se obtiene los centavos
                $centavos = substr($n, strpos($n, ".") + 1);    
                if($centavos > 0) {
                    //Aqui esta todo convertido a texto
                    $texto = strtoupper($o->toString($n)) . " CENTAVOS"; 
                    //echo '    cantidades expresadas en quetzales';
                } else {
                    $texto = strtoupper($o->toString($n)) . " EXACTOS";
                    //echo '   cantidades expresadas en quetzales';
                }
                //FECHA
                $date = explode('-', $factura[0]->fecha);
                $anio   = $date[0];
                $mes   = $date[1];
                $dia  = $date[2];
                $pdf = \PDF::loadView('admin.facturacion.facturaPDF', ['factura' => $factura, 'letras' => $texto, 'dia' => $dia, 'mes' =>  $mes, 'anio' => $anio]);
                return $pdf->download('factura-No-' . $factura[0]->no_factura . '-Serie-' . $factura[0]->serie . '.pdf');
              
            //} catch(Exception $e) {

            //} finally{ 
                 $this->printed($id);

                //return redirect()->route('cheques.index')->withFlash('El Cheque se generará en segundos');

            //}
    }
}
