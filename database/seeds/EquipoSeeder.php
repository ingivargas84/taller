<?php

use Illuminate\Database\Seeder;
use App\Equipo;

class EquipoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('equipo'=>'CATER ADM3/TORNILLOS'),
            array('equipo'=>'CATERPILLAR 3211'),
            array('equipo'=>'CELECT'),
            array('equipo'=>'DDEC3'),
            array('equipo'=>'DDEC4'),
            array('equipo'=>'DDEC5'),
            array('equipo'=>'INTER 446'),
            array('equipo'=>'ISX'),
            array('equipo'=>'SENSOR CATERPILLAR'),
        );

        Equipo::insert($data);
    }
}
