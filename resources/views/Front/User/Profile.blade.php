@extends('layouts.Front.Master')

@section('content')
    <!-- Breadcrumb Area Start -->
    <section class="breadcrumb-area gamer-profile pt-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="bc-content">
                        <div class="left">
                            <section class="gamer-profile-top BackgroundImageUnset">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-12 text-center">
                                            <div class="gamer-profile-top-inner">
                                                <div class="profile-photo">
                                                    <div class="img">
                                                        <img id="ProfileImage" src="{{asset('images/Users/DefaultProfile.png')}}" alt="" class="rounded-pill" />
                                                    </div>
                                                </div>
                                            </div>
                                            <h3 id="ProfileUsername"></h3>
                                            <p id="ProfileJoinDate"></p>
                                        </div>
                                    </div>
                                </div>
                            </section>

                        </div>
                        <div class="right">
                            <div class="player-wrapper">
                                <span>Championship</span>
                                <h6 id="Championship"></h6>
                            </div>
                            <ul>
                                <li>
                                    <a href="#">
                                        <img src="{{asset('Front/images/gamer/c2.png')}}" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="{{asset('Front/images/ui/gold.png')}}" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="{{asset('Front/images/ui/silver.png')}}" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="{{asset('Front/images/ui/bronze.png')}}" alt="">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Area End -->

    <!-- Gamer Profile area Start -->
    <section class="gamer-profile-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="gamer-profile-top-inner">
                        <div class="g-p-t-counters row">
                            <div class="g-p-t-single-counter">
                                <div class="img">
                                    <img src="{{asset('Front/images/gamer/c1.png')}}" alt="">
                                </div>
                                <div class="content">
                                    <h4 id="TournamentsJoined">0</h4>
                                    <span>Total Match</span>
                                </div>
                            </div>
                            <div class="g-p-t-single-counter">
                                <div class="img">
                                    <img src="{{asset('Front/images/gamer/c2.png')}}" alt="">
                                </div>
                                <div class="content">
                                    <h4 id="TournamentsWinned">0</h4>
                                    <span>Win Ratio</span>
                                </div>
                            </div>
                            <div class="g-p-t-single-counter">
                                <div class="img">
                                    <img src="{{asset('Front/images/gamer/c3.png')}}" alt="">
                                </div>
                                <div class="content">
                                    <h4 id="ReferralCount">0</h4>
                                    <span>User's invited</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Gamer Profile  area End -->

    <!-- User Menu Area Start -->
    <div class="usermenu-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="t-t-s-nav">
                        <div class="row">
                            <div class="col-4">
                                <a class="nav-link text-center mybtn mybtn-primary mybtn-pill-10   ProfileSectionButtons" id="AffiliateButton" data-Section="Affiliate"  > Invite</a>
                            </div>
                            <div class="col-4">
                                <a class="nav-link text-center mybtn mybtn-primary  mybtn-pill-10 ProfileSectionButtons" id="PlatformButton" data-Section="Platform"  > Platform</a>
                            </div>
                            <div class="col-4">
                                <a class="nav-link text-center mybtn mybtn-primary  mybtn-pill-10 ProfileSectionButtons" id="SettingButton" data-Section="Setting"  > Setting</a>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- User Menu Area End -->

    <!-- User Main Content Area Start -->
    <section class="user-main-dashboard">
        <div class="container">
            <div class="row">
                <div class="col-xl-12" id="MainDashboardSectionDiv">
                    <main class="MainDashboardSections" id="AffiliateSection" >
                        <div class="main-box affiliate-box">
                            <div class="header-area">
                                <h4>Referral Program</h4>
                                <p>
                                    Get a lifetime reward for inviting new people!
                                </p>
                            </div>
                            <div class="referral-link-area">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="left">
                                            <h4 class="title">Copy Referral Link <i class="fas fa-file" id="ReferralidCopyIcon" ></i></h4>

                                            <div class="aff-code">
                                                <span>
                                                    <span id="MyInviteLink" onclick="copyContent(this.value)"></span>
                                                </span>


                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="header-area mt-5 mb-0">
                                <h4>Referral Status</h4>
                            </div>

                            <div class="earning-info-area mt-0">

                                <div class="s-info">
                                    <img src="{{asset('Front/images/user/a1.png')}}" alt="">
                                    <div class="content">
                                        <h4 id="ReferralCountinTable">0</h4>
                                        <p>Referral Count</p>
                                    </div>
                                </div>
                                <div class="s-info">
                                    <img src="{{asset('Front/images/user/a2.png')}}" alt="">
                                    <div class="content">
                                        <h4 id="ReferralIncome">0</h4>
                                        <p>Earned Referral</p>
                                    </div>
                                </div>

                            </div>


                            <div class="user-main-dashboard">

                                <aside>
                                    <div class="about">
                                        <h4>Referral Plan</h4>
                                        <p> here you can see all our Referral plans and see your progress , also for completing each plan you will get rewards </p>

                                    </div>
                                   <div id="ReferralPlansDiv">

                                   </div>



                                </aside>

                            </div>



                            <div class="aff-table">
                                <div class="header-area">
                                    <h4>Referral History</h4>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>User Name</th>
                                            <th>Plato ID</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody id="ReferralHistoryTable">


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </main>
                    <main class="MainDashboardSections" id="PlatformSection" style="display: none">
                        <div class="main-box u-setting-area">
                            <div class="header-area">
                                <h4>Platform's</h4>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-md-9">
                                    <div class="single-user-setting">
                                        <div class="s-title-area">
                                            <h4>Platform Details</h4>
                                        </div>
                                        <div class="s-content-area">
                                            <form action="{{route('Front.Profile.UpdatePlatform')}}" enctype="multipart/form-data" method="post">
                                                @csrf
                                                <input type="hidden" name="UserID" id="UserIDForPlato">
                                                <div class="form-group">
                                                    <label for="PlatoID"> Plato ID</label>
                                                    <input class="form-control" id="PlatoID" name="PlatoID" type="text" placeholder="Enter Your Plato ID">
                                                </div>

                                                <div class="form-group">
                                                    <label for="WalletAddress">Counter Account</label>
                                                    <input class="form-control" id="CounterAccount" name="CounterAccount" type="text" placeholder="Counter games" disabled>
                                                </div>

                                                <div class="form-group">
                                                    <label for="WalletAddress">Activision Account</label>
                                                    <input class="form-control" id="ActivisionAccount" name="ActivisionAccount" type="text" placeholder="call of duty games" disabled="">
                                                </div>

                                                <div class="form-group">
                                                    <label for="WalletAddress">Supercell ID</label>
                                                    <input class="form-control" id="SupercellID" name="SupercellID" type="text" placeholder="clash of clans " disabled>
                                                </div>

                                                <button type="submit" class=" mybtn mybtn-primary mybtn-pill-40 " >Update</button>
                                            </form>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </main>
                    <main class="MainDashboardSections" id="SettingSection" style="display: none">
                        <div class="main-box u-setting-area">
                            <div class="header-area">
                                <h4>Setting</h4>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-md-9">
                                    <div class="single-user-setting">
                                        <div class="s-title-area">
                                            <h4>Personal Details</h4>
                                        </div>
                                        <div class="s-content-area">
                                            <form >
                                                @csrf
                                                <input type="hidden" name="UserID" id="UserID">
                                                <div class="form-group">
                                                    <label for="UserName"> Telegram Username</label>
                                                    <input class="form-control" id="UserName" name="UserName" type="text" placeholder="Enter Your Telegram UserName">
                                                </div>

                                                <div class="form-group">
                                                    <label for="WalletAddress">Polygon Wallet</label>
                                                    <input class="form-control" id="WalletAddress" name="WalletAddress" type="text" placeholder="Enter Your Polygon Wallet Address">
                                                </div>

                                                <div class="form-group">
                                                    <label for="ImageInput">Image</label>
                                                    <input type="file" accept="image/*"  class="form-control ImageInput" id="ImageInput" name="ImageInput">
                                                </div>
                                                <button type="button" class=" mybtn mybtn-primary mybtn-pill-40 " id="UpdateProfileButton">Update</button>
                                            </form>

                                        </div>
                                    </div>

                                </div>



                            </div>
                        </div>
                    </main>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modal" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalLabel">Crop image</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="img-container">
                        <div class="row">
                            <div class="col-md-8">
                                <img id="image" src="" alt="">
                            </div>
                            <div class="col-md-4">
                                <div class="preview"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="mybtn mybtn-secondary mybtn-pill-20" data-dismiss="modal">Cancel</button>
                    <button type="button" class="mybtn mybtn-primary mybtn-pill-30" id="crop">Crop</button>
                </div>
            </div>
        </div>
    </div>



    <!-- User Main Content Area End -->
    <div class="forged-fixed-bottom-bar"></div>



