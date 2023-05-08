<?php

use App\Http\Controllers\InfoController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\FOInfoController;
use App\Http\Controllers\FOLoginController;
use Illuminate\Support\Facades\Route;
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
    return view('login');
});

Route::get('/frontOffice', function () {
    return view('loginFO');
});

Route::get('/login', [LoginController::class,"loginAdmin"])->name("loginAdmin");

Route::get('/home',[InfoController::class,"home"])->name(("home"));

Route::get('/listeNonConfirm', [InfoController::class,"listeNonConfirm"])->name("listeNonConfirm");

Route::get('/showToUdpate/{id}', [InfoController::class,"showToUpdate"])->name("showToUpdate");

Route::get('/publier/{id}', [InfoController::class,"publier"])->name("publier");

Route::get('/search',[InfoController::class,"search"])->name("search");

Route::get('/loginFO', [FOLoginController::class,"loginAdmin"])->name("loginAdmin");

Route::get('/homeFO',[FOInfoController::class,"home"])->name(("home"));

Route::get('/addInfoFO', [FOInfoController::class,"insertForm"])->name("insertForm");

Route::post('/createInfoFO', [FOInfoController::class,"insert"])->name("insert");

Route::get('/searchFO',[FOInfoController::class,"search"])->name("search");
