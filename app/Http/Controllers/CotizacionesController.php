<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Events\ActualizacionBitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Cliente;
use App\Servicio;
use App\CotizacionMaestro;
use App\CotizacionDetalle;
use App\Producto;
use DateTime;

class CotizacionesController extends Controller
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
        return view('admin.cotizaciones.index');
    }

    //
    public function getStrongJson() {

        $api_result['data'] = CotizacionMaestro::where('estado_id', '1')->get();

        foreach($api_result['data'] as $cot) {
            $cot->cliente;
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
        return view('admin.cotizaciones.create');
    }

    public function getProducto($codigo) {
          $producto = Producto::where('codigo', $codigo)->where('estado_id', 1)->get();
        
            return response()->json($producto);
         
    }

    public function getClientes() {
         $clientes = Cliente::where('estado_id', 1)->get();
        
            return response()->json($clientes);
    }

    public function getServicios() {
         $servicios = Servicio::where('estado_id', 1)->get();
        
            return response()->json($servicios);
    }

     public function getServicio($id) {
          $servicio = Servicio::where('id', $id)->where('estado_id', 1)->get();
        
            return response()->json($servicio);   
    }

    public function getCliente($id) {
          $cliente = Cliente::where('id', $id)->where('estado_id', 1)->get();
        
            return response()->json($cliente);   
    }


     /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        if(isset($_POST["fecha"])) {
            
            $fecha = Carbon::parse($_POST["fecha"]);
            $cliente_id = $_POST["cliente"];
            $bienes = $_POST["bienes"];
            $total = $_POST["total"];

            //Condicionar que numero corresponde
            $today = Carbon::today()->format('Y-m-d');
            $year = Carbon::today()->year;

            $last = DB::table('cotizaciones_maestro')->latest('created_at')->first();
            if(isset($last)) {
                    
                $newYear = $last->anio . '-01-01';
                
                if($today == $newYear && $last->anio != $year) {
                    //Si hoy es anio nuevo y el ultimo registro es del anio pasado
                    $cotizacionMaestro = CotizacionMaestro::create([
                        'no_cotizacion' => 1,
                        'cliente_id' => $cliente_id,
                        'anio' => $year,
                        'fecha' => $fecha,
                        'total' => $total,
                    ]);
                } else if($today == $newYear && $last->anio == $year) {
                    //Aun es 1 de enero pero ya hay registros del anio nuevo
                    $cotizacionMaestro = CotizacionMaestro::create([
                        'no_cotizacion' => $last->no_cotizacion + 1,
                        'cliente_id' => $cliente_id,
                        'anio' => $year,
                        'fecha' => $fecha,
                        'total' => $total,
                    ]);
                } else {
                    //Cualquier otro dia del anio
                    $cotizacionMaestro = CotizacionMaestro::create([
                        'no_cotizacion' => $last->no_cotizacion + 1,
                        'cliente_id' => $cliente_id,
                        'anio' => $year,
                        'fecha' => $fecha,
                        'total' => $total,
                    ]);
                }
            } else {
                //Es el primer registro
                    $cotizacionMaestro = CotizacionMaestro::create([
                        'no_cotizacion' => 1,
                        'cliente_id' => $cliente_id,
                        'anio' => $year,
                        'fecha' => $fecha,
                        'total' => $total,
                    ]);
            }
            
            //Interar para ingreso de productos / servicios a CotizacionDetalle
             for($i=0; $i<sizeof($bienes); $i++) { 
                 
                $product = Producto::where('nombre', $bienes[$i][0])->where('estado_id', 1)->get();
                $counter = count($product);
                if($counter == 1) {
                    //Si es un producto
                    //Ingresar producto a tabla detalle
                    $ingresoD = CotizacionDetalle::create([
                        'producto_id' => $product[0]->id,
                        'cantidad' => $bienes[$i][1],
                        'precio' => $bienes[$i][2],
                        'isProduct' => 1,
                        'subtotal' => $bienes[$i][3],
                        'cotizacion_maestro_id' => $cotizacionMaestro->id,
                        ]);  
                        
                    } else if($counter == 0) {
                    $servicio = Servicio::where('nombre', $bienes[$i][0])->where('estado_id', 1)->get();
                    if(count($servicio) == 1) {
                        //Si es un servicio
                        $ingresoD = CotizacionDetalle::create([
                            'servicio_id' => $servicio[0]->id,
                            'cantidad' => $bienes[$i][1],
                            'precio' => $bienes[$i][2],
                            'subtotal' => $bienes[$i][3],
                            'isProduct' => 0,
                            'cotizacion_maestro_id' => $cotizacionMaestro->id,
                            ]); 
                    }
                }
                //Ya ingresado detalle
                event(new ActualizacionBitacora($ingresoD->id, Auth::user()->id, 'Creación', '', $ingresoD,'CotizacionDetalle'));
                
            }
            //Bitacora para Cotizacion creada
            event(new ActualizacionBitacora($cotizacionMaestro->id, Auth::user()->id, 'Creación', '', $cotizacionMaestro,'CotizacionMaestro'));
        }
    }

     /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $cot = CotizacionMaestro::where('id', $id)->where('estado_id', 1)->first();
       if(isset($cot)) {
           $cot->cliente;
           return view('admin.cotizaciones.show', compact('cot'));
       } else {
           return view('notfound');
       }
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

    //Generador de PDF
    public function getPDF($id) {

        $data = [];
        $cot = CotizacionMaestro::where('id', $id)->where('estado_id', 1)->first();
        $cot->cliente;
        

        $detalles = CotizacionDetalle::where('cotizacion_maestro_id', $id)->where('estado_id', 1)->get();
         foreach($detalles as $i) {
                 $i->producto;
                 $i->servicio;
            }
        //Obtengo el mes en un array
        $arrayMonthNumber = DB::select('select month(fecha) mes from cotizaciones_maestro where id =?', [$id]);
        //Obtengo el mes numero
        $monthName = $this->obtenerMes($arrayMonthNumber[0]->mes);
    
        $pdf = \PDF::loadView('admin.cotizaciones.vistaPDF', ['head' => $cot, 'detalles' => $detalles, 'fecha' => $monthName]);
        return $pdf->download('cotizacion' . '00' . $cot->no_cotizacion. $cot->anio . '.pdf');
    } 

    public function edit($cot) {
        $cotizacion = CotizacionMaestro::where('id', $cot)->where('estado_id', 1)->get();

        $cotizacion[0]->cliente;
        //return response()->json($cotizacion);
        return view('admin.cotizaciones.edit', compact('cotizacion'));
    }


    //Actualizar Cotizacion
    public function update($cotizacion) {   

        parse_str(file_get_contents("php://input"), $data);

        $object = (object) $data;
        $cot = CotizacionMaestro::where('id', $cotizacion)->get();
        if(isset($object->bienesEliminados)) {

            if(isset($object->bienes) ) {

                //lo que significa que hay datos que deben actualizarse
               // return "Debo eliminar datos y guardar en la base de datos los nuevos";
                
                for($a=0; $a<sizeof($cot[0]->cotizacionesDetalle); $a++) {
                    
                    for($i=0; $i<sizeof($object->bienesEliminados); $i++) { 
                        $nombre = $object->bienesEliminados[$i];
                        
                        
                    //Aqui recorrere todos los detalles, hasta encontrar un IDPRODUCTO IGUAL

                    if($cot[0]->cotizacionesDetalle[$a]->producto_id != null) {
                        //Buscar producto por nombre
                        $p = Producto::where('nombre', $nombre)->get();
                        if(!empty($p[0])) {
                            if($cot[0]->cotizacionesDetalle[$a]->producto_id == $p[0]->id) {
                                
                                $cot[0]->cotizacionesDetalle[$a]->estado_id = 2;
                                $cot[0]->cotizacionesDetalle[$a]->save();
                        }
                        }
                    
                    } 
                    if ($cot[0]->cotizacionesDetalle[$a]->servicio_id != null){
                        //Buscar servicio por nombre
                        $s = Servicio::where('nombre', $nombre)->get();
                         if(!empty($s[0])) {
                            if($cot[0]->cotizacionesDetalle[$a]->servicio_id == $s[0]->id) {

                            $cot[0]->cotizacionesDetalle[$a]->estado_id = 2;
                            $cot[0]->cotizacionesDetalle[$a]->save();
                        }
                         }

                    }
                
                }

               }
                //
               for($i=0; $i<sizeof($object->bienes); $i++) { 
                 
                if($object->bienes[$i][0] != "") {
                    $product = Producto::where('nombre', $object->bienes[$i][1])->where('estado_id', 1)->get();
                    $counter = count($product);
                    if($counter == 1) {
                        //Si es un producto
                        //Ingresar producto a tabla detalle
                        $ingresoD = CotizacionDetalle::where([['producto_id', $product[0]->id], ['cotizacion_maestro_id', $cot[0]->id]])->get(); 
                        $ingresoD[0]->cantidad = (int) $object->bienes[$i][2];
                        $ingresoD[0]->precio = (float) $object->bienes[$i][3];
                        $ingresoD[0]->subtotal = (float) $object->bienes[$i][4];
                        $ingresoD[0]->estado_id = 1;
                        $ingresoD[0]->save();

                    } else if($counter == 0) {
                        $servicio = Servicio::where('nombre', $object->bienes[$i][1])->where('estado_id', 1)->get();
                        
                        if(count($servicio) == 1) {
                            //Si es un servicio
                            $ingresoD = CotizacionDetalle::where([['servicio_id', $servicio[0]->id], ['cotizacion_maestro_id', $cot[0]->id]])->get(); 
                            $ingresoD[0]->cantidad = (int) $object->bienes[$i][2];
                            $ingresoD[0]->precio = (float) $object->bienes[$i][3];
                            $ingresoD[0]->subtotal = (float) $object->bienes[$i][4];
                             $ingresoD[0]->estado_id = 1;
                            $ingresoD[0]->save();
                        }
                    }
                    
                } else {
                    $product = Producto::where('nombre', $object->bienes[$i][1])->where('estado_id', 1)->get();
                    $counter = count($product);
                    if($counter == 1) {
                        //Si es un producto
                        //Ingresar producto a tabla detalle
                        $ingresoD = CotizacionDetalle::create([
                            'producto_id' => $product[0]->id,
                            'cantidad' => (int) $object->bienes[$i][2],
                            'precio' => (float) $object->bienes[$i][3],
                            'isProduct' => 1,
                            'subtotal' => (float) $object->bienes[$i][4],
                            'cotizacion_maestro_id' => $cot[0]->id,
                        ]);  

                    } else if($counter == 0) {
                        $servicio = Servicio::where('nombre', $object->bienes[$i][1])->where('estado_id', 1)->get();
                        if(count($servicio) == 1) {
                            //Si es un servicio
                            $ingresoD = CotizacionDetalle::create([
                            'servicio_id' => $servicio[0]->id,
                            'cantidad' => (int) $object->bienes[$i][2],
                            'precio' => (float) $object->bienes[$i][3],
                            'subtotal' => (float) $object->bienes[$i][4],
                            'isProduct' => 0,
                            'cotizacion_maestro_id' => $cot[0]->id,
                        ]); 

                        }
                    }
                }


                //Ya ingresado detalle
                //Comprobar si bienes tiene ID
               
            }
                //

            } else {
                //Debe unicamente eliminar datos
 
                for($a=0; $a<sizeof($cot[0]->cotizacionesDetalle); $a++) {
                    
                    for($i=0; $i<sizeof($object->bienesEliminados); $i++) { 
                    $nombre = $object->bienesEliminados[$i];
                        
                        
                    //Aqui recorrere todos los detalles, hasta encontrar un IDPRODUCTO IGUAL

                    if($cot[0]->cotizacionesDetalle[$a]->producto_id != null) {
                        //Buscar producto por nombre
                        $p = Producto::where('nombre', $nombre)->get();
                        if(!empty($p[0])) {
                             if($cot[0]->cotizacionesDetalle[$a]->producto_id == $p[0]->id) {

                            $cot[0]->cotizacionesDetalle[$a]->estado_id = 2;
                            $cot[0]->cotizacionesDetalle[$a]->save();
                        }
                        }
                       
                    //Que pasa si el objeto p no lleva ningun dato?
                    } 
                    if ($cot[0]->cotizacionesDetalle[$a]->servicio_id != null){
                        //Buscar servicio por nombre
                        $s = Servicio::where('nombre', $nombre)->get();
                        if(!empty($s[0])) {
                            if($cot[0]->cotizacionesDetalle[$a]->servicio_id == $s[0]->id) {

                            $cot[0]->cotizacionesDetalle[$a]->estado_id = 2;
                            $cot[0]->cotizacionesDetalle[$a]->save();
                        }
                        } 
                        

                    }
                
                }
                

               }
            
              //  return "Solo eliminar los datos";
            }
            
        } else if(isset($object->bienes)){
            //Tenes solo nuevos datos
             //Interar para ingreso de productos / servicios a CotizacionDetalle
             for($i=0; $i<sizeof($object->bienes); $i++) { 
               
                if($object->bienes[$i][0] != "") {
                    $product = Producto::where('nombre', $object->bienes[$i][1])->where('estado_id', 1)->get();
                    $counter = count($product);
                    if($counter == 1) {
                        //Si es un producto
                        //Ingresar producto a tabla detalle
                        $ingresoD = CotizacionDetalle::where([['producto_id', $product[0]->id], ['cotizacion_maestro_id', $cot[0]->id]])->get(); 
                        $ingresoD[0]->cantidad = (int) $object->bienes[$i][2];
                        $ingresoD[0]->precio = (float) $object->bienes[$i][3];
                        $ingresoD[0]->subtotal = (float) $object->bienes[$i][4];
                        $ingresoD[0]->estado_id = 1;
                        $ingresoD[0]->save();
                    } else if($counter == 0) {
                        $servicio = Servicio::where('nombre', $object->bienes[$i][1])->where('estado_id', 1)->get();
                        if(count($servicio) == 1) {

                            //Si es un servicio
                            $ingD = CotizacionDetalle::where([['servicio_id', $servicio[0]->id], ['cotizacion_maestro_id', $cot[0]->id]])->get();   
                             
                            $ingD[0]->update([
                                'cantidad'=> (int) $object->bienes[$i][2], 
                                'precio'=> (float) $object->bienes[$i][3], 
                                'subtotal'=> (float) $object->bienes[$i][4]
                                ]);
                        }
                    }
                } else {
                    $product = Producto::where('nombre', $object->bienes[$i][1])->where('estado_id', 1)->get();
                $counter = count($product);
                if($counter == 1) {
                    //Si es un producto
                    //Ingresar producto a tabla detalle
                    $ingresoD = CotizacionDetalle::create([
                        'producto_id' => $product[0]->id,
                        'cantidad' => $object->bienes[$i][2],
                        'precio' => $object->bienes[$i][3],
                        'isProduct' => 1,
                        'subtotal' => $object->bienes[$i][4],
                        'cotizacion_maestro_id' => $cot[0]->id,
                    ]);  

                } else if($counter == 0) {
                    $servicio = Servicio::where('nombre', $object->bienes[$i][1])->where('estado_id', 1)->get();
                    if(count($servicio) == 1) {
                        //Si es un servicio
                        $ingresoD = CotizacionDetalle::create([
                        'servicio_id' => $servicio[0]->id,
                        'cantidad' => $object->bienes[$i][2],
                        'precio' => $object->bienes[$i][3],
                        'subtotal' => $object->bienes[$i][4],
                        'isProduct' => 0,
                        'cotizacion_maestro_id' => $cot[0]->id,
                    ]); 
                    }
                }
                //Ya ingresado detalle
               
                }
                
            }
          // return "solo guardar nuevos datos";
        }


        $cot[0]->fecha = Carbon::parse($object->fecha);
        $cot[0]->cliente_id = $object->cliente;
        $cot[0]->total = $object->total;
        $cot[0]->save();
        event(new ActualizacionBitacora($cot[0]->id, Auth::user()->id, 'Actualizacion', '', $cot[0], 'CotizacionMaestro'));
            //return "Solo actualizar CotizacionMaestro";
        
        

        return response()->json(['success'=> 'exito']);
    }
    

    public function getWeakJson($id) {

        $detalles = CotizacionDetalle::where('cotizacion_maestro_id', $id)->where('estado_id', 1)->get();
         foreach($detalles as $i) {
                 $i->producto;
                 $i->servicio;
            }    
            $api_result['data'] = $detalles;

       
        
        return response()->json($api_result);
    }


        public function destroy(Request $request)
    {
        $cot = CotizacionMaestro::where('id', $request->id)->get();
        //Agregar a bitacora
        //Cambiar estado y poner a 0 cada movimientoProducto
        $detalles = CotizacionDetalle::where('cotizacion_maestro_id', $request->id)->get();
         foreach($detalles as $i) {
                 //Agregar a bitacora al eliminar
                 $i->estado_id = 2;
                 $i->save();
                 event(new ActualizacionBitacora($i->id, Auth::user()->id, 'Desactivacion', '', $i, 'ingresoDetalle'));
        }    
    
        //Agregar a bitacora compra
        event(new ActualizacionBitacora($cot[0]->id, Auth::user()->id, 'Desactivacion', '', $cot[0], 'CotizacionMaestro'));
        $cot[0]->estado_id = 2;
        $cot[0]->save();

    }

    public function getCotizacion($id) {
        $cot = CotizacionMaestro::where('id', $id)->where('estado_id', '1')->get();

        return response()->json($cot);
    }

    public function destroyDetailUpdate(Request $request) {
        $productoD = CotizacionDetalle::where('id', $request->id)->get();

        //Actualizar total de COTIZACION MAESTRO
        $cot = CotizacionMaestro::where('id', $productoD[0]->cotizacion_maestro_id)->get();
        $cot[0]->total = $cot[0]->total - $productoD[0]->subtotal;
       
        //Agregar a bitacora el detalle producto
        event(new ActualizacionBitacora($productoD[0]->id, Auth::user()->id, 'Desactivacion', '', $productoD[0], 'CotizacionDetalle'));
        $productoD[0]->estado_id = 2;
        $productoD[0]->save();
        $cot[0]->save();
    }


    public function destroyDetail(Request $request) {
        $productoD = CotizacionDetalle::where('id', $request->id)->get();

        //Actualizar total de COTIZACION MAESTRO
        $cot = CotizacionMaestro::where('id', $productoD[0]->cotizacion_maestro_id)->get();
        $cot[0]->total = $cot[0]->total - $productoD[0]->subtotal;
       
        //Agregar a bitacora el detalle producto
        event(new ActualizacionBitacora($productoD[0]->id, Auth::user()->id, 'Desactivacion', '', $productoD[0], 'CotizacionDetalle'));
        $productoD[0]->estado_id = 2;
        $productoD[0]->save();
        if($cot[0]->total == 0) {
            $cot[0]->estado_id = 2;
        }
        $cot[0]->save();
    }
}
