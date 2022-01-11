<?php

use Illuminate\Database\Seeder;
use App\TipoCuenta;

class TipoCuentaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('tipo'=> 'Monetaria'),
            array('tipo' => 'Ahorro')
        );
        
        TipoCuenta::insert($data);
    }
}
