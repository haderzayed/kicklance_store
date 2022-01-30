@extends('layouts.front')

@section('content')

   <h2 class="m-5"> All Currencies</h2>
   <div class="alert alert-info m-5" style="width: 500px; text-align: center">
       <img src="https://openweathermap.org/img/wn/{{$weather['weather'][0]['icon']}}@2x.png">
        <span class="h4">{{$weather['weather'][0]['description']}}</span>
        <span class="h1">{{$weather['main']['temp']}}</span>
   </div>
    <table class="table m-5" style="width: 50%">
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
                <td> {{$i}} </td>
                <td>{{$currency['id']}}</td>
                <td>{{$currency['currencyName']}}</td>
                <td>{{$currency['currencySymbol'] ?? ''}}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">No currencies</td>
            </tr>
        @endforelse

        </tbody>
    </table>
@endsection
