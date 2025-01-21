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
                                    <table class="table table-dark table-striped table-bordered text-center mb-0">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Name</th>
                                            <th>Username</th>
                                            <th>PlatoID</th>
                                            <th>Wallet</th>
                                            <th>Tournaments</th>
                                            <th>Actions</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($Users as $user)
                                            <tr>
                                                <th scope="row">{{$loop->iteration}}</th>
                                                <td>{{$user->FirstName .' ' . $user->LastName}}</td>
                                                <td>
                                                    <div>
                                                        <p>{{$user->UserName}}</p>
                                                        <span>Referral : {{$user->ReferralID ? $user->Referral->UserName : 'not set'}}</span>
                                                    </div>
                                                </td>
                                                <td>{{$user->PlatoID}}</td>
                                                <td>
                                                    <div class="">
                                                        Wallet address : {{$user->WalletAddress ?? 'not set'}}
                                                    </div>
                                                    <div class="">
                                                        Charge :${{$user->Charge}}
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class="">
                                                        total : {{$user->Tournaments()->count()}}
                                                    </div>
                                                    <div class="">
                                                        win's : {{$user->TournamentsWon()->count()}}
                                                    </div>
                                                </td>
                                                <td>
                                                    @if($user->Tournaments()->count() > 0 )
                                                        <a class="btn btn-sm btn-outline-dark waves-effect waves-light disabled" disabled href="#" >Delete <i class="mdi mdi-trash-can"></i> </a>
                                                    @else
                                                        <a class="btn btn-sm btn-danger waves-effect waves-light"  href="{{route('Dashboard.Users.TelegramDelete' , $user->id)}}" data-confirm-delete="true" >Delete <i class="mdi mdi-trash-can"></i> </a>
                                                    @endif

                                                </td>
                                            </tr>
                                        @endforeach


                                        </tbody>
                                    </table>
                                </div>
                                <div class="row d-flex justify-content-center mt-3">
                                    {!! $Users->links('pagination::bootstrap-4') !!}

                                </div>

                            </div>

                        </div>

                    </div>
                </div>




            </div> <!-- container-fluid -->
        </div> <!-- content -->

    </div>
@endsection
