@extends('layouts.Front.Master')
@section('content')
    <!-- Turnaments Area Start -->
    <section class="turnaments-section">
        <div class="turnaments-top-section">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="single-turnaments">
                            <div class="left-area pb-0">
                                <div class="single-play">
                                    <div class="image">
                                        <img src="{{$Tournament->Image}}" alt="">
                                    </div>
                                    <h4>{{$Tournament->Name}}</h4>
                                    <div class="contant">
                                        <button type="button" class="btn btn-primary btn-lg rounded-pill">Back to Details</button>
                                    </div>
                                </div>

                            </div>
                            <input type="hidden" id="TournamentID" value="{{$Tournament->id}}">
                            <div class="right-area pt-0">
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
                            <div class="center">
                                <div class="time-area">
                                    <h6>Start : {{\Carbon\Carbon::parse($Tournament->Start)->format('Y/m/d H:i')}} <br> End : {{\Carbon\Carbon::parse($Tournament->End)->format('Y/m/d H:i') }}</h6>
                                    <img src="{{asset('Front/images/bg-time.png')}}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12 pt-5">
                    <div class="section-heading">
                        <h2 class="title">
                            Tournament Plans
                        </h2>
                    </div>
                    @for($i = 1 ; $i <= $Tournament->TotalStage ; $i++)
                        <div class="l-arcive-box2-wrapper">
                            <h6> Stage {{$i}}</h6>
                            <div class="l-arcive-box2">
                                @foreach($Tournament->Plans()->where('Stage' , $i)->get() as $plan)
                                    <div class="s-a-b">
                                        <div class="left">
                                            <div class="content">
                                                <div class="left2">
                                                    <img src="{{asset('images/Users/DefaultProfile.png')}}" alt="">
                                                </div>
                                                <div class="right2 vselement">
                                                    <p>PID: {{$plan->Player1->PlatoID}}</p>
                                                    <p>TID: {{$plan->Player1->UserName}}</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="center vsDiv">
                                            <span>Group {{$plan->Group}}</span>
                                            <span>{{\Carbon\Carbon::parse($plan->Time)->format('M/d')}}</span>
                                            <span>{{\Carbon\Carbon::parse($plan->Time)->format('H:i')}}</span>
                                            <span>{{$plan->Player1Score ?? 0}} / {{$plan->Player2Score ?? 0}}</span>
                                        </div>
                                        <div class="left">
                                            <div class="content">
                                                <div class="left2">
                                                    <img src="{{asset('images/Users/DefaultProfile.png')}}" alt="">
                                                </div>
                                                <div class="right2 vselement">
                                                    <p>Plato: {{$plan->Player2->PlatoID}}</p>
                                                    <p>Telegram: {{$plan->Player2->UserName}}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach

                            </div>
                        </div>
                    @endfor

                </div>
            </div>
        </div>
    </section>
    <!-- Turnaments Area End -->
@endsection

@section('js')
    @vite('resources/js/Front/Tournament.js')
@endsection

