<?php

use Illuminate\Database\Seeder;
use App\TipoMovimiento;

class TipoMovimientoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('tipo' => 'Entrada'),
            array('tipo' => 'Salida'),
        );

        TipoMovimiento::insert($data);
    }
}
