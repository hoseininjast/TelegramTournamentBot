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
                    <a href="#Users" data-bs-toggle="collapse">
                        <i class="mdi mdi-account-multiple"></i>
                        <span> Users </span>
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

                @if(Auth::user()->Role == 'Owner')
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
                        <a href="{{route('Dashboard.Profile.Setting')}}">
                            <i class="mdi mdi-cog-sync"></i>
                            <span> Settings </span>
                        </a>
                    </li>
                    @endif


            {{--    <li>
                    <a href="#Package" data-bs-toggle="collapse">
                        <i class="mdi mdi-package"></i>
                        <span> Package </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="Package">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('Dashboard.Package.index')}}">All</a>
                            </li>
                            <li>
                                <a href="{{route('Dashboard.Package.Add')}}">Add</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#PackageCategory" data-bs-toggle="collapse">
                        <i class="mdi mdi-package-variant-closed"></i>
                        <span> Package Category </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="PackageCategory">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('Dashboard.PackageCategory.index')}}">All</a>
                            </li>
                            <li>
                                <a href="{{route('Dashboard.PackageCategory.Add')}}">Add</a>
                            </li>
                        </ul>
                    </div>
                </li>

                <li>
                    <a href="#Servers" data-bs-toggle="collapse">
                        <i class="mdi mdi-lan"></i>
                        <span> Servers </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="Servers">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('Dashboard.Servers.index')}}">All</a>
                            </li>
                            <li>
                                <a href="{{route('Dashboard.Servers.Add')}}">Add</a>
                            </li>
                            <li>
                                <a href="{{route('Dashboard.Servers.Test')}}">Test</a>
                            </li>
                        </ul>
                    </div>
                </li>--}}






            {{--    <li>
                    <a href="#Questions" data-bs-toggle="collapse">
                        <i class="mdi mdi-chat-question"></i>
                        <span> Questions </span>
                        <span class="menu-arrow"></span>
                    </a>
                    <div class="collapse" id="Questions">
                        <ul class="nav-second-level">
                            <li>
                                <a href="{{route('Dashboard.Questions.index')}}">All</a>
                            </li>
                            <li>
                                <a href="{{route('Dashboard.Questions.Add')}}">Add</a>
                            </li>
                            <li>
                                <a href="{{route('Dashboard.Questions.Category')}}">Category</a>
                            </li>

                        </ul>
                    </div>
                </li>--}}





            </ul>
        </div>

    </div>
    <!-- End Sidebar -->

    <div class="clearfix"></div>

</div>
<!-- Sidebar -left -->

</div>
