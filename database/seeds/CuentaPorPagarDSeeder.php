<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\CuentaPorPagarDetalle;

class CuentaPorPagarDSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('cuenta_pagar_maestro_id' => '1', 'tipo_transaccion_id' => '1', 'fecha_transaccion' => Carbon::now(), 'compra_id' => '1', 'total' => '200', 'saldo' => '200', 'user_id' => '1'),
        );

        CuentaPorPagarDetalle::insert($data);
    }
}
