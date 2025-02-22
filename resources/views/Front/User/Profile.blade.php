@extends('layouts.Front.Master')
@section('content')
    <!-- Breadcrumb Area Start -->
    <section class="breadcrumb-area gamer-profile">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="bc-content">
                        <div class="left">
                            <h3 id="ProfileUsername"></h3>
                            <p id="ProfileJoinDate"></p>
                        </div>
                        <div class="right">
                            <div class="player-wrapper">
                                <span>Championship</span>
                                <h6 id="Championship"></h6>
                            </div>
                            <ul>
                                <li>
                                    <a href="#">
                                        <img src="{{asset('Front/images/gamer/c2.png')}}" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="{{asset('Front/images/prize/1.png')}}" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="{{asset('Front/images/prize/2.png')}}" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="{{asset('Front/images/prize/3.png')}}" alt="">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Area End -->

    <!-- Gamer Profile area Start -->
    <section class="gamer-profile-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="gamer-profile-top-inner">
                        <div class="profile-photo">
                            <div class="img">
                                <img id="ProfileImage" src="{{asset('images/Users/DefaultProfile.png')}}" alt="" class="rounded-pill" />
                            </div>
                            <div class="mybadge">
                                <img src="{{asset('Front/images/gamer/badge.png')}}" alt="">
                            </div>
                        </div>
                        <div class="g-p-t-counters row">
                            <div class="g-p-t-single-counter">
                                <div class="img">
                                    <img src="{{asset('Front/images/gamer/c1.png')}}" alt="">
                                </div>
                                <div class="content">
                                    <h4 id="TournamentsJoined">0</h4>
                                    <span>Total Match</span>
                                </div>
                            </div>
                            <div class="g-p-t-single-counter">
                                <div class="img">
                                    <img src="{{asset('Front/images/gamer/c2.png')}}" alt="">
                                </div>
                                <div class="content">
                                    <h4 id="TournamentsWinned">0</h4>
                                    <span>Win Ratio</span>
                                </div>
                            </div>
                            <div class="g-p-t-single-counter">
                                <div class="img">
                                    <img src="{{asset('Front/images/gamer/c3.png')}}" alt="">
                                </div>
                                <div class="content">
                                    <h4 id="ReferralCount">0</h4>
                                    <span>User's invited</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Gamer Profile  area End -->
@endsection

@section('js')
    @vite('resources/js/Front/Profile.js')
@endsection

