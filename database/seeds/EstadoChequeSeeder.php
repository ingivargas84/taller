<?php

use Illuminate\Database\Seeder;
use App\EstadoCheque;

class EstadoChequeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('estado' => 'Creado'),
            array('estado' => 'Impreso'),
            array('estado' => 'Entregado'),
            array('estado' => 'Anulado'),
            array('estado' => 'Cobrado'),
        );

        EstadoCheque::insert($data);
    }
}
