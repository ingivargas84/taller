<?php

use Illuminate\Database\Seeder;
use App\CajaMaestro;
use Carbon\Carbon;

class CajaMaestroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('fecha' => '2020-02-01','saldo' => 10000,'estado_caja_id'=>2, 'created_at' => Carbon::now(),),
            array('fecha' => '2020-02-02','saldo' => 12000,'estado_caja_id'=>2, 'created_at' => Carbon::now(),),
            array('fecha' => '2020-02-03' ,'saldo' => 11000,'estado_caja_id'=>2, 'created_at' => Carbon::now(),),
            array('fecha' =>'2020-02-04','saldo' => 10000,'estado_caja_id'=>2, 'created_at' => Carbon::now(),),
            array('fecha' => '2020-02-05','saldo' => 10000,'estado_caja_id'=>2, 'created_at' => Carbon::now(),),
            array('fecha' => '2020-02-27','saldo' => 200,'estado_caja_id'=>2, 'created_at' => Carbon::now(),),
            array('fecha' => '2020-02-28','saldo' => 400,'estado_caja_id'=>2, 'created_at' => Carbon::now(),),
        );

        CajaMaestro::insert($data);
    }
}
