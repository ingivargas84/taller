<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;
use App\CuentaPorCobrarDetalle;

class CuentaPorCobrarDSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('cuenta_cobrar_maestro_id' => '1', 'tipo_transaccion_id' => '1', 'fecha_transaccion' => Carbon::now(), 'credito_id' => '1', 'total' => '200', 'saldo' => '200', 'user_id' => '1'),
        );

        CuentaPorCobrarDetalle::insert($data);
    }
}
