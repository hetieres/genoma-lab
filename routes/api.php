<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
 */

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

/* API Routes */
Route::group(['prefix' => 'admin/ajax', 'middleware' => 'ajax'], function () {
    Route::get('get-users/{app?}', 'UserController@list')->name('list-user');
    Route::post('create-user', 'UserController@createUpdate')->name('create-user');
    Route::post('edit-user', 'UserController@editProfile')->name('edit-user');
    Route::delete('del-user/{id}', 'UserController@destroy')->name('delete-user');
    Route::post('published-user', 'UserController@toogleActive')->name('toogle-active-user');

    Route::post('genetic-test-import', 'GeneticTestController@import');

    Route::post('post-save', 'PostController@save');
    Route::get('post-list', 'PostController@list');
    Route::post('post-del', 'PostController@delete');
    Route::post('post-destroy-image', 'PostController@destroyImage');
    Route::post('post-view-image', 'PostController@imageEditView');
    Route::post('post-order-save', 'PostController@orderSave');
    Route::post('post-upload', 'PostController@upload');
    Route::post('post-upload-del', 'PostController@uploadDestroy');
    Route::post('post-load', 'PostController@post');
    Route::post('post-highlight-off', 'PostController@highlightOff');


    Route::post('link-save', 'LinkController@save');
    Route::get('link-list', 'LinkController@list');
    Route::post('link-del', 'LinkController@delete');

    Route::get('get-news', 'NewsController@list');
    Route::post('news-delete', 'NewsController@delete');
    Route::post('news-save', 'NewsController@createUpdate');
    Route::post('news-multiple-save', 'NewsController@multipleSave');
    Route::post('news-equals', 'NewsController@equals');
    Route::post('news-destroy-image', 'NewsController@destroyImage');
    Route::post('news-view-image', 'NewsController@imageEditView');
    Route::get('news/all-combo-box', 'NewsController@allComboBox');

    Route::get('vehicle-get', 'VehicleController@list');
    Route::post('vehicle-save', 'VehicleController@createUpdate');
    Route::post('vehicle-multiple-save', 'VehicleController@multipleSave');
    Route::get('vehicle/all-combo-box', 'VehicleController@allComboBox');

    Route::post('session-save', 'SessionController@save');

    Route::post('report/news', 'ReportController@reportNews');
    Route::get('report/team', 'ReportTeamController@report');
});

Route::group(['prefix' => 'site', 'middleware' => 'ajax'], function () {
    Route::get('get-news-featured/{id}', 'SiteApiController@getNewsFeatured')->name('site-get-news-featured');
    Route::get('get-news/{type?}', 'SiteApiController@getNews')->name('site-get-news');
    Route::get('get-news-vehicles', 'SiteApiController@getNewsVehicles')->name('site-get-news-vehicles');
});

Route::group(['prefix' => 'ajax'], function () {
    Route::get('get-news-home', 'SiteController@index');
    Route::get('bv-links', 'ApiController@bv')->middleware('fapesp');
});

Route::get('clipping-service', 'ApiController@clippingService');
Route::get('bv-links', 'ApiController@bv2');

Route::post('genetic-test-status-bar', 'GeneticTestController@statusBar');