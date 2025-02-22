@extends('layouts.Front.Master')
@section('content')



    <section class="games-filter">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="filter-wrapp">
                        <div class="left-area">
                            <button id="LoadGamesFree" type="button" class="btn btn-success btn-lg rounded-pill">Free</button>
                            <button id="LoadGamesPaid" type="button" class="btn btn-success btn-lg rounded-pill">Paid</button>
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
