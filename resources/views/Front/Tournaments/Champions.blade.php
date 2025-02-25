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
                                Leaderboard
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
                                    <img class="rounded-pill " width="40px" height="40px" src="{{$User->Image}}" alt="">
                                    <span style="font-size: 12px">{{$User->UserName}}</span>
                                </div>
                                <div class="right">
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

