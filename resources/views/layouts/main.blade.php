<!DOCTYPE html>
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">   
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">

</head>
<body>
<nav class="navbar navbar-expand-sm py-2">
        <div class="container-fluid d-flex justify-content-center text-center">
            <a href="#" class="navbar-brand">{{ config('app.name', 'Laravel') }}</a>
            <button class="navbar-toggler" data-toggle="collapse" data-target="#navbarItems">
                <span class="navbar-toggler-icon"></span>
            </button>
        </div>

    </nav>
    <header>
        <div class="d-flex flex-row m-2 align-content-center" id="filters ">
            <div class="float-left btn btn-outline-gray "><i class="fa fa-filter"></i> </div>
            <div id="sentiment" class="mr-2">
           
                <a href="{{ URL::to('all') }}" class="btn btn-mini btn-primary">All</a>
                <a href="{{ URL::to('positive') }}" class="btn btn-mini btn-primary">Positive</a>
                <a href="{{ URL::to('negative') }}" class="btn btn-mini btn-primary">Negative</a>
         
        
                
            </div>
            <!-- <div id="city">
                    <select class="custom-select">
                    <option selected>City</option>
                    <option value="1">One</option>
                    <option value="2">Two</option>
                    <option value="3">Three</option>
                    </select>
            </div> -->
        </div>
    </header>

    <div class="container-fluid px-0 ">
        <div class="d-flex flex-column-reverse flex-md-row ">
            @yield('content')
        </div>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/popper.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/map.js') }}"></script>
    <script src="https://developers.google.com/maps/documentation/javascript/examples/markerclusterer/markerclusterer.js">
    </script>
    <script src="https://maps.googleapis.com/maps/api/js??v=3.exp&key=AIzaSyDnHdiohry3tzhSuIyNkjJJNu1XKutmTmU&callback=initMap"></script>


</body>
</html>