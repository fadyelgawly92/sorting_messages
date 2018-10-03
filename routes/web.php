<?php

use GuzzleHttp\Client;

Route::get('/','MessagesController@index');
Route::get('/map','MessagesController@map');
Route::get('/split','MessagesController@split');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
