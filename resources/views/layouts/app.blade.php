<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Krypto Arena</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="tournament platform for all games" name="description" />
    <meta content="Ai1Polaris" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('images/MainLogo.png')}}">
    <!-- App css -->
    <link href="{{asset('Dashboard/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" id="app-style" />


    <!-- icons -->
    <link href="{{asset('Dashboard/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <meta name="csrf-token" content="{{ csrf_token() }}">



</head>

<body class="loading authentication-bg authentication-bg-pattern" >

@yield('content')
<!-- end page -->

<!-- Vendor -->
<script src="{{asset('Dashboard/assets/libs/jquery/jquery.min.js')}}"></script>
<script src="{{asset('Dashboard/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('Dashboard/assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('Dashboard/assets/libs/node-waves/waves.min.js')}}"></script>
<script src="{{asset('Dashboard/assets/libs/waypoints/lib/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('Dashboard/assets/libs/jquery.counterup/jquery.counterup.min.js')}}"></script>
<script src="{{asset('Dashboard/assets/libs/feather-icons/feather.min.js')}}"></script>

<!-- App js -->
<script src="{{asset('Dashboard/assets/js/app.min.js')}}"></script>

</body>

</html>
