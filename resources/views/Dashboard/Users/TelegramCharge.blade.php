@extends('layouts.Dashboard.Master')
@section('content')
    <div class="content-page">
        <div class="content">

            <!-- Start Content-->
            <div class="container-fluid">

                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="header-title">Charge User</h4>


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
                                        <form method="POST" action="{{route('Dashboard.Users.TelegramCharge' , $User->id)}}" >
                                            @csrf
                                            <div class="mb-3">
                                                <label for="Name" class="form-label">Username</label>
                                                <input type="text" id="Name" name="Name" class="form-control" value="{{$User->UserName}}" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label for="Charge" class="form-label">Charge</label>
                                                <input type="number" id="Charge" name="Charge" step="0.01" class="form-control" value="{{$User->Charge}}">
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
