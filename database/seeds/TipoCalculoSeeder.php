<?php

use Illuminate\Database\Seeder;
use App\TipoCalculo;

class TipoCalculoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('tipo' => 'Porcentual'),
            array('tipo' => 'Calculado'),
            array('tipo' => 'Fijo'),
        );

        TipoCalculo::insert($data);
    }
}
