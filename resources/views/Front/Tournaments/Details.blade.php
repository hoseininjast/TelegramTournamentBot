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
                                        <img src="assets/images/game-play/1.png" alt="">
                                    </div>
                                    <div class="contant">
                                        <a href="#" class="mybtn2">JOin Now</a>

                                    </div>
                                </div>

                            </div>
                            <div class="right-area">
                                <div class="r-top-area">
                                    <h4>Eventide Esports 5v5 Tournament</h4>
                                    <div class="list">
                                        <p>
                                            Fortnite: Battle Royale
                                        </p>
                                        <span></span>
                                        <p>
                                            PS4 & XB1
                                        </p>
                                    </div>
                                </div>
                                <div class="r-bottom-area2">
                                    <ul>
                                        <li>
											<span>
												TEAM SIZE
											</span>
                                            <h4>
                                                5 vs 5
                                            </h4>
                                        </li>
                                        <li>
											<span>
												MAX TEAMS
											</span>
                                            <h4>
                                                16
                                            </h4>
                                        </li>
                                        <li>
											<span>
												ENROLLED
											</span>
                                            <h4>
                                                04
                                            </h4>
                                        </li>
                                        <li>
											<span>
												SKILL LEVEL
											</span>
                                            <h4>
                                                Novice
                                            </h4>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="stf">
                            <div class="left">
                                <h4>37 People Playing</h4>
                                <ul>
                                    <li>
                                        <a href="#">
                                            <img src="assets/images/player/sm1.png" alt="">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="assets/images/player/sm2.png" alt="">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="assets/images/player/sm3.png" alt="">
                                        </a>
                                    </li>
                                    <li>
                                        <a href="#">
                                            <img src="assets/images/player/sm4.png" alt="">
                                        </a>
                                    </li>
                                </ul>
                            </div>
                            <div class="center">
                                <div class="time-area">
                                    <h6>3/11/21 6:00 AM - 3/18/21 5:59 AM</h6>
                                    <img src="assets/images/bg-time.png" alt="">
                                </div>
                            </div>
                            <div class="right">
                                <a href="#" class="mybtn2">Deposit</a>
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
                            <div class="col-lg-4 col-md-6">
                                <div class="single-prize">
                                    <img src="assets/images/prize/1.png" alt="">
                                    <h6>$165,00</h6>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="single-prize">
                                    <img src="assets/images/prize/2.png" alt="">
                                    <h6>$135,00</h6>
                                </div>
                            </div>
                            <div class="col-lg-4 col-md-6">
                                <div class="single-prize">
                                    <img src="assets/images/prize/3.png" alt="">
                                    <h6>$100,00</h6>
                                </div>
                            </div>
                        </div>
                        <br>
                        <br>
                        <h4>
                            HOW TO JOIN TOURNAMENT:
                        </h4>
                        <ul>
                            <li>
                                1) Click Join Now
                            </li>
                            <li>
                                2) Create a Team
                            </li>
                            <li>
                                3) Invite Members
                            </li>
                            <li>
                                4) Members Accept Invite
                            </li>
                            <li>
                                5) Refresh & Enroll Now!
                            </li>
                        </ul>
                        <br>
                        <br>
                        <h4>
                            HOW TO START A MATCH:
                        </h4>
                        <ul>
                            <li>
                                1) Wait for bracket to generate
                            </li>
                            <li>
                                2) You will receive a pop up/notification once your match has scheduled

                            </li>
                            <li>
                                3) Click link directing you to the match details page

                            </li>
                            <li>
                                4) Invite member on EPIC games account to start the match
                            </li>
                        </ul>
                        <br>
                        <br>
                        <h4>
                            PRIZE CLAIM
                        </h4>
                        <p>
                            Prize claims must be completed within 24 hours of the end of the tournament otherwise risk penalty of the prize. Claims can take
                            up to 72 hours to be processed. Players who reside in any of the below states are not eligible to receive and/or claim any
                            prizes from Jugaro Gaming;
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Turnaments Area End -->
@endsection

@section('js')
    @vite('resources/js/Front/Tournaments.js')
@endsection

