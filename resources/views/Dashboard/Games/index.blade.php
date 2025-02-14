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
                                <h4 class="header-title">Games</h4>

                                <div class="table-responsive">
                                    <table class="table table-dark table-striped table-bordered text-center mb-0">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Description</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($Games as $game)
                                            <tr>
                                                <th scope="row">{{$loop->iteration}}</th>
                                                <td>{{$game->Name}}</td>
                                                <td>{{$game->Description}}</td>
                                                <td>
                                                    <a class="btn btn-sm btn-warning waves-effect waves-light" href="{{route('Dashboard.Games.Edit' , $game->id)}}"   >Edit <i class="mdi mdi-pen-plus"></i> </a>
                                                    <a class="btn btn-sm btn-danger waves-effect waves-light" href="{{route('Dashboard.Games.Delete' , $game->id)}}"  data-confirm-delete="true" >Delete <i class="mdi mdi-trash-can"></i> </a>
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
