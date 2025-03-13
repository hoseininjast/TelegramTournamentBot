@extends('layouts.Front.Master')
@section('content')
    <!-- Latest arcive area start -->
    <section class="latest-arcive">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="sh-wrpper">
                        <img src="{{asset('Front/images/arcive/i1.png')}}" alt="">
                        <div class="section-heading">
                            <h5 class="subtitle">
                                This month tournaments
                            </h5>
                            <h2 class="title ">
                                Time Table
                            </h2>
                        </div>


                    </div>
                    <div class="row TimeTableDiv" >
                        <img src="{{$TimeTable->Image}}" alt="time table image">
                    </div>
                    <div class="row d-flex justify-content-around pt-4">
                        <a href="{{route('Front.DownloadTimeTable')}}" class="mybtn mybtn-primary mybtn-pill"> Download <i class="fa fa-download"></i></a>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Latest arcive area End -->
@endsection

@section('js')
    @vite('resources/js/Front/Tournament.js')
@endsection

