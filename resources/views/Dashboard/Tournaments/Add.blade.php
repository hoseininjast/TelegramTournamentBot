@extends('layouts.Dashboard.Master')
@section('Head')
    <link href="{{asset('Dashboard/assets/libs/flatpickr/flatpickr.min.css')}}" rel="stylesheet" type="text/css" />
@endsection
@section('content')
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Add Tournament</h4>


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
                                        <form method="POST" action="{{route('Dashboard.Tournaments.Create')}}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="row">
                                                <div class="mb-3 col-6">
                                                    <label for="Name" class="form-label">Name</label>
                                                    <input type="text" id="Name" name="Name" class="form-control" value="{{old('Name')}}">
                                                </div>

                                                <div class="mb-3 col-6">
                                                    <label for="Description" class="form-label">Description</label>
                                                    <textarea name="Description" id="Description" class="form-control"  rows="1">{{old('Description')}}</textarea>
                                                </div>
                                            </div>


                                            <div class="row">

                                                <div class="mb-3 col-6">
                                                    <label for="PlayerCount" class="form-label">Player Count</label>
                                                    <input type="number" id="PlayerCount" name="PlayerCount" class="form-control" value="{{old('PlayerCount')}}">
                                                </div>

                                                <div class="mb-3 col-6">
                                                    <label for="GameID"  class="form-label">Game</label>
                                                    <select class="form-select" id="GameID" name="GameID">
                                                        <option selected>Select tournament Game</option>
                                                        @foreach($Games as $game)
                                                            <option @if(old('GameID') == $game->id) selected @endif value="{{$game->id}}">{{$game->Name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>



                                            </div>





                                            <div class="row">


                                                <div class="mb-3 col-6">
                                                    <label for="Type"  class="form-label">Type</label>
                                                    <select class="form-select" id="Type" name="Type">
                                                        <option selected>Select tournament type</option>
                                                        <option @if(old('Type') == 'Knockout') selected @endif value="Knockout">Knockout</option>
                                                        <option @if(old('Type') == 'WorldCup') selected @endif value="WorldCup">WorldCup</option>
                                                        <option @if(old('Type') == 'League') selected @endif value="League">League</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3 col-6">
                                                    <label for="Mode"  class="form-label">Mode</label>
                                                    <select class="form-select" id="Mode" name="Mode" onchange="SetMode(this.value)">
                                                        <option selected>Select tournament Mode</option>
                                                        <option @if(old('Type') == 'Free') selected @endif value="Free">Free</option>
                                                        <option @if(old('Type') == 'Paid') selected @endif value="Paid">Paid</option>
                                                    </select>
                                                </div>


                                            </div>


                                            <div class="row">
                                                <div class="mb-3 col-6">
                                                    <label for="Price" class="form-label">Price</label>
                                                    <input type="number" id="Price" name="Price" class="form-control">
                                                </div>

                                                <div class="mb-3 col-6">
                                                    <label for="Time" class="form-label">Time</label>
                                                    <input type="number" id="Time" name="Time" class="form-control" onchange="SetEndDate(this.value)">
                                                </div>


                                            </div>


                                            <div class="row">
                                                <div class="mb-3 col-6">
                                                    <label for="Start" class="form-label">Start Date</label>
                                                    <input type="text" id="Start" name="Start" class="form-control" placeholder="Start Date" onchange="SetValue(this.value , 'Start')">
                                                </div>


                                                <div class="mb-3 col-6">
                                                    <label for="End" class="form-label">End Date</label>
                                                    <input type="text" id="End" name="End" class="form-control" placeholder="End Date" onchange="SetValue(this.value , 'End')">
                                                </div>

                                            </div>

                                            <div class="row">


                                                <div class="mb-3 col-6">
                                                    <label for="TotalStage" class="form-label">Total Stage</label>
                                                    <input type="number" id="TotalStage" name="TotalStage" class="form-control" value="{{old('TotalStage')}}" onkeyup="CreateStagesDate(this.value)">
                                                </div>


                                                <div class="mb-3 col-6">
                                                    <label for="Winners" class="form-label">Winners</label>
                                                    <input type="number" id="Winners" name="Winners" class="form-control" onkeyup="CreateAdwards(this.value)">
                                                </div>

                                            </div>
                                            <div class="row" id="StagesDiv">


                                            </div>

                                            <div class="row" id="AwardsDiv">



                                            </div>






                                            <div class=" row">
                                                <div class="col-8 col-xl-9">
                                                    <button type="submit" class="btn btn-success waves-effect waves-light">Submit</button>
                                                </div>
                                            </div>



                                        </form>
                                    </div> <!-- end col -->

                                </div>
                                <!-- end row-->

                            </div> <!-- end card-body -->
                        </div> <!-- end card -->
                    </div><!-- end col -->
                </div>
                <!-- end row -->

            </div> <!-- container -->

        </div> <!-- content -->


    </div>
@endsection

@section('js')
    <script src="{{asset('Dashboard/assets/libs/flatpickr/flatpickr.min.js')}}"></script>
    <script>
        var StartDate , EndDate, Time;
        $(document).ready(function() {
            $("#Start").flatpickr({enableTime:!0,dateFormat:"Y-m-d H:i:ss",minDate: "today"});
            $("#End").flatpickr({enableTime:!0,dateFormat:"Y-m-d H:i:ss",minDate: "today"});
        });

        function CreateAdwards(AdwardCount) {
            $('#AwardsDiv').empty()
            for(var i = 1 ; i <= AdwardCount ; i++){
                var row = '<div class="mb-3 col-auto"><label for="Award'+i+'" class="form-label">Award '+i+'</label><input type="number" id="Award'+i+'" name="Awards[]" class="form-control"></div>';
                $('#AwardsDiv').append(row)
            }
        }


        function CreateStagesDate(StageCount) {
            if (StartDate && EndDate){
                $('#StagesDiv').empty()
                for(var i = 1 ; i <= StageCount ; i++){
                    var row = '<div class="mb-3 col-auto"><label for="Stage'+i+'" class="form-label">Stage '+i+'</label><input type="text" id="Stage'+i+'" name="StagesDate[]" class="form-control StagesDate"></div>';
                    $('#StagesDiv').append(row)
                }
                $(".StagesDate").flatpickr({
                    enableTime:!0,
                    dateFormat:"Y-m-d H:i:ss",
                    minDate: StartDate,
                    maxDate: EndDate
                });
            }else{
                $('#TotalStage').val(null)
                ShowToast('warning' , 'Please select start date and end date first' );
            }


        }

        function SetEndDate(EndDate ) {
            if(StartDate){
                $("#End").flatpickr({enableTime:!0,dateFormat:"Y-m-d H:i:ss",minDate: StartDate , maxDate: new Date(StartDate).fp_incr(EndDate)});
            }else{
                $("#End").flatpickr({enableTime:!0,dateFormat:"Y-m-d H:i:ss",minDate: "today" , maxDate: new Date().fp_incr(EndDate)});
            }

        }

        function SetMode(Mode) {
            if(Mode == 'Free'){
                $('#Price').val(0)
            }
        }

        function SetValue(SelectedDate , varname) {
            if(varname == 'Start'){
                StartDate = SelectedDate;
                SetEndDate( $('#Time').val() ,SelectedDate);
            }else if(varname == 'End'){
                EndDate = SelectedDate;
            }
        }
    </script>
@endsection
