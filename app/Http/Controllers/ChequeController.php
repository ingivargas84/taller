<?php

namespace App\Http\Controllers;

use App\Cheque;
use Illuminate\Http\Request;
use App\Empleado;
use App\Voucher;
use App\CuentaBancaria;
use App\Events\ActualizacionBitacora;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class ChequeController extends Controller
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
        return view('admin.cheques.index');
    }

    //

    public function getJson() {
        
        $api_result['data'] = Cheque::all();
        foreach($api_result['data'] as $e) {
            $e->cuentaBancaria;
            $e->cuentaBancaria->banco;
            $e->voucher;
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
        //$colaboradores = Empleado::where('estado_id', 1)->get();
        $cuentas = CuentaBancaria::where('estado_id', 1)->get();
        return view('admin.cheques.create', compact('cuentas'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $date = Carbon::parse($request->fecha);
        $data = $request->all();
        $cheque = Cheque::create([
            'fecha' => $date,
            'cantidad' => $request->cantidad,
            'no_cheque' => $request->no_cheque,
            'descripcion' => $request->desc,
            'receptor' => $request->receptor,
            'referencia' => $request->ref,
            'usuario_id' => Auth::user()->id,
            'persona_acepta' => $request->persona_acepta,
            'cuenta_bancaria_id' => $request->cuenta_bancaria_id
        ]);

        event(new ActualizacionBitacora($cheque->id, Auth::user()->id, 'Creación', '', $cheque,'Cheque'));
        return redirect()->route('cheques.index')->withFlash('¡El Cheque ha sido creado exitosamente!');

    }

   

    public function chequePDF($id) {

            try { 
                  //Obtener cheque
                $cheque = Cheque::where('id', $id)->get();
                include 'Num2Txt.php';
                $o = new  \Alp3476\Num2Txt();
                $number = $cheque[0]->cantidad;
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
                $pdf = \PDF::loadView('admin.cheques.chequePDF', ['cheque' => $cheque, 'letras' => $texto]);
                return $pdf->download('cheque' . $cheque[0]->no_cheque . '.pdf');
              
            } catch(Exception $e) {

            } finally{ 
                 $this->printed($id);

                //return redirect()->route('cheques.index')->withFlash('El Cheque se generará en segundos');

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

    public function voucherPDF($id) {

                          //Obtener voucher
                $voucher = Voucher::where('id', $id)->get();
                $cheque = $voucher[0]->cheque;
                include 'Num2Txt.php';
                $o = new  \Alp3476\Num2Txt();
                $number = $cheque->cantidad;
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
                //CUENTA
                $cuenta = $cheque->cuentaBancaria;
                $empleado = $cheque->usuario;

                 //Obtengo el mes en un array
                    $arrayMonthNumber = DB::select('select month(created_at) mes from vouchers where id =?', [$id]);
                    //Obtengo el mes numero
                    $monthName = $this->obtenerMes($arrayMonthNumber[0]->mes);
                $pdf = \PDF::loadView('admin.cheques.voucherPDF', ['cheque' => $cheque, 'letras' => $texto, 'voucher' => $voucher, 'mes' => $monthName, 'cuenta' => $cuenta, 'empleado' => $empleado]);
                return $pdf->download('voucher' . "00" . $voucher[0]->no_voucher ."-" . $voucher[0]->anio . '.pdf');

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Cheque  $cheque
     * @return \Illuminate\Http\Response
     */
    public function show(Cheque $cheque)
    {
        return view('admin.cheques.show');
    }

    public function getCheque($id) {
        $cheque = Cheque::where('id',$id)->get();
        $cheque[0]->usuario;
        $cheque[0]->cuentaBancaria;
        $cheque[0]->cuentaBancaria->banco;
        $cheque[0]->estadoCheque;
        return response()->json($cheque);
     }

    public function chequeEmitido() {
         $noC = Input::get("numero");
         $cuenta_id = Input::get("cuentaID");
         $query = Cheque::where([["no_cheque",$noC],["cuenta_bancaria_id", $cuenta_id]])->get();
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

     public function chequeEmitidoEdit()
    {
        $noC = Input::get("numero");
        $cuenta_id = Input::get("cuentaID");
        $cheque_id = Input::get("chequeID");


        $query = Cheque::where([["no_cheque",$noC],["cuenta_bancaria_id", $cuenta_id]])
                        ->where('id','!=', $cheque_id)->get();
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
     * @param  \App\Cheque  $cheque
     * @return \Illuminate\Http\Response
     */
    public function edit(Cheque $cheque)
    {
        //$cheque->empleado;
        $cheque->cuentaBancaria;
       // $colaboradores = Empleado::where([['estado_id', 1],['id', '!=', $cheque->empleado->id]])->get();
        $cuentas = CuentaBancaria::where([['estado_id', 1],['id', '!=', $cheque->cuentaBancaria->id]])->get();

        return view('admin.cheques.edit', compact('cheque', 'cuentas'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Cheque  $cheque
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Cheque $cheque)
    {

        $info_nueva = $request->all();
        $new = json_encode($info_nueva);
        event(new ActualizacionBitacora($cheque->id, Auth::user()->id,'Edición',$cheque, $new,'Cheque'));
        $cheque->update($request->all());
        return redirect()->route('cheques.index', $cheque)->withFlash('El Cheque ha sido actualizado correctamente');
  
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cheque  $cheque
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $cheque = Cheque::where('id', $request->id)->first();
        $cheque->estado_cheque_id = 4;
        $cheque->save();
        event(new ActualizacionBitacora($cheque->id, Auth::user()->id,'Estado Anulado','','','Cheque'));

    }

    //Este metodo se llamará una vez generado el PDF del cheque
    public function printed($id)
    {
        $cheque = Cheque::where('id', $id)->first();
        $cheque->estado_cheque_id = 2;
        $cheque->save();
        event(new ActualizacionBitacora($cheque->id, Auth::user()->id,'Estado Impreso','','','Cheque'));

    }

    //Este metodo se llamará una vez impreso el PDF, ya estará opcion para imprimir
    public function delivered(Request $request)
    {
        $cheque = Cheque::where('id', $request->id)->first();
        $cheque->estado_cheque_id = 3;
        $cheque->save();
        event(new ActualizacionBitacora($cheque->id, Auth::user()->id,'Estado Entregado','','','Cheque'));

    }

    //Este metodo se llamará una vez entregado el cheque
    public function charged(Request $request)
    {
        $cheque = Cheque::where('id', $request->id)->first();
        $cheque->estado_cheque_id = 5;
        $cheque->save();
        event(new ActualizacionBitacora($cheque->id, Auth::user()->id,'Estado Cobrado','','','Cheque'));

    }
}
