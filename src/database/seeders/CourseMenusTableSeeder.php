<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CourseMenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $param = [
        'restaurant_id' => '1',
        'name' => '松コース',
        'price' => '2500',
    ];
    DB::table('course_menus')->insert($param);
        $param = [
        'restaurant_id' => '1',
        'name' => '竹コース',
        'price' => '3500',
    ];
    DB::table('course_menus')->insert($param);
        $param = [
        'restaurant_id' => '1',
        'name' => '梅コース',
        'price' => '5000',
    ];
    DB::table('course_menus')->insert($param);


    $param = [
        'restaurant_id' => '2',
        'name' => 'お手頃コース',
        'price' => '2800',
    ];
    DB::table('course_menus')->insert($param);
    $param = [
        'restaurant_id' => '2',
        'name' => 'スタンダードコース',
        'price' => '3500',
    ];
    DB::table('course_menus')->insert($param);
    $param = [
        'restaurant_id' => '2',
        'name' => 'プレミアムコース',
        'price' => '4600',
    ];
    DB::table('course_menus')->insert($param);
    $param = [
        'restaurant_id' => '11',
        'name' => 'お手頃コース',
        'price' => '2500',
    ];
    DB::table('course_menus')->insert($param);
    $param = [
        'restaurant_id' => '11',
        'name' => '国産牛コース',
        'price' => '3600',
    ];
    DB::table('course_menus')->insert($param);
    $param = [
        'restaurant_id' => '11',
        'name' => '黒毛和牛コース',
        'price' => '4800',
    ];
    DB::table('course_menus')->insert($param);
    $param = [
        'restaurant_id' => '13',
        'name' => '食べ放題コース',
        'price' => '3000',
    ];
    DB::table('course_menus')->insert($param);
    }
}
