<?php

Route::group(['middleware' => ['web']], function () {

    Route::get('/', 'PagesController@home');

    Route::get('/', function () {
        return view('pages.home');
    });

    Route::resource('flyers', 'FlyersController');
    Route::get('{zip}/{street}', 'FlyersController@show');
    Route::post('{zip}/{street}/photos', ['as' => 'store_photo_path', 'uses'=> 'PhotosController@store']);
    Route::delete('photos/{id}', 'PhotosController@destroy');

    Route::auth();

    Route::get('about', function(){
        return 'about pages';
    });
});
