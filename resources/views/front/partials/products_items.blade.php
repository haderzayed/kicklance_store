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
    <?php
    $star=1;
    while ( $star<= $product->rating){?>
    <span>&#9733;</span>
    <?php $star++; }?>({{$product->rating}})
    <div>

    <form action="{{route('cart.store')}}" method="post" class="d-inline">
        @csrf
        <button type="submit" class="add-to-cart-link" name="product_id" value="{{$product->id}}"><i class="fa fa-shopping-cart"></i> </button>
    </form>
        <select class="favourite" data-toggle="product-rating" data-id="{{$product->id}}" style="width:5px;">
            <option> Rate</option>
            @for($i=1 ;$i<=5 ;$i++)
                <option value="{{$i}}">{{$i}}</option>
            @endfor
        </select>
{{--        <button type="button" class="favourite" data-toggle="modal" data-target="#rating">--}}
{{--            <i class="fa fa-star"></i>--}}
{{--        </button>--}}
        <a href="#" data-toggle="favourites"  data-id="{{$product->id}}" class="favourite @if($product->favourite) active @endif"><i class="fa fa-heart"></i></a>
    </div>

{{--    <div class="modal fade" id="rating" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">--}}
{{--        <div class="modal-dialog modal-dialog-centered" role="document">--}}
{{--            <div class="modal-content">--}}
{{--                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">--}}
{{--                        <span aria-hidden="true">&times;</span>--}}
{{--                    </button>--}}
{{--                <div class="container d-flex justify-content-center mt-5">--}}
{{--                    <div class="card text-center mb-5">--}}
{{--                        <div class="rate bg-success py-3 text-white mt-3">--}}
{{--                        <h6 class="mb-0">Rate your driver</h6>--}}
{{--                        <form  name="input">--}}
{{--                        <div class="rating">--}}

{{--                            @for($i=5 ; $i>=1 ; $i--)--}}
{{--                                <input type="radio"  name="rating"  value="{{$i}}" id="{{$i}}"><label for="{{$i}}">☆</label>--}}
{{--                            @endfor--}}
{{--                        </div>--}}
{{--                        <div class="buttons px-4 mt-0">--}}
{{--                            <input type="submit" id="submit"   data-id="{{$product->id}}" class="btn btn-warning btn-block rating-submit">--}}
{{--                        </div>--}}
{{--                        </form>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

</div>

@section('script')
    <script>
      /*  $(document).ready(function() {
            $('#submit').click(function(e) {
                e.preventDefault();
                var product_id=$(this).data('id');
                var rating = $('input[name=rating]:checked').val();
                   console.log(rating);
                  console.log(product_id);
                 $.post('/ratings/product',{
                    product_id:product_id,
                    rating:rating,
                    _token:_crfToken
                },function (response){
                    alert(response.rating)
                })
            });
        });
        */
    </script>

@endsection
