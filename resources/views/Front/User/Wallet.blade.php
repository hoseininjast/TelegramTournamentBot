@extends('layouts.Front.Master')
@section('content')
    <!-- Breadcrumb Area Start -->
    <section class="breadcrumb-area gamer-profile pt-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <section class="gamer-profile-top">
                        <div class="container">
                            <div class="row">
                                <div class="col-lg-12 text-center">
                                    <div class="gamer-profile-top-inner">
                                        <div class="profile-photo">
                                            <div class="img">
                                                <img id="ProfileImage" src="{{asset('images/Users/DefaultProfile.png')}}" alt="" class="rounded-pill" />
                                            </div>
                                        </div>
                                        <h3 id="ProfileUsername"></h3>
                                    </div>
                                    <p id="ProfileJoinDate"></p>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Area End -->

    <!-- User Main Content Area Start -->
    <section class="user-main-dashboard">
        <div class="container">
            <div class="row">
                <div class="col-xl-12">
                    <main class="MainDashboardSections" id="WalletSection">
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
                                                                            <button class="btn btn-success rounded-pill   TokenButtons" id="TonButton" data-Token="TON">Ton</button>
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




                                                                    <div class="left mt-5" id="PaymentArea" style="display: none">

                                                                        <div class="row">
                                                                            <div class="col-12 mt-2">
                                                                                Order ID : <span id="OrderID"></span>
                                                                            </div>
                                                                            <div class="col-12 mt-2">
                                                                                Payment Method : <span id="PaymentMethod"></span>
                                                                            </div>
                                                                            <div class="col-12 mt-2">
                                                                                Amount : <span id="Amount"></span>
                                                                            </div>
                                                                        </div>

                                                                        <h4 class="title">Deposit Address</h4>
                                                                        <div class="aff-code">
                                                                            <input type="text" id="WalletAddress" value="" onclick="copyContent(this.value)">
                                                                            <i class="fas fa-file" onclick="copyContent($('#WalletAddress').val())"></i>
                                                                        </div>
                                                                        <h4 class="title">Amount</h4>
                                                                        <div class="aff-code">
                                                                            <input type="text" id="DepositAmount" value="" onclick="copyContent(this.value)">
                                                                            <i class="fas fa-file" onclick="copyContent($('#DepositAmount').val())"></i>
                                                                        </div>


                                                                        <div class="mt-3">
                                                                            <a id="PaymentButton" class="btn btn-outline-success rounded-pill btn-block" href="#" target="_blank">Pay</a>
                                                                            <button id="CheckStatusButton" class="btn btn-outline-primary btn-block rounded-pill ">Check Status</button>
                                                                            <button id="CancelButton" class="btn btn-outline-danger btn-block rounded-pill ">Cancel</button>
                                                                        </div>



                                                                        <div class="row" style="margin-bottom: 20px;display:none;" id="ConfirmingHandler">
                                                                            <div class="note bg-success col-sm-12 col-md-12 "><em class="fa fa-check text-dark"></em>
                                                                                <p id="ConfirmingHandler-Text" class="text-warning"></p>
                                                                            </div>
                                                                        </div>
                                                                        <div class="row" style="margin-bottom: 20px;display:none;" id="ErrorHandler">
                                                                            <div class="note note-danger col-sm-12 col-md-12"><em class="fa fa-exclamation-triangle text text-warning"></em>
                                                                                <p id="ErrorHandler-Text">something wet wrong , please try again</p></div>
                                                                        </div>

                                                                        <div class="mt-4 p-3 border border-primary rounded">
                                                                            <span>you must transfer token using Pay button or if you dont see Pay button you must transfer tokens manually using your wallet application</span>

                                                                        </div>



                                                                    </div>

                                                                    <div  id="PaymentSuccessArea" style="display: none">
                                                                        <div class="message-box _success">
                                                                            <i class="fa fa-check-circle" aria-hidden="true"></i>
                                                                            <h3> Your payment was successful </h3>
                                                                            <span> Thank you for your payment. <br>
                                                                                your wallet has been charged. </span>
                                                                        </div>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="notice-area">
                                                            <p><span>IMPORTANT:</span>Send only Selected token to this address, sending any other coin or
                                                                token will result in losing your funds</p>
                                                            <p><span>Notice :</span>you must deposit the fund in the wallet and then send the transaction hash to our support</p>
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
                </div>
            </div>
        </div>
    </section>
    <!-- User Main Content Area End -->
    <div class="forged-fixed-bottom-bar"></div>



@endsection

@section('js')
    @vite('resources/js/Front/Wallet.js')
@endsection

