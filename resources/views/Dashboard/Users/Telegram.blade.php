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
                                <h4 class="header-title">Telegram Users</h4>

                                <div class="table-responsive">
                                    <table class="table table-dark mb-0">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>PlatoID</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($Users as $user)
                                            <tr>
                                                <th scope="row">{{$loop->iteration}}</th>
                                                <td>{{$user->FirstName .' ' . $user->LastName}}</td>
                                                <td>{{$user->UserName}}</td>
                                                <td>{{$user->PlatoID}}</td>
                                                <td>
                                                    <a class="row" href="{{route('Dashboard.Users.Delete' , $user->id)}}" data-confirm-delete="true" >Delete</a>

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
