<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'FULL TIME'],
            ['name' => 'PART TIME'],
            ['name' => 'INTERNSHIP'],
        ];
        DB::table('types')->insert($data);
    }
}
