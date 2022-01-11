<?php

use Illuminate\Database\Seeder;
use App\TipoTransaccionCargoAbono;
class TipoTransaccionCargoAbonoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('tipo_transaccion' => 'Cargo'),
            array('tipo_transaccion' => 'Abono'),
            array('tipo_transaccion' => 'Reversión-cargo'),
            array('tipo_transaccion' => 'Reversión-abono'),
        );

        TipoTransaccionCargoAbono::insert($data);
    }
}
