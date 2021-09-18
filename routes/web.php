<?php

use Illuminate\Support\Facades\Route;
// use Nexmo\Client;
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

Route::group(['middleware' => ['auth']], function(){

    Route::group(['prefix' => 'campaigns'], function(){
        Route::get('/', 'CampaignsController@campaigns')->name('campaigns');
        Route::get('/preparefile', 'CampaignsController@preparefile')->name('preparefile');
        Route::post('/store_csv_values', 'CampaignsController@store_csv_values');
        
        Route::group(['prefix' => 'contact_campaign'], function(){
            Route::get('/{id}', 'CampaignsController@contact_campaign');
            Route::post('/send_message', 'ChatController@send_message');
            Route::post('/receive_message', 'ChatController@receive_message');
            
        });
    
        Route::group(['prefix' => 'files'], function(){
            Route::post('/temporary_upload', 'CampaignsController@temporary_upload');
        });
        
    });
    
    Route::group(['prefix' => 'conversations'], function(){
        Route::get('/', 'ChatController@conversations')->name('conversations');
        Route::post('/update_unread', 'ChatController@update_unread');
        Route::post('/refresh_conversations', 'ChatController@refresh_conversations');
    });
    
    
    Route::get('/', 'CampaignsController@campaigns')->name('campaigns');
});




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
