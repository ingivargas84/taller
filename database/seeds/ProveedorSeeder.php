<?php

use Illuminate\Database\Seeder;
use App\Proveedor;

class ProveedorSeeder extends Seeder
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
                'nombre_comercial' => 'VR Informática & Sistemas',
                'nombre_legal' => 'Iver Adolfo Vargas Villanueva',
                'nit'=> '28818059',
                'direccion' => 'Zona 18, Ciudad de Guatemala',
                'telefono' => '50171392',
                'email' => 'ivargas@vrinfosysgt.com',
                'nombre_contacto1' => 'Iver Adolfo Vargas',
                'puesto_contacto1' => 'Gerente General',
                'telefono_contacto1' => '50171392',
                'correo_contacto1' => 'ivargas@vrinfosysgt.com',
                'nombre_contacto2' => 'Narcy Noelia Pazos',
                'puesto_contacto2' => 'Administradora de Proyectos',
                'telefono_contacto2' => '48469150',
                'correo_contacto2' => 'npazos@vrinfosysgt.com',
                'observaciones' => 'Servicios y asesoria en temas tecnológicos, software, cámaras, alarmas, biométricos, etc',
                'estado' => '1',
                'user_id' => '1',
            ),
        );

        Proveedor::insert($data);
    }
}
