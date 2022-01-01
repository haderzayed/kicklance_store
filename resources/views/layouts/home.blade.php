<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://pro.fontawesome.com/releases/v5.10.0/css/all.css" integrity="sha384-AYmEC3Yw5cVb3ZcuHtOA93w35dYTsvhLPVnYs9eStHfGJvOvKxVfELGroGkvsg+p" crossorigin="anonymous"/>
    <link href="{{asset('css/bootstrap.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css')}}" rel="stylesheet">

</head>
<body class="antialiased">
@include('layouts.navbar')
<div class="container px-4">
    <div class="row gx-5 mt-5">
    <div class="col-3">
        @include('layouts.sidebar')
    </div>
<div class="col-8 ">
    <h2 style="text-align:center;">@yield('page-title','title')</h2>
    @yield('content')
</div>

</div>
</div>
<script src="{{ asset('js/bootstrap.js') }}"></script>

</body>
</html>
