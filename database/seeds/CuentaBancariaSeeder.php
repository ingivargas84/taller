<?php

use Illuminate\Database\Seeder;
use App\CuentaBancaria;

class CuentaBancariaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('nombre_cuenta' => 'NAMSA', 'no_cuenta' => '6006098047', 'banco_id'=>'1'),
            array('nombre_cuenta' => 'NAMSA', 'no_cuenta' => '2006496062', 'banco_id'=>'2'),
            array('nombre_cuenta' => 'NAMSA', 'no_cuenta' => '5006493077', 'banco_id'=>'3'),
            array('nombre_cuenta' => 'NAMSA', 'no_cuenta' => '8006578029', 'banco_id'=>'4'),
            array('nombre_cuenta' => 'NAMSA', 'no_cuenta' => '2006098062', 'banco_id'=>'5'),
            array('nombre_cuenta' => 'NAMSA', 'no_cuenta' => '7003045848', 'banco_id'=>'6'),
            array('nombre_cuenta' => 'NAMSA', 'no_cuenta' => '8003094087', 'banco_id'=>'7'),
            array('nombre_cuenta' => 'NAMSA', 'no_cuenta' => '4006048048', 'banco_id'=>'8'),
            array('nombre_cuenta' => 'NAMSA', 'no_cuenta' => '9006038048', 'banco_id'=>'9'),
            array('nombre_cuenta' => 'NAMSA', 'no_cuenta' => '3008498094', 'banco_id'=>'10'),
        );

        CuentaBancaria::insert($data);
    }
}
