<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         $this->call(AdminTableSeeder::class);
         $this->call(CategoriesTableSeeder::class);
         $this->call(LanguagesTableSeeder::class);
         $this->call(RegionsTableSeeder::class);
         $this->call(SkillsTableSeeder::class);
         $this->call(TypesTableSeeder::class);

         $this->call(CompaniesTableSeeder::class);
         $this->call(EmployiesTableSeeder::class);
         $this->call(JobsTableSeeder::class);
    }
}
