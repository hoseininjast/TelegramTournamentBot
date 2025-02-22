@extends('layouts.Front.Master')
@section('content')
    <section class="turnaments-tab-section">
        <div class="s-top-area">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-xl-6 col-lg-4">
                        <div class="top-left-title">
                            <h4>My Tournaments</h4>
                        </div>
                    </div>
                    <div class="col-xl-6 col-lg-8">
                        <div class="t-t-s-nav">
                            <ul class="nav"  role="tablist">
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link mybtn2  StatusButton" id="StatusPending" data-Status="Pending"  >Pending</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link mybtn2 StatusButton" id="StatusRunning" data-Status="Running"  >Running</a>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link mybtn2 StatusButton" id="StatusFinished" data-Status="Finished"  >Finished</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="row" id="TournamentsDiv">

                    </div>
                </div>

            </div>
        </div>
    </section>
@endsection

@section('js')
    @vite('resources/js/Front/MyTournaments.js')
@endsection

