<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use App\Events\ActualizacionBitacora;
use App\User;
use App\Equipo;
use App\Equipos_Detalles;

class CompusController extends Controller
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
        return view('admin.compus.index');
    }

    /**
     * Get the forma de pago json 
     */

     public function getJson() {
        $api_result['data'] = Equipo::Where('estado_id', '1')->Where('existencias','>',0)->get();
        return response()->json($api_result);
     }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createingreso()
    {
        $equipos = Equipo::where('estado_id',1)->get();
        
        return view("admin.compus.createingreso", compact('equipos'));
    }

    public function createsalida()
    {
        $equipos = Equipo::where('estado_id',1)->get();
        
        return view("admin.compus.createsalida", compact('equipos'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeingreso(Request $request)
    {
        $data = $request->all();
        $compus = Equipos_Detalles::create($data);
        $compus->user_ingreso = Auth::user()->id;   
        $compus->estado_computadora = 1;  
        $compus->save();

        $equipo = Equipo::Where("id",$compus->equipo_id)->get();
        $equipo[0]->existencias = $equipo[0]->existencias + 1;
        $equipo[0]->save();
       
        event(new ActualizacionBitacora($compus->id, Auth::user()->id,'Creación','', $compus,'Ingreso de Computadora'));

        return redirect()->route('compus.index')->withFlash('El registro de ingreso de Computadora, se realizó correctamente!');
    }


    public function storesalida(Request $request)
    {
        $compus = Equipos_Detalles::Where("id",$request->tatuaje)->get();
        $compus[0]->user_salida = Auth::user()->id;   
        $compus[0]->fecha_salida = $request->fecha_salida;   
        $compus[0]->razon_salida = $request->razon_salida;   
        $compus[0]->estado_computadora = 2;  
        $compus[0]->save();

        $equipo = Equipo::Where("id",$request->equipo_id)->get();
        $equipo[0]->existencias = $equipo[0]->existencias - 1;
        $equipo[0]->save();
       
        event(new ActualizacionBitacora($request->equipo_id, Auth::user()->id,'Creación','', $compus,'Salida de Computadora'));

        return redirect()->route('compus.index')->withFlash('El registro de salida de Computadora, se realizó correctamente!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    public function getTatuajes($id){
        
        $api_result = Equipos_Detalles::WHERE("equipo_id",$id)->WHERE("estado_computadora",1)->get();

        return Response::json($api_result);
    }




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
