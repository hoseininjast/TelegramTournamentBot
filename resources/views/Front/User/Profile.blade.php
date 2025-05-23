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
                                <span>Stars</span>
                                <h6 id="Stars"></h6>
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
                                    <span>Total Tours</span>
                                </div>
                            </div>

                            <div class="g-p-t-single-counter">
                                <div class="img">
                                    <img src="{{asset('Front/images/gamer/a1.png')}}" alt="">
                                </div>
                                <div class="content">
                                    <h4 id="TotalGames">0</h4>
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
                            <div class="col-6">
                                <a class="nav-link text-center mybtn mybtn-primary  mybtn-pill-10 ProfileSectionButtons" id="SettingButton" data-Section="Setting"  > Setting</a>
                            </div>
                            <div class="col-6">
                                <a class="nav-link text-center mybtn mybtn-primary  mybtn-pill-10 ProfileSectionButtons" id="PlatformButton" data-Section="Platform"  > Platform</a>
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
                                            <form  >
                                                <input type="hidden" name="UserIDForPlato" id="UserIDForPlato">
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

                                                <button type="button" id="UpdatePlatformButton" class=" mybtn mybtn-primary mybtn-pill-40 " >Update</button>
                                            </form>

                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </main>
                    <main class="MainDashboardSections" id="SettingSection" >
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
                                                    <label for="KryptoArenaID">Krypto Arena ID</label>
                                                    <input class="form-control" id="KryptoArenaID" name="KryptoArenaID" type="text" placeholder="Enter Your KryptoArena ID ">
                                                </div>

                                                <div class="form-group">
                                                    <label for="Bio">Bio</label>
                                                    <textarea class="form-control" rows="5" placeholder="Type your Bio" name="Bio" id="Bio"></textarea>
                                                </div>

                                                <div class="form-group">
                                                    <label for="Country">Country (optional)</label>
                                                    <input class="form-control" id="Country" name="Country" type="text" placeholder="Enter Your Country">
                                                </div>


                                                <div class="form-group">
                                                    <label for="City">City (optional)</label>
                                                    <input class="form-control" id="City" name="City" type="text" placeholder="Enter Your City ">
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
    @vite('resources/js/Front/MyProfile.js')
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

