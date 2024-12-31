<?php

use App\Http\Controllers\brtController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Http;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/data_analysis', function (Request $request) {
    $brtController = new brtController();
    $result = $brtController->data_analysis($request);
    return view('analysis', ['result' => $result, 'startdate' => $request->startdate, 'enddate' => $request->enddate]);
});

Route::get('/notification', function () {
    return view('notification');
});
