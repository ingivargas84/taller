<?php

use Illuminate\Database\Seeder;
use App\PlanillaDetalle;

class PlanillaDetalleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array(
                'planilla_medio_id' => 1,
                'movimiento_id' => 1,
                'cantidad' => 250.00,
                'subtotal' => 250.00
        ),
        );
        PlanillaDetalle::insert($data);

    }
}
