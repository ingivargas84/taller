<?php

use Illuminate\Database\Seeder;
use App\ValoresFijo;

class ValoresFijoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('tipo' => 'Manual'),
            array('tipo' => 'Automático'),
        );

        ValoresFijo::insert($data);
    }
}
