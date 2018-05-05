<?php

use Illuminate\Database\Seeder;

class TownSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('villages')->insert([
            'name' => 'Serres',
            'type' => 0,
            'latitude' => 41.092083,
            'longitude' => 23.541016
        ]);
        DB::table('villages')->insert([
            'name' => 'Provatas',
            'latitude' => 41.068238,
            'longitude' => 23.390686
        ]);
        DB::table('villages')->insert([
            'name' => 'A. Kamila',
            'latitude' => 41.058320,
            'longitude' => 23.424134
        ]);
        DB::table('villages')->insert([
            'name' => 'K. Kamila',
            'latitude' => 41.020431,
            'longitude' => 23.483293
        ]);
        DB::table('villages')->insert([
            'name' => 'K. Mitrousi',
            'latitude' => 41.058680,
            'longitude' => 23.457547
        ]);
        DB::table('villages')->insert([
            'name' => 'Koumaria',
            'latitude' => 41.016434,
            'longitude' => 23.434656
        ]);
        DB::table('villages')->insert([
            'name' => 'Skoutari',
            'latitude' => 41.020032,
            'longitude' => 23.520701
        ]);
        DB::table('villages')->insert([
            'name' => 'Adelfiko',
            'type' => 2,
            'latitude' => 41.014645,
            'longitude' => 23.457354
        ]);
        DB::table('villages')->insert([
            'name' => 'Ag. Eleni',
            'latitude' => 41.003545,
            'longitude' => 23.559196
        ]);
        DB::table('villages')->insert([
            'name' => 'Peponia',
            'latitude' => 40.988154,
            'longitude' => 23.516756
        ]);
    }
}
