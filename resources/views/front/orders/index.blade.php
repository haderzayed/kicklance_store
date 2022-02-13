@extends('layouts.front')

@section('content')
    <x-alerts></x-alerts>
   <h2 class="text-center">{{trans('order.my_order')}}</h2>
    <table class="table" style="width:50%;margin-left:400px;">
        <thead>
        <tr>
            <th scope="col">#</th>
            <th scope="col">Total</th>
            <th scope="col">Status</th>
            <th scope="col">Time</th>
            <th scope="col"></th>
        </tr>
        </thead>
        <tbody>
        <?php $i=0;?>
        @forelse($orders as $order )
            <tr>
                <?php $i++;?>
                <td><a href="{{route('order.show',$order->id)}}">{{$i}}</a></td>
                <td>{{$order->total}}</td>
                <td>{{$order->status}}</td>
                <td>{{$order->created_at}}</td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="text-center">No Products</td>
            </tr>
        @endforelse

        </tbody>
    </table>

@endsection
