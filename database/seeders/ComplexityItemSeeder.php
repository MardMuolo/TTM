<?php

namespace Database\Seeders;

use App\Models\ComplexityItem;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ComplexityItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        ComplexityItem::factory(10)->hasComplexityTargets(5)->create();
    }
}
