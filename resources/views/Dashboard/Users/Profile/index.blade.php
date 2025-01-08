@extends('layouts.Dashboard.Master')
@section('content')
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                {{--data --}}
                <div class="row">
                    <div class="col-12">
                        {{--Robot data setting--}}
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Settings</h4>

                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="row">
                                    <div class="col-lg-12">
                                        <form method="POST" action="{{route('Dashboard.Profile.Update')}}">
                                            @csrf

                                            <div class="row">
                                                <div class="col-6 mb-3">
                                                    <label for="Ai1ID" class="form-label">Username <i class="fa fa-lock"></i> </label>
                                                    <input type="text" id="Ai1ID" name="Ai1ID" class="form-control" value="{{\Auth::user()->Username}}" disabled>
                                                </div>
                                                <div class="col-6 mb-3">
                                                    <label for="WalletAddress" class="form-label">Email <i class="fa fa-lock"></i></label>
                                                    <input type="text" id="WalletAddress" name="WalletAddress" class="form-control" value="{{\Auth::user()->email}}" disabled>
                                                </div>

                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="name" class="form-label">name  </label>
                                                        <input type="text" id="name" name="name" class="form-control" value="{{\Auth::user()->name}}" >
                                                    </div>
                                                </div>

                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="TelegramUserID" class="form-label">Telegram ID (@userinfobot) </label>
                                                        <input type="text" id="TelegramUserID" name="TelegramUserID" class="form-control" value="{{\Auth::user()->TelegramUserID}}" >
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">

                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="WalletAddress" class="form-label">WalletAddress</label>
                                                        <input type="text" id="WalletAddress" name="WalletAddress" class="form-control" value="{{\Auth::user()->WalletAddress}}">
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="PlatoID" class="form-label">Plato ID</label>
                                                        <input type="text" id="PlatoID" name="PlatoID" class="form-control" value="{{\Auth::user()->PlatoID}}">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <label for="password" class="form-label">Password</label>
                                                        <small class="cursor-pointer" onclick="GeneratePassword()">generate</small>
                                                        <input type="text" id="password" name="password" class="form-control" >
                                                    </div>
                                                </div>


                                                <div class="col-6">
                                                    <div class="mb-3">
                                                        <img width="300" src="{{\Auth::user()->Image}}"  alt="profile image"/>

                                                        <label for="Image" class="form-label">Profile image</label>
                                                        <input type="file" id="Image" name="Image" accept="image/*" class="form-control" disabled>
                                                    </div>
                                                </div>
                                            </div>





                                            <div class="row ">
                                                <div class="col-12 d-flex justify-content-around" >
                                                    <button type="submit" class="btn col-6 btn-info waves-effect waves-light">Submit</button>
                                                </div>
                                            </div>




                                        </form>
                                    </div> <!-- end col -->

                                </div>
                                <!-- end row-->

                            </div> <!-- end card-body -->
                        </div>

                        <!-- end card -->
                    </div><!-- end col -->
                </div>
                <!-- end row -->

            </div> <!-- container -->

        </div> <!-- content -->


    </div>
@endsection


@section('js')
    <script>
        function GeneratePassword(){
            var length = 12,
                charset = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*-_=+;:~",
                pass = "";
            for (var i = 0, n = charset.length; i < length; ++i) {
                pass += charset.charAt(Math.floor(Math.random() * n));
            }
            $('#password').val(pass);

        }
    </script>
@endsection

