<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href="{{asset('css/style.css')}}" rel="stylesheet">
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">

 @yield('css')

</head>
<body class="antialiased">
@include('layouts.admin.navbar')
<div class="container px-4">
    <div class="row gx-5 mt-5">
    <div class="col-3">
        @include('layouts.admin.sidebar')
    </div>
<div class="col-9 ">
    <h2>@yield('page-title','title')</h2>
    @yield('content')
</div>

</div>
</div>
<script src="{{asset('js/bootstrap.js')}}"></script>
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="https://js.pusher.com/7.0/pusher.min.js"></script>
<script>

    // Enable pusher logging - don't include this in production
    Pusher.logToConsole = true;

    var pusher = new Pusher('f49db998330f5fcbdb3c', {
        cluster: 'eu',
        authEndpoint: '/broadcasting/auth'
    });

    var channel = pusher.subscribe('private-orders');
    channel.bind('order-created', function(data) {
          alert(`new order created #`+ data.order.id)
      //  alert(JSON.stringify(data));
    });
</script>
@yield('js')
</body>
</html>
