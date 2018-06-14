<?php
namespace App\Libs;
use App\Libs\Review;

class ReviewsService {
    public static $instance;

    private $feedUrl;
    private $feedXML;
    private $xmlDoc;
    private $ReviewsList=array();

    public static function getInstance(){
       return ReviewsService::$instance = new ReviewsService();
    }

    private function __construct(){
        
    }

    public function setFeedUrl($url){    
        $this->feedUrl = $url;
    }


    public function getFeedUrl($url){    
        return $this->feedUrl;
    }

    public function fetchFeed(){

        $this->xmlDoc = new \DOMDocument();
        $this->xmlDoc->load($this->feedUrl);
        $this->feedXML = $this->xmlDoc->saveXML();               
    }

    public function loadEntires($limit=5,$offset=0,$filters){
        //$xmlObj = simplexml_load_string($this->feedXML);
        
        $xpath = new \DOMXPath($this->xmlDoc);
        $rootNamespace = $this->xmlDoc->lookupNamespaceUri($this->xmlDoc->namespaceURI); 
        $xpath->registerNamespace('feed', $rootNamespace);

        $to_offset=$offset+$limit;
        
        //$query = "//feed:entry[position() >= $offset and position() < $to_offset]";
        if(isset($filters['type']) && $filters['type']=='positive')
            $query = "//feed:entry[feed:content[contains(text(), 'Positive')]]";
        elseif(isset($filters['type']) && $filters['type']=='negative')
            $query = "//feed:entry[feed:content[contains(text(), 'Negative')]]";
        else
            $query = "//feed:entry";
        //echo $xpath->query($query)->length;
        $nodes = $xpath->query($query);

        foreach($nodes as $entry){
            if($entry->hasChildNodes())
            {
               
                // echo '<pre>';
                // dump($entry->childNodes);
                // echo '</pre>';
                $tags=['id','updated','title','content'];
                $review = new Review;
                foreach($entry->childNodes as $child){

                    if(in_array($child->nodeName, $tags)){
                        
                        
                        $func= 'set'.$child->nodeName;
                    
                        $val = $child->ownerDocument->saveHTML( $child->firstChild );
                        $review->$func( $val );
                    }

                    
                    // dump($child->nodeName);
                    // dump($child->ownerDocument->saveHTML( $child->firstChild ));
                }

                $review->extractContent()->verifySentiment();
                $this->ReviewsList[]=$review;
                
            }   
        }

        return $this->ReviewsList;
       
    }

    // public function getNext($nodeId){

    // }
    // public function getPrev($nodeId){
        
    // }
    public function loadNodeById($nodeId){
        $xpath = new \DOMXPath($this->xmlDoc);
        $rootNamespace = $this->xmlDoc->lookupNamespaceUri($this->xmlDoc->namespaceURI); 
        $xpath->registerNamespace('feed', $rootNamespace);
        dump($xpath);
        $query = "//feed:entry[feed:id ='$nodeId']";
        echo $xpath->query($query)->length;
        $nodes = $xpath->query($query);

        foreach($nodes as $node){
            if($node->hasChildNodes())
            {
                dump($node);
                echo '<pre>';
                var_dump($node->childNodes);
                echo '</pre>';

                foreach($node->childNodes as $child){
                    dump($child->nodeName);
                    dump($child->ownerDocument->saveHTML( $child->firstChild ));
                }
            }   
        }
    }

    //get from source
    //retrive by filters
    //parse xml

    //verify sentiment
}

?>