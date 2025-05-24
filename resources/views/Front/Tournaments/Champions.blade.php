@extends('layouts.Front.Master')
@section('content')
    <!-- Latest arcive area start -->
    <div class="usermenu-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="t-t-s-nav">
                        <div class="row">
                            <div class="col-6">
                                <a class="nav-link text-center mybtn mybtn-primary mybtn-pill-10   LeaderboardSectionButtons" id="PlatoButton"   > Plato</a>
                            </div>
                            <div class="col-6">
                                <a class="nav-link text-center mybtn mybtn-primary  mybtn-pill-10 LeaderboardSectionButtons" id="InvitersButton"   > Inviters</a>
                            </div>


                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <section class="latest-arcive">
        <div class="container">
            <div class="row">

                <div class="col-md-12 LeaderboardSections" id="PlatoLeaderboard">
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
                                <div class="left ChampionLeft">
                                    <img src="{{asset('Front/images/arcive/sa'. $loop->iteration + 3 .'.png')}}" alt="">
                                    <h6>Stars : {{$champion['Stars']}} <i class="fa fa-star text-warning"></i></h6>
                                    <h6>Tours : {{$champion['WinCount']}} <i class="fa fa-trophy text-secondry"></i></h6>

                                </div>
                                <div class="right ">
                                    <div class="d-flex flex-column align-items-center">
                                        <img class="champion-image RedirectToProfile"  data-UserID="{{$User->id}}" src="{{$User->Image ? $User->Image : asset('images/Users/DefaultProfile.png')}}" alt="">
                                        <span class="text text-white RedirectToProfile" data-UserID="{{$User->id}}" ><img class="rounded-pill " width="15px" height="15px" src="{{asset('images/MainLogo.png')}}"  /> {{$User->UserName}}</span>
                                    </div>

                                </div>
                            </div>

                        @endforeach

                    </div>
                </div>

                <div class="col-md-12 LeaderboardSections" id="InvitersLeaderboard" style="display: none">
                    <div class="sh-wrpper">
                        <img src="{{asset('Front/images/arcive/i1.png')}}" alt="">
                        <div class="section-heading">
                            <h5 class="subtitle">
                                Top Inviters
                            </h5>
                            <h2 class="title ">
                                Inviters Leaderboard
                            </h2>
                        </div>
                    </div>
                    <div class="l-arcive-box">
                        @foreach($MostReferrals as $User)
                            <div class="s-a-b">
                                <div class="left ChampionLeft">
                                    <img src="{{asset('Front/images/arcive/sa'. $loop->iteration + 3 .'.png')}}" alt="">
                                    <h6>Invite : {{$User->referrals_count}} <i class="fa fa-user "></i> </h6>
                                    <div class="vselement">
                                        <span class="text text-white pt-2"><i class="fab fa-telegram telegramIcon"></i> <a href="https://t.me/{{$User->UserName}}">{{$User->UserName}}</a></span>
                                    </div>
                                </div>
                                <div class="right ">
                                    <div class="d-flex flex-column align-items-center">
                                        <img class="champion-image RedirectToProfile"  data-UserID="{{$User->id}}" src="{{$User->Image ? $User->Image : asset('images/Users/DefaultProfile.png')}}" alt="">
                                        <span class="text text-white RedirectToProfile" data-UserID="{{$User->id}}" ><img class="rounded-pill " width="15px" height="15px" src="{{asset('images/MainLogo.png')}}"  /> {{$User->UserName}}</span>
                                    </div>

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
    @vite('resources/js/Front/Champions.js')
@endsection

