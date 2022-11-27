<?php

namespace Database\Seeders;

use App\Models\City;
use App\Models\Country;
use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for ($i = 1; $i <= 50; $i++) {
            $data1 = Country::create([
                'name' => "Pais" . " " . $i,
                'flag' => 'public/4IYjl3kRhVF3oB7A2ojSum7LfxmVTGygBGP9KeQC.jpg'
            ]); 
            for ($j = 1; $j <= 30; $j++) {
                $data2 = Department::create([
                    'country_id' => $data1->id,
                    'name' => "Departamento" . $data1->name . " " . $j,
                ]);
                for ($k = 1; $k <= 20; $k++) {
                    City::create([
                        'department_id' => $data2->id,
                        'name' => "Ciudad" . $data2->name . " " . $k,
                    ]);
                }
            }
        }
    }
}
