<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'English'],
            ['name' => 'Russian'],
            ['name' => 'German'],
            ['name' => 'French'],
            ['name' => 'Spanish'],
            ['name' => 'Italish']

        ];
        DB::table('languages')->insert($data);
    }
}
