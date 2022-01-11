<?php

use Illuminate\Database\Seeder;
use App\UbicacionEquipo;

class UbicacionEquipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('ubicacion' =>'Recepción'),
            array('ubicacion' =>'Taller'),
            array('ubicacion' =>'Bodega de reparación'),
            array('ubicacion' =>'Bodega de equipo'),
            array('ubicacion' =>'Entregada'),
            array('ubicacion' =>'Recepción 2'),
            array('ubicacion' =>'Taller 2'),
        );

        UbicacionEquipo::insert($data);
    }
}
