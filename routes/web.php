<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::group(['namespace' => 'Dashboard', 'prefix' => 'dashboard'],
    function() {
        Route::get('/', 'DashboardController@index')->name('dashboard');
        Route::resource('team', 'TeamController');
        Route::resource('competition', 'CompetitionController');
    }
);