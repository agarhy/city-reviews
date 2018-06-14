<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libs\ReviewsService;

class HomeController extends Controller
{
    public function home($filtersType=''){
        $feedUrl='https://spreadsheets.google.com/feeds/list/0Ai2EnLApq68edEVRNU0xdW9QX1BqQXhHRl9sWDNfQXc/od6/public/basic';
        
        $tags=['positive','negative','all'];
        if(in_array($filtersType,$tags)){
            $filters['type']=$filtersType;
        }
        
        $review = ReviewsService::getInstance();
        $review->setFeedUrl($feedUrl);
        $review->fetchFeed();
        $list = $review->loadEntires($limit=10,$offset=1,$filters);

  
        return view('home',compact('list'));
    
    }
}
