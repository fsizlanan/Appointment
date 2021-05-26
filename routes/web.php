<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Artisan;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\front\indexController;
use GuzzleHttp\Middleware;

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
//     return view('welcome');
// });
Route::group(['prefix'=>'cron'],function(){
    Route::get('/reminder', function(){
        Artisan::call('Reminder:Start');
    });
});


Route::get('/', 'Front\indexController@index')->name('index');
Route::get('/detail', 'Front\indexController@detail')->name('detail');
 


Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');


Route::group(['namespace'=>'Admin', 'prefix'=>'admin', 'as'=>'admin.', 'middleware' => ['auth']], function(){
    Route::get('/', 'indexController@index')->name('index');
    Route::get('/working', 'indexController@working')->name('working'); 

});