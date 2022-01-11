<?php

use Illuminate\Database\Seeder;
use App\Puesto;
class PuestoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $puesto = new Puesto();
        $puesto->nombre = 'Asesor';
        $puesto->user_id = 1;
        $puesto->save();
    }
}
