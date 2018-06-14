<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libs\ReviewsService;

class HomeController extends Controller
{
    public function home($filtersType=''){

        //Set Feed URL
        $feedUrl='https://spreadsheets.google.com/feeds/list/0Ai2EnLApq68edEVRNU0xdW9QX1BqQXhHRl9sWDNfQXc/od6/public/basic';
        
        $filters=null;
        //validate filter-type
        $tags=['positive','negative'];
        if(in_array($filtersType,$tags)){
            $filters['type']=$filtersType;
        }
        
        //Fetch source entries
        $review = ReviewsService::getInstance();
        $review->setFeedUrl($feedUrl);
        $review->fetchFeed();
        $list = $review->loadEntires($limit=10,$offset=1,$filters);

        //re-Check retrived filter-types
        if(isset($filters['type'])){
            foreach($list as $i => $elm){
                if($elm->getSentiment() !== $filters['type'])
                    unset($list[$i]);
            }
        }
        
        return view('home',compact('list'));
    
    }
}
