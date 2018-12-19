<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        foreach (range(1, 10) as $k=>$index) {
            DB::table('jobs_vacansies')->insert([
                'company_id' => ($k+1),
                'region_id' => rand(1,6),
                'category_id' => rand(1,4),
                'type_id' => rand(1,3),
                'title' => $faker->sentence($nbWords = 3, $variableNbWords = true),
                'description' => $faker->sentence($nbWords = 5, $variableNbWords = true),
                'closing_date' => \Carbon\Carbon::now()->addDays(rand(10,20)),
                'salary' => rand(1,6)*100000,
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }
    }
}
