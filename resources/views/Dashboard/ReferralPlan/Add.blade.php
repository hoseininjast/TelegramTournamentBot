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
                                <h4 class="header-title">Add Referral Plan</h4>


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
                                        <form method="POST" action="{{route('Dashboard.ReferralPlan.Create')}}" enctype="multipart/form-data">
                                            @csrf
                                            <div class="mb-3">
                                                <label for="Name" class="form-label">Name</label>
                                                <input type="text" id="Name" name="Name" class="form-control">
                                            </div>

                                            <div class="mb-3">
                                                <label for="Description" class="form-label">Description</label>
                                                <textarea name="Description" id="Description" class="form-control"  rows="5"></textarea>
                                            </div>

                                            <div class="mb-3 ">
                                                <label for="Image" class="form-label">Image</label>
                                                <input type="file" id="Image" name="Image" accept="image/*" class="form-control">
                                            </div>

                                            <div class="mb-3">
                                                <label for="Level" class="form-label">Level</label>
                                                <input type="number" id="Level" name="Level" class="form-control">
                                            </div>

                                            <div class="mb-3">
                                                <label for="Count" class="form-label">Count</label>
                                                <input type="number" id="Count" name="Count" class="form-control">
                                            </div>

                                            <div class="mb-3">
                                                <label for="Award" class="form-label">Award</label>
                                                <input type="number" id="Award" name="Award" step="0.01" class="form-control">
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