@endsection

@section('js')
    @vite('resources/js/Front/Profile.js')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.css"/>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.6/cropper.js"></script>
    <script>


        var $modal = $('#modal');
        var image = document.getElementById('image');
        var cropper;

        $("body").on("change", ".ImageInput", function(e){
            var files = e.target.files;
            var done = function (url) {
                image.src = url;
                $modal.modal('show');
            };
            var reader;
            var file;
            var url;
            if (files && files.length > 0) {
                file = files[0];
                if (URL) {
                    done(URL.createObjectURL(file));
                } else if (FileReader) {
                    reader = new FileReader();
                    reader.onload = function (e) {
                        done(reader.result);
                    };
                    reader.readAsDataURL(file);
                }
            }
        });
        $modal.on('shown.bs.modal', function () {
            cropper = new Cropper(image, {
                aspectRatio: 1,
                viewMode: 3,
                preview: '.preview'
            });
        }).on('hidden.bs.modal', function () {
            cropper.destroy();
            cropper = null;
        });
        $("#crop").click(function(){
            canvas = cropper.getCroppedCanvas({
                width: 160,
                height: 160,
            });
            canvas.toBlob(function(blob) {
                url = URL.createObjectURL(blob);
                var reader = new FileReader();
                reader.readAsDataURL(blob);
                reader.onloadend = function() {
                    var base64data = reader.result;

                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        type: 'POST',
                        async: false,
                        cache: false,
                    });

                    $.ajax({
                        url: "{{route('V1.Profile.UpdateImage')}}",
                        data: {
                            UserID : $('#UserID').val(),
                            'Image': base64data
                        },
                        success: function(response){
                            $modal.modal('hide');
                            if(response.Data.Code == 200){
                                Swal.fire({
                                    icon: 'success',
                                    text: response.Data.Message,
                                });
                                window.location.reload();
                            }else{
                                Swal.fire({
                                    icon: 'error',
                                    text: response.Data.Message,
                                });
                            }

                        }
                    });
                }
            });
        })
    </script>
@endsection

