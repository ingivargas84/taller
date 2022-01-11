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
use App\Visita;
use App\Cliente;
use App\Events\ActualizacionBitacora;
use Validator;

class VisitaController extends Controller
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
        return view ("admin.visitas.index");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $clientes = Cliente::Where("estado_id",1)->orderBy("id","ASC")->get();

        return view('admin.visitas.create', compact('clientes'));
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
        $visita = Visita::create($data);
        $visita->user_id = Auth::user()->id;
        $visita->estado = 1;
        $visita->save();
       
        event(new ActualizacionBitacora($visita->id, Auth::user()->id,'Creación','', $visita,' visitas'));
        return redirect()->route('visitas.index')->withFlash('La visita ha sido creada exitosamente!');
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
    public function edit(Visita $visita)
    {
        $clientes = Cliente::Where("estado_id",1)->orderBy("id","ASC")->get();
        return view('admin.visitas.edit', compact('clientes','visita'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Visita $visita)
    {
        $this->validate($request,[
            'cliente_id'=>'required',
            'observaciones'=>'required',
        ]);

        $nuevos_datos = array(
            'cliente_id' => $request->cliente_id,
            'observaciones' => $request->observaciones,
        );

        $json = json_encode($nuevos_datos);

        event(new ActualizacionBitacora($visita->id, Auth::user()->id, 'Edición', $visita, $json, 'visitas'));

        $visita->update($request->all());

        return redirect()->route('visitas.index', $visita)->withFlash('La visita se ha actualizado exitosamente');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visita $visita, Request $request)
    {
        $visita->estado = 2;
        $visita->save();

        event(new ActualizacionBitacora($visita->id, Auth::user()->id, 'Eliminacion', '', '', 'visitas'));
        
        return Response::json(['success'=> 'Exito']);
    }


    public function getJson(Request $params)
     {
        $api_result['data'] = Visita::select(
            'visitas.id',
            'clientes.nombre_comercial',
            'clientes.direccion',
            'visitas.tipo_visita',
            'visitas.nombre_cliente',
            'visitas.observaciones',
            'users.name',
            'visitas.created_at'
        )->join(
            'clientes',
            'visitas.cliente_id',
            '=',
            'clientes.id'
        )->join(
            'users',
            'visitas.user_id',
            '=',
            'users.id'
        )->where(
            'visitas.estado',
            '=',
            1
        )->get();

        return Response::json($api_result);
     }
}
