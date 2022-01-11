<?php

use Illuminate\Database\Seeder;
use App\Banco;

class BancoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $data = array(
            array('banco'=>'AGROMERCANTIL'),
            array('banco'=>'Industrial'),
            array('banco'=>'Credomatic'),
            array('banco'=>'Promerica'),
            array('banco'=>'Banco Internacional'),
            array('banco'=>'G&T'),
            array('banco'=>'Banrural'),
            array('banco'=>'Bantrab'),
            array('banco'=>'Vivibanco'),
            array('banco'=>'Ficohsa'),
        );

        Banco::insert($data);
    }
}
