<div class="left-side-menu">

    <div class="h-100" data-simplebar>

        <!-- User box -->
        <div class="user-box text-center">

            <img src="{{asset('images/MainLogo.png')}}" alt="user-img" title="Mat Helme"
                 class="rounded-circle img-thumbnail avatar-md">
            <div class="dropdown">
                <a href="#" class="user-name dropdown-toggle h5 mt-2 mb-1 d-block" data-bs-toggle="dropdown"
                   aria-expanded="false">
                    {{\Illuminate\Support\Facades\Auth::user()->email}}
                </a>

            </div>

        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <ul id="side-menu">

                <li>
                    <a href="{{route('Dashboard.index')}}">
                        <i class="mdi mdi-view-dashboard-outline"></i>
                        <span> Dashboard </span>
                    </a>
                </li>






                @if(Auth::user()->Role == 'Owner')
                    <li>
                        <a href="#Games" data-bs-toggle="collapse">
                            <i class="mdi mdi-controller-classic-outline"></i>
                            <span> Games </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="Games">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="{{route('Dashboard.Games.index')}}">All</a>
                                </li>
                                <li>
                                    <a href="{{route('Dashboard.Games.Add')}}">Add</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li>
                        <a href="#Tournaments" data-bs-toggle="collapse">
                            <i class="mdi mdi-tournament"></i>
                            <span> Tournaments </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="Tournaments">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="{{route('Dashboard.Tournaments.index')}}">All</a>
                                </li>
                                <li>
                                    <a href="{{route('Dashboard.Tournaments.Add')}}">Add</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    <li>
                        <a href="{{route('Dashboard.TimeTable.index')}}">
                            <i class="mdi mdi-table-clock"></i>
                            <span> Time Table </span>
                        </a>
                    </li>
                    <li>
                        <a href="#Users" data-bs-toggle="collapse">
                            <i class="mdi mdi-account-multiple"></i>
                            <span> Panel Users </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="Users">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="{{route('Dashboard.Users.index')}}">All</a>
                                </li>
                                <li>
                                    <a href="{{route('Dashboard.Users.Add')}}">Add</a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li>
                        <a href="#Telegram" data-bs-toggle="collapse">
                            <i class="mdi mdi-card-account-details"></i>
                            <span> Telegram </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="Telegram">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="{{route('Dashboard.Users.Telegram')}}">Users</a>
                                </li>
                                <li>
                                    <a href="{{route('Dashboard.Users.SendMessageToAllUsersPage')}}">Send Message</a>
                                </li>
                            </ul>
                        </div>
                    </li>


                    <li>
                        <a href="#Settings" data-bs-toggle="collapse">
                            <i class="mdi mdi-cog-sync"></i>
                            <span> Settings </span>
                            <span class="menu-arrow"></span>
                        </a>
                        <div class="collapse" id="Settings">
                            <ul class="nav-second-level">
                                <li>
                                    <a href="#">Site Setting</a>
                                </li>
                                <li>
                                    <a href="{{route('Dashboard.Profile.Setting')}}">User Setting</a>
                                </li>
                            </ul>
                        </div>
                    </li>
                    @else

                    <li>
                        <a href="{{route('Dashboard.Tournaments.index')}}">
                            <i class="mdi mdi-tournament"></i>
                            <span> Tournaments </span>
                        </a>
                    </li>

                        @if(Auth::user()->Role == 'Admin')

                            <li>
                                <a href="#Users" data-bs-toggle="collapse">
                                    <i class="mdi mdi-account-multiple"></i>
                                    <span> Panel Users </span>
                                    <span class="menu-arrow"></span>
                                </a>
                                <div class="collapse" id="Users">
                                    <ul class="nav-second-level">
                                        <li>
                                            <a href="{{route('Dashboard.Users.index')}}">All</a>
                                        </li>
                                        <li>
                                            <a href="{{route('Dashboard.Users.Add')}}">Add</a>
                                        </li>
                                    </ul>
                                </div>
                            </li>

                        @endif
                    <li>
                        <a href="{{route('Dashboard.Profile.Setting')}}">
                            <i class="mdi mdi-cog-sync"></i>
                            <span> Settings </span>
                        </a>
                    </li>
                    @endif

                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                        <i class="mdi mdi-logout-variant"></i>
                        <span> Logout </span>
                    </a>
                </li>

                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                    @csrf
                </form>



            </ul>
        </div>

    </div>
    <!-- End Sidebar -->

    <div class="clearfix"></div>

</div>
<!-- Sidebar -left -->

</div>
