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
                                <h4 class="header-title">Add Tasks</h4>


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
                                        <form method="POST" action="{{route('Dashboard.Tasks.Create')}}" enctype="multipart/form-data">
                                            @csrf

                                            <div class="mb-3">
                                                <label for="TaskID" class="form-label">Task ID</label>
                                                <input type="text" id="TaskID" name="TaskID" class="form-control">
                                            </div>


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
                                                <label for="Category" class="form-label">Category</label>
                                                <input type="text" id="Category" name="Category" class="form-control">
                                            </div>

                                            <div class="mb-3">
                                                <label for="Condition" class="form-label">Condition</label>
                                                <input type="text" id="Condition" name="Condition" class="form-control">
                                            </div>

                                            <div class="mb-3">
                                                <label for="Reward" class="form-label">Reward</label>
                                                <input type="text" id="Reward" name="Reward" class="form-control">
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
