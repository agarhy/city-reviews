@extends('layouts.main')
@section('content')
<div class="col-md-4 px-0 border" >
    
    <div id="review-list">
        <ul class="list-group" ss-container>
            @foreach($list as $entry)
            <li class="list-group-item @if(  $entry->getSentiment()  == 'positive') positive-r @elseif ($entry->getSentiment()  == 'negative') negative-r  @elseif ($entry->getSentiment()  == 'neutral') neutral-r @endif" data-lat="{{ $entry->getLat() }}" data-lng="{{ $entry->getLng() }}" data-sentiment="{{$entry->getSentiment()}}">
                <a href="#">
                    <div class="float-right">
                        <div class="badge badge-light">{{ $entry->getCity() }}</div>
                    </div>
                    <div class="d-flex justify-content-start ">

                        @if(  $entry->getSentiment()  == 'positive')
                        <div class="align-self-baseline badge badge-success mr-2"><i class="fa fa-plus-circle"></i></div>

                        @elseif ($entry->getSentiment()  == 'negative')
                        <div class="align-self-baseline badge badge-danger mr-2"><i class="fa fa-minus-circle"></i></div>
                        @elseif ($entry->getSentiment()  == 'neutral')
                        <div class="align-self-baseline badge badge-primary mr-2"><i class="fa fa-compass"></i></div>
                        @endif
                        <small>{{ $entry->getMsg() }}</small>
                    </div>
                </a>
                
            </li>
            @endforeach
            <!-- <li>
                <a class="btn btn-block btn-lg btn-primary">
                    Load More
                </a>
            </li> -->
                        
        </ul>
    </div>
</div>
<div class="col-md-8 border" id="map-container">
   
</div>
@endsection