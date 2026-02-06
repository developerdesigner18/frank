<?php

namespace Database\Seeders;

use App\Models\Subdealer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubdealerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Subdealer::create([
            'name'  => 'MysteryVisits.nl',
            'email' => 'welkom@mysteryvisits.nls',
            'phone' => '024 234 28 13',
            'logo'  => null
        ]);
    }
}
