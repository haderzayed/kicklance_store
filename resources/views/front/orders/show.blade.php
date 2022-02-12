@extends('layouts.front')

@section('content')
    <x-alerts></x-alerts>
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
      <section class="row m-5">
          <h3>payment</h3>
          <form accept-charset="UTF-8" action="https://api.moyasar.com/v1/payments.html" method="POST">
              <input type="hidden" name="callback_url" value="{{url(route('payment.callback',[$order->id]))}}" />
              <input type="hidden" name="publishable_api_key" value="{{config('services.moyasar.key')}}" />
              <input type="hidden" name="amount" value="{{$order->total}}" />
              <input type="hidden" name="source[type]" value="creditcard" />
              <input type="hidden" name="description" value="Order id {{$order->id}} by {{Auth::user()->name}}" />

                <div class="form-group col-6 m-3">
                    <input type="text" name="source[name]"    class="form-control" placeholder="Card Holder" />
                </div>
              <div class="form-group col-6 m-3">
                  <input type="number" name="source[number]"  class="form-control" placeholder="Card Number"/>
              </div>
              <div class="form-group col-6 m-3">
                  <input type="number" name="source[month]" class="form-control" placeholder="Expiry Month"/>
              </div>
              <div class="form-group col-6 m-3">
                  <input type="number" name="source[year]"  class="form-control" placeholder="Expiry Year"/>
              </div>
              <div class="form-group col-6 m-3">
                  <input type="number" name="source[cvc]"   class="form-control" placeholder="CVC"/>
              </div>

              <button type="submit" class="btn btn-primary">Pay</button>
          </form>
      </section>
@endsection
