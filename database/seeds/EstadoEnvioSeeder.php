<?php

use Illuminate\Database\Seeder;
use App\EstadoEnvio;

class EstadoEnvioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('estado' => 'Listo'),
            array('estado' => 'En ruta'),
            array('estado' => 'Entregado'),
            array('estado' => 'Rechazado'),
            array('estado' => 'Recibido de vuelta'),
            array('estado' => 'Anulado')
        );

        EstadoEnvio::insert($data);
    }
}
