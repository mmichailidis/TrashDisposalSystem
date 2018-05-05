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
            'type' => 0
        ]);
        DB::table('villages')->insert([
            'name' => 'Provatas'
        ]);
        DB::table('villages')->insert([
            'name' => 'A. Kamila'
        ]);
        DB::table('villages')->insert([
            'name' => 'K. Kamila'
        ]);
        DB::table('villages')->insert([
            'name' => 'K. Mitrousi'
        ]);
        DB::table('villages')->insert([
            'name' => 'Koumaria'
        ]);
        DB::table('villages')->insert([
            'name' => 'Skoutari'
        ]);
        DB::table('villages')->insert([
            'name' => 'Adelfiko',
            'type' => 2
        ]);
        DB::table('villages')->insert([
            'name' => 'Ag. Eleni'
        ]);
        DB::table('villages')->insert([
            'name' => 'Peponia'
        ]);
    }
}
