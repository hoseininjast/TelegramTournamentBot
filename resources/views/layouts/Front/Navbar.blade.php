<div class="footer-bar" style="display: none" id="FooterBar">
    <menu class="menu">

        <a class="menu__item  NavbarButtons" id="Navbar-Tournaments" href="{{route('Front.Games')}}">
            <i class="fa fa-dice mb-2"></i>
            <span>Tours</span>
        </a>

        <a class="menu__item NavbarButtons" id="Navbar-Search" href="{{route('Front.Profile.Search')}}">
           <i class="fa fa-search mb-2"></i>
            <span>Search</span>
        </a>


        <a class="menu__item NavbarButtons" id="Navbar-TaskAndInvite" href="{{route('Front.TaskAndInvite.index')}}">
            <i class="fa fa-list-ul mb-2"></i>
            <span>Task & Invite</span>
        </a>

        <a class="menu__item NavbarButtons" id="Navbar-Wallet" href="{{route('Front.Profile.Wallet')}}">
           <i class="fa fa-wallet mb-2"></i>
            <span>Wallet</span>
        </a>

        <a class="menu__item NavbarButtons" id="Navbar-Profile" href="{{route('Front.Profile.index')}}">
           <i class="fa fa-user mb-2"></i>
            <span>Profile</span>
        </a>

       {{-- <a class="menu__item" href="{{route('Front.Games')}}">
           <i class="fa fa-wallet mb-2"></i>
            <span>Wallet</span>
        </a>--}}

    </menu>

</div>
