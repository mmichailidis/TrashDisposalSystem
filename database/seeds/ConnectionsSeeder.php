<?php

use Illuminate\Database\Seeder;

class ConnectionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('connections')->insert([
            'route_village' => 1,
            'connected_village' => 2
        ]);
        DB::table('connections')->insert([
            'route_village' => 1,
            'connected_village' => 5
        ]);
        DB::table('connections')->insert([
            'route_village' => 1,
            'connected_village' => 7
        ]);
        DB::table('connections')->insert([
            'route_village' => 2,
            'connected_village' => 1
        ]);
        DB::table('connections')->insert([
            'route_village' => 2,
            'connected_village' => 3
        ]);
        DB::table('connections')->insert([
            'route_village' => 5,
            'connected_village' => 3
        ]);
        DB::table('connections')->insert([
            'route_village' => 5,
            'connected_village' => 4
        ]);
        DB::table('connections')->insert([
            'route_village' => 5,
            'connected_village' => 1
        ]);
        DB::table('connections')->insert([
            'route_village' => 5,
            'connected_village' => 6
        ]);
        DB::table('connections')->insert([
            'route_village' => 7,
            'connected_village' => 1
        ]);
        DB::table('connections')->insert([
            'route_village' => 7,
            'connected_village' => 4
        ]);
        DB::table('connections')->insert([
            'route_village' => 7,
            'connected_village' => 10
        ]);
        DB::table('connections')->insert([
            'route_village' => 7,
            'connected_village' => 9
        ]);
        DB::table('connections')->insert([
            'route_village' => 3,
            'connected_village' => 2
        ]);
        DB::table('connections')->insert([
            'route_village' => 3,
            'connected_village' => 5
        ]);
        DB::table('connections')->insert([
            'route_village' => 3,
            'connected_village' => 6
        ]);
        DB::table('connections')->insert([
            'route_village' => 4,
            'connected_village' => 5
        ]);
        DB::table('connections')->insert([
            'route_village' => 4,
            'connected_village' => 6
        ]);
        DB::table('connections')->insert([
            'route_village' => 4,
            'connected_village' => 7
        ]);
        DB::table('connections')->insert([
            'route_village' => 6,
            'connected_village' => 3
        ]);
        DB::table('connections')->insert([
            'route_village' => 6,
            'connected_village' => 4
        ]);
        DB::table('connections')->insert([
            'route_village' => 6,
            'connected_village' => 8
        ]);
        DB::table('connections')->insert([
            'route_village' => 10,
            'connected_village' => 8
        ]);
        DB::table('connections')->insert([
            'route_village' => 10,
            'connected_village' => 7
        ]);
        DB::table('connections')->insert([
            'route_village' => 10,
            'connected_village' => 9
        ]);
        DB::table('connections')->insert([
            'route_village' => 9,
            'connected_village' => 10
        ]);
        DB::table('connections')->insert([
            'route_village' => 9,
            'connected_village' => 7
        ]);
        DB::table('connections')->insert([
            'route_village' => 8,
            'connected_village' => 6
        ]);
        DB::table('connections')->insert([
            'route_village' => 8,
            'connected_village' => 10
        ]);
        DB::table('connections')->insert([
            'route_village' => 6,
            'connected_village' => 5
        ]);
    }
}
