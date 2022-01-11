<?php

use Illuminate\Database\Seeder;
use App\PlanillaMedio;
class PlanillaMedioSeeder extends Seeder
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
                'planilla_maestro_id' => 1,
                'empleado_id' => 1,
                'total_ingresos' => 3357.39,
                'total_egresos' => 194.17,
                'total_liquido' => 3163.22
            )
        );

        PlanillaMedio::insert($data);
    }
}
