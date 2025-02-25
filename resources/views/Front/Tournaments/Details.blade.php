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
                                        @if($Tournament->Status == 'Pending')
                                            <button type="button" data-TournamentID="{{$Tournament->id}}" class="mybtn mybtn-primary mybtn-pill-30 JoinButton">Join Now</button>
                                        @else
                                            <button type="button"  class="mybtn mybtn-danger mybtn-pill-30 disabled JoinButton" disabled>Finished</button>
                                        @endif


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
                                @if($Tournament->Status == 'Pending')
                                    <button type="button" data-TournamentID="{{$Tournament->id}}" class="mybtn mybtn-primary mybtn-pill-30 JoinButton">Join Now</button>
                                @endif
                                <a href="{{route('Front.Tournaments.Plan' , $Tournament->id)}}"  class="mybtn mybtn-info mybtn-pill-30 mt-2 rounded-pill">Plans</a>
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
            </div>
        </div>
    </section>
    <!-- Turnaments Area End -->
@endsection

@section('js')
    @vite('resources/js/Front/Tournament.js')
@endsection

