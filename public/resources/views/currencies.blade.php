@extends('layouts.front')

@section('content')

    <h2 class="m-5">All Currencies</h2>
    <div class="alert alert-info m-5" style="width:500px;text-align: center;">
        <img src="https://https://openweathermap.org/img/wn/{{ $weather['weather'][0]['icon']}}.png">
        <span class="h4 m-2">{{$weather['weather'][0]['icon']}}</span>
       <span class="h4 m-2">{{$weather['main']['temp']}}</span>

    </div>
    <table class="table" style="width:50%; margin:70px;">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Code</th>
            <th scope="col">Name</th>
            <th scope="col">Symbol</th>
        </tr>
        </thead>
        <tbody>
        <?php $i=0;?>
        @forelse($currencies as $currency )
            <tr>
                <?php $i++;?>
                <td>{{$i}}</td>
                <td>{{$currency['id']}}</td>
                <td>{{$currency['currencyName']}}</td>
                <td>{{$currency['currencySymbol'] ?? ''}}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">No Currencies</td>
            </tr>
        @endforelse

        </tbody>
    </table>
@endsection
