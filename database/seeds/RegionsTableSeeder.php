<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['name' => 'Yerevan'],
            ['name' => 'Lori'],
            ['name' => 'Tavush'],
            ['name' => 'Shirak'],
            ['name' => 'Kotayk'],
            ['name' => 'Aragatsotn'],
            ['name' => 'Armavir'],
            ['name' => 'Ararat'],
            ['name' => 'Gexarkunik'],
            ['name' => 'Vayots Dzor'],
            ['name' => 'Syunik'],
        ];
        DB::table('regions')->insert($data);
    }
}
