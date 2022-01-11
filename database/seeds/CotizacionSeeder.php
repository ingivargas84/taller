<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CotizacionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('fecha' => Carbon::now(), 'created_at' => Carbon::now(), 'total'=> '500'),
            array('fecha' => Carbon::now(), 'created_at' => Carbon::now(), 'total'=> '800'),
        );

        App\CotizacionMaestro::insert($data);
    }
}
