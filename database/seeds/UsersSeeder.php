<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();
        User::truncate();

        $superadminRole = Role::create(['name' => 'Super-Administrador']);
        $adminRole = Role::create(['name' => 'Administrador']);
        $jefetallerRole = Role::create(['name' => 'Jefe de Taller']);
        $asistentetallerRole = Role::create(['name' => 'Asistente de Taller']);
        $asistenteRole = Role::create(['name' => 'Asistente']);
        $vendedorRole = Role::create(['name' => 'Vendedor']);
        $tecnicoRole = Role::create(['name' => 'Tecnico']);

        $user = new user;
        $user->name = 'Super Administrador';
        $user->email= 'superadmin@gmail.com';
        $user->password = bcrypt('superadmin');
        $user->username = 'superadmin';
        $user->estado = 1;
        $user->save();
        $user->assignRole($superadminRole); 

        $user = new user;
        $user->name = 'Administrador';
        $user->email= 'admin@1gmail.com';
        $user->password = bcrypt('admin');
        $user->username = 'admin';
        $user->estado = 1;
        $user->save();
        $user->assignRole($adminRole);

        $user = new user;
        $user->name = 'Jefe de Taller';
        $user->email= 'jefedetaller@gmail.com';
        $user->password = bcrypt('jefedetaller');
        $user->username = 'jefedetaller';
        $user->estado = 1;
        $user->save();
        $user->assignRole($jefetallerRole); 

        $user = new user;
        $user->name = 'Asistente de Taller';
        $user->email= 'asistentedetaller@gmail.com';
        $user->password = bcrypt('asistentedetaller');
        $user->username = 'asistentedetaller';
        $user->estado = 1;
        $user->save();
        $user->assignRole($asistentetallerRole);  

        $user = new user;
        $user->name = 'Asistente';
        $user->email= 'asistente@gmail.com';
        $user->password = bcrypt('asistente');
        $user->username = 'asistente';
        $user->estado = 1;
        $user->save();
        $user->assignRole($asistenteRole);
        
        $user = new user;
        $user->name = 'Vendedor';
        $user->email= 'vendedor@gmail.com';
        $user->password = bcrypt('vendedor');
        $user->username = 'vendedor';
        $user->estado = 1;
        $user->save();
        $user->assignRole($vendedorRole);

        $user = new user;
        $user->name = 'Tecnico';
        $user->email= 'tecnico@gmail.com';
        $user->password = bcrypt('tecnico');
        $user->username = 'tecnico';
        $user->estado = 1;
        $user->save();
        $user->assignRole($tecnicoRole);
        
    }
}
