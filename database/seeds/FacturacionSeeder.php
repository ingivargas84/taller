<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\Facturacion;

class FacturacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('no_factura'=>1, 'serie' => '001101', 'anio' => '2020', 
            'fecha'=> Carbon::today(), 'monto' =>300, 'cliente_id' => 1, 'orden_id' => 1),
            
            array('no_factura'=>2, 'serie' => '001202', 'anio' => '2020', 
            'fecha'=> Carbon::today(), 'monto' =>3000, 'cliente_id' => 1, 'orden_id' => 2),
        );

        Facturacion::insert($data);
    }
}
