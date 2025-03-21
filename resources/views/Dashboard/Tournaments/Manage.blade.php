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

                                <div class="row d-flex justify-content-around">
                                    <img style="max-width: 300px;max-height: fit-content;" src="{{$Tournament->GetImage()}}"  alt="Tournament image"/>
                                </div>

                            </div>
                            {{-- Users and supervisors table--}}
                            @if(\Auth::user()->isOwner())
                                <div class="card-body ">
                                    <h4 class="header-title">Users</h4>

                                    @if($Tournament->Players->count() < $Tournament->PlayerCount)
                                        <div class=" d-flex justify-content-end mb-3">
                                            <a class="btn btn-sm btn-success waves-effect waves-light"  href="{{route('Dashboard.Tournaments.Fill' , $Tournament->id)}}"  >Fill Tournament <i class="mdi mdi-account-multiple-plus"></i> </a>
                                        </div>
                                    @endif


                                    <div class="table-responsive">
                                        <table class="table table-dark table-striped table-bordered text-center mb-0">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>name</th>
                                                <th>Username</th>
                                                <th>PlatoID</th>
                                                <th>Wallet Address</th>
                                                <th>Date</th>
                                                <th>Action</th>
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
                                                    <td>
                                                        @if(\Auth::user()->isOwner())
                                                            @if($Tournament->Status == 'Pending')
                                                                <a class="btn btn-sm btn-danger waves-effect waves-light" href="{{route('Dashboard.Tournaments.RemoveUser' , $user->id )}}"  data-confirm-delete="true" >Remove <i class="mdi mdi-trash-can"></i> </a>
                                                            @else
                                                                <a class="btn btn-sm btn-outline-dark waves-effect waves-light disabled" href="#"  disabled>Remove <i class="mdi mdi-trash-can"></i> </a>
                                                            @endif
                                                        @endif
                                                    </td>
                                                </tr>
                                            @endforeach


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                                <div class="card-body border-top border-primary ">
                                    <h4 class="header-title">Supervisors</h4>

                                    <div class="table-responsive">
                                        <table class="table table-dark table-striped table-bordered text-center mb-0">
                                            <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>name</th>
                                                <th>Username</th>
                                                <th>PlatoID</th>
                                                <th>Games count</th>
                                                <th>Wallet Address</th>
                                                <th>Date</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($Supervisors as $user)
                                                <tr>
                                                    <th scope="row">{{$loop->iteration}}</th>
                                                    <td>{{$user->name}}</td>
                                                    <td>{{$user->Username}}</td>
                                                    <td>{{$user->PlatoID ?? 'not set'}}</td>
                                                    <td>{{$Tournament->Plans()->where('SupervisorID' , $user->id)->where('Status' , 'Finished')->count()}} : {{$Tournament->Plans()->where('SupervisorID' , $user->id)->count()}}</td>
                                                    <td class="cursor-pointer" onclick="CopyTextWithToast('{{$user->WalletAddress}}' , 'Wallet Address')">{{$user->WalletAddress}}</td>
                                                    <td>{{$user->created_at}}</td>
                                                </tr>
                                            @endforeach


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @elseif(\Auth::user()->isAdmin())
                                <div class="card-body">
                                    <h4 class="header-title">Users</h4>

                                    <div class="table-responsive">
                                        <table class="table table-dark table-striped table-bordered text-center mb-0">
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
                            @endif




                            {{--Stage plans--}}
                            @if(\Auth::user()->isOwner() || \Auth::user()->isAdmin() || \Auth::user()->isSupervisor() )

                                @for($i = 1 ; $i <= $Tournament->TotalStage ; $i++)

                                    <div class="card-body border-top border-primary">
                                        <h4 class="header-title">Stage {{$i}} Game plans</h4>

                                        <div class="table-responsive">
                                            <table class="table table-dark table-striped table-bordered text-center mb-0">
                                                <thead>
                                                <tr>
                                                    <th>Group</th>
                                                    <th>Player 1</th>
                                                    <th>Player 2</th>
                                                    <th>Time</th>
                                                    <th>Score</th>
                                                    <th>Winner</th>
                                                    <th>Supervisor</th>
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
                                                            @if(\Auth::user()->isAdmin())
                                                                    @if($plan->SupervisorID && $plan->Supervisor->AdminID == \Auth::id() || $plan->SupervisorID == \Auth::id())
                                                                        {{$plan->SupervisorID ? $plan->Supervisor->Username :'not know'}}
                                                                    @else
                                                                        {{$plan->SupervisorID ? $plan->Supervisor->Admin->Username :'not know'}}
                                                                    @endif
                                                                @else
                                                                {{$plan->SupervisorID ? $plan->Supervisor->Username :'not know'}}
                                                                @endif
                                                        </td>
                                                        <td>
                                                            @if($plan->SupervisorID == null)
                                                                <a href="{{route('Dashboard.TournamentPlan.JoinAsSupervisor' , $plan->id)}}" class="btn btn-sm btn-info waves-effect waves-light">Join as supervisor</a>
                                                            @else
                                                                @if(Auth::user()->isOwner())
                                                                    <a href="{{route('Dashboard.TournamentPlan.Manage' , $plan->id)}}" class="btn btn-sm btn-success waves-effect waves-light">Manage</a>
                                                                @else
                                                                    @if($plan->SupervisorID == \Auth::id())
                                                                        @if($plan->Status == 'Pending')
                                                                            <a href="{{route('Dashboard.TournamentPlan.Manage' , $plan->id)}}" class="btn btn-sm btn-success waves-effect waves-light">Manage</a>
                                                                        @else
                                                                            <a href="#" class="btn btn-sm btn-outline-dark waves-effect waves-light disabled">Manage</a>
                                                                        @endif
                                                                    @else
                                                                        <button class="btn btn-sm btn-outline-danger disabled" style="cursor: not-allowed">not allowed</button>
                                                                    @endif
                                                                @endif

                                                            @endif





                                                        </td>
                                                    </tr>
                                                @endforeach


                                                </tbody>
                                            </table>
                                        </div>
                                    </div>

                                @endfor


                            @else

                            @endif


                        </div>
                        @if(Auth::user()->Role == 'Owner')
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
                        @endif

                    </div>
                </div>

            </div>

        </div>


    </div>
@endsection
