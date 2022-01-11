<?php

use Illuminate\Database\Seeder;
use App\EstadoPlanilla;
class EstadoPlanillaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array('estado' => 'Creada'),
            array('estado' => 'Anulada'),
            array('estado' => 'Liquidada')
        );
        
        EstadoPlanilla::insert($data);
    }

}
