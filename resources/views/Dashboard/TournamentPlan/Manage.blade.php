@extends('layouts.Dashboard.Master')
@section('Head')
    <link href="{{asset('Dashboard/assets/libs/flatpickr/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="content-page">
        <div class="content">

            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Set Game Time</h4>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="row">

                                            <div class="col-lg-12">
                                                <div class="row ">
                                                    <div class="col-12">
                                                        <p>Cuurent game time : {{$TournamentPlan->Time}}</p>
                                                    </div>


                                                </div>
                                            </div>
                                        </div>
                                        <form method="POST" action="{{route('Dashboard.TournamentPlan.SetTime' , $TournamentPlan->id)}}">
                                            @csrf
                                            <div class="row d-flex justify-content-around mt-3">
                                                <div class="col-8 mb-3  ">
                                                    <label for="Time" class="form-label">Time</label>
                                                    <input type="text" id="Time" name="Time" class="form-control"  placeholder="Start Date">
                                                </div>
                                                <div class="col-4 mt-3" >
                                                    <button type="submit" class="btn col-6 btn-info waves-effect waves-light">Submit</button>
                                                </div>
                                            </div>





                                        </form>
                                    </div> <!-- end col -->

                                </div>

                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Manage Tournament Plan</h4>


                                <div class="row">

                                    <div class="col-lg-12">
                                        <div class="row ">
                                            <div class="col-6">
                                                <p>Group : {{$TournamentPlan->Group}}</p>
                                            </div>

                                            <div class="col-6">
                                                <p>Stage : {{$TournamentPlan->Stage}}</p>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="row ">
                                            <div class="col-6">
                                                <p>Time : {{$TournamentPlan->Time}}</p>
                                            </div>

                                            <div class="col-6">
                                                <p>Tournament Name : {{$TournamentPlan->Tournament->Name}}</p>
                                            </div>

                                        </div>
                                    </div>

                                    <div class="col-lg-12">
                                        <div class="row ">
                                            <div class="col-6">
                                                <p>
                                                    Player 1 :
                                                    <br>
                                                    Telegram ID : {{$TournamentPlan->Player1->UserName}}
                                                    <br>
                                                    Plato ID : {{$TournamentPlan->Player1->PlatoID}}
                                                </p>

                                            </div>

                                            <div class="col-6">
                                                <p>
                                                    Player 2 :
                                                    <br>
                                                    Telegram ID : {{$TournamentPlan->Player2->UserName}}
                                                    <br>
                                                    Plato ID : {{$TournamentPlan->Player2->PlatoID}}
                                                </p>
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

@section('js')
    <script src="{{asset('Dashboard/assets/libs/flatpickr/flatpickr.min.js')}}"></script>
    <script>
        var EndTime = '{{$TournamentPlan->Tournament->End}}'
        $(document).ready(function() {
            $("#Time").flatpickr({enableTime:!0,dateFormat:"Y-m-d H:i:ss",minDate: "today" , 'maxDate' : EndTime});
        });
    </script>
@endsection
