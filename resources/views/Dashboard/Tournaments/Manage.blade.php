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
                                            <th>Wallet Address</th>
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
                                                <td class="cursor-pointer" onclick="CopyTextWithToast('{{$user->Player->WalletAddress}}' , 'Wallet Address')">{{$user->Player->WalletAddress}}</td>
                                                <td>{{$user->created_at}}</td>
                                            </tr>
                                        @endforeach


                                        </tbody>
                                    </table>
                                </div>
                            </div>




                            @for($i = 1 ; $i <= $Tournament->TotalStage ; $i++)

                                <div class="card-body">
                                    <h4 class="header-title">Stage {{$i}} Game plans</h4>

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
                                            @foreach($Tournament->Plans()->where('Stage' , $i)->get() as $plan)
                                                <tr>
                                                    <td>{{$plan->Group}}</td>
                                                    <td>{{$plan->Player1->UserName}} => {{$plan->Player1->PlatoID}} </td>
                                                    <td>{{$plan->Player2->UserName}} => {{$plan->Player2->PlatoID}} </td>
                                                    <td>{{$plan->Time}}</td>
                                                    <td>{{$plan->Player1Score ?? 0}} / {{$plan->Player2Score ?? 0}}</td>
                                                    <td>{{$plan->WinnerID ? $plan->Winner->PlatoID :'not know'}}</td>
                                                    <td>
                                                        @if($plan->Status == 'Pending')
                                                            <a href="{{route('Dashboard.TournamentPlan.Manage' , $plan->id)}}" class="btn btn-sm btn-success waves-effect waves-light">Manage</a>
                                                        @else
                                                            <a href="#" class="btn btn-sm btn-outline-dark waves-effect waves-light disabled">Manage</a>
                                                        @endif

                                                    </td>
                                                </tr>
                                            @endforeach


                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            @endfor

                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title text-center">Tournament Settings</h4>


                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row justify-content-around">
                                            @if($Tournament->Status != 'Finished')
                                                @for($i = 1 ; $i <= $Tournament->TotalStage ; $i++)
                                                    @if($i == 1)
                                                        <div class="col-auto " >
                                                            <a @if($Tournament->LastStage == 0 && $Tournament->PlayerCount == $Tournament->Players()->count()) href="{{route('Dashboard.Tournaments.StartStage1' , $Tournament->id)}}" class="btn btn-success waves-effect waves-light" @else href="#" class="btn btn-outline-dark waves-effect waves-light disabled" @endif  >Start Stage 1</a>
                                                        </div>
                                                    @else
                                                        <div class="col-auto " >
                                                            <a @if($Tournament->LastStage == $i - 1  && $Tournament->Plans()->where('Stage' , $i - 1)->count() == $Tournament->Plans()->where('Stage' , $i - 1)->where('Status' , 'Finished')->count()) href="{{route('Dashboard.Tournaments.StartNextStage' , $Tournament->id)}}" class="btn btn-success waves-effect waves-light" @else href="#" class="btn btn-outline-dark waves-effect waves-light disabled" @endif >Start Stage {{$i}}</a>
                                                        </div>
                                                    @endif

                                                @endfor
                                                @if($Tournament->LastStage == $Tournament->TotalStage && $Tournament->Plans()->where('Stage' , $Tournament->TotalStage)->count() == $Tournament->Plans()->where('Stage' , $Tournament->TotalStage)->where('Status' , 'Finished')->count() && $Tournament->Status != 'Finished')
                                                    <div class="col-auto " >
                                                        <a href="{{route('Dashboard.Tournaments.ClosePage' , $Tournament->id)}}" class="btn btn-danger waves-effect waves-light" >Finish Tournament</a>
                                                    </div>
                                                @else
                                                    <div class="col-auto " >
                                                        <a href="#" class="btn btn-outline-dark waves-effect waves-light disabled" >Finish Tournament</a>
                                                    </div>
                                                @endif

                                                @else
                                                <h3 class="text-center">this tournament finished</h3>
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
