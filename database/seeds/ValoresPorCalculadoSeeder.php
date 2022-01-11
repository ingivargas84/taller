<?php

use Illuminate\Database\Seeder;
use App\ValoresPorCalculado;

class ValoresPorCalculadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('dato' => 'Sueldo Base'),
            array('dato' => 'Sueldo Total'),
            array('dato' => 'Valor Hora'),
        );

        ValoresPorCalculado::insert($data);        
    }
}
