<?php

namespace Database\Seeders;

use App\Models\Tamu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Str;

class TamuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');

        for ($i = 1; $i <= 50; $i++) {
            $fo = $faker->name;
            Tamu::create([
                'slug' => Str::slug($fo),
                'nama' => $fo,
                'no_telp' => '0' . $faker->unique()->numberBetween(1000000000, 9999999999),
                'alamat' => $faker->address
            ]);
        }
    }
}
