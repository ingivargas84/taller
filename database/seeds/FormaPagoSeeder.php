<?php

use Illuminate\Database\Seeder;
use App\FormaPago;
class FormaPagoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('nombre'=>'Efectivo'),
            array('nombre'=>'Depósito'),
            array('nombre'=>'Cheque'),
            array('nombre'=>'Tarjeta'),
            array('nombre'=>'Credito'),
        );

        FormaPago::insert($data);

    }
}
