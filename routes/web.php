<?php

use GuzzleHttp\Client;

Route::get('/','MessagesController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
