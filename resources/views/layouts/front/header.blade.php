
<div class="site-branding-area">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="logo">
                    <h1><a href="./"><img src="img/logo.png"></a></h1>
                </div>
            </div>

            <div class="col-sm-6 mt-4" >
                <div class="shopping-item m-2" >
                    <a href="{{route('cart')}}">Cart - <span class="cart-amunt">$100</span> <i class="fa fa-shopping-cart"></i> <span class="product-count">5</span></a>
                </div>
                @auth
                    <div class="btn-group shopping-item m-2" >
                        <a   class="porto-icon  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-bell" aria-hidden="true"></i>
                            <span class="product-count">{{Auth::user()->unreadNotifications()->count()}}</span> </a>
                        <div class="dropdown-menu" style="height: 420px; overflow-y: auto">
                            @foreach(Auth::user()->notifications as $notification)
                                <a href="{{route('notification.read',$notification->id)}}" class="dropdown-item">
                                    <h5>{{$notification->data['title']}} @if($notification->unread()) * @endif</h5>
                                    <P>{{$notification->data['body']}}</P>
                                    <small>{{$notification->created_at->diffForHumans()}}</small>
                                </a>
                            @endforeach
                        </div>
                    </div>
                @endauth
            </div>

        </div>
    </div>
</div> <!-- End site branding area -->

<div class="mainmenu-area">
    <div class="container">
        <div class="row">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="navbar-collapse collapse">
                <ul class="nav navbar-nav">
                    <li class="active"><a href="index.html">Home</a></li>
                    <li><a href="shop.html">Shop page</a></li>
                    <li><a href="single-product.html">Single product</a></li>
                    <li><a href="cart.html">Cart</a></li>
                    <li><a href="checkout.html">Checkout</a></li>
                    <li><a href="#">Category</a></li>
                    <li><a href="#">Others</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
            </div>
        </div>
    </div>
</div> <!-- End mainmenu area -->
