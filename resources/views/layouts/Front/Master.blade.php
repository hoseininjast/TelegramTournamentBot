<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="{{env('APP_NAME')}}">
    <meta name="keywords" content="Tournaments & gaming platform with crypto">
    <meta name="author" content="{{env('APP_NAME')}}">
    <title>{{env('APP_NAME')}}</title>
    @routes()

    {{--Telegram--}}

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- favicon -->
    <link rel="shortcut icon" href="{{asset('images/MainLogo.png')}}" type="image/x-icon">
    <!-- bootstrap -->
    <link rel="stylesheet" href="{{asset('Front/css/bootstrap.min.css')}}">
    <!-- Plugin css -->
    <link rel="stylesheet" href="{{asset('Front/css/plugin.css')}}">

    <!-- stylesheet -->
    <link rel="stylesheet" href="{{asset('Front/css/style.css')}}">
    <!-- responsive -->
    <link rel="stylesheet" href="{{asset('Front/css/responsive.css')}}">
    <link href="{{asset('Dashboard/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <script src="{{asset('Dashboard/assets/libs/feather-icons/feather.min.js')}}"></script>

    @vite(['resources/css/app.css'])

    @yield('head')
</head>

<body>
<!-- preloader area start -->
<div class="preloader" id="preloader">
    <div class="loader loader-1">
        <div class="loader-outter"></div>
        <div class="loader-inner"></div>
    </div>
</div>
<!-- preloader area end -->

<!-- Header Area Start  -->
{{--@include('layouts.Front.Header')--}}

<!-- Header Area End  -->

<!-- Breadcrumb Area Start -->
<section class="breadcrumb-area games">
    <div class="content">
        <img id="UserImage"  alt="">
        <h4 id="UserUsername"></h4>
    </div>
</section>
<!-- Breadcrumb Area End -->

@yield('content')
<!-- Footer Area Start -->


@include('layouts.Front.Navbar')


{{--@include('layouts.Front.Footer')--}}
{{--<p style="background: yellow" id="logs">the logs comes here...</p>--}}
<!-- Footer Area End -->

{{--
<!-- Back to Top Start -->
<div class="bottomtotop">
    <i class="fas fa-chevron-right"></i>
</div>
<!-- Back to Top End -->--}}


<!-- SignIn Area Start -->
<div class="modal fade login-modal sign-in" id="signin" tabindex="-1" role="dialog" aria-labelledby="signin" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered " role="document">
        <div class="modal-content">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <div class="modal-body">
                <ul class="nav l-nav" role="tablist">
                    <li class="nav-item" role="presentation">
                        <a class="nav-link mybtn2 active" id="pills-m_login-tab" data-toggle="pill" href="#pills-m_login" role="tab" aria-controls="pills-m_login" aria-selected="true">Login</a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link mybtn2" id="pills-m_register-tab" data-toggle="pill" href="#pills-m_register" role="tab" aria-controls="pills-m_register" aria-selected="false">Register</a>
                    </li>
                </ul>
                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade show active" id="pills-m_login" role="tabpanel" aria-labelledby="pills-m_login-tab">
                        <div class="header-area">
                            <h4 class="title">Welcome to
                                JuGARO</h4>
                        </div>
                        <div class="form-area">
                            <form action="#" method="POST">
                                <div class="form-group">
                                    <input type="text" class="input-field" id="input-name"  placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <input type="email" class="input-field" id="input-email"  placeholder="Password">
                                </div>
                                <div class="form-group">
                                    <span>Forgot your password? <a href="#">recover password</a></span>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="mybtn2">Login</button>
                                </div>
                            </form>
                        </div>

                    </div>
                    <div class="tab-pane fade" id="pills-m_register" role="tabpanel" aria-labelledby="pills-m_register-tab">
                        <div class="header-area">
								<span class="bunnus_btn">
									<span>Current Contest Pool</span>
									<h4>$500</h4>
								</span>
                            <h4 class="title">Play +100 games
                                and win cash!</h4>
                            <p class="text">
                                Fill this outyour majesty & Get Your Bonus
                            </p>
                        </div>
                        <div class="form-area">
                            <form action="#" method="POST">
                                <div class="form-group">
                                    <input type="text" class="input-field" id="input-name"  placeholder="Username">
                                </div>
                                <div class="form-group">
                                    <input type="email" class="input-field" id="input-email"  placeholder="Enter your Email">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="input-field" id="input-password"  placeholder="Enter your password">
                                </div>
                                <div class="form-group">
                                    <input type="password" class="input-field" id="input-con-password"  placeholder="Enter your Confirm Password">
                                </div>
                                <div class="form-group">
                                    <div class="check-group">
                                        <input type="checkbox" class="check-box-field" id="input-terms" checked>
                                        <label for="input-terms">
                                            I agree with <a href="#">terms and Conditions</a> and  <a href="#">privacy policy</a>
                                        </label>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="mybtn2">Register</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
<!-- SignIn Area End -->

<!-- jquery -->
<script src="{{asset('Front/js/jquery.js')}}"></script>
<!-- popper -->
<script src="{{asset('Front/js/popper.min.js')}}"></script>
<!-- bootstrap -->
<script src="{{asset('Front/js/bootstrap.min.js')}}"></script>
<!-- plugin js-->
<script src="{{asset('Front/js/plugin.js')}}"></script>

<!-- MpusemoverParallax JS-->
<script src="{{asset('Front/js/TweenMax.js')}}"></script>
<script src="{{asset('Front/js/mousemoveparallax.js')}}"></script>
<!-- main -->
<script src="{{asset('Front/js/main.js')}}"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script src="https://cdn.jsdelivr.net/npm/jquery.session@1.0.0/jquery.session.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.11/dist/clipboard.min.js"></script>


{{--<script src="//cdn.jsdelivr.net/npm/eruda"></script>--}}

@include('sweetalert::alert' )

@vite(['resources/js/app.js'])
@yield('js')
</body>


</html>
