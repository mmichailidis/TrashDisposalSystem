<?php
/**
 * Created by PhpStorm.
 * User: orestis
 * Date: 5/5/2018
 * Time: 1:22 μμ
 */

namespace App\Services;

define('GOOGLE_DEST_URL', 'https://maps.googleapis.com/maps/api/distancematrix/json?');

class DistanceCalculator
{
    public function ddd($lat_route, $lon_route, $des_lat, $des_lon)
    {
        $matrix['41.092083']['23.541016']['41.068238']['23.390686'] = 15126;
        $matrix['41.092083']['23.541016']['41.05868']['23.457547'] = 9423;
        $matrix['41.092083']['23.541016']['41.020032']['23.520701'] = 9140;
        $matrix['41.068238']['23.390686']['41.092083']['23.541016'] = 14183;
        $matrix['41.068238']['23.390686']['41.05832']['23.424134'] = 5144;
        $matrix['41.05868']['23.457547']['41.05832']['23.424134'] = 3064;
        $matrix['41.05868']['23.457547']['41.020431']['23.483293'] = 7040;
        $matrix['41.05868']['23.457547']['41.092083']['23.541016'] = 9373;
        $matrix['41.05868']['23.457547']['41.016434']['23.434656'] = 5511;
        $matrix['41.020032']['23.520701']['41.092083']['23.541016'] = 9100;
        $matrix['41.020032']['23.520701']['41.020431']['23.483293'] = 3218;
        $matrix['41.020032']['23.520701']['40.988154']['23.516756'] = 4488;
        $matrix['41.020032']['23.520701']['41.003545']['23.559196'] = 4622;
        $matrix['41.05832']['23.424134']['41.068238']['23.390686'] = 5144;
        $matrix['41.05832']['23.424134']['41.05868']['23.457547'] = 3064;
        $matrix['41.05832']['23.424134']['41.016434']['23.434656'] = 6272;
        $matrix['41.020431']['23.483293']['41.05868']['23.457547'] = 7275;
        $matrix['41.020431']['23.483293']['41.016434']['23.434656'] = 5735;
        $matrix['41.020431']['23.483293']['41.020032']['23.520701'] = 3251;
        $matrix['41.016434']['23.434656']['41.05832']['23.424134'] = 6399;
        $matrix['41.016434']['23.434656']['41.020431']['23.483293'] = 5833;
        $matrix['41.016434']['23.434656']['41.014645']['23.457354'] = 2466;
        $matrix['40.988154']['23.516756']['41.014645']['23.457354'] = 6821;
        $matrix['40.988154']['23.516756']['41.020032']['23.520701'] = 4019;
        $matrix['40.988154']['23.516756']['41.003545']['23.559196'] = 4734;
        $matrix['41.003545']['23.559196']['40.988154']['23.516756'] = 4784;
        $matrix['41.003545']['23.559196']['41.020032']['23.520701'] = 4622;
        $matrix['41.014645']['23.457354']['41.016434']['23.434656'] = 2427;
        $matrix['41.014645']['23.457354']['40.988154']['23.516756'] = 6821;
        $matrix['41.016434']['23.434656']['41.05868']['23.457547'] = 5511;

        return $matrix[strval($lat_route)][strval($lon_route)][strval($des_lat)][strval($des_lon)];
    }

    public function calculateDistance($lat_route, $lon_route, $des_lat, $des_lon)
    {
        return ['meters_distance' => $this->ddd($lat_route, $lon_route, $des_lat, $des_lon)];
//        $distance = $this->setupUrl($lat_route, $lon_route, $des_lat, $des_lon);
//        $distanceDec = json_decode($distance);
//
//        if ($distanceDec->status != "OK") {
//            dd($distance);
//        }
//
//        $result = $this->formatResult($distanceDec->rows);
//
//        return $result;
    }

    private function curlGoogleDistanceApi($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        $result = curl_exec($ch);
        curl_close($ch);

        return $result;
    }

    private function setupUrl($lat_route, $lon_route, $des_lat, $des_lon)
    {
        $url = GOOGLE_DEST_URL . "origins=$lat_route,$lon_route&destinations=$des_lat,$des_lon&key=AIzaSyAGrQY2qHDggcQI9Htkw8oDsBwbmchBkig";

        $result = $this->curlGoogleDistanceApi($url);
        return $result;
    }

    private function formatResult($distance)
    {
        $parseDist = $distance[0]->elements[0]->distance;

        $distArr = [
            'km_distance' => $parseDist->text,
            'meters_distance' => $parseDist->value
        ];

        return $distArr;
    }
}