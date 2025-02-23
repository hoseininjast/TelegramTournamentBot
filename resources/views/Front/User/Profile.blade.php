@extends('layouts.Front.Master')

@section('content')
    <!-- Breadcrumb Area Start -->
    <section class="breadcrumb-area gamer-profile">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="bc-content">
                        <div class="left">
                            <h3 id="ProfileUsername"></h3>
                            <p id="ProfileJoinDate"></p>
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
                                        <img src="{{asset('Front/images/prize/1.png')}}" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="{{asset('Front/images/prize/2.png')}}" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="{{asset('Front/images/prize/3.png')}}" alt="">
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
                        <div class="profile-photo">
                            <div class="img">
                                <img id="ProfileImage" src="{{asset('images/Users/DefaultProfile.png')}}" alt="" class="rounded-pill" />
                            </div>
                            <div class="mybadge">
                                <img src="{{asset('Front/images/gamer/badge.png')}}" alt="">
                            </div>
                        </div>
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
                                <a class="nav-link btn btn-outline-warning rounded-pill   ProfileSectionButtons" id="AffiliateButton" data-Section="Affiliate"  ><i class="fas fa-code-branch"></i> Affiliate</a>
                            </div>
                            <div class="col-4">
                                <a class="nav-link btn btn-outline-success rounded-pill  ProfileSectionButtons" id="WalletButton" data-Section="Wallet"  > <i class="fas fa-wallet"></i> Wallet</a>
                            </div>
                            <div class="col-4">
                                <a class="nav-link btn btn-outline-danger rounded-pill  ProfileSectionButtons" id="SettingButton" data-Section="Setting"  > <i class="fas  fa-cog"></i> Setting</a>
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
                    <main class="MainDashboardSections" id="WalletSection" style="display: none">
                        <div class="main-box wallet-box">
                            <div class="header-area">
                                <h4>Wallet</h4>
                            </div>
                            <div class="wallet-tab-menu">
                                <ul class="nav" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="pills-wt1-tab" data-toggle="pill" href="#pills-wt1" role="tab" aria-controls="pills-wt1" aria-selected="true">Deposit</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="wallet-tab-content"  id="pills-tabContent">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="pills-wt1" role="tabpanel" aria-labelledby="pills-wt1-tab">
                                        <div class="dipo-box">
                                            <div class="row">
                                                <div class="col-lg-8">
                                                    <div class="dipo_btc">
                                                        <div class="header-area">
                                                            <h4>Deposit </h4>
                                                        </div>
                                                        <div class="referral-link-area">
                                                            <div class="row">
                                                                <div class="col-md-12">

                                                                    <h6> Select Token</h6>
                                                                    <div class="row">
                                                                        <div class="col-6 pt-2">
                                                                            <button class="btn btn-success rounded-pill   TokenButtons" id="PolygonButton" data-Token="Polygon">Polygon</button>
                                                                        </div>
                                                                        <div class="col-6 pt-2">
                                                                            <button class="btn btn-success rounded-pill   TokenButtons" id="TonButton" data-Token="Ton">Ton</button>
                                                                        </div>
                                                                        <div class="col-6 pt-2">
                                                                            <button class="btn btn-success rounded-pill   TokenButtons" id="USDTPOLButton" data-Token="USDTPOL">USDT(POL)</button>
                                                                        </div>
                                                                        <div class="col-6 pt-2">
                                                                            <button class="btn btn-success rounded-pill   TokenButtons" id="USDTTONButton" data-Token="USDTTON">USDT(TON)</button>
                                                                        </div>

                                                                    </div>
                                                                    <h6 class="pt-2"> Select Amount</h6>
                                                                    <div class="row pt-2">
                                                                        <div class="col-4">
                                                                            <button class="btn btn-primary rounded-pill PriceButton" data-Amount="1">$1</button>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <button class="btn btn-primary rounded-pill PriceButton" data-Amount="2">$2</button>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <button class="btn btn-primary rounded-pill PriceButton" data-Amount="5">$5</button>
                                                                        </div>
                                                                    </div>

                                                                    <div class="row pt-2">
                                                                        <div class="col-4">
                                                                            <button class="btn btn-primary rounded-pill PriceButton" data-Amount="10">$10</button>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <button class="btn btn-primary rounded-pill PriceButton" data-Amount="20">$20</button>
                                                                        </div>
                                                                        <div class="col-4">
                                                                            <button class="btn btn-primary rounded-pill PriceButton" data-Amount="50">$50</button>
                                                                        </div>

                                                                    </div>

                                                                    <div class="row pt-2">
                                                                        <div class="col-12">
                                                                            <button class="btn btn-primary btn-block rounded-pill PriceButton" data-Amount="100">$100</button>
                                                                        </div>
                                                                    </div>

                                                                    <div class="pt-4">
                                                                        <button class="btn btn-info btn-block rounded-pill  InvoiceButton" id="InvoiceButton">Create Invoice</button>
                                                                    </div>




                                                                    <div class="left" id="PaymentArea" style="display: none">
                                                                        <h4 class="title">Deposit Address</h4>
                                                                        <div class="aff-code">
                                                                            <input type="text" id="WalletAddress" value="bc1quxahsy9s7h99q5q4xykmmmh">
                                                                            <i class="fas fa-file"></i>
                                                                        </div>
                                                                        <div class="aff-code-bottom">
                                                                            <a href="#">Show QR Code</a>
                                                                            <a href="#">Copy Address</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="notice-area">
                                                            <p><span>IMPORTANT:</span>Send only BTC to this address, sending any other coin or
                                                                token will result in losing your funds</p>
                                                            <p><span>Notice :</span>Your deposit will be credited after 1 confirmation on the BTC
                                                                blockchain network.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
                                                    <label for="PlatoID"> Plato ID</label>
                                                    <input class="form-control" id="PlatoID" name="PlatoID" type="text" placeholder="Enter Your Plato ID">
                                                </div>
                                                <div class="form-group">
                                                    <label for="Image">Image</label>
                                                    <input type="file" accept="image/*"  class="form-control" id="Image" name="Image">
                                                </div>
                                                <button type="submit" class="btn btn-success rounded-pill">Update</button>
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

