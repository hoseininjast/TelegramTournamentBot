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
                                    <a class="nav-link btn btn-outline-warning rounded-pill   StatusButton" id="StatusPending" data-Status="Pending"  >Pending</a>
                                </div>
                                <div class="col-4">
                                    <a class="nav-link btn btn-outline-success rounded-pill  StatusButton" id="StatusRunning" data-Status="Running"  >Running</a>
                                </div>
                                <div class="col-4">
                                    <a class="nav-link btn btn-outline-danger rounded-pill  StatusButton" id="StatusFinished" data-Status="Finished"  >Finished</a>
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

