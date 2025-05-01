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
                            <div class="row">
                                <div class="col-4">
                                    <button class="nav-link mybtn mybtn-warning mybtn-pill-10   StatusButton" id="StatusPending" data-Status="Pending"  >Pending</button>
                                </div>
                                <div class="col-4">
                                    <button class="nav-link mybtn mybtn-success mybtn-pill-10  StatusButton" id="StatusRunning" data-Status="Running"  >Running</button>
                                </div>
                                <div class="col-4">
                                    <button class="nav-link mybtn mybtn-danger mybtn-pill-10  StatusButton" id="StatusFinished" data-Status="Finished"  >Finished</button>
                                </div>
                            </div>
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

