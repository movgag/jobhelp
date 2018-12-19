<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Web Design'],
            ['name' => 'Designing'],
            ['name' => 'Development'],
            ['name' => 'Programing'],
        ];
        DB::table('categories')->insert($data);
    }
}
