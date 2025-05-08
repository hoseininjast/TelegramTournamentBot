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
                                        <button type="button" id="BackToDetailsButton" class="mybtn mybtn-info mybtn-pill-40">Back to Details</button>
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

        @if($Tournament->Status == 'Finished')
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 pt-5">
                        <div class="section-heading">
                            <h2 class="title">
                                Champions
                            </h2>
                        </div>

                        <div class="l-arcive-box2-wrapper">
                            <div class="l-arcive-box2">
                                @foreach($Tournament->History->Winners as $winner)
                                    @php
                                        $User = \App\Models\TelegramUsers::find($winner);
                                    @endphp
                                    <div class="s-a-b">
                                        <div class="left">
                                            <img src="{{asset('Front/images/arcive/sa'. $loop->iteration + 3 .'.png')}}" alt="">
                                            <div class="content pl-5">
                                                <div class="left2">
                                                    <img class="champion-image" src="{{$User->Image ? $User->Image : asset('images/Users/DefaultProfile.png')}}" alt="">
                                                </div>
                                                <div class="right2 vselement">
                                                    <span class="text text-white"><img class="PlatoIcon" src="{{asset('images/Plato.png')}}" /> {{$User->PlatoID}}</span>
                                                    <span class="text text-white"><i class="fab fa-telegram telegramIcon"></i> <a href="https://t.me/{{$User->UserName}}">{{$User->UserName}}</a></span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="right pt-5">
                                            <img src="{{asset('Front/images/arcive/mony.png')}}" alt="">
                                            <h6>${{$Tournament->Awards[$loop->index]}}</h6>
                                        </div>
                                    </div>
                                @endforeach



                            </div>
                        </div>

                    </div>
                </div>
            </div>
        @endif


        <div class="container">
            <div class="row">
                <div class="col-lg-12 pt-5">
                    <div class="section-heading">
                        <h2 class="title">
                            Tournament Plans
                        </h2>
                    </div>
                    @php
                    $alphabet = range('A', 'Z');

                    @endphp
                    @for($i = 1 ; $i <= $Tournament->TotalStage ; $i++)
                        <div class="l-arcive-box2-wrapper">
                            <h6> Stage {{$i}}</h6>
                            <div class="row pl-3">
                                <span class="text text-success"> Start : {{$Tournament->StagesDate[$i - 1]}}</span>
                                @if($i == $Tournament->TotalStage)
                                    <span class="text text-danger"> End : {{$Tournament->End}}</span>
                                @else
                                    <span class="text text-danger"> End : {{$Tournament->StagesDate[$i]}}</span>
                                @endif
                            </div>
                            <div class="l-arcive-box2">
                                @if($Tournament->Plans()->where('Stage' , $i)->count() > 0)
                                    @foreach($Tournament->Plans()->where('Stage' , $i)->get() as $plan)
                                        <div class="s-a-b">
                                            <div class="left">
                                                <div class="content">
                                                    <div class="left2">
                                                        <img class="plan-image" src="{{$plan->Player1->Image ? $plan->Player1->Image : asset('images/Users/DefaultProfile.png')}}" alt="">
                                                    </div>
                                                    <div class="right2 vselement pt-2">
                                                        <span class="text text-white"><img class="PlatoIcon" src="{{asset('images/Plato.png')}}" /> {{$plan->Player1->PlatoID}}</span>
                                                        <span class="text text-white"><i class="fab fa-telegram telegramIcon"></i><a href="https://t.me/{{$plan->Player1->UserName}}">{{$plan->Player1->UserName}}</a></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="center vsDiv">
                                                <span>Group {{$alphabet[$plan->Group - 1]}}</span>
                                                <span>{{\Carbon\Carbon::parse($plan->Time)->format('M/d')}}</span>
                                                <span>{{\Carbon\Carbon::parse($plan->Time)->format('H:i')}}</span>
                                                <span>{{$plan->Player1Score ?? 0}} / {{$plan->Player2Score ?? 0}}</span>
                                            </div>
                                            <div class="left">
                                                <div class="content">
                                                    <div class="left2">
                                                        <img class="plan-image" src="{{$plan->Player2->Image ? $plan->Player2->Image : asset('images/Users/DefaultProfile.png')}}" alt="">
                                                    </div>
                                                    <div class="right2 vselement pt-2">
                                                        <span class="text text-white"><img class="PlatoIcon" src="{{asset('images/Plato.png')}}" /> {{$plan->Player2->PlatoID}}</span>
                                                        <span class="text text-white"><i class="fab fa-telegram telegramIcon"></i><a href="https://t.me/{{$plan->Player2->UserName}}">{{$plan->Player2->UserName}}</a></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <span>this stage does not started</span>
                                @endif


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

