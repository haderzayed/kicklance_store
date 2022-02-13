<div class="header-area">
    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="user-menu">
                    <ul>
                        <li><a href="{{route('home')}}"><i class="fa fa-home"></i> Home</a></li>
                        <li><a href="#"><i class="fa fa-heart"></i> Wishlist</a></li>
                        <li><a href="{{route('cart')}}"><i class="fa fa-shopping-cart"></i> My Cart</a></li>
                        <li><a href="{{route('orders')}}">My Orders</a></li>
                    </ul>
                </div>
            </div>

            <div class="col-md-4">
                <div class="header-right" style="margin-left: 400px;margin-top: 7px;">
                        <div>
                            <a   class="porto-icon  dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fa fa-user" aria-hidden="true"></i></a>
                            <div class="dropdown-menu">
                                @if (\Illuminate\Support\Facades\Auth::guest())
                               <a  href="{{route('login')}}" class="dropdown-item">login</a>
                                @else
                                    <a  class="dropdown-item"   href="#" onclick="event.preventDefault();document.getElementById('logout-form').submit();">  <i class="fa fa-power-off"></i>Logout</a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        {{ csrf_field() }}
                                    </form>
                                    <a class="dropdown-item" href="{{route('profile.show')}}"><i class="fa fa-user"></i> My Account</a>
                                @endif
                            </div>
                        </div>

                </div>
            </div>
        </div>
    </div>
</div> <!-- End header area -->
