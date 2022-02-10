<div class="single-product">
    <div class="product-f-image">
        <img src="{{$product->image_url}}" alt="" style="width:200px;height:250px">
        <div class="product-hover">

            <a href="single-product.html" class="view-details-link"><i class="fa fa-link"></i> See details</a>
        </div>
    </div>

    <h2>{{$product->name}}</h2>
    <div class="product-carousel-price">
        <ins>${{number_format($product->price,2)}}</ins> <del>${{number_format($product->sale_pric,2)}}</del>
    </div>
    <div>
    <form action="{{route('cart.store')}}" method="post" class="d-inline">
        @csrf
        <button type="submit" class="add-to-cart-link" name="product_id" value="{{$product->id}}"><i class="fa fa-shopping-cart"></i> </button>
    </form>
        <a href="#" data-toggle="favourites"  data-id="{{$product->id}}" class="favourite @if($product->favourite) active @endif"><i class="fa fa-heart"></i></a>
    </div>
</div>
