<?php

use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table("usuarios")->insert(array(
            'nombre_usuario'  => 'Oscar Javier Olivos',
            'email'      => 'ojolivos@gmail.com',
            'estado'=>'1',
            'id_perfil' => 1,
            'password'   => Hash::make('12345') // Hash::make() nos va generar una cadena con nuestra contraseña encriptada
        ));
    }
}
