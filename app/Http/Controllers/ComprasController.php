<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Events\ActualizacionBitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\IngresoMaestro;
use App\MovimientoProducto;
use App\IngresoDetalle;
use App\User;
use App\Proveedor;
use App\Producto;
use App\EstadoCuentaProveedor;
use App\CuentaPorPagarMaestro;
use App\CuentaPorPagarDetalle;

class ComprasController extends Controller
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
        return view('admin.compras.index');
    }

    public function getStrongJson() {

        $api_result['data'] = IngresoMaestro::where('estado_id', '1')->get();

        foreach($api_result['data'] as $ingreso) {
            $ingreso->proveedor;
        }

        return response()->json($api_result);
    }

    public function getProveedores() {
        $proveedores = Proveedor::where('estado', 1)->get();
        return response()->json($proveedores);
    }

    public function getProducto($codigo) {
          $producto = Producto::where('codigo', $codigo)->where('estado_id', 1)->get();
        
            return response()->json($producto);
         
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.compras.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(isset($_POST["fecha_factura"])) {
            $fecha_f = Carbon::parse($_POST["fecha_factura"]);
            $fecha_c = Carbon::parse($_POST["fecha_compra"]);
            $serie = $_POST["serie"];
            $user;
            $no_factura = $_POST["no_factura"];
            $proveedor = $_POST["proveedor"];
            $productos = $_POST["productos"];
            $total = $_POST["total"];
            
            //INGRESAR INGRESO MAESTRO
            $ingresoMaestro = IngresoMaestro::create([
                'user_id' => Auth::user()->id,
                'fecha_compra' => $fecha_c,
                'fecha_factura' => $fecha_f,
                'proveedor_id' => $proveedor,
                'serie_factura' => $serie,
                'num_factura' => $no_factura,
                'total' => $total,
            ]);
            //Iteracion de todos los productos y busqueda del id del producto
            for($i=0; $i<sizeof($productos); $i++) {
                $product = Producto::where('nombre', $productos[$i][0])->where('estado_id', 1)->get();
                //INGRESAR MOVIMIENTO PRODUCTO
                $movimientoP = MovimientoProducto::create([
                    'fecha_ingreso' => Carbon::now(),
                    'producto_id' => $product[0]->id,
                    'existencias' => $productos[$i][1],
                    'precio_compra' => $productos[$i][2],
                    'precio_venta' => $product[0]->precio_venta,
                    ]);
                    event(new ActualizacionBitacora($movimientoP->id, Auth::user()->id, 'Creación', '', $movimientoP,'Movimiento producto'));
                    //INGRESAR PRODUCTO / DETALLE
                    $ingresoD = IngresoDetalle::create([
                        'fecha_ingreso' => Carbon::now(),
                        'producto_id' => $product[0]->id,
                        'precio_compra' => $productos[$i][2],
                        'cantidad' => $productos[$i][1],
                        'subtotal' => $productos[$i][3],
                        'ingreso_maestro_id' => $ingresoMaestro->id,
                        'movimiento_producto_id' => $movimientoP->id,
                        ]);  
                    event(new ActualizacionBitacora($ingresoD->id, Auth::user()->id, 'Creación', '', $ingresoD,'Ingreso detalle'));
            }
            //Llenar tabla de estado_cuenta_proveedor
            $estadoCP = EstadoCuentaProveedor::create([
                'proveedor_id' => $proveedor,
                'documento_id' => $ingresoMaestro->id,
                'total' => $total,
            ]);
            //end for
            event(new ActualizacionBitacora($estadoCP->id, Auth::user()->id, 'Creación', '', $estadoCP,'Estado cuenta proveedor'));
            event(new ActualizacionBitacora($ingresoMaestro->id, Auth::user()->id, 'Creación', '', $ingresoMaestro,'IngresoMaestro'));

            //Agregar cuenta por pagar a Compra. 
            //Se obtienen la cuenta por pagar segun el proveedor
            $cuenta = CuentaPorPagarMaestro::where([['estado_id', '1'],['proveedor_id', $ingresoMaestro->proveedor_id]])->get();
                
            //Intero cada cuenta para obtener el proveedor
                //Si encuentra una relacion entre el id de cuenta Pagar y el de compra
                if(!empty($cuenta[0])) {
                    //Solo crear un nuevo cargo. Registro Detalle Cuentas Por Pagar
                    //Falta comprobar el total
                    //Obtengo el ultimo saldo del ultimo registro detalle
                    $last = CuentaPorPagarDetalle::latest()->where([['estado_id', 1],['cuenta_pagar_maestro_id', $cuenta[0]->id]])->first();

                    $cuentaDetalle = CuentaPorPagarDetalle::create([
                        'cuenta_pagar_maestro_id' => $cuenta[0]->id,
                        'tipo_transaccion_id' => 1,
                        'fecha_transaccion' => $ingresoMaestro->fecha_compra,
                        'compra_id' => $ingresoMaestro->id,
                        'total' => $ingresoMaestro->total,
                        'saldo' => $last->saldo + $ingresoMaestro->total,
                        'user_id' => Auth::user()->id,
                    ]);

                } else {

                    //Sino, creara tabla maestro y cargo, detalle.
                     $cuentaMaestro = CuentaPorPagarMaestro::create([
                        'proveedor_id' => $proveedor,
                        'user_id' => Auth::user()->id
                    ]);
                    //Agregar tabla Cuenta Por Pagar Maestro a Bitácora
                    event(new ActualizacionBitacora($cuentaMaestro->id, Auth::user()->id, 'Creación', '', $cuentaMaestro,'CuentaPorPagarMaestro'));

                    //Detalle cargo
                    $cuentaDetalle = CuentaPorPagarDetalle::create([
                        'cuenta_pagar_maestro_id' => $cuentaMaestro->id,
                        'tipo_transaccion_id' => 1,
                        'fecha_transaccion' => $ingresoMaestro->fecha_compra,
                        'compra_id' => $ingresoMaestro->id,
                        'total' => $ingresoMaestro->total,
                        'saldo' => $ingresoMaestro->total,
                        'user_id' => Auth::user()->id,
                    ]);
                }
                //Agregar tabla Cuenta Por Pagar Detalle a Bitácora
                    event(new ActualizacionBitacora($cuentaDetalle->id, Auth::user()->id, 'Creación', '', $cuentaDetalle,'CuentaPorPagarDetalle'));
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
       $compra = IngresoMaestro::where('id', $id)->where('estado_id', 1)->first();
       if(isset($compra)) {
           $compra->proveedor;
           $compra->user;
           return view('admin.compras.show', compact('compra'));
       } else {
           return view('notfound');
       }
    }

    public function getWeakJson($id) {

       // $compra = IngresoMaestro::where('id', $id)->where('estado_id', 1)->first();
       // $d = $compra->ingresosDetalle;
        $detalles = IngresoDetalle::where('ingreso_maestro_id', $id)->where('estado_id', 1)->get();
         foreach($detalles as $i) {
                 $i->producto;
                 $i->movimientoProducto;
            }    
            $api_result['data'] = $detalles;

       
        
        return response()->json($api_result);
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

    public function getCompra($id) {
        $compra = IngresoMaestro::where('id', $id)->get();

        return response()->json($compra);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $compra = IngresoMaestro::where('id', $request->id)->get();
        //Agregar a bitacora
        //Cambiar estado y poner a 0 cada movimientoProducto
        $detalles = IngresoDetalle::where('ingreso_maestro_id', $request->id)->get();
         foreach($detalles as $i) {
                 $i->movimientoProducto->existencias = 0;
                 //Agregar a bitacora al movimiento Producto
                 $i->movimientoProducto->estado_id = 2;
                 $i->movimientoProducto->save();
                 $i->estado_id = 2;
                 $i->save();
                 event(new ActualizacionBitacora($i->id, Auth::user()->id, 'Desactivacion', '', $i, 'ingresoDetalle'));
                 event(new ActualizacionBitacora($i->movimientoProducto->id, Auth::user()->id, 'Desactivacion', '', $i->movimientoProducto->id, 'MovimientoProducto'));
            }    
        //Cambiar estado y 0 la cuentaProveedor
        $cp = EstadoCuentaProveedor::where('documento_id', $request->id)->get();
        $cp[0]->total = 0;
        $cp[0]->estado_id = 2;
        $cp[0]->save();
        //Agregar a bitacora estado_cuenta_proveedor
        event(new ActualizacionBitacora($cp[0]->id, Auth::user()->id, 'Desactivacion', '', $cp[0], 'cuentaProveedor'));
        //Agregar a bitacora compra
        event(new ActualizacionBitacora($compra[0]->id, Auth::user()->id, 'Desactivacion', '', $compra[0], 'IngresoMaestro'));
        $compra[0]->estado_id = 2;
        $compra[0]->save();

        //Obtener la cuenta por Pagar de esta compra

        //Obtener el cargo a Revertir
        $cargo = CuentaPorPagarDetalle::where([['estado_id',1],['compra_id', $request->id]] )->get();
        $cargo[0]->estado_id = '2';
        $cargo[0]->save();
        //Ultimo registro
        $cuenta = CuentaPorPagarDetalle::latest()->where([['estado_id',1],['cuenta_pagar_maestro_id', $cargo[0]->cuenta_pagar_maestro_id]])->first();
        //Crear un nuevo detalle de cuentas por pagar
        $cuentaDetalle = new CuentaPorPagarDetalle;
        $cuentaDetalle->cuenta_pagar_maestro_id = $cargo[0]->cuenta_pagar_maestro_id;
        $cuentaDetalle->tipo_transaccion_id = '3';
        $cuentaDetalle->fecha_transaccion = Carbon::today();
        $cuentaDetalle->compra_id = $request->id;
        $cuentaDetalle->total = $compra[0]->total;
        $cuentaDetalle->saldo = $cuenta->saldo - $compra[0]->total;
        $cuentaDetalle->user_id = Auth::user()->id;
        $cuentaDetalle->save();
        

            //Agregar evento
        event(new ActualizacionBitacora($cuentaDetalle->id, Auth::user()->id, 'Creacion', '', $cuentaDetalle,'CuentaPorPagarDetalleRCargo'));

        //return response()->json(['success'=>'Exito']);
    }

    public function destroyDetail(Request $request) {
        $productoD = IngresoDetalle::where('id', $request->id)->get();

        //Actualizar total en estado_cuenta_proveedor
        $cuentaProveedor = EstadoCuentaProveedor::where('documento_id', $productoD[0]->ingreso_maestro_id)->get();
        $cuentaProveedor[0]->total = $cuentaProveedor[0]->total - $productoD[0]->subtotal;
        //Actualizar total de INGRESO MAESTRO
        $compra = IngresoMaestro::where('id', $productoD[0]->ingreso_maestro_id)->get();
        $compra[0]->total = $compra[0]->total - $productoD[0]->subtotal;
        //cambiar estado y pasar a cero las existencias de movimiento producto
        $mp = MovimientoProducto::where('id', $productoD[0]->movimiento_producto_id)->get();
        $mp[0]->existencias = 0;
        $mp[0]->estado_id = 2;

        //Agregar a bitacora al movimiento Producto
        event(new ActualizacionBitacora($mp[0]->id, Auth::user()->id, 'Desactivacion', '', $mp[0], 'MovimientoProducto'));
        //Agregar a bitacora el detalle producto
        event(new ActualizacionBitacora($productoD[0]->id, Auth::user()->id, 'Desactivacion', '', $productoD[0], 'IngresoDetalle'));
        $productoD[0]->estado_id = 2;
        $productoD[0]->save();
        //Agregar a bitacora estado_cuenta_proveedor
        event(new ActualizacionBitacora($cuentaProveedor[0]->id, Auth::user()->id, 'Desactivacion', '', $cuentaProveedor[0], 'cuentaProveedor'));
        $cuentaProveedor[0]->save();
        $mp[0]->save();
        if($compra[0]->total == 0) {
            $compra[0]->estado_id = 2;
        }
        $compra[0]->save();
        

    }
}
