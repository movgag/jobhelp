<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EmployiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create();
        foreach (range(1, 20) as $k=>$index) {
            DB::table('employees')->insert([
                'name' => $faker->name,
                'last_name' => 'test',
                'email' => /*$faker->emai*/'gagmovses+'.($k+1).'@gmail.com',
                'phone' => $faker->phoneNumber,
                'password' => bcrypt('123456'),
                'verify' => 1,
                'status' => 1,
                'verify_code' => str_random(10),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }

    }
}
