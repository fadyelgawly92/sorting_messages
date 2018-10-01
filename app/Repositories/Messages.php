<?php

namespace App\Repositories ;

use GuzzleHttp\Client;

class Messages 
{
    protected $client;

    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    public function all()
    {   
        $response = $this->client->request('GET');
    
        $my_messages = json_decode( $response->getBody()->getContents() ) ;
        return  $my_messages->feed->entry ;
    }
}