<?php

use Illuminate\Database\Seeder;
use App\PlanillaMaestro;
use Carbon\Carbon;
class PlanillaMaestroSeeder extends Seeder
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
                'no_planilla' => 1,
                'anio' => Carbon::today()->year,
                'contador_id' => 1,
                'total' => 11827.16,
                'estado_planilla_id' => 1,
                'fecha_planilla' => Carbon::today()->format('Y-m-d'),
            ),
        );

        PlanillaMaestro::insert($data);

    }
}
