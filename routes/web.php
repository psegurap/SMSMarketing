<?php

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


Route::group(['prefix' => 'campaigns'], function(){
    Route::get('/', 'CampaignsController@campaigns')->name('campaigns');
    Route::get('/preparefile', 'CampaignsController@preparefile')->name('preparefile');

    Route::group(['prefix' => 'files'], function(){
        Route::post('/temporary_upload', 'CampaignsController@temporary_upload');
    });
    
});

Route::get('/', function () {
    return view('campaigns');
})->name('campaigns');
