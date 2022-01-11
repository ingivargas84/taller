<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\CajaDetalle;

class CajaDetalleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            //Entrada
            array('fecha' => Carbon::now(),'total'=>'500', 'anio' => Carbon::today()->year,
                'caja_maestro_id' => 6, 'tipo_movimiento_id' => '1'),
            //Salida
            array('fecha' => Carbon::now(), 'total'=>'200', 'anio' => Carbon::today()->year,
'caja_maestro_id' => 6,  'tipo_movimiento_id' => '2'),
            //Entrada
            array('fecha' => Carbon::now(),'total'=>'100', 'anio' => Carbon::today()->year,
                'caja_maestro_id' => 6, 'tipo_movimiento_id' => '1'),
            //Salida
            array('fecha' => Carbon::now(), 'total'=>'0', 'anio' => Carbon::today()->year,
                'caja_maestro_id' => 6,   'tipo_movimiento_id' => '2'),
            );

        CajaDetalle::insert($data);
    }
}
