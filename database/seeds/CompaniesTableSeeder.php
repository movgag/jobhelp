<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CompaniesTableSeeder extends Seeder
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
            DB::table('companies')->insert([
                'company_name' => $faker->company,
                'contact_person_name' => $faker->name,
                'contact_person_phone' => $faker->phoneNumber,
                'tax_number' => mt_rand(100000,999999),
                'email' => /*$faker->email*/'movsisyangag+'.($k+1).'@gmail.com',
                'verify' => 1,
                'status' => 1,
                'admin_verify' => 1,
                'verify_code' => str_random(10),
                'password' => bcrypt('123456'),
                'created_at' => \Carbon\Carbon::now(),
                'updated_at' => \Carbon\Carbon::now(),
            ]);
        }
    }
}
