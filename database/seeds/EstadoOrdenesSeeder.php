<?php

use Illuminate\Database\Seeder;
use App\EstadoOrdenTaller;

class EstadoOrdenesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('estado_orden_trabajo' => 'Recepción'),
            array('estado_orden_trabajo' => 'Enviado Taller'),
            array('estado_orden_trabajo' => 'Recibido Taller'),
            array('estado_orden_trabajo' => 'Enviado Asesor'),
            array('estado_orden_trabajo' => 'Recibido Asesor'),
            array('estado_orden_trabajo' => 'Enviado Recepción Llamada'),
            array('estado_orden_trabajo' => 'Recibido Recepción Llamada'),
            array('estado_orden_trabajo' => 'Enviado Taller 2'),
            array('estado_orden_trabajo' => 'Recibido Taller 2'),
            array('estado_orden_trabajo' => 'Enviada a Recepción Entrega'),
            array('estado_orden_trabajo' => 'Recibido Recepción Entrega'),
            array('estado_orden_trabajo' => 'Lista para Entregar'),
            array('estado_orden_trabajo' => 'Cobrada y Entregada'),
            array('estado_orden_trabajo' => 'Irreparable y Entregada'),
        );

        EstadoOrdenTaller::insert($data);
    }
}
