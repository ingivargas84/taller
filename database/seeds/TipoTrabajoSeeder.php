<?php

use Illuminate\Database\Seeder;
use App\TipoTrabajo;

class TipoTrabajoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('nombre'=> 'Garantía'),
            array('nombre'=> 'Reparación'),
            array('nombre'=> 'Tatuar'),
        );

        TipoTrabajo::insert($data);
    }
}
