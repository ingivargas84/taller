<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Cheque;

class ChequeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('fecha' => Carbon::now(), 'cantidad' => '2500.20', 
            'no_cheque'=> '000111', 'descripcion'=> 'SERVICIOS, TAL...', 
            'receptor'=> 'Juan Perez', 'referencia'=> '002', 'usuario_id' => 2,
            'persona_acepta'=> 'Gorge'),
        );

        Cheque::insert($data);

    }
}
