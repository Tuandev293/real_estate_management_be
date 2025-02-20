<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class BuildingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        $storagePath = storage_path('app/public/buildings');

        if (!file_exists($storagePath)) {
            mkdir($storagePath, 0777, true);
        }

        for ($i = 0; $i < 20; $i++) {
            $imageName = $faker->image($storagePath, 640, 480, null, false);

            DB::table('buildings')->insert([
                'name_building' => $faker->company,
                'address'       => $faker->address,
                'room_number'   => $faker->numberBetween(1, 100),
                'price'         => $faker->randomFloat(3, 100000, 10000000),
                'image'         => 'buildings/' . $imageName,
                'created_at'    => now(),
                'updated_at'    => now(),
            ]);
        }
    }
}
