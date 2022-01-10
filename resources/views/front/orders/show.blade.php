@extends('layouts.front')

@section('content')
      <h2>Order # {{$order->id}}</h2>

      <table class="table ">
          <thead>
          <tr>
              <th scope="col">Product</th>
              <th scope="col">Quantity</th>
              <th scope="col">Price</th>
              <th scope="col">Total</th>
              <th scope="col"></th>
          </tr>
          </thead>
          <tbody>

          @forelse($order->products as $product )
              <tr>
                  <td>{{$product->name}}</td>
                  <td>{{$product->pivot->quantity}}</td>
                  <td>{{$product->pivot->price}}</td>
                  <td>{{$product->pivot->price * $product->pivot->quantity}}</td>
              </tr>
          @empty
              <tr>
                  <td colspan="7" class="text-center">No Products</td>
              </tr>
          @endforelse

          </tbody>
      </table>
@endsection
