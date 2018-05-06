<?php

namespace App\Console\Commands;

use App\Services\DistanceCalculator;
use App\VillageConnection;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class DistanceCalc extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'calc';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $vC = VillageConnection::all();
        $d = new DistanceCalculator();

        $baseLine = '$matrix[#sLat#][#sLon#][#tLat#][#tLon#] = #val#';
        $totalString = "";
        foreach ($vC as $connection) {
            $route = DB::select(DB::raw(
                'SELECT latitude, longitude FROM villages WHERE id = ' . $connection->route_village
            ));

            $dest = DB::select(DB::raw(
                'SELECT latitude, longitude FROM villages WHERE id = ' . $connection->connected_village
            ));

            $line = str_replace("#sLat#", $route[0]->latitude, $baseLine);
            $line = str_replace("#sLon#", $route[0]->longitude, $line);
            $line = str_replace("#tLat#", $dest[0]->latitude, $line);
            $line = str_replace("#tLon#", $dest[0]->longitude, $line);

            $distance = $d->calculateDistance($route[0]->latitude, $route[0]->longitude, $dest[0]->latitude, $dest[0]->longitude);

            $line = str_replace("#val#", $distance['meters_distance'], $line);
            $totalString = $totalString . PHP_EOL . $line;
        }
        dd($totalString);
    }
}
