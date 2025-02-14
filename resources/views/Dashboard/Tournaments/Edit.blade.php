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
                                <h4 class="header-title">Edit Tournament</h4>


                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <div class="row d-flex justify-content-around mb-5">
                                    <img style="max-width: 300px;max-height: fit-content;" src="{{$Tournament->GetImage()}}"  alt="Tournament image"/>
                                </div>


                                <div class="row">
                                    <div class="col-lg-12">
                                        <form method="POST" action="{{route('Dashboard.Tournaments.Update' , $Tournament->id)}}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="row">
                                                <div class="mb-3 col-4">
                                                    <label for="Name" class="form-label">Name</label>
                                                    <input type="text" id="Name" name="Name" class="form-control" value="{{$Tournament->Name}}">
                                                </div>

                                                <div class="mb-3 col-4">
                                                    <label for="Description" class="form-label">Description</label>
                                                    <textarea name="Description" id="Description" class="form-control"  rows="1">{{$Tournament->Description}}</textarea>
                                                </div>


                                                <div class="mb-3 col-4">
                                                    <label for="Image" class="form-label">Image</label>
                                                    <input type="file" id="Image" name="Image" accept="image/*" class="form-control" >
                                                </div>

                                            </div>


                                            <div class="row">

                                                <div class="mb-3 col-6">
                                                    <label for="PlayerCount" class="form-label">Player Count</label>
                                                    <input type="number" id="PlayerCount" name="PlayerCount" class="form-control" value="{{$Tournament->PlayerCount}}">
                                                </div>

                                                <div class="mb-3 col-6">
                                                    <label for="GameID"  class="form-label">Game</label>
                                                    <select class="form-select" id="GameID" name="GameID">
                                                        <option selected>Select tournament Game</option>
                                                        @foreach($Games as $game)
                                                            <option @if($Tournament->GameID == $game->id) selected @endif value="{{$game->id}}">{{$game->Name}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>



                                            </div>





                                            <div class="row">


                                                <div class="mb-3 col-6">
                                                    <label for="Type"  class="form-label">Type</label>
                                                    <select class="form-select" id="Type" name="Type">
                                                        <option selected>Select tournament type</option>
                                                        <option @if($Tournament->Type == 'Knockout') selected @endif value="Knockout">Knockout</option>
                                                        <option @if($Tournament->Type == 'WorldCup') selected @endif value="WorldCup">WorldCup</option>
                                                        <option @if($Tournament->Type == 'League') selected @endif value="League">League</option>
                                                    </select>
                                                </div>

                                                <div class="mb-3 col-6">
                                                    <label for="Mode"  class="form-label">Mode</label>
                                                    <select class="form-select" id="Mode" name="Mode" onchange="SetMode(this.value)">
                                                        <option selected>Select tournament Mode</option>
                                                        <option @if($Tournament->Mode == 'Free') selected @endif value="Free">Free</option>
                                                        <option @if($Tournament->Mode == 'Paid') selected @endif value="Paid">Paid</option>
                                                    </select>
                                                </div>


                                            </div>


                                            <div class="row">
                                                <div class="mb-3 col-6">
                                                    <label for="Price" class="form-label">Price</label>
                                                    <input type="number" id="Price" name="Price" class="form-control" value="{{$Tournament->Price}}">
                                                </div>

                                                <div class="mb-3 col-6">
                                                    <label for="Time" class="form-label">Time</label>
                                                    <input type="number" id="Time" name="Time" class="form-control" value="{{$Tournament->Time}}" onchange="SetEndDate(this.value)">
                                                </div>


                                            </div>


                                            <div class="row">
                                                <div class="mb-3 col-6">
                                                    <label for="Start" class="form-label">Start Date</label>
                                                    <input type="text" id="Start" name="Start" class="form-control" value="{{$Tournament->Start}}" placeholder="Start Date" onchange="SetValue(this.value , 'Start')">
                                                </div>


                                                <div class="mb-3 col-6">
                                                    <label for="End" class="form-label">End Date</label>
                                                    <input type="text" id="End" name="End" class="form-control" value="{{$Tournament->End}}" placeholder="End Date" onchange="SetValue(this.value , 'End')">
                                                </div>

                                            </div>

                                            <div class="row">


                                                <div class="mb-3 col-6">
                                                    <label for="TotalStage" class="form-label">Total Stage</label>
                                                    <input type="number" id="TotalStage" name="TotalStage" class="form-control" value="{{$Tournament->TotalStage}}" onkeyup="CreateStagesDate(this.value)">
                                                </div>


                                                <div class="mb-3 col-6">
                                                    <label for="Winners" class="form-label">Winners</label>
                                                    <input type="number" id="Winners" name="Winners" class="form-control" value="{{$Tournament->Winners}}" onkeyup="CreateAdwards(this.value)">
                                                </div>

                                            </div>
                                            <div class="row" id="StagesDiv">


                                            </div>

                                            <div class="row" id="AwardsDiv">



                                            </div>






                                            <div class=" row">
                                                <div class="col-8 col-xl-9">
                                                    <button type="submit" class="btn btn-success waves-effect waves-light">Update</button>
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
        var StartDate = '{{$Tournament->Start}}' ;
        var EndDate = '{{$Tournament->End}}';
        var Time = '{{$Tournament->Time}}';
        var TotalStages = '{{$Tournament->TotalStage}}';
        var Winners = '{{$Tournament->Winners}}';
        var TournamentID = '{{$Tournament->id}}' ;
        var Tournament ;








        $(document).ready(function() {
            GetTournamentDetail();
            SetEndDate(Time)
            SetValue(StartDate , 'Start')
            SetValue(EndDate , 'End')
            CreateStagesDate(TotalStages)
            CreateAdwards(Winners)
            $("#Start").flatpickr({enableTime:!0,dateFormat:"Y-m-d H:i:ss",minDate: "today"});
            $("#End").flatpickr({enableTime:!0,dateFormat:"Y-m-d H:i:ss",minDate: "today"});
        });

        function GetTournamentDetail(){
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                type: 'GET',
                async: false,
                cache: false,
            });
            $.ajax({
                url: route('V1.Tournaments.Detail' , TournamentID),
                success: function (response) {
                    Tournament = response.Data.Tournament;
                }
            });
        }

        function CreateAdwards(AdwardCount) {
            $('#AwardsDiv').empty()
            var Awards = Tournament.Awards;
            for(var i = 0 ; i <= AdwardCount - 1 ; i++){
                var row = '<div class="mb-3 col-auto"><label for="Award'+i+'" class="form-label">Award '+i+'</label><input type="number" id="Award'+i+'" name="Awards[]" value="'+Awards[i]+'" class="form-control"></div>';
                $('#AwardsDiv').append(row)
            }
        }





        function CreateStagesDate(StageCount) {
            if (StartDate && EndDate){
                $('#StagesDiv').empty()
                var StageDates = Tournament.StagesDate;
                for(var i = 0 ; i <= StageCount - 1 ; i++){
                    var row = '<div class="mb-3 col-auto"><label for="Stage'+i+'" class="form-label">Stage '+i+'</label><input type="text" id="Stage'+i+'" name="StagesDate[]" value="'+StageDates[i]+'" class="form-control StagesDate"></div>';
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
