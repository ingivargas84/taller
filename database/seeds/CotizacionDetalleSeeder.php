<?php

use Illuminate\Database\Seeder;

class CotizacionDetalleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('cantidad'=>5, 'precio'=>100, 'subtotal'=>500, 'isProduct' => 1),
        );

        App\CotizacionDetalle::insert($data);
    }
}
