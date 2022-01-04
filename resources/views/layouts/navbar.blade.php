
    <nav class="navbar navbar-expand-lg navbar-light bg-dark">
        <div class="container">
            <div class="d-flex">
                <div>
                    <a class="navbar-brand text-light" href="#">Store App</a>
                </div>
                <div class="text-light" style="margin-left:900px">
                  <a href="{{route('profile.show')}}">{{Auth::user()->name}}</a>
                  <a href="#" onclick="document.getElementById('logout').submit()">Logout</a>
                    <form action="{{route('logout')}}" method="post" class="d-none" id="logout">
                        @csrf
                        <button type="submit"></button>
                    </form>
                </div>
            </div>


        </div>
    </nav>

