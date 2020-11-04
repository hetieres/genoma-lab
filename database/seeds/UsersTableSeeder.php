<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'type'        => 'admin',
            'name'        => 'Administrador',
            'email'       => 'admin@fapesp.br',
            'password'    => bcrypt('123456'),
            'is_verified' => 1,
            'created_at'  => date('Y-m-d H:i:s')
        ]);
    }
}
