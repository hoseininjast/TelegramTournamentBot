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
                                <a class="nav-link btn btn-outline-warning rounded-pill   ProfileSectionButtons" id="StatusPending" data-Status="Pending"  ><i class="fas fa-code-branch"></i> Affiliate</a>
                            </div>
                            <div class="col-4">
                                <a class="nav-link btn btn-outline-success rounded-pill  ProfileSectionButtons" id="StatusRunning" data-Status="Running"  > <i class="fas fa-wallet"></i> Wallet</a>
                            </div>
                            <div class="col-4">
                                <a class="nav-link btn btn-outline-danger rounded-pill  ProfileSectionButtons" id="StatusFinished" data-Status="Finished"  > <i class="fas  fa-cog"></i> Setting</a>
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
                    <main>
                        <div class="main-box wallet-box">
                            <div class="header-area">
                                <h4>Wallet</h4>
                            </div>
                            <div class="wallet-tab-menu">
                                <ul class="nav" id="pills-tab" role="tablist">
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link active" id="pills-wt1-tab" data-toggle="pill" href="#pills-wt1" role="tab" aria-controls="pills-wt1" aria-selected="true">Deposit</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="pills-wt2-tab" data-toggle="pill" href="#pills-wt2" role="tab" aria-controls="pills-wt2" aria-selected="false">Withdraw</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="pills-wt3-tab" data-toggle="pill" href="#pills-wt3" role="tab" aria-controls="pills-wt3" aria-selected="false">Buy Crypto</a>
                                    </li>
                                    <li class="nav-item" role="presentation">
                                        <a class="nav-link" id="pills-wt4-tab" data-toggle="pill" href="#pills-wt4" role="tab" aria-controls="pills-wt4" aria-selected="false">Transactions</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="wallet-tab-content"  id="pills-tabContent">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="pills-wt1" role="tabpanel" aria-labelledby="pills-wt1-tab">
                                        <div class="dipo-box">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="current-balance">
                                                        <p>Current Balance</p>
                                                        <h4>
                                                            0.00051 <span>BTC</span>
                                                        </h4>
                                                        <span class="t-sm">
															1BTC = 39746.90 USD
														</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8">
                                                    <div class="dipo_btc">
                                                        <div class="header-area">
                                                            <h4>Deposit BTC</h4>
                                                            <p>
                                                                You may switch to other currencies in the top right corner.
                                                            </p>
                                                        </div>
                                                        <div class="referral-link-area">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <div class="left">
                                                                        <h4 class="title"BTC Deposit Address</h4>
                                                                        <div class="aff-code">
                                                                            <input type="text" value="bc1quxahsy9s7h99q5q4xykmmmh">
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
                                    <div class="tab-pane fade" id="pills-wt2" role="tabpanel" aria-labelledby="pills-wt2-tab">
                                        <div class="dipo-box">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="current-balance">
                                                        <p>Current Balance</p>
                                                        <h4>
                                                            0.00051 <span>BTC</span>
                                                        </h4>
                                                        <span class="t-sm">
															1BTC = 39746.90 USD
														</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8">
                                                    <div class="dipo_btc">
                                                        <div class="header-area">
                                                            <h4>Withdraw BITCOIN</h4>
                                                            <p>
                                                                You may switch to other currencies in the top right corner.
                                                            </p>
                                                        </div>
                                                        <div class="form-area">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <form action="#">
                                                                        <div class="form-group">
                                                                            <label for="">Amount</label>
                                                                            <input type="text" class="input-field" placeholder="Amount">
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <label for="">Payment Address</label>
                                                                            <input type="text"  class="input-field" placeholder="Payment Address">
                                                                        </div>
                                                                        <button type="submit" class="mybtn2">Submit</button>
                                                                    </form>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="notice-area">
                                                            <p><span>Transaction fee:</span> Your withdrawal will also have 0.0006 BTC  subtracted to cover the transaction fee.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-wt3" role="tabpanel" aria-labelledby="pills-wt3-tab">
                                        <div class="dipo-box">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="current-balance">
                                                        <p>Current Balance</p>
                                                        <h4>
                                                            0.00051 <span>BTC</span>
                                                        </h4>
                                                        <span class="t-sm">
															1BTC = 39746.90 USD
														</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8">
                                                    <div class="dipo_btc">
                                                        <div class="header-area">
                                                            <h4>Buy cryptocurrency directly to your Jugaro account</h4>
                                                            <p>
                                                                Once payment is completed, your cryptocurrency will be available in your Jugaro
                                                                a																unt within minutes
                                                            </p>
                                                        </div>
                                                        <div class="crypto-info">
                                                            <h5>1. Choose the crypto you wish to buy, enter the amount, and choose your
                                                                favorite payment method.</h5>
                                                            <div class="row">
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="">Buy</label>
                                                                        <select name="" id="" class="input-field" placeholder="Amount">
                                                                            <option value="">BTC</option>
                                                                            <option value="">CTO</option>
                                                                            <option value="">YOK</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-6">
                                                                    <div class="form-group">
                                                                        <label for="">Payment Methods</label>
                                                                        <select name="" id="" class="input-field" placeholder="Amount">
                                                                            <option value="">VISA</option>
                                                                            <option value="">MASTER</option>
                                                                            <option value="">DABIT</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="col-lg-12">
                                                                    <div class="form-group-2">
                                                                        <label for="">Amount</label>
                                                                        <div class="select-payment-area">
                                                                            <input type="text" value="434">
                                                                            <select name="" id="">
                                                                                <option value="">BTC</option>
                                                                                <option value="">CTO</option>
                                                                                <option value="">YOK</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <h5 class="mt-5">2. Choose the best offer from our payment partners, and complete
                                                                your purchase.</h5>
                                                            <div class="table-responsive">
                                                                <table class="table">
                                                                    <thead>
                                                                    <tr>
                                                                        <th>Channels</th>
                                                                        <th>Arrival Time</th>
                                                                        <th>You will get</th>
                                                                        <th>Rate ( Fee Included)</th>
                                                                        <th>Trade</th>
                                                                    </tr>
                                                                    </thead>
                                                                    <tbody>
                                                                    <tr>
                                                                        <td>
                                                                            <img src="assets/images/chanel-logo.png" alt="">
                                                                        </td>
                                                                        <td>5-15 mins</td>
                                                                        <td>0.003091 BTC</td>
                                                                        <td>39254.59 USD</td>
                                                                        <td><a href="#" class="mybtn2">BUY</a></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <img src="assets/images/chanel-logo.png" alt="">
                                                                        </td>
                                                                        <td>5-15 mins</td>
                                                                        <td>0.003091 BTC</td>
                                                                        <td>39254.59 USD</td>
                                                                        <td><a href="#" class="mybtn2">BUY</a></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <img src="assets/images/chanel-logo.png" alt="">
                                                                        </td>
                                                                        <td>5-15 mins</td>
                                                                        <td>0.003091 BTC</td>
                                                                        <td>39254.59 USD</td>
                                                                        <td><a href="#" class="mybtn2">BUY</a></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <img src="assets/images/chanel-logo.png" alt="">
                                                                        </td>
                                                                        <td>5-15 mins</td>
                                                                        <td>0.003091 BTC</td>
                                                                        <td>39254.59 USD</td>
                                                                        <td><a href="#" class="mybtn2">BUY</a></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <img src="assets/images/chanel-logo.png" alt="">
                                                                        </td>
                                                                        <td>5-15 mins</td>
                                                                        <td>0.003091 BTC</td>
                                                                        <td>39254.59 USD</td>
                                                                        <td><a href="#" class="mybtn2">BUY</a></td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>
                                                                            <img src="assets/images/chanel-logo.png" alt="">
                                                                        </td>
                                                                        <td>5-15 mins</td>
                                                                        <td>0.003091 BTC</td>
                                                                        <td>39254.59 USD</td>
                                                                        <td><a href="#" class="mybtn2">BUY</a></td>
                                                                    </tr>
                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="tab-pane fade" id="pills-wt4" role="tabpanel" aria-labelledby="pills-wt4-tab">
                                        <div class="trns-box">
                                            <div class="trns-table-filter">
                                                <div class="row">
                                                    <div class="col-md-3">
                                                        <div class="single-filter">
                                                            <label for="">Month</label>
                                                            <input type="month" class="input-field" name="" id="">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="single-filter">
                                                            <label for="">Type</label>
                                                            <select name="" id="" class="input-field">
                                                                <option value="">All</option>
                                                                <option value="">Type 1</option>
                                                                <option value="">Type 2</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="single-filter">
                                                            <label for="">Currency</label>
                                                            <select name="" id="" class="input-field">
                                                                <option value="">BTC</option>
                                                                <option value="">BDT</option>
                                                                <option value="">USD</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <div class="filter-wrapper">
                                                            <a href="#" class="mybtn2">Filter</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th>Date/Time</th>
                                                        <th>Type</th>
                                                        <th>Currency</th>
                                                        <th>Amount</th>
                                                        <th>Balance before</th>
                                                        <th>Balance after</th>
                                                        <th>Game</th>
                                                        <th>Game ID</th>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    <tr>
                                                        <td>2021-01-07 16:33:53</td>
                                                        <td>Deposit</td>
                                                        <td>BTC</td>
                                                        <td>0.000005210</td>
                                                        <td>0.000000000</td>
                                                        <td>0.000005210</td>
                                                        <td>--</td>
                                                        <td>--</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2021-01-07 16:33:53</td>
                                                        <td>Deposit</td>
                                                        <td>BTC</td>
                                                        <td>0.000005210</td>
                                                        <td>0.000000000</td>
                                                        <td>0.000005210</td>
                                                        <td>--</td>
                                                        <td>--</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2021-01-07 16:33:53</td>
                                                        <td>Deposit</td>
                                                        <td>BTC</td>
                                                        <td>0.000005210</td>
                                                        <td>0.000000000</td>
                                                        <td>0.000005210</td>
                                                        <td>--</td>
                                                        <td>--</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2021-01-07 16:33:53</td>
                                                        <td>Deposit</td>
                                                        <td>BTC</td>
                                                        <td>0.000005210</td>
                                                        <td>0.000000000</td>
                                                        <td>0.000005210</td>
                                                        <td>--</td>
                                                        <td>--</td>
                                                    </tr>
                                                    <tr>
                                                        <td>2021-01-07 16:33:53</td>
                                                        <td>Deposit</td>
                                                        <td>BTC</td>
                                                        <td>0.000005210</td>
                                                        <td>0.000000000</td>
                                                        <td>0.000005210</td>
                                                        <td>--</td>
                                                        <td>--</td>
                                                    </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </main>
                    <main>
                        <div class="main-box u-setting-area">
                            <div class="header-area">
                                <h4>Setting</h4>
                            </div>
                            <div class="row justify-content-center">
                                <div class="col-md-9">
                                    <div class="single-user-setting">
                                        <div class="s-title-area">
                                            <h4>Personal Details</h4>
                                            <a href="#"> <i class="fas fa-edit"></i> Edit</a>
                                        </div>
                                        <div class="s-content-area">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tr>
                                                        <td>Name <span>:</span></td>
                                                        <td>Tim Wilkins</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Date of Birth <span>:</span></td>
                                                        <td>15-03-1974</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Address <span>:</span></td>
                                                        <td>8198 Fieldstone Dr.La Crosse, WI 54601</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single-user-setting">
                                        <div class="s-title-area">
                                            <h4>Account Settings</h4>
                                            <a href="#"> <i class="fas fa-edit"></i> Edit</a>
                                        </div>
                                        <div class="s-content-area">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tr>
                                                        <td>Language <span>:</span></td>
                                                        <td>English (United States)</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Time Zone <span>:</span></td>
                                                        <td>(GMT-06:00) Central America</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Status <span>:</span></td>
                                                        <td>Active</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single-user-setting">
                                        <div class="s-title-area">
                                            <h4>Email Addresses</h4>
                                            <a href="#"> <i class="fas fa-edit"></i> Edit</a>
                                        </div>
                                        <div class="s-content-area">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tr>
                                                        <td>Email <span>:</span></td>
                                                        <td><a href="https://pixner.net/cdn-cgi/l/email-protection" class="__cf_email__" data-cfemail="5c3d303e392e286f68651c3b313d3530723f3331">[email&#160;protected]</a></td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single-user-setting">
                                        <div class="s-title-area">
                                            <h4>Phone</h4>
                                            <a href="#"> <i class="fas fa-edit"></i> Edit</a>
                                        </div>
                                        <div class="s-content-area">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tr>
                                                        <td>Mobile <span>:</span></td>
                                                        <td>+1 234-567-8925</td>
                                                    </tr>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="single-user-setting">
                                        <div class="s-title-area">
                                            <h4>Security</h4>
                                            <a href="#"> <i class="fas fa-edit"></i> Edit</a>
                                        </div>
                                        <div class="s-content-area">
                                            <div class="table-responsive">
                                                <table class="table">
                                                    <tr>
                                                        <td>Password <span>:</span></td>
                                                        <td>********</td>
                                                    </tr>
                                                </table>
                                            </div>
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

