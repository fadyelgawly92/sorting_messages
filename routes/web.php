<?php

use GuzzleHttp\Client;

Route::get('/', function () {

    $client = new Client([
        'headers' => ['content-type' => 'application/json' , 'Accept' => 'application/json'],
        'base_uri' => 'https://spreadsheets.google.com/feeds/list/0Ai2EnLApq68edEVRNU0xdW9QX1BqQXhHRl9sWDNfQXc/od6/public/basic?alt=json',
        // 'timeout'  => 2.0,
    ]);
    
    $response = $client->request('GET');

    $my_messages = json_decode( $response->getBody()->getContents() ) ;
    $messages =  $my_messages->feed->entry ;
    $t = "\$t";   
    // dd($messages[0]->content->$t);
    return view('messages.index' , compact('messages', 't'));
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
