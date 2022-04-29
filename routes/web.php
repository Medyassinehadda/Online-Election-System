<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CondidatController;
use App\Http\Controllers\VoterController;
use App\Models\Condidat;
use App\Models\Voter;


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

// Route::get('/', function () {
//     $condidats = Condidat::all();
//     // dd($condidats);
//     return view('welcome', ["condidats"=>$condidats]);
// });

Route::get('/', [CondidatController::class,'index'] );

Route::resource('condidats', CondidatController::class);

Route::get('/condidats/create', function () {
    return view('condidats/create');
})->name('create page condidats');

Route::resource('voters', VoterController::class);

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::get('/test', function () {
    return view('test');
});