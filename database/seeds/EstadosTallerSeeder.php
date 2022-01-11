<?php

use Illuminate\Database\Seeder;
use App\EstadosTaller;

class EstadosTallerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('nombre'=> 'Calibración'),
            array('nombre'=> 'Colocación de piezas'),
            array('nombre'=> 'Diagnósticos'),
            array('nombre'=> 'Entregada Irreparable'),
            array('nombre'=> 'Entregada sin autorización'),
            array('nombre'=> 'Extracción de piezas'),
            array('nombre'=> 'Limpieza profunda'),
            array('nombre'=> 'Lista'),
            array('nombre'=> 'Lista y entregada'),
            array('nombre'=> 'Lista y entregada sin batería'),
            array('nombre'=> 'Pruebas finales'),
            array('nombre'=> 'Repuestos'),
            array('nombre'=> 'Revisiones'),
            array('nombre'=> 'Unauthorized'),
            array('nombre'=> 'UnauthorizedBodega'),
            array('nombre'=> 'UnauthorizedTaller'),
        );

        EstadosTaller::insert($data);
    }
}
