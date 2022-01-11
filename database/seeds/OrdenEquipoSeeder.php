<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\OrdenEquipo;
class OrdenEquipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('fecha_orden' => Carbon::now(), 'no_orden_trabajo' => '1011', 'no_comprobante' => '1',
            'cliente_id' => '1', 'equipo_id' => '4', 'tipo_trabajo_id' => 2, 'empleado_id' => '1', 
            'estado_id' => '1', 'ubicacion_id' => '1', 'user_id' => '2', 'observaciones' => 'asdfsdf')
        );


        OrdenEquipo::insert($data);
    }
}
