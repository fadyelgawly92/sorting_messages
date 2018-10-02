<?php

use GuzzleHttp\Client;

Route::get('/','MessagesController@index');
Route::get('/map','MessagesController@map');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
