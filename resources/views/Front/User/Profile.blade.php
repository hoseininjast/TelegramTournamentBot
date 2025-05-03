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
                                                        <img id="ProfileImage" style="clip-path: circle(30%);" src="{{asset('images/Users/DefaultProfile.png')}}" alt="" class="rounded-pill" />
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
                <div class="col-xl-12">
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
                                        <h4 id="ReferralIncome">$0</h4>
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
                                            <form action="#" enctype="multipart/form-data" method="post">
                                                @csrf
                                                <input type="hidden" name="UserID" id="UserID">
                                                <div class="form-group">
                                                    <label for="PlatoID"> Plato ID</label>
                                                    <input class="form-control" id="PlatoID" name="PlatoID" type="text" placeholder="Enter Your Plato ID">
                                                </div>

                                                <div class="form-group">
                                                    <label for="WalletAddress">Counter Account</label>
                                                    <input class="form-control" id="CounterAccount" name="CounterAccount" type="text" placeholder="Enter Your Polygon Wallet Address">
                                                </div>

                                                <div class="form-group">
                                                    <label for="WalletAddress">Activision Account</label>
                                                    <input class="form-control" id="ActivisionAccount" name="ActivisionAccount" type="text" placeholder="Enter Your Polygon Wallet Address">
                                                </div>

                                                <div class="form-group">
                                                    <label for="WalletAddress">Supercell ID</label>
                                                    <input class="form-control" id="SupercellID" name="SupercellID" type="text" placeholder="Enter Your Polygon Wallet Address">
                                                </div>

                                                <button type="submit" class=" mybtn mybtn-primary mybtn-pill-40 " id="UpdateProfileButton">Update</button>
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
                                            <form action="{{route('Front.Profile.Update')}}" enctype="multipart/form-data" method="post">
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
                                                    <label for="Image">Image</label>
                                                    <input type="file" accept="image/*"  class="form-control" id="Image" name="Image">
                                                </div>
                                                <button type="submit" class=" mybtn mybtn-primary mybtn-pill-40 " id="UpdateProfileButton">Update</button>
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
    <!-- User Main Content Area End -->
    <div class="forged-fixed-bottom-bar"></div>



@endsection

@section('js')
    @vite('resources/js/Front/Profile.js')
@endsection

