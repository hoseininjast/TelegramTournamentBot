@extends('layouts.Dashboard.Master')
@section('content')
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Add User</h4>


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
                                        <form method="POST" action="{{route('Dashboard.Users.Create')}}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="mb-3 col-6">
                                                    <label for="name" class="form-label">Name</label>
                                                    <input type="text" id="name" name="name" class="form-control" required>
                                                </div>

                                                <div class="mb-3 col-6">
                                                    <label for="Username" class="form-label">Username</label>
                                                    <input type="text" id="Username" name="Username" class="form-control" required>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="mb-3 col-6">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" id="email" name="email" class="form-control" required>
                                                </div>

                                                <div class="mb-3 col-6">
                                                    <label for="Role"  class="form-label">Role</label>
                                                    <select class="form-select" id="Role" name="Role">
                                                        <option selected>Select User Role</option>
                                                        <option value="Admin">Admin</option>
                                                        <option value="Supervisor">Supervisor</option>
                                                        <option value="User">User</option>
                                                    </select>
                                                </div>
                                            </div>


                                            <div class="row">
                                                <div class="mb-3 col-6">
                                                    <label for="password" class="form-label">Password</label>
                                                    <small class="cursor-pointer" onclick="GeneratePassword()">generate</small>
                                                    <input type="text" id="password" name="password" class="form-control" required>
                                                </div>

                                                <div class="mb-3 col-6">
                                                    <label for="WalletAddress" class="form-label">Wallet Address</label>
                                                    <input type="text" id="WalletAddress" name="WalletAddress" class="form-control" >
                                                </div>
                                            </div>



                                            <div class=" row">
                                                <div class="col-8 col-xl-9">
                                                    <button type="submit" class="btn btn-success waves-effect waves-light">Submit</button>
                                                </div>
                                            </div>



                                        </form>
                                    </div> <!-- end col -->

                                </div>
                                <!-- end row-->

                            </div> <!-- end card-body -->
                        </div> <!-- end card -->
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
