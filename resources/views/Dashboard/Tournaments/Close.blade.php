@extends('layouts.Dashboard.Master')
@section('content')
    <div class="content-page">
        <div class="content">

            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Close Tournament</h4>
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form method="POST" action="{{route('Dashboard.Tournaments.Close' , $Tournament->id)}}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row d-flex justify-content-around">


                                        @for($i = 0; $i < $Tournament->Winners ; $i++)
                                            <div class="col-auto mb-3 ">
                                                <label for="Winner{{$i}}" class="form-label">Winner {{$i + 1}}</label>
                                                <select class="form-select" id="Winner{{$i}}" name="Winner[{{$i + 1}}]" >
                                                    <option selected>Select tournament Winner</option>
                                                    @foreach($Players as $player)
                                                        <option value="{{$player->id}}">{{$player->UserName}} => {{$player->PlatoID}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        @endfor

                                            <div class="mb-3 ">
                                                <label for="Image" class="form-label">Image</label>
                                                <input type="file" id="Image" name="Image" accept="image/*" class="form-control">
                                            </div>

                                            <div class="col-12 d-flex justify-content-around">
                                                <button type="submit" class="btn btn-success waves-effect waves-light col-4">Submit</button>
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
@endsection
