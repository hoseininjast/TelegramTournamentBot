@extends('layouts.Front.Master')
@section('content')




    <section class="games-filter">

        <div class="s-top-area pb-5">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-lg-4">
                        <div class="top-left-title">
                            <h4>Quick Access</h4>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-8">
                        <div class="t-t-s-nav">
                            <div class="row">
                                <div class="col-6">
                                    <a  href="{{route('Front.Tournaments.Open')}}" class="mybtn mybtn-warning mybtn-pill-25">Open Tours</a>
                                </div>
                                <div class="col-6">
                                    <a  href="{{route('Front.TimeTable')}}" class="mybtn mybtn-primary mybtn-pill-30">Time Table</a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="s-top-area ">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-lg-4">
                        <div class="top-left-title">
                            <h4>Select Tournament Mode</h4>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-8">
                        <div class="t-t-s-nav">
                            <div class="row">
                                <div class="col-6">
                                    <button id="LoadGamesFree" type="button" class="mybtn mybtn-warning mybtn-pill">Free</button>
                                </div>
                                <div class="col-6">
                                    <button id="LoadGamesPaid" type="button" class="mybtn mybtn-primary mybtn-pill">Paid</button>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container pt-5">
            <div class="row">
                <div class="col-xl-6 col-lg-4">
                    <div class="top-left-title">
                        <h4>Join Private Tournament</h4>
                    </div>
                </div>
                <div class="col-lg-12 pt-2">
                    <div class="row">
                        <div class="col-7">
                            <input type="text" class="form-control" name="TournamentCode" id="TournamentCode" placeholder="Tournament Code">
                        </div>
                        <div class="col-5">
                            <button class="mybtn mybtn-success mybtn-pill-40"> Join  </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </section>

    <!-- Game play area start -->
    <section class="game-play-section game-play-section2" style="display: none" id="GameSection">
        <div class="container">
            <div class="row" id="GameRow">
                @foreach($Games as $Game)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-4">
                        <div class="single-play">
                            <div class="image">
                                <img src="{{$Game->Image}}" alt="Game Image">
                                <h4>{{$Game->Name}}</h4>

                            </div>
                            <div class="contant">
                                <button type="button" class="mybtn mybtn-primary mybtn-pill-40  PlayGame" data-GameID="{{$Game->id}}" id="GameButton-{{$Game->id}}" value="{{$Game->id}}">Play</button>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    <!-- Game play area end -->


@endsection

@section('js')
    @vite('resources/js/Front/Games.js')
@endsection
