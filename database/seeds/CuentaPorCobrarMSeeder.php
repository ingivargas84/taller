<?php

use Illuminate\Database\Seeder;
use App\CuentaPorCobrarMaestro;

class CuentaPorCobrarMSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('cliente_id' => '1', 'user_id' => '1'),
        );

        CuentaPorCobrarMaestro::insert($data);
    }
}
