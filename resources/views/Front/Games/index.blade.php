@extends('layouts.Front.Master')
@section('content')




    <section class="games-filter">
        <div class="container">
            <div class="row">
                <div class="col-xl-6 col-lg-4">
                    <div class="top-left-title">
                        <h4>Join Private Tournament</h4>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="row">
                        <div class="col-8">
                            <input type="text" class="form-control" name="TournamentCode" id="TournamentCode" placeholder="Tournament Code">
                        </div>
                        <div class="col-4">
                            <button class="btn btn-info"> Search <i class="fa fa-search"></i>  </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="s-top-area pt-3">
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
                                    <button id="LoadGamesFree" type="button" class="btn btn-outline-success btn-lg btn-block  rounded-pill">Free</button>
                                </div>
                                <div class="col-6">
                                    <button id="LoadGamesPaid" type="button" class="btn btn-outline-info btn-lg btn-block rounded-pill">Paid</button>
                                </div>
                            </div>

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
                                <button type="button" class="btn btn-primary btn-lg rounded-pill  PlayGame" data-GameID="{{$Game->id}}" id="GameButton-{{$Game->id}}" value="{{$Game->id}}">Play</button>
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
