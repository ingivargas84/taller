<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\RegistroEnvioEquipo;
use App\User;

class RegistroEnvioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('no_envio' => '1', 'anio' => Carbon::today()->year, 'orden_equipo_id' => '1',
                'empleado_id' => '1', 'direccion' => 'Guatemala', 'observaciones' => 'nada',
                'receptor' => 'Roberto', 'estado_envio_id' => '1'),
            
            array('no_envio' => '2', 'anio' => Carbon::today()->year, 'orden_equipo_id' => '2',
                'empleado_id' => '2', 'direccion' => 'Guatemala, Esquipulas', 'observaciones' => 'nada',
                'receptor' => 'Carlos', 'estado_envio_id' => '1'),
        );

        RegistroEnvioEquipo::insert($data);
    }
}
