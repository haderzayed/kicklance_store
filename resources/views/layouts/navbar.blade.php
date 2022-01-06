
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
    <!-- Navbar -->
    <nav id="main-navbar" class="navbar navbar-expand-lg navbar-light bg-white fixed-top">
        <!-- Container wrapper -->
        <div class="container-fluid">
            <!-- Toggle button -->
            <button class="navbar-toggler" type="button" data-mdb-toggle="collapse" data-mdb-target="#sidebarMenu"
                aria-controls="sidebarMenu" aria-expanded="false" aria-label="Toggle navigation">
                <i class="fas fa-bars"></i>
            </button>

            <!-- Brand -->
            <a class="navbar-brand" href="#">
                <h1>KickLance</h1>
            </a>

            <!-- Right links -->
            <ul class="navbar-nav ms-auto d-flex flex-row">
                <!-- Notification dropdown -->
                <li class="nav-item dropdown">
                    <a class="nav-link me-3 me-lg-0 dropdown-toggle hidden-arrow"
                       href="#" id="navbarDropdownMenuLink" role="button" data-mdb-toggle="dropdown" aria-expanded="false">
                        <i class="fas fa-bell"></i>
                        <span class="badge rounded-pill badge-notification bg-danger">1</span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                        <li>
                            <a class="dropdown-item" href="#">Some news</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">Another news</a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="#">Something else here</a>
                        </li>
                    </ul>
                </li>


                <!-- Avatar -->
                <li class="nav-item dropdown">
                    <div >
                        <a href="{{route('profile.show')}}">{{Auth::user()->name}}</a>
                        <a href="#" onclick="document.getElementById('logout').submit()">Logout</a>
                        <form action="{{route('logout')}}" method="post" class="d-none" id="logout">
                            @csrf
                            <button type="submit"></button>
                        </form>
                    </div>
                </li>
            </ul>
        </div>
        <!-- Container wrapper -->
    </nav>
    <!-- Navbar -->
    </header>
    <!--Main Navigation-->

    <script>
        /* When the user clicks on the button,
        toggle between hiding and showing the dropdown content */
        function myFunction() {
            document.getElementById("myDropdown").classList.toggle("show");
        }

        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                    }
                }
            }
        }
    </script>

