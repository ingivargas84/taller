<?php

use Illuminate\Database\Seeder;
use App\RutasVendedor;
use Carbon\Carbon;

class RutasVendedorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('fecha' => Carbon::now(), 'orden_equipo_id' => '1',
            'cliente_id' => '1', 'observaciones' => 'hola', 'vendedor_id' => '6'),
        );

        RutasVendedor::insert($data);
    }
}
