<!DOCTYPE html>
<html lang="en">

<!-- Mirrored from coderthemes.com/adminto/layouts/index.html by HTTrack Website Copier/3.x [XR&CO'2014], Wed, 30 Aug 2023 14:51:17 GMT -->
<head>

    <meta charset="utf-8" />
    <title>Krypto Arena</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="tournament platform for all games" name="description" />
    <meta content="Ai1Polaris" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{asset('images/MainLogo.png')}}">

    <!-- Wappalyzer Technology -->
    <script charset="utf-8" src="https://cdn-client.medium.com/lite/static/js/tracing.075b133f.chunk.js"></script>
    <!-- Wapp -->
    <!-- App css -->

    <link href="{{asset('Dashboard/assets/css/app.min.css')}}" rel="stylesheet" type="text/css" id="app-style" />

    <!-- icons -->
    <link href="{{asset('Dashboard/assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <style>
        .cursor-pointer {
            cursor: pointer;
        }
        .swal2-modal{
            background: rgb(49 56 67) !important;
        }
        .swal2-toast{
            background: rgb(49 56 67) !important;
        }
        .swal2-html-container{
            color: white;
        }
    </style>
    @yield('Head')
</head>

<!-- body start -->
<body class="loading" data-layout-color="dark"  data-layout-mode="default" data-layout-size="fluid" data-topbar-color="dark" data-leftbar-position="fixed" data-leftbar-color="dark" data-leftbar-size='default' data-sidebar-user='true'>

<!-- Begin page -->
<div id="wrapper">



    <!-- Topbar Start -->
    @include('layouts.Dashboard.Header')

    <!-- end Topbar -->

    <!-- ========== Left Sidebar Start ========== -->
    @include('layouts.Dashboard.Navbar')
    <!-- Left Sidebar End -->

    <!-- ============================================================== -->
    <!-- Start Page Content here -->
    <!-- ============================================================== -->

    @yield('content')
    @include('layouts.Dashboard.Footer')
    <!-- ============================================================== -->
    <!-- End Page content -->
    <!-- ============================================================== -->


</div>
<!-- END wrapper -->

<!-- Right Sidebar -->
<!-- /Right-bar -->

<!-- Right bar overlay-->
<div class="rightbar-overlay"></div>

<!-- Vendor -->
<script src="{{asset('Dashboard/assets/libs/jquery/jquery.min.js')}}"></script>
<script src="{{asset('Dashboard/assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<script src="{{asset('Dashboard/assets/libs/simplebar/simplebar.min.js')}}"></script>
<script src="{{asset('Dashboard/assets/libs/node-waves/waves.min.js')}}"></script>
<script src="{{asset('Dashboard/assets/libs/waypoints/lib/jquery.waypoints.min.js')}}"></script>
<script src="{{asset('Dashboard/assets/libs/jquery.counterup/jquery.counterup.min.js')}}"></script>
<script src="{{asset('Dashboard/assets/libs/feather-icons/feather.min.js')}}"></script>

<!-- knob plugin -->
<script src="{{asset('Dashboard/assets/libs/jquery-knob/jquery.knob.min.js')}}"></script>

<!--Morris Chart-->
<script src="{{asset('Dashboard/assets/libs/morris.js06/morris.min.js')}}"></script>
<script src="{{asset('Dashboard/assets/libs/raphael/raphael.min.js')}}"></script>

<!-- Dashboar init js-->
<script src="{{asset('Dashboard/assets/js/pages/dashboard.init.js')}}"></script>
{{--<script src="{{asset('Assets/Libs/SweetAlert2/sweetalert2.all.min.js')}}" type="module"></script>--}}
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@include('sweetalert::alert' )
<script src="{{asset('js/Functions.js')}}"></script>
<!-- App js-->
<script src="{{asset('Dashboard/assets/js/app.min.js')}}"></script>

<script>

    $(function () {
        $('[data-toggle="tooltip"]').tooltip()
    })

    @if($errors->any())
        @foreach($errors->all() as $err)
            ShowToast('error' , '{{$err}}')
        @endforeach
    @endif


</script>

@yield('js')

</body>

</html>



