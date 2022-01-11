<?php

use Illuminate\Database\Seeder;
use App\Documento;

class DocumentoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('documento' => 'Depósito'),
            array('documento' => 'Cheque'),
            array('documento' => 'Efectivo')
        );

        Documento::insert($data);
    }
}
