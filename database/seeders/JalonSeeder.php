<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Jalon;

class JalonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Jalon::create(['designation' => 'T-1']);
        Jalon::create(['designation' => 'T0']);
        Jalon::create(['designation' => 'T1']);
        Jalon::create(['designation' => 'T2']);
        Jalon::create(['designation' => 'T3']);
        Jalon::create(['designation' => 'T4']);
    }
}