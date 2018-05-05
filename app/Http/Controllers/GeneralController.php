<?php

namespace App\Http\Controllers;

use App\Services\DistanceCalculator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class GeneralController extends Controller
{
    public function calculate(Request $request)
    {
        //convert json to object
        //calculus
        //response with object
    }

    public function index(){
        //return all towns, all routes
    }

    public function distanceCalculator(Request $request) {
        if ($request->input['hasData']) {
            //calc for those data
        } else {
            $distance = new DistanceCalculator();

            $combinations = DB::select(DB::raw(
                'SELECT vil.name as route, vill.name as dest FROM TrashDisposalSystem.connections as conn
                      INNER JOIN TrashDisposalSystem.villages as vil ON vil.id = conn.route_village
                      INNER JOIN TrashDisposalSystem.villages as vill ON vill.id = conn.connected_village;'
            ));

            $combinationArr = [];
            foreach ($combinations as $combination) {
                $revert = (object)[
                    'route' => $combination->dest,
                    'dest' => $combination->route
                ];

                if(array_search($revert, $combinationArr) === false)  {
                    $combinationArr[] = $combination;
                }

            }

            $calculated = [];
            foreach ($combinationArr as $key => $value) {
                $coordinates = [];
                foreach ($value as $v) {
                    $coordinates[$v] = DB::table('villages')
                        ->select('latitude', 'longitude')
                        ->where('name', $v)
                        ->first();
                }

                foreach ($value as $path => $vil) {
                    if ($path == 'route') {
                        $route_lat = $coordinates[$vil]->latitude;
                        $route_lon = $coordinates[$vil]->longitude;
                    } else {
                        $des_lat = $coordinates[$vil]->latitude;
                        $des_lon = $coordinates[$vil]->longitude;
                    }
                }

                $calc = $distance->calculateDistance($route_lat, $route_lon, $des_lat, $des_lon);
                $calculated[] = [
                    'from' => $value->route,
                    'to' => $value->dest,
                    'distance_km' => $calc['km_distance'],
                    'distance_m' => $calc['meters_distance']
                ];
            }
        }

        return $calculated;
    }



}