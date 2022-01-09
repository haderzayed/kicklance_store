@extends('layouts.front')

@section('content')
    <div class="product-big-title-area">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="product-bit-title text-center">
                        <h2>Shopping Cart</h2>
                    </div>
                </div>
            </div>
        </div>
    </div> <!-- End Page title area -->


    <div class="single-product-area">
        <div class="zigzag-bottom"></div>
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="product-content-right">
                        <div class="woocommerce">
                            <form method="post" action="{{route('cart.update')}}">
                                @csrf
                                @method('patch')
                                <table cellspacing="0" class="shop_table cart">
                                    <thead>
                                    <tr>
                                        <th class="product-remove">&nbsp;</th>
                                        <th class="product-thumbnail">&nbsp;</th>
                                        <th class="product-name">Product</th>
                                        <th class="product-price">Price</th>
                                        <th class="product-quantity">Quantity</th>
                                        <th class="product-subtotal">Total</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($cart as $item)
                                    <tr class="cart_item">
                                        <td class="product-remove">
                                            <a title="Remove this item" class="remove" href="#">×</a>
                                        </td>

                                        <td class="product-thumbnail">
                                            <a href="single-product.html"><img width="145" height="145" alt="poster_1_up" class="shop_thumbnail" src="{{$item->product->image_url}}"></a>
                                        </td>

                                        <td class="product-name">
                                            <a href="single-product.html">{{ $item->product->name }}</a>
                                        </td>

                                        <td class="product-price">
                                            <span class="amount">£{{ $item->product->price }}</span>
                                        </td>

                                        <td class="product-quantity">
                                            <div class="quantity buttons_added">
                                                <input type="button" class="minus" value="-">
                                                <input type="number" size="4" class="input-text qty text" title="Qty" name="quantity[{{$item->product_id}}]" value="{{$item->quantity}}" min="0" step="1">
                                                <input type="button" class="plus" value="+">
                                            </div>
                                        </td>

                                        <td class="product-subtotal">
                                            <span class="amount">£{{$item->quantity * $item->product->price}}</span>
                                        </td>
                                    </tr>
                                    @endforeach
                                    <tr>
                                        <td class="actions" colspan="6">
                                            <div class="coupon">
                                                <label for="coupon_code">Coupon:</label>
                                                <input type="text" placeholder="Coupon code" value="" id="coupon_code" class="input-text" name="coupon_code">
                                                <input type="submit" value="Apply Coupon" name="apply_coupon" class="button">
                                            </div>
                                            <input type="submit"  name="update_cart" value="update cart" class="button">
                                          
                                        </td>
                                    </tr>

                                    </tbody>
                                </table>
                            </form>

                            <form method="post" action="{{route('cart.destroy')}}" class=" ">
                                @csrf
                                @method('delete')
                                <input type="submit" value="delete Cart" name="delete_cart" class="button">
                            </form>

                        </div>
                    </div>
                </div>
                <div class=" col-md-4 cart-collaterals">
                    <div class="cart_totals ">
                        <h2>Cart Totals</h2>
                        <div class="t">
                            <span>Cart Subtotal: </span><span class="amount">£{{$sub_total}}</span>
                            <hr>
                            <span>tax: </span><span class="amount">£{{$tax}}</span>
                            <hr>
                            <span>Order Total: </span><span class="amount">£{{$total}}</span>
                            <hr>
                            <input type="submit" value="CheckOut" name="update_cart" class="button">
                        </div>
                 {{--<table cellspacing="0" >
                            <tbody>
                            <tr class="cart-subtotal">
                                <td> <span>Cart Subtotal: </span><span class="amount">£{{$sub_total}}</span></td>
                            </tr>

                            <tr class="shipping">
                                <td> <span>tax: </span><span class="amount">£{{$tax}}</span></td>
                            </tr>

                            <tr class="order-total">
                                <td> <span>Order Total: </span><span class="amount">£{{$total}}</span></td>
                            </tr>
                            <tr class="order-total">

                                <button type="submit">Update Cart</button>
                            </tr>

                            </tbody>
                        </table>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
