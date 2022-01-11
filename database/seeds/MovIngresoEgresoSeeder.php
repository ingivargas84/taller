<?php

use Illuminate\Database\Seeder;
use App\MovIngresoEgreso;

class MovIngresoEgresoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('tipo' => 'Ingreso'),
            array('tipo' => 'Egreso'),
        );

        MovIngresoEgreso::insert($data);
    }
}
