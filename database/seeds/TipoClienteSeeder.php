<?php

use Illuminate\Database\Seeder;
use App\tipo_cliente;

class TipoClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tipo_cliente = new tipo_cliente();
        $tipo_cliente->tipo_cliente = 'Empresa';
        $tipo_cliente->save();

        $tipo_cliente = new tipo_cliente();
        $tipo_cliente->tipo_cliente = 'Distribuidor';
        $tipo_cliente->save();
    }
}
