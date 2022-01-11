<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use App\Events\ActualizacionBitacora;
use App\User;
use App\Producto;

class ProductosController extends Controller
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
        return view('admin.productos.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.productos.create');
    }

    //
    public function codigoDisponible()
        {
            $dato = Input::get("codigo");
            $query = Producto::where("codigo",$dato)
                            ->where('estado_id', 1)->get();
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
    public function codigoDisponibleEdit()
    {
        $dato = Input::get("codigo");
        $id = Input::get('id');

        $query = Producto::where("codigo",$dato)
                        ->where('estado_id', 1)
                        ->where('id','!=', $id)->get();
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
    public function nombreDisponible()
    {
        $dato = Input::get("producto");
        $query = Producto::where("nombre",$dato)
                        ->where('estado_id', 1)->get();
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

    public function nombreDisponibleEdit()
    {
        $dato = Input::get("producto");
        $id = Input::get('id');

        $query = Producto::where("nombre",$dato)
                        ->where('estado_id', 1)
                        ->where('id','!=', $id)->get();
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $producto = new Producto;
        $producto->codigo = $request->codigo;
        $producto->nombre = $request->producto;
        $producto->observaciones = $request->observaciones;
        $producto->stock_minimo = $request->stock_minimo;
        $producto->stock_maximo = $request->stock_maximo;
        $producto->precio_venta = $request->precio_venta;
        $producto->save();

        event(new ActualizacionBitacora($producto->id, Auth::user()->id,'Creación','', $producto,'productos'));
        return redirect()->route('productos.index')->withFlash('¡El producto ha sido creado exitosamente!');
    
    }

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
    public function edit(Producto $producto)
    {
        $producto->stock_minimo =  (float)$producto->stock_minimo;
        return view('admin.productos.edit', compact('producto'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Producto $producto)
    {
        $newInfo = array();

        $new = json_encode($newInfo);
        event(new ActualizacionBitacora($producto->id, Auth::user()->id,'Edición',$producto, $new,'productos'));
        $producto->update($request->all());
        
        return redirect()->route('productos.index', $producto)->withFlash('El producto ha sido actualizado correctamente');
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $pro = Producto::where('id', $request->id)->first();
        $pro->estado_id = 2;
        $pro->save();
         event(new ActualizacionBitacora($pro->id, Auth::user()->id,'Inactivación','','','productos'));
        return Response::json(['success' => 'Éxito']);
    
    }

    /**
     * activar un producto
     */

    public function activar(Producto $producto) {
        
        $producto->estado_id = 1;
        $producto->save();
        event(new ActualizacionBitacora($producto->id, Auth::user()->id,'Activación','','','productos'));
        return Response::json(['success' => 'Éxito']);       
     }

    /**
     * Obtener productos
     */

    public function getJson() {
        
        $api_Result['data'] = Producto::all();

        return response()->json($api_Result);
    }
}
