<?php

namespace App\Http\Controllers;

use App\Voucher;
use Illuminate\Http\Request;
use App\Cheque;
use App\Events\ActualizacionBitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class VoucherController extends Controller
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
        //
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

            //Condicionar que numero corresponde
            $today = Carbon::today()->format('Y-m-d');
            $year = Carbon::today()->year;

            $last = DB::table('vouchers')->latest('created_at')->first();
            if(isset($last)) {
                    
                $newYear = $last->anio . '-01-01';
                
                if($today == $newYear && $last->anio != $year) {
                    //Si hoy es anio nuevo y el ultimo registro es del anio pasado
                    $voucher = new Voucher;
                    $voucher->receptor = $data['receptor_voucher'];
                    $voucher->no_voucher = 1;
                    $voucher->anio = $year;
                    $voucher->cheque_id = $data['cheque_id'];
                    $voucher->save();

                } else if($today == $newYear && $last->anio == $year) {
                    //Aun es 1 de enero pero ya hay registros del anio nuevo
                    $voucher = new Voucher;
                    $voucher->receptor = $data['receptor_voucher'];
                    $voucher->no_voucher = $last->no_voucher + 1;
                    $voucher->anio = $year;
                    $voucher->cheque_id = $data['cheque_id'];
                    $voucher->save();
                } else {
                    //Cualquier otro dia del anio
                     $voucher = new Voucher;
                    $voucher->receptor = $data['receptor_voucher'];
                    $voucher->no_voucher = $last->no_voucher + 1;
                    $voucher->anio = $year;
                    $voucher->cheque_id = $data['cheque_id'];
                    $voucher->save();
                }
            } else {
                //Es el primer registro
                    $voucher = new Voucher;
                    $voucher->receptor = $data['receptor_voucher'];
                    $voucher->no_voucher = 1;
                    $voucher->anio = $year;
                    $voucher->cheque_id = $data['cheque_id'];
                    $voucher->save();
            }
            
        //
        event(new ActualizacionBitacora($voucher->id, Auth::user()->id, 'Creación', '', $voucher, 'Voucher'));

        return response()->json(['success'=>'Éxito']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function show(Voucher $voucher)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function edit(Voucher $voucher)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Voucher $voucher)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Voucher  $voucher
     * @return \Illuminate\Http\Response
     */
    public function destroy(Voucher $voucher)
    {
        //
    }
}
