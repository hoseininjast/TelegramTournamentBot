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
                            <ul class="nav"  role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link mybtn2  StatusButton" id="StatusPending" data-Status="Pending"  >Pending</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link mybtn2 StatusButton" id="StatusRunning" data-Status="Running"  >Running</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link mybtn2 StatusButton" id="StatusFinished" data-Status="Finished"  >Finished</a>
                                </li>
                            </ul>
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
                                                <button type="button"  class="mybtn2 TournamentDetail" data-TournamentID="{{$Tournament->id}}">Tournament Detail</button>
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
                                            </div>
                                        </div>
                                        <div class="r-bottom-area">
                                            <div class="rl-area">
                                                <span class="title">Time left before finish:</span>
                                                <div class="timecounter">
                                                    <i class="far fa-clock"></i>
                                                    <div data-countdown="{{\Carbon\Carbon::parse($Tournament->Start)->format('Y/m/d')}}"></div>
                                                </div>
                                                <img src="{{asset('Front/images/s-box.png')}}" alt="">
                                            </div>
                                            <div class="rr-area">
                                                <h5>Prize pool</h5>
                                                @foreach($Tournament->Awards as $award)
                                                    <p>${{$award}}</p>
                                                @endforeach
                                                <div class="time-area">
                                                    <h6>{{$Tournament->Start}} - {{$Tournament->End}}</h6>
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

