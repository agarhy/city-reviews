<?php
namespace App\Libs;
use App\Libs\Geodecode;
use App\Libs\Watson;

Class Review{

    private $id;
    private $updated;
    private $title;
    private $content;

    private $messageid;
    private $message;
    private $sentiment;

    private $city;
    private $lat;
    private $lng;


    public function __construct(){
        //inject watson
    }

    public function setid($id){ $this->id = $id;  }
    public function getId(){ return $this->id; }

    public function setupdated($updated){ $this->updated = $updated;  }
    public function getUpdated(){ return $this->updated; }

    public function settitle($title){ $this->title = $title;  }
    public function getTitle(){ return $this->title; }

    public function setcontent($content){ $this->content = $content;  }
    public function getContent(){ return $this->content; }

    
    public function getMsgId(){ return $this->messageid; }

    public function getMsg(){ return $this->message; }

    public function getSentiment(){ return $this->sentiment; }
    public function getCity(){ return $this->city; }
    public function getLat(){ return $this->lat; }
    public function getLng(){ return $this->lng; }
    public function __toString()
    {
        return json_encode(array(
                'id' => $this->id,
                'date' => $this->updated,
                'message' => $this->message,
                'sentiment' => $this->sentiment,
                'city' => $this->city,
                'lat' => $this->lat,
                'lng' => $this->lng,
        ));
    }

    public function getPoints(){ 
        $geoPoint = new stdClass();
        $geoPoint->lat = $this->lat;
        $geoPoint->lng = $this->lng;
        return json_encode($geoPoint); 
    }


    public function extractContent(){
        //echo $this->content;

        $content = explode(', ',$this->content);
           

        $content_=array();
        if(count($content)>=3){
            $content_[0]=$content[0];
            $content_[1]='';
            $n=1;
            while($n<count($content)-1){
                $content_[1].=$content[$n];
                
                if($n+1<count($content)-1)
                    $content_[1].=', ';

                $n+=1;
            }
            $content_[2]=$content[count($content)-1];

        }

        
        foreach($content_ as $elm){
                $nElm=explode(': ', $elm);
                
                $var=$nElm[0];
                $this->$var = $nElm[1];
        }
        
        //Verfiy feed semtiment , and get city entity
        $this->verifySentiment();
        //Get City location coordinates
        $this->geoDecode();

        return $this;
        
    }

    public function geoDecode(){

        $location = json_decode( 
            Geodecode::getInstance()
                    ->gedecode($this->city)
                    ->getLocatoin()
                );

        $this->lat= $location->lat;
        $this->lng= $location->lng;
    }

    public function verifySentiment(){
        $watson=new Watson;
        $watson->analyze($this->message);
        $this->city = $watson->getCity();
        $this->sentiment = $watson->getSentiment();                    
                
        // set $this->sentiment
    }
}

?>