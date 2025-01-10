@extends('layouts.Dashboard.Master')
@section('content')
    <div class="content-page">
        <div class="content">

            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Manage Tournament Plan</h4>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif


                            </div>
                            <div class="card-body">


                                <div class="row">

                                    <div class="col-lg-12">
                                        <div class="row ">
                                            <div class="col-6">
                                                Group : {{$TournamentPlan->Group}}
                                            </div>

                                            <div class="col-6">
                                                Stage : {{$TournamentPlan->Stage}}
                                            </div>

                                        </div>
                                    </div>


                                    <div class="col-lg-12">
                                        <div class="row ">
                                            <div class="col-6">
                                                Player 1 : {{$TournamentPlan->Player1->UserName}} => {{$TournamentPlan->Player1->PlatoID}}
                                            </div>

                                            <div class="col-6">
                                                Player 2 : {{$TournamentPlan->Player2->UserName}} => {{$TournamentPlan->Player2->PlatoID}}
                                            </div>

                                        </div>
                                    </div>

                                    <form method="POST" action="{{route('Dashboard.TournamentPlan.Update' , $TournamentPlan->id)}}" >
                                        @csrf
                                        <div class="row mt-5">
                                            <div class="mb-3 col-4">
                                                <label for="Player1Score" class="form-label">Player 1 Score</label>
                                                <input type="number" id="Player1Score" name="Player1Score" class="form-control">
                                            </div>

                                            <div class="mb-3 col-4">
                                                <label for="Player2Score" class="form-label">Player 2 Score</label>
                                                <input type="number" id="Player2Score" name="Player2Score" class="form-control">
                                            </div>

                                            <div class="mb-3 col-4">
                                                <label for="WinnerID"  class="form-label">Winner </label>
                                                <select class="form-select" id="WinnerID" name="WinnerID">
                                                    <option selected>Select tournament type</option>
                                                    <option value="{{$TournamentPlan->Player1->id}}">{{$TournamentPlan->Player1->UserName}} => {{$TournamentPlan->Player1->PlatoID}} </option>
                                                    <option value="{{$TournamentPlan->Player2->id}}">{{$TournamentPlan->Player2->UserName}} => {{$TournamentPlan->Player2->PlatoID}} </option>
                                                </select>
                                            </div>
                                        </div>



                                        <div class=" row">
                                            <div class="col-8 col-xl-9">
                                                <button type="submit" class="btn btn-success waves-effect waves-light">Submit</button>
                                            </div>
                                        </div>



                                    </form>



                                </div>

                            </div>

                        </div>

                    </div>
                </div>

            </div>

        </div>


    </div>
@endsection
