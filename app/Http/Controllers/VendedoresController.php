<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Response;
use App\Events\ActualizacionBitacora;
use App\User;
use App\Vendedor;

class VendedoresController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function __construct() {
         $this->middleware('auth');
    }

    public function index()
    {
        return view('admin.vendedores.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        return view('admin.vendedores.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        //validar
        $data = $request->all();
        $vendedor = Vendedor::create($data);
        event(new ActualizacionBitacora($vendedor->id, Auth::user()->id,'Creación','', $vendedor,'vendedores'));
        return redirect()->route('vendedores.index')->withFlash('¡El vendedor ha sido creado exitosamente!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id) {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Vendedor $vendedor) {
        //
        return view('admin.vendedores.edit', compact('vendedor'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Vendedor $vendedor) {
        //
         $this->validate($request,['nit' => 'unique:vendedores,nit,'.$vendedor->id
        ]);
        //Request 
        $info_nueva = array(
            'nombres' => $request->nombres,
            'apellidos' => $request->apellidos,
            'nit' => $request->nit,
            'direccion' => $request->direccion,
            'celular' => $request->celular,
            'correo' => $request->correo,
            'comision' => $request->comision,
        );
        $new = json_encode($info_nueva);
        event(new ActualizacionBitacora($vendedor->id, Auth::user()->id,'Edición',$vendedor, $new,'vendedores'));
        $vendedor->update($request->all());
        return redirect()->route('vendedores.index', $vendedor)->withFlash('El vendedor ha sido actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        
        $ven = Vendedor::where('id', $request->id)->first();
        $ven->estado_id = 2;
        $ven->save();
         event(new ActualizacionBitacora($ven->id, Auth::user()->id,'Inactivación','','','vendedores'));
        return Response::json(['success' => 'Éxito']);
    }

    /**
     *  Active a seller
     */
    public function activar(Vendedor $vendedor)
     {
        $vendedor->estado_id = 1;
        $vendedor->save();
        event(new ActualizacionBitacora($vendedor->id, Auth::user()->id,'Activación','','','vendedores'));
        return Response::json(['success' => 'Éxito']);       
     }
    /**
     * Get a json format data from Vendedores table
     */
    public function getSellerJson() {
        
        $api_Result['data'] = Vendedor::all();

        return response()->json($api_Result);
    }

    /**
     * 
     */
    public function nitDisponible()
     {
         $nit = Input::get("nit");
         $query = Vendedor::where("nit",$nit)->get();
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
}
