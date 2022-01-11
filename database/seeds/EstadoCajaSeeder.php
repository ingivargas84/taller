<?php

use Illuminate\Database\Seeder;
use App\EstadoCaja;

class EstadoCajaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('estado' => 'Abierto'),
            array('estado' => 'Cerrado'),
        );

        EstadoCaja::insert($data);
    }
}
