@extends('layouts.Dashboard.Master')
@section('content')
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Users</h4>

                                <div class="table-responsive">
                                    <table class="table table-dark table-striped table-bordered text-center mb-0">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Username</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                            <th>Admin</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($Users as $user)
                                            <tr>
                                                <th scope="row">{{$loop->iteration}}</th>
                                                <td>{{$user->Username}}</td>
                                                <td>{{$user->email}}</td>
                                                <td>{{$user->Role}}</td>
                                                <td>{{$user->Admin->Username}}</td>
                                                <td>
                                                    <a class="btn btn-sm btn-danger waves-effect waves-light" href="{{route('Dashboard.Users.Delete' , $user->id)}}" data-confirm-delete="true" >Delete <i class="mdi mdi-trash-can"></i> </a>

                                                </td>
                                            </tr>
                                        @endforeach


                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>


            </div> <!-- container-fluid -->
        </div> <!-- content -->

    </div>
@endsection
