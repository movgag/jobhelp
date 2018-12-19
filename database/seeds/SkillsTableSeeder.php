<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SkillsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'laravel'],
            ['name' => 'codeigniter'],
            ['name' => 'yii'],
            ['name' => 'cake'],
            ['name' => 'zend'],
            ['name' => 'node'],
            ['name' => 'express'],
            ['name' => 'react js'],
            ['name' => 'angular js'],
            ['name' => 'angular 2'],
            ['name' => 'angular 4'],
            ['name' => 'angular 5'],
            ['name' => 'vue js'],
            ['name' => 'html'],
            ['name' => 'css'],
            ['name' => 'html5'],
            ['name' => 'css3'],
            ['name' => 'php'],
            ['name' => 'java'],
            ['name' => 'javascript'],
            ['name' => 'jquery'],
            ['name' => 'mysql'],
            ['name' => 'postgre'],
            ['name' => 'oracle'],
            ['name' => 'api'],
            ['name' => 'stripe api'],
            ['name' => 'paypal api'],
            ['name' => 'checkout api'],
        ];
        DB::table('skills')->insert($data);
    }
}
