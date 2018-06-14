<?php
namespace App\Libs;

class Geodecode {
    private static $_instance= null;

    public static $name;
    public static $lat;
    public static $lng;

    private function __construct () { }
    public static function getInstance ()
    {
        if (self::$_instance === null) {
            self::$_instance = new self;
        }

        return self::$_instance;
    }
    
    /////
    // Curl function gets city position coordinate from google geocode API
    // @paramter(city) - Text city name
    ////
    public  function gedecode($city){

        $url = "https://maps.googleapis.com/maps/api/geocode/json?address=$city&key=".env('GOOGLE_MAPS_API_KEY');

        $ch = curl_init(); 

        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         $result = curl_exec($ch);
         if ($result === FALSE) {
             die('Send Error: ' . curl_error($ch));
         }
        curl_close($ch);
        $res =json_decode( $result );
        //return if no data retrieved 
        if(!isset($res->results[0])){
            return $this;
        }

        //set city coordinates
        self::$lat = $res->results[0]->geometry->location->lat;
        self::$lng = $res->results[0]->geometry->location->lng;

        return $this;
    }

    public  function getLocatoin(){
        return json_encode(array(
            'lat' => self::$lat,
            'lng' => self::$lng,
        ));
    }
}
?>