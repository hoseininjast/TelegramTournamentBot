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
                                <h4 class="header-title">Edit Referral Plan</h4>


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
                                    <img style="max-width: 300px;max-height: fit-content;" src="{{$ReferralPlan->Image}}"  alt="Referral Plan image"/>
                                </div>



                                <div class="row">
                                    <div class="col-lg-12">
                                        <form method="POST" action="{{route('Dashboard.ReferralPlan.Update' , $ReferralPlan->id)}}" enctype="multipart/form-data">
                                            @csrf
                                            @method('PUT')
                                            <div class="mb-3">
                                                <label for="Name" class="form-label">Name</label>
                                                <input type="text" id="Name" name="Name" class="form-control" value="{{$ReferralPlan->Name}}">
                                            </div>

                                            <div class="mb-3">
                                                <label for="Description" class="form-label">Description</label>
                                                <textarea name="Description" id="Description" class="form-control"  rows="5">{{$ReferralPlan->Description}}</textarea>
                                            </div>

                                            <div class="mb-3 ">
                                                <label for="Image" class="form-label">Image</label>
                                                <input type="file" id="Image" name="Image" accept="image/*" class="form-control">
                                            </div>


                                            <div class="mb-3">
                                                <label for="Level" class="form-label">Level</label>
                                                <input type="number" id="Level" name="Level" class="form-control" value="{{$ReferralPlan->Level}}">
                                            </div>

                                            <div class="mb-3">
                                                <label for="Count" class="form-label">Count</label>
                                                <input type="number" id="Count" name="Count" class="form-control" value="{{$ReferralPlan->Count}}">
                                            </div>

                                            <div class="mb-3">
                                                <label for="Award" class="form-label">Award</label>
                                                <input type="number" id="Award" name="Award" step="0.01" class="form-control" value="{{$ReferralPlan->Award}}">
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
