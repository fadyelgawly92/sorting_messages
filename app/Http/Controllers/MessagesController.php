<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Messages;
use FarhanWazir\GoogleMaps\GMaps;
use Illuminate\Support\Facades\Session;




class MessagesController extends Controller
{
    protected $messages;
    protected $gmaps;

    public function __construct(Messages $messages , GMaps $gmaps)
    {
        $this->messages = $messages;
        $this->gmaps = $gmaps;
    }

    public function index()
    {
        $t = "\$t";   
        // dd($messages[0]->id->$t);
        $messages = $this->messages->all(); 

        return view('messages.index' , compact('messages', 't'));
    }

    public function split()
    {
        $t = "\$t"; 
        $messages = $this->messages->all();
        foreach($messages as $message){
            $string = $message->content->$t ;
            $result = preg_split('/sentiment:/',$string);
            if(count($result)>1){
                $result_split = explode(' ',$result[1]);
                print_r($result_split[1]);
                echo '<br/>';
            }
        }
    }

    public function map()
    {
        $marker = array();
        $config = array();
        $config['center'] = 'Cairo, Egypt';
        $config['zoom'] = '16';
        $config['map_height'] = '500px';
        // $config['map_width'] = '500px';
        $config['scrollwheel'] = false;

        $this->gmaps->initialize($config);

        //Add Marker
        $marker['position'] = 'Tahrir Square Egypt';
        $marker['infowindow_content'] = 'midan el tahrir';
        $marker['icon'] = 'http://maps.google.com/mapfiles/kml/paddle/grn-blank.png';

        $this->gmaps->add_marker($marker);

        $map = $this->gmaps->create_map();

        return view('messages.map')->with('map',$map);
    }

}
