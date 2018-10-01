<?php

namespace App\Repositories ;

use GuzzleHttp\Client;

class Messages 
{
    public function all()
    {
        $client = new Client([
            'headers' => ['content-type' => 'application/json' , 'Accept' => 'application/json'],
            'base_uri' => 'https://spreadsheets.google.com/feeds/list/0Ai2EnLApq68edEVRNU0xdW9QX1BqQXhHRl9sWDNfQXc/od6/public/basic?alt=json',
        ]);
        
        $response = $client->request('GET');
    
        $my_messages = json_decode( $response->getBody()->getContents() ) ;
        return  $my_messages->feed->entry ;
    }
}