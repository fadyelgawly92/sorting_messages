<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Messages;

class MessagesController extends Controller
{
    protected $messages;

    public function __construct(Messages $messages)
    {
        $this->messages = $messages;
    }

    public function index()
    {
        $t = "\$t";   
        // dd($messages[0]->id->$t);
        $messages = $this->messages->all(); 
        
        $config['center'] = 'Air Canada Centre , Toronto';
        $config['zoom'] = '14';
        $config['map_height'] = '500px';
        // $config['map_width'] = '500px';
        $config['scrollwheel'] = false;

        return view('messages.index' , compact('messages', 't'));
    }

}
