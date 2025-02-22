@extends('layouts.Front.Master')
@section('content')
    <!-- Turnaments Area Start -->
    <section class="turnaments-section">
        <div class="turnaments-top-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="single-turnaments">
                            <div class="left-area">
                                <div class="single-play">
                                    <div class="image">
                                        <img src="{{$Tournament->Image}}" alt="">
                                    </div>
                                    <div class="contant">
                                        <button type="button" data-TournamentID="{{$Tournament->id}}" class="btn btn-primary btn-lg rounded-pill JoinButton">Join Now</button>


                                    </div>
                                </div>

                            </div>
                            <input type="hidden" id="TournamentID" value="{{$Tournament->id}}">
                            <div class="right-area">
                                <div class="r-top-area">
                                    <h4>{{$Tournament->Name}}</h4>
                                    <div class="list">
                                        <p>
                                            Mode: {{$Tournament->Mode}}
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
                                            Status : {{$Tournament->Status}}
                                        </p>
                                    </div>
                                </div>
                                <div class="r-bottom-area2">
                                    <ul style="margin-left: 50px;">
                                        <li>
											<span>
												Players
											</span>
                                            <h4>
                                                {{$Tournament->PlayerCount}}
                                            </h4>
                                        </li>
                                        <li>
											<span>
												Stages
											</span>
                                            <h4>
                                                {{$Tournament->TotalStage}}
                                            </h4>
                                        </li>
                                        <li>
											<span>
												Time
											</span>
                                            <h4>
                                                {{$Tournament->Time}} Days
                                            </h4>
                                        </li>
                                        <li>
											<span>
												Winners
											</span>
                                            <h4>
                                                {{$Tournament->Winners}}
                                            </h4>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="stf">
                            <div class="left">
                                <h4>{{$Tournament->Players()->count()}} People Joined</h4>
                                <ul>
                                    <li>
                                        <a href="#">
                                            <img src="{{asset('Front/images/player/sm1.png')}}" alt="">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="{{asset('Front/images/player/sm2.png')}}" alt="">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="{{asset('Front/images/player/sm3.png')}}" alt="">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="{{asset('Front/images/player/sm4.png')}}" alt="">
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="center">
                                <div class="time-area">
                                    <h6>Start : {{\Carbon\Carbon::parse($Tournament->Start)->format('Y/m/d H:i')}} <br> End : {{\Carbon\Carbon::parse($Tournament->End)->format('Y/m/d H:i') }}</h6>
                                    <img src="{{asset('Front/images/bg-time.png')}}" alt="">
                                </div>
                            </div>
                            <div class="right">
                                <button type="button" data-TournamentID="{{$Tournament->id}}" class="btn btn-primary btn-lg btn-block rounded-pill JoinButton">Join Now</button>
                                <a href="{{route('Front.Tournaments.Plan' , $Tournament->id)}}"  class="btn btn-info btn-lg btn-block mt-2 rounded-pill JoinButton">Plans</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="turnaments-info">
                        <h4>Prize</h4>
                        <div class="row">
                            @foreach($Tournament->Awards as $key => $award)
                                <div class="col-4">
                                    <div class="single-prize">
                                        <img src="{{asset('Front/images/prize/'. $key + 1 .'.png')}}" alt="">
                                        <span>${{number_format($award)}}</span>
                                    </div>
                                </div>
                            @endforeach

                        </div>
                        <br>
                        <br>
                        <h4>
                            Description :
                        </h4>
                        <div>
                            {!! $Tournament->Description !!}
                        </div>
                        <br>
                        <br>

                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="section-heading">
                        <h2 class="title ">
                            Tournament Plans
                        </h2>
                    </div>
                    <div class="l-arcive-box2-wrapper">
                        <div class="l-arcive-box2">
                            <div class="s-a-b">
                                <div class="left">
                                    <img src="assets/images/arcive/sa4.png" alt="">
                                    <div class="content">
                                        <div class="left2">
                                            <img src="assets/images/arcive/m1.png" alt="">
                                        </div>
                                        <div class="right2">
                                            <h4>Lee Miller</h4>
                                            <div class="stars">
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star"></i>
                                                <i class="fas fa-star-half-alt"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="right">
                                    <img src="assets/images/arcive/mony.png" alt="">
                                    <h6>_ 25.8772200 BTC</h6>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Turnaments Area End -->
@endsection

@section('js')
    @vite('resources/js/Front/Tournament.js')
@endsection

