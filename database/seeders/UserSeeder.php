<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use DB;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name='admin user';
        $slug = Str::of($name)->slug('-');

        DB::table('users')->insert([
            'name' => $name,
            'email' => 'admin@gmail.com',
            'role'=>'admin',
            'slug'=>$slug,
            'status'=>1,
            'password' => Hash::make('password'),
        ]);
    }
}
