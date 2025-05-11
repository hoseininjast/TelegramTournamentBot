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
@include('layouts.Front.Header')

<!-- Header Area End  -->

<!-- Breadcrumb Area Start -->
@if(preg_match('/Profile/' , Request::url() ) != 1 )
    <section class="MasterBreadCrumbSection pt-100 ">
        <div class="content breadcrumb-section">
            <img class="breadcrumb-image rounded-pill" src="{{asset('images/MainLogo.png')}}"  alt="" />
            <h2 class="title pt-2 rainbow-text" >Krypto Arena</h2>
            <h5 class="subtitle">Blockchain Tournament Platform</h5>
        </div>
    </section>
@endif

<!-- Breadcrumb Area End -->

<div id="MainDiv" >
    @yield('content')
</div>
<!-- Footer Area Start -->

<div class="forged-fixed-bottom-bar"></div>
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


<script src="https://raw.githubusercontent.com/AlexChittock/JQuery-Session-Plugin/refs/heads/master/jquery.session.js"></script>
<script src="https://cdn.jsdelivr.net/npm/clipboard@2.0.11/dist/clipboard.min.js"></script>


{{--<script src="//cdn.jsdelivr.net/npm/eruda"></script>--}}

@include('sweetalert::alert' )
<script src="{{asset('js/Functions.js')}}"></script>

@vite(['resources/js/app.js'])
@yield('js')


@if($errors->any())
    @foreach($errors->all() as $err)
        @dd($err)
        <script>
            Swal.fire({
                icon: 'error',
                title: "Something went wrong!",
                text: '{{$err}}',
            });
        </script>
    @endforeach
@endif


</body>


</html>
