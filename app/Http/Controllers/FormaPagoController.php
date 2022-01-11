<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Events\ActualizacionBitacora;
use App\User;
use App\FormaPago;

class FormaPagoController extends Controller
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


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.formaPago.index');
    }

    /**
     * Get the forma de pago json 
     */

     public function getJson() {
        $api_result['data'] = FormaPago::where('estado_id', '1')->get();
        return response()->json($api_result);
     }

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

        $formaP = new FormaPago;
        $formaP->nombre = $data['nombre'];
        $formaP->save();
        event(new ActualizacionBitacora($formaP->id, Auth::user()->id,'Creación','',$formaP,'formaPago'));

        return response()->json(['success' => 'Éxito']);

    }

    /**
     * 
     */

    public function nombreDisponible()
    {
        $dato = Input::get("nombre");
        $query = FormaPago::where("nombre",$dato)->where('estado_id', '1')->get();
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
     * 
     */

    public function nombreDisponibleEdit()
    {
        $dato = Input::get("nombre");
        $id = Input::get('id');

        $query = FormaPago::where("nombre",$dato)
                        ->where('id','!=', $id)->where('estado_id', '1')->get();
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
    public function update(Request $request, FormaPago $formaPago)
    {
        $new = $request->all();
        //Save Bitacora
        event(new ActualizacionBitacora($formaPago->id, Auth::user()->id,'Edición',$formaPago->nombre, $new['nombre'],'formaPago'));
        $formaPago->nombre = $request->nombre;
        $formaPago->save();

        return response()->json(['success' => 'Éxito']);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $formaP = FormaPago::where('id', $request->id)->first();
        $formaP->estado_id = 2;
        $formaP->save();
        event(new ActualizacionBitacora($formaP->id, Auth::user()->id,'Inactivación','','','formaPago'));
        return Response::json(['success' => 'Éxito']);
    
    }

    /**
     *  Active
     */
    public function activar(FormaPago $formaPago)
     {
        //echo 'hola';
        $formaPago->estado_id = 1;
        $formaPago->save();
        event(new ActualizacionBitacora($formaPago->id, Auth::user()->id,'Activación','','','formaPago'));
        return response()->json(['success' => 'Éxito']);       
     }
}
