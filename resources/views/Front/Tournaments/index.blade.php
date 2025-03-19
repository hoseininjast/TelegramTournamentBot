@extends('layouts.Front.Master')
@section('content')
    <section class="turnaments-tab-section">
        <div class="s-top-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-lg-4">
                        <div class="top-left-title">
                            <h4>Browse Tournaments</h4>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-8">
                        <div class="t-t-s-nav">
                            <div class="row">
                                <div class="col-4">
                                    <button class="nav-link mybtn mybtn-warning mybtn-pill-10   StatusButton" id="StatusPending" data-Status="Pending"  >Pending</button>
                                </div>
                                <div class="col-4">
                                    <button class="nav-link mybtn mybtn-success mybtn-pill-10  StatusButton" id="StatusRunning" data-Status="Running"  >Running</button>
                                </div>
                                <div class="col-4">
                                    <button class="nav-link mybtn mybtn-danger mybtn-pill-10  StatusButton" id="StatusFinished" data-Status="Finished"  >Finished</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row">
                        @foreach($Tournaments as $Tournament)
                            <div class="col-lg-12 Tournamnet TournamnetStatus-{{$Tournament->Status}}">
                                <div class="single-turnaments">
                                    <div class="left-area">
                                        <div class="single-play">
                                            <div class="image">
                                                <img src="{{$Tournament->GetImage()}}" alt="">
                                                <h4>{{$Tournament->Name}}</h4>
                                            </div>
                                            <div class="contant">
                                                <button type="button"  class="mybtn mybtn-primary mybtn-pill-20 TournamentDetail" data-TournamentID="{{$Tournament->id}}">Details</button>
                                            </div>
                                        </div>
                                        <h4>{{$Tournament->PlayerCount}} Players</h4>
                                    </div>
                                    <div class="right-area">
                                        <div class="r-top-area">

                                            <div class="list">
                                                <p>
                                                   Mode : {{$Tournament->Mode}}
                                                </p>
                                                <span></span>
                                                <p>
                                                    Type : {{$Tournament->Type}}
                                                </p>
                                                <span></span>
                                                <p>
                                                    Game : {{$Tournament->Game->Name}}
                                                </p>
                                                <span></span>
                                                <p>
                                                    Price : <i class="fa fa-coins text-warning mr-1"></i> {{$Tournament->Price}}
                                                </p>
                                            </div>
                                        </div>
                                        <div class="r-bottom-area">
                                            @if(\Carbon\Carbon::now() < $Tournament->Start)
                                                <div class="rl-area">
                                                    <span class="title">Time left before finish:</span>
                                                    <div class="timecounter">
                                                        <i class="far fa-clock"></i>
                                                        <div data-countdown="{{\Carbon\Carbon::parse($Tournament->Start)->format('Y/m/d')}}"></div>
                                                    </div>
                                                    <img src="{{asset('Front/images/s-box.png')}}" alt="">
                                                </div>
                                            @endif

                                            <div class="rr-area">
                                                <h5>Prize pool</h5>
                                                <div class="d-flex justify-content-around">
                                                    @foreach($Tournament->Awards as $award)
                                                        <p>${{$award}}</p>
                                                    @endforeach
                                                </div>

                                                <div class="time-area">
                                                    <h6>{{\Carbon\Carbon::parse($Tournament->Start)->format('Y/m/d H:i')}} - {{\Carbon\Carbon::parse($Tournament->End)->format('Y/m/d H:i') }}</h6>
                                                    <img src="{{asset('Front/images/bg-time.png')}}" alt="">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@section('js')
    @vite('resources/js/Front/Tournaments.js')
@endsection

