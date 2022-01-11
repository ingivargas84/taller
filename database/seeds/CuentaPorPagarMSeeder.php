<?php

use Illuminate\Database\Seeder;
use App\CuentaPorPagarMaestro;

class CuentaPorPagarMSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('proveedor_id' => '1', 'user_id' => '1'),
        );

        CuentaPorPagarMaestro::insert($data);
    }
}
