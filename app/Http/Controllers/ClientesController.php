<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use App\User;
use App\Cliente;
use App\Events\ActualizacionBitacora;
use App\tipo_cliente;
use App\Empleado;
use App\estados;
use Validator;

class ClientesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function __construct()
     {
        $this->middleware('auth');
     }
 
 
     public function index()
     {
         return view ("admin.clientes.index");
     }
 
     /**
      * Show the form for creating a new resource.
      *
      * @return \Illuminate\Http\Response
      */
     public function create()
     {
        $tipo_cliente = tipo_cliente::all();
        $empleado = Empleado::where("puesto_id", 1)->get();
        return view("admin.clientes.create" , compact('tipo_cliente', 'empleado'));
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
         $data["user_id"] = Auth::user()->id;
         $data["estado_id"] = 1;
         $cliente = Cliente::create($data);
        
         event(new ActualizacionBitacora($cliente->id, Auth::user()->id,'Creación','', $cliente,'clientes'));
         return redirect()->route('clientes.index')->withFlash('El cliente ha sido creado exitosamente!');
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
     public function nitDisponible()
     {
         $dato = Input::get("nit");
         $query = Cliente::where("nit",$dato)->get();
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
      * Show the form for editing the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function edit(Cliente $cliente)
     {
        $tipo_cliente = tipo_cliente::all();
        $empleado = Empleado::where("puesto_id", 1)->get();
        return view('admin.clientes.edit', compact('cliente', 'tipo_cliente', 'empleado'));
     }
 
     /**
      * Update the specified resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function update(Cliente $cliente, Request $request)
     {

        $this->validate($request,['nit' => 'required'
        ]);

        $nuevos_datos = array(
            'nit' => $request->nit,
            'tipocliente_id' => $request->tipocliente_id,
            'empleado_id' => $request->empleado_id,
            'nombre_fiscal' => $request->nombre_fiscal,
            'nombre_comercial' => $request->nombre_comercial,
            'telefono' => $request->telefono,
            'correo_electronico' => $request->correo_electronico,
            'fecha_imp' => $request->fecha_imp,
            'ubicacion' => $request->ubicacion,
            'direccion' => $request->direccion,
            'nombre_contacto1' => $request->nombre_contacto1,
            'puesto_contacto1' => $request->puesto_contacto1,
            'telefono_contacto1' => $request->telefono_contacto1,
            'correo_contacto1' => $request->correo_contacto1,
            'nombre_contacto2' => $request->nombre_contacto2,
            'puesto_contacto2' => $request->puesto_contacto2,
            'telefono_contacto2' => $request->telefono_contacto2,
            'correo_contacto2' => $request->correo_contacto2,
            );
        $json = json_encode($nuevos_datos);
 
        event(new ActualizacionBitacora($cliente->id, Auth::user()->id,'Edición',$cliente, $json,'clientes'));

        $cliente->update($request->all());
      
        return redirect()->route('clientes.index', $cliente)->with('flash','El cliente ha sido actualizado!');
     }
  
     /**
      * Remove the specified resource from storage.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function destroy(Request $request)
     {
        $cliente = Cliente::where('id',$request->id)->first();
        $cliente->estado_id = 2;
        $cliente->save();
        
        event(new ActualizacionBitacora($cliente->id, Auth::user()->id,'Inactivación', '', '', 'Cliente'));
        
        return response()->json(['success'=>'Éxito']);
     }

     public function activar(Cliente $cliente)
     {
        $cliente->estado_id = 1;
        $cliente->save();
        event(new ActualizacionBitacora($cliente->id, Auth::user()->id,'Activación','','','Cliente'));
        return response()->json(['success' => 'Éxito']);        
     }
      
     public function getJson(Request $params)
     {
         $api_Result['data'] = Cliente::all();
 
         return Response::json( $api_Result );
     }
}
