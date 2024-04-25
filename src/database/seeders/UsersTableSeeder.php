<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
        'name' => 'test',
        'email' => 'test@test',
        'password' => Hash::make('password'),
        'role_id' => '1',
    ];
    DB::table('users')->insert($param);
        $param = [
        'name' => '店舗代表a',
        'email' => 'a@a',
        'password' => Hash::make('password'),
        'role_id' => '2',
    ];
    DB::table('users')->insert($param);
        $param = [
        'name' => '店舗代表b',
        'email' => 'b@b',
        'password' => Hash::make('password'),
        'role_id' => '2',
    ];
    DB::table('users')->insert($param);
        $param = [
        'name' => '店舗代表c',
        'email' => 'c@c',
        'password' => Hash::make('password'),
        'role_id' => '2',
    ];
    DB::table('users')->insert($param);
        $param = [
        'name' => 'user a',
        'email' => 'usera@usera',
        'password' => Hash::make('password'),
        'role_id' => '3',
    ];
    DB::table('users')->insert($param);
        $param = [
        'name' => 'user b',
        'email' => 'userb@userb',
        'password' => Hash::make('password'),
        'role_id' => '3',
    ];
    DB::table('users')->insert($param);
        $param = [
        'name' => 'user c',
        'email' => 'userc@userc',
        'password' => Hash::make('password'),
        'role_id' => '3',
    ];
    DB::table('users')->insert($param);
    }
}
