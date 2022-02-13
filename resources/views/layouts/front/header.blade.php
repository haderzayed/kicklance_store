
<div class="site-branding-area">
    <div class="container">
        <div class="row">
            <div class="col-sm-6">
                <div class="logo">
                    <h1><a href="./"><img src="img/logo.png"></a></h1>
                </div>
            </div>

            <div class="col-sm-6 mt-4" >
                    <div class="btn-group shopping-item m-2" >
                        <a class="porto-icon  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fa fa-shopping-cart"></i>
                            <span class="product-count">{{\App\Models\Cart::count()}}</span> </a>
                        <div class="dropdown-menu" style="height:auto; overflow-y: auto">
                            @foreach(\App\Models\Cart::all() as $item)
                            <a href="{{route('cart')}}" class="dropdown-item">{{$item->product->name}}</a>
                            @endforeach
                      </div>
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

