<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\getBooks;
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

Route::get('/', function () {
    return view('index');
});

Route::get("/view",[getBooks::class, 'getBookByData']);

Route::get("/getBar",[getBooks::class, 'getBar']);
Route::get("/closeApp",[getBooks::class, 'closeApp']);
Route::get("/borrow",[getBooks::class, 'borrow']);
