<?php

namespace App\Http\Controllers;

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
            $combinations = DB::select(DB::raw(
                'SELECT vil.name as route, vill.name as dest FROM TrashDisposalSystem.connections as conn
                      INNER JOIN TrashDisposalSystem.villages as vil ON vil.id = conn.route_village
                      INNER JOIN TrashDisposalSystem.villages as vill ON vill.id = conn.connected_village;'
            ));

            foreach ($combinations as $combination) {

            }

            dd($combinations);

//            foreach ($combinations as $combination) {
//
//            }
        }
    }



}