@extends('layouts.Dashboard.Master')
@section('content')
    <div class="content-page">
        <div class="content">

            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Manage Tournament</h4>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif


                            </div>
                            <div class="card-body">
                                <h4 class="header-title">Users</h4>

                                <div class="table-responsive">
                                    <table class="table table-dark mb-0">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>name</th>
                                            <th>Username</th>
                                            <th>PlatoID</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($Tournament->Players as $user)
                                            <tr>
                                                <th scope="row">{{$loop->iteration}}</th>
                                                <td>{{$user->Player->FirstName . ' ' . $user->Player->LastName}}</td>
                                                <td>{{$user->Player->UserName}}</td>
                                                <td>{{$user->Player->PlatoID}}</td>
                                                <td>{{$user->created_at}}</td>
                                            </tr>
                                        @endforeach


                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            @if($Tournament->LastStage == 1)
                                <div class="card-body">
                                    <h4 class="header-title">Stage 1 Game plans</h4>

                                    <div class="table-responsive">
                                        <table class="table table-dark mb-0">
                                            <thead>
                                            <tr>
                                                <th>Group</th>
                                                <th>Player 1</th>
                                                <th>Player 2</th>
                                                <th>Time</th>
                                                <th>Score</th>
                                                <th>Winner</th>
                                                <th>action</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($Tournament->Plans()->where('Stage' , 1)->get() as $plan)
                                                <tr>
                                                    <td>{{$plan->Group}}</td>
                                                    <td>{{$plan->Player1->UserName}} => {{$plan->Player1->PlatoID}} </td>
                                                    <td>{{$plan->Player2->UserName}} => {{$plan->Player2->PlatoID}} </td>
                                                    <td>{{$plan->Time}}</td>
                                                    <td>{{$plan->Player1Score ?? 0}} / {{$plan->Player2Score ?? 0}}</td>
                                                    <td>{{$plan->WinnerID ?? 'not know'}}</td>
                                                    <td>
                                                        <a href="{{route('Dashboard.TournamentPlan.Manage' , $plan->id)}}">Manage</a>
                                                    </td>
                                                </tr>
                                            @endforeach


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif


                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title text-center">Tournament Settings</h4>


                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row ">
                                            @if($Tournament->PlayerCount == $Tournament->Players()->count())
                                                <div class="col-6 d-flex justify-content-around" >
                                                    <a href="{{route('Dashboard.Tournaments.StartStage1' , $Tournament->id)}}" class="btn btn-primary waves-effect waves-light">Start Stage 1</a>
                                                </div>
                                            @endif

                                        </div>
                                    </div>

                                </div>

                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>


    </div>
@endsection
