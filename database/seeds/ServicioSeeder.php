<?php

use Illuminate\Database\Seeder;
use App\Servicio;
class ServicioSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $secondData = array(
            array('nombre'=>'Corte de cilindros', 'precio'=>'Q.300'),            
            array('nombre'=>'Dosificación de inyectores', 'precio'=>'Q.300'),            
            array('nombre'=>'Borrado de códigos', 'precio'=>'Q.300'),            
            array('nombre'=>'Verificación de calibración y programación según unidad física', 'precio'=>'Q.300'),            
            array('nombre'=>'Eliminar contraseña existente en la ECM', 'precio'=>'Q.300'),            
            array('nombre'=>'Agregar la contraseña de origen o agregar una personalizada', 'precio'=>'Q.300'),            
            array('nombre'=>'Estudio de tren motriz', 'precio'=>'Q.300'),            
            array('nombre'=>'Estudio de la cabina', 'precio'=>'Q.300'),            
            array('nombre'=>'Calibración de parámetros que estén fuera de orden', 'precio'=>'Q.300'),            
            array('nombre'=>'Borrado de la programación existente', 'precio'=>'Q.300'),            
            array('nombre'=>'Nueva programación con las especificaciones de la unidad en la que se estará utilizando la ECM', 'precio'=>'Q.300'),            
            array('nombre'=>'Reparación de ECM', 'precio'=>'Q.300'),            
            array('nombre'=>'Venta de ECM', 'precio'=>'Q.300'),            
        );

        $data = array(
            array('nombre'=> 'Diagnóstico de una ECM', 'precio'=> '300'),
            array('nombre'=> 'Remoción de contraseñas de una ECM', 'precio'=> '300'),
            array('nombre'=> 'Calibración de una ECM', 'precio'=> '300'),
            array('nombre'=> 'Programación de una ECM', 'precio'=> '300'),
            array('nombre'=> 'Reparación de una ECM', 'precio'=> '300'),
            array('nombre'=> 'Venta de ECM', 'precio'=> '300'),

        );

        Servicio::insert($data);
    }
}
