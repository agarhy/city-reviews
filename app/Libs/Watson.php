<?php 
namespace App\Libs;

class Watson{
   

    private  $result;
    private  $city;
    private  $sentiment;

    public function __construct () { }

    public function analyze($text){
        $text =urlencode( $text);

        $url = "https://gateway.watsonplatform.net/natural-language-understanding/api/v1/analyze?version=2017-02-27&text=$text&features=entities%2Csentiment&return_analyzed_text=false&clean=true&fallback_to_raw=true&concepts.limit=8&emotion.document=true&entities.limit=50&entities.mentions=false&entities.emotion=false&entities.sentiment=false&keywords.limit=50&keywords.emotion=false&keywords.sentiment=false&relations.model=en-news&semantic_roles.limit=50&semantic_roles.entities=false&semantic_roles.keywords=false&sentiment.document=true";

         $headers = array(
            'Content-Type: application/json'
            );
        
       

         // create curl resource 
         $ch = curl_init(); 
         curl_setopt($ch, CURLOPT_USERPWD, "b3b49399-4b15-4360-a615-5e173aa5c32f:OHVQ2Dq8QTsL");
         
         curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
         curl_setopt($ch, CURLOPT_URL, $url);

         curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
         $result = curl_exec($ch);
         if ($result === FALSE) {
             die('Send Error: ' . curl_error($ch));
         }
         curl_close($ch);
         $res=json_decode($result) ;
         if(isset($res->error))
            return json_encode(array('status'=>false,'error'=> $res->error, 'code'=> $res->code));
        
         if(!isset($res->entities) || count($res->entities) < 1)
            return json_encode(array('status'=>false,'error'=> "IBM Watson is unable to analyze sentance"));
         
           
         foreach($res->entities as $elm){
             if($elm->type == "Location" && in_array("City", $elm->disambiguation->subtype) ){
                $this->city = $elm->text;
               
                break;
             }
         }

         $this->sentiment = $res->sentiment->document->label;

         //dump($res);

         return $this;
    }
    public  function getCity(){
        return $this->city;
    }
    public  function getSentiment(){
        return $this->sentiment;
    }

}

?>