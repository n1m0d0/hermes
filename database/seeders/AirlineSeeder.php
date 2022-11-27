<?php

namespace Database\Seeders;

use App\Models\Airline;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AirlineSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 50; $i++) {
            Airline::create([
                'name' => "Aerolinea" . " " . $i,
                'logo' => 'public/4IYjl3kRhVF3oB7A2ojSum7LfxmVTGygBGP9KeQC.jpg'
            ]); 
        }
    }
}
