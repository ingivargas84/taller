<?php

use Illuminate\Database\Seeder;
use App\IngresoEgreso;

class IngresoEgresoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Porcentaje
        $data = array(
            array('nombre' => 'name', 'tipo_movimiento_id' => 1, 'tipo_calculo_id' => 1, 'campo_pc_id' => 1, 'campo_am_id' => null, 'porcentaje' => '0.20', 'cantidad_multiplicar' => null, 'cantidad_ingreso_fijo' => null),
            //Calculado
            array('nombre' => 'nana', 'tipo_movimiento_id' => 1, 'tipo_calculo_id' => 2, 'campo_pc_id' => 1, 'campo_am_id' => null, 'porcentaje' => null, 'cantidad_multiplicar' => '10', 'cantidad_ingreso_fijo' => null),
            //Fijo
            array('nombre' => 'nana', 'tipo_movimiento_id' => 1, 'tipo_calculo_id' => 3, 'campo_am_id' => 2, 'campo_pc_id' => null, 'porcentaje' => null, 'cantidad_multiplicar' => null,'cantidad_ingreso_fijo' => '2500'),
        );
        
        IngresoEgreso::insert($data);
    }
}
