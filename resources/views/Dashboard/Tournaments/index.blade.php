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
                                <h4 class="header-title">Tournaments</h4>

                                <div class="table-responsive">
                                    <table class="table table-dark mb-0">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Game</th>
                                            <th>Players</th>
                                            <th>Status</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($Tournaments as $tournament)
                                            <tr>
                                                <th scope="row">{{$loop->iteration}}</th>
                                                <td>{{$tournament->Name}}</td>
                                                <td>{{$tournament->Game->Name}}</td>
                                                <td>{{$tournament->PlayerCount}}</td>
                                                <td>{{$tournament->Status}}</td>
                                                <td>
                                                    <a class="row" href="{{route('Dashboard.Tournaments.Manage' , $tournament->id)}}">Manage</a>
                                                    @if(Auth::user()->isOwner())
                                                        <a class="row" href="{{route('Dashboard.Tournaments.Delete' , $tournament->id)}}"  data-confirm-delete="true" >Delete</a>
                                                    @endif
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
