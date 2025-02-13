@extends('layouts.Front.Master')
@section('content')

    <!-- Breadcrumb Area Start -->
    <section class="breadcrumb-area games">
        <div class="content">
            <img src="{{asset('Front/images/contest/top-icon_.png')}}" alt="">
            <h4>Super Fast Withdrawals!</h4>
        </div>
    </section>
    <!-- Breadcrumb Area End -->

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
            <div class="row">
                @foreach($Games as $Game)
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-4">
                        <div class="single-play">
                            <div class="image">
                                <img src="{{$Game->Image}}" alt="Game Image">
                            </div>
                            <div class="contant">
                                <button type="button" class="mybtn1 PlayGame" data-GameID="{{$Game->id}}" id="GameButton-{{$Game->id}}" value="{{$Game->id}}">Play</button>
                                <h4>{{$Game->Tournaments()->count()}} Tournaments</h4>
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
    <script>
        function LoadTournaments(Mode){

        }
    </script>
@endsection
