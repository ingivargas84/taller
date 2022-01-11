<?php

use Illuminate\Database\Seeder;
use App\Cliente;

class ClienteSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            array(
                'tipocliente_id' => '1', 
                'user_id'=> '1', 
                'nit' => '33243670', 
                'nombre_comercial'=> 'cliente 1', 
                'empleado_id' => '1',
                'telefono' => '45676543',
                'correo_electronico' => 'cliente@gmail.com',
                'estado_id' => '1',
                'user_id' => '6',
                'direccion'=> 'esquipulas')
        );
        Cliente::insert($data);
    }
}
