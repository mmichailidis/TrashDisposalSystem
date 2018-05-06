<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

use Illuminate\Support\Facades\Route;

Route::get('/', 'GeneralController@index');

Route::post('/calculate', 'GeneralController@distanceCalculator');

Route::post('/demo', 'GeneralController@demo');
Route::post('/b2', 'GeneralController@questionB2');
Route::post('/b3', 'GeneralController@questionB3');
Route::post('/b4', 'GeneralController@questionB4');