<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {


        $this->call([JalonSeeder::class]);
        $this->call(CategoryDemandeSeeder::class);
        $this->call(RoleSeeder::class);

        $this->call(AllDemandeSeeder::class);
        $this->call(OptionTtmSeeder::class);
        $this->call(ComplexityItemSeeder::class);
        $this->call(ComplexityTargetSeeder::class);
    }
}
