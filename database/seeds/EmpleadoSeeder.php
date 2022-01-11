<?php

use Illuminate\Database\Seeder;
use App\Empleado;
use App\Puesto;
class EmpleadoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = array(
            //Marco
            array('nombres'=>'Marco', 'apellidos'=>'Duarte', 
            'nit'=>'2345678', 'salario' => '2825.10', 'emp_cui'=>'336789662007', 
            'direccion'=>'Guatemala', 'telefono'=>'11111111', 
            'celular'=>'45675435','email'=>'marco@duarte.com', 
            'fecha_nacimiento'=>'1983/02/02', 'user_id'=>1,
            'puesto_id'=>Puesto::where('nombre','Asesor')->first()->id),
            //Norman
            array('nombres'=>'Norman', 'apellidos'=>'Mejía', 
            'nit'=>'1325476', 'salario' => '2825.10', 'emp_cui'=>'333769792007', 
            'direccion'=>'Guatemala', 'telefono'=>'22222222', 
            'celular'=>'25275735','email'=>'norman@mejia.com', 
            'fecha_nacimiento'=>'1978/06/01', 'user_id'=>1,
            'puesto_id'=>Puesto::where('nombre','Asesor')->first()->id),
            //Oficina
            array('nombres'=>'Oficina', 'apellidos'=>'office', 
            'nit'=>'1535273', 'salario' => '2825.10', 'emp_cui'=>'346762732007', 
            'direccion'=>'Guatemala', 'telefono'=>'33333333', 
            'celular'=>'47368643','email'=>'oficina@office.com', 
            'fecha_nacimiento'=>'1950/01/01', 'user_id'=>1,
            'puesto_id'=>Puesto::where('nombre','Asesor')->first()->id),
            //Sharlyn
             array('nombres'=>'Sharlyn', 'apellidos'=>'Payne', 
            'nit'=>'678563457', 'salario' => '2825.10', 'emp_cui'=>'3473623632007', 
            'direccion'=>'Guatemala', 'telefono'=>'33333333', 
            'celular'=>'45672423','email'=>'sharlyn@payne.com', 
            'fecha_nacimiento'=>'1995/06/02', 'user_id'=>1,
            'puesto_id'=>Puesto::where('nombre','Asesor')->first()->id),
        );

        Empleado::insert($data);
    }
}
