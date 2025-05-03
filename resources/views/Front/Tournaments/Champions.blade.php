@extends('layouts.Front.Master')
@section('content')
    <!-- Latest arcive area start -->
    <section class="latest-arcive">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="sh-wrpper">
                        <img src="{{asset('Front/images/arcive/i1.png')}}" alt="">
                        <div class="section-heading">
                            <h5 class="subtitle">
                                Top Players
                            </h5>
                            <h2 class="title ">
                                Plato Leaderboard
                            </h2>
                        </div>
                    </div>
                    <div class="l-arcive-box">
                        @foreach($Champions as $champion)
                            @php
                            $User = \App\Models\TelegramUsers::find($champion['ChampionID']);
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
                                    <h6>{{$champion['WinCount']}} Wins</h6>
                                </div>
                            </div>

                        @endforeach

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Latest arcive area End -->
@endsection

@section('js')
    @vite('resources/js/Front/Tournament.js')
@endsection

