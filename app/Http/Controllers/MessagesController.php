<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Messages;
use FarhanWazir\GoogleMaps\GMaps;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\User;
use PragmaRX\Countries\Package\Countries;




class MessagesController extends Controller
{
    protected $messages;
    protected $gmaps;
    protected $sentiment;
    protected $info;

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

    public function split(Request $request)
    {
        $t = "\$t"; 
        $sentiment = array();
        $info = array();
        $messages = $this->messages->all();
        foreach($messages as $message){
            $string = $message->content->$t ;
            $result = preg_split('/sentiment:/',$string);
            if(count($result)>1){
                $result_split = explode(' ',$result[1]);
                array_push($sentiment,$result_split[1]);
            }
            $between = preg_replace('/(.*)message: (.*), sentiment:(.*)/sm', '\2', $string);
            array_push($info , $between);
        }
        $countries = Countries::where('name.common', 'Brazil');
    }

    public function map()
    {
        //array and sorting and messages data
        $t = "\$t"; 
        $countries = ['Damascus', 'Mogadishu' , 'Ibiza' , 'Cairo, Egypt' , 'Tahrir, Cairo' , 'Nairobi', 'Kathmandu', 'Madrid, Spain' , 'Athens', 'Istanbul'];
        $sentiment = array();
        $info = array();
        $messages = $this->messages->all();
        foreach($messages as $message){
            $string = $message->content->$t ;
            $result = preg_split('/sentiment:/',$string);
            if(count($result)>1){
                $result_split = explode(' ',$result[1]);
                array_push($sentiment,$result_split[1]);
            }
            $between = preg_replace('/(.*)message: (.*), sentiment:(.*)/sm', '\2', $string);
            array_push($info , $between);
        }


        //map data
        $marker = array();
        $config = array();
        $config['center'] = 'Cairo, Egypt';
        $config['zoom'] = '16';
        $config['map_height'] = '500px';
        // $config['map_width'] = '500px';
        $config['scrollwheel'] = false;

        $this->gmaps->initialize($config);

        //Add Marker for all data
        for($i=0;$i<count($sentiment);$i++){
            $marker['position'] = $countries[$i];
            $marker['infowindow_content'] = $info[$i];
            if($sentiment[$i] == 'Positive'){
                $marker['icon'] = 'http://maps.google.com/mapfiles/kml/paddle/red-blank.png';
            }elseif($sentiment[$i] == 'Neutral'){
                $marker['icon'] = 'http://maps.google.com/mapfiles/kml/paddle/grn-blank.png';
            }else{
                $marker['icon'] = 'http://maps.google.com/mapfiles/kml/paddle/blu-blank.png';
            }
            $this->gmaps->add_marker($marker);
        }    
        $map = $this->gmaps->create_map();

        return view('messages.map')->with('map',$map);
    }

}
