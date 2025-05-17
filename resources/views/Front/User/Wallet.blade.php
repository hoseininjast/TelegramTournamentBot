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
                                    </div>
                                    <h3 id="ProfileUsername"></h3>
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
                                <div class="row">
                                    <div class="col-6">
                                        <a class="mybtn mybtn-primary mybtn-pill-40" id="pills-wt1-tab" data-toggle="pill" href="#pills-wt1" role="tab" aria-controls="pills-wt1" aria-selected="true">Deposit</a>

                                    </div>
                                    <div class="col-6">
                                        <a class="mybtn mybtn-primary mybtn-pill-20 "  id="pills-wt2-tab" data-toggle="pill" href="#pills-wt2" role="tab" aria-controls="pills-wt2" aria-selected="false">Withdraw</a>

                                    </div>
                                </div>

                                <div class="row ">
                                    <div class="col-12 mt-3">
                                        <a class="mybtn mybtn-primary disabled" disabled="" style="padding: 10px 115px;" id="pills-wt3-tab" data-toggle="pill" href="#pills-wt3" role="tab" aria-controls="pills-wt3" aria-selected="false">Swap</a>

                                    </div>

                                    <div class="col-12 mt-3">
                                        <a class="mybtn mybtn-primary" style="padding: 10px 85px;" id="pills-wt4-tab" data-toggle="pill" href="#pills-wt4" role="tab" aria-controls="pills-wt4" aria-selected="false">Transactions</a>

                                    </div>

                                    <div class="col-12 mt-3">
                                        <a class="mybtn mybtn-primary" style="padding: 10px 105px;" id="pills-wt5-tab" data-toggle="pill" href="#pills-wt5" role="tab" aria-controls="pills-wt5" aria-selected="false">Transfer</a>

                                    </div>
                                </div>





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
                                                                    <div class="row mb-5">
                                                                        <div class="col-6 pt-2 text-center TokenButtons" id="PolygonButton"  data-Token="Polygon" >
                                                                            <img src="{{asset('images/CryptoIcons/matic.png')}}"   />
                                                                            <span class="text-white">Polygon</span>
                                                                        </div>
                                                                        <div class="col-6 pt-2 text-center TokenButtons" id="TonButton"  data-Token="TON" >
                                                                            <img src="{{asset('images/CryptoIcons/ton.png')}}"   />
                                                                            <span class="text-white">TON</span>
                                                                        </div>
                                                                        <div class="col-6 pt-2 text-center TokenButtons" id="USDTPOLButton"  data-Token="USDTPOL" >
                                                                            <img src="{{asset('images/CryptoIcons/USDTPOL.png')}}"   />
                                                                            <span class="text-white">USDT(POL)</span>

                                                                        </div>
                                                                        <div class="col-6 pt-2 text-center TokenButtons" id="USDTTONButton"  data-Token="USDTTON" >
                                                                            <img src="{{asset('images/CryptoIcons/USDTTON.png')}}"   />
                                                                            <span class="text-white">USDT(TON)</span>

                                                                        </div>

                                                                    </div>
                                                                    <div class="AmountDiv" style="display: none">
                                                                        <h6 class="pt-2"> Select Amount</h6>
                                                                        <div class="row">
                                                                            <span>Selected Amount : <span id="SelectedAmount"></span></span>
                                                                        </div>
                                                                        <div class="row pt-2">
                                                                            <div class="col-6">
                                                                                <button class="mybtn mybtn-primary mybtn-pill-40 PriceButton" data-Amount="1">$1</button>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <button class="mybtn mybtn-primary mybtn-pill-40 PriceButton" data-Amount="2">$2</button>
                                                                            </div>
                                                                        </div>


                                                                        <div class="row pt-2">
                                                                            <div class="col-6">
                                                                                <button class="mybtn mybtn-primary mybtn-pill-40 PriceButton" data-Amount="5">$5</button>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <button class="mybtn mybtn-primary mybtn-pill-35 PriceButton" data-Amount="10">$10</button>
                                                                            </div>

                                                                        </div>

                                                                        <div class="row pt-2">
                                                                            <div class="col-6">
                                                                                <button class="mybtn mybtn-primary mybtn-pill-35 PriceButton" data-Amount="20">$20</button>
                                                                            </div>
                                                                            <div class="col-6">
                                                                                <button class="mybtn mybtn-primary mybtn-pill-35 PriceButton" data-Amount="50">$50</button>
                                                                            </div>

                                                                        </div>



                                                                    </div>

                                                                    <div class="pt-4" >
                                                                        <button class="mybtn mybtn-info  InvoiceButton" style="display: none" id="InvoiceButton">Create Invoice</button>
                                                                    </div>





                                                                    <div class="left mt-5" id="PaymentArea" style="display: none">

                                                                        <input type="hidden" id="OrderIdVal">
                                                                        <input type="hidden" id="PaymentIDVal">
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
                                                                            <a id="PaymentButton" class="mybtn mybtn-success mybtn-pill-90 " href="#" target="_blank">Pay</a>
                                                                            <button id="CheckStatusButton" class="mybtn mybtn-primary mybtn-pill-50 mb-3 mt-4">Check Status</button>
                                                                            <button id="CancelButton" class="mybtn mybtn-danger mybtn-pill-80 ">Cancel</button>
                                                                        </div>



                                                                        <div class="row" style="margin-bottom: 20px;display:none;" id="ConfirmingHandler">
                                                                            <div class="note mybg-primary mt-3 col-sm-12 col-md-12 "><em class="fa fa-check text-dark"></em>
                                                                                <p id="ConfirmingHandler-Text" class="text-warning"></p>
                                                                            </div>
                                                                        </div>

                                                                        <div class="row" style="margin-bottom: 20px;display:none;" id="ErrorHandler">
                                                                            <div class="note note-danger col-sm-12 col-md-12"><em class="fa fa-exclamation-triangle text text-warning"></em>
                                                                                <p id="ErrorHandler-Text">something wet wrong , please try again</p></div>
                                                                        </div>

                                                                        <div class="mt-4 p-3">
                                                                            <span>you must transfer token using Pay button or if you dont see Pay button you must transfer tokens manually using your wallet application</span>

                                                                        </div>

                                                                        <div class="notice-area">
                                                                            <p><span>IMPORTANT:</span>Send only Selected token to this address, sending any other coin or
                                                                                token will result in losing your funds</p>
                                                                            <p><span>Notice :</span>you must deposit the fund in the wallet and then send the transaction hash to our support</p>
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
                                                            <span id="CurrentKATBalance">0</span> <span>KAT</span>
                                                        </h4>
                                                        <span class="t-sm">
															1 KAT = 1 USDT
														</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8">
                                                    <div class="dipo_btc">
                                                        <div class="header-area">
                                                            <h4>Withdraw KAT</h4>
                                                            <p>
                                                                you can change your payout address from your profile -> settings section
                                                            </p>
                                                        </div>
                                                        <div class="form-area">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <form action="#">

                                                                        <div class="form-group">
                                                                            <div class="WithdrawAmountLabelDiv pb-3">
                                                                                <label for="">Amount</label>
                                                                                <button type="button" id="MaxWithdrawButton" class="mybtn mybtn-primary mybtn-pill-30">Max</button>
                                                                            </div>

                                                                            <input type="text" id="WithdrawAmount" name="WithdrawAmount" class="input-field" placeholder="Amount">
                                                                        </div>

                                                                        <div class="form-group">
                                                                            <label for="">Payment Address</label>
                                                                            <input type="text" id="PayingAddress" name="PayingAddress"  class="input-field" placeholder="Paying Address" readonly>
                                                                        </div>

                                                                        <button type="button" id="SubmitButton" class="mybtn mybtn-success">Submit</button>

                                                                    </form>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="notice-area">
                                                            <p><span>Transaction fee:</span> Your withdrawal will also have 1 USD subtracted to cover the transaction fee.</p>
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
                                            <div class="aff-table">
                                                <div class="header-area">
                                                    <h4>Transaction History</h4>
                                                </div>
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                        <tr>
                                                            <th>#</th>
                                                            <th>Date</th>
                                                            <th>Amount</th>
                                                            <th>Type</th>
                                                            <th>Currency</th>
                                                            <th>Description</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="TransactionTable">


                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>


                                        </div>
                                    </div>


                                    <div class="tab-pane fade" id="pills-wt5" role="tabpanel" aria-labelledby="pills-wt5-tab">
                                        <div class="dipo-box">
                                            <div class="row">
                                                <div class="col-lg-4">
                                                    <div class="current-balance">
                                                        <p>Current Balance</p>
                                                        <h4>
                                                            <span id="CurrentKACBalance">0</span> <span>KAC</span>
                                                        </h4>
                                                        <span class="t-sm">
															1000 KAC = 1 USDT
														</span>
                                                    </div>
                                                </div>
                                                <div class="col-lg-8">
                                                    <div class="dipo_btc">
                                                        <div class="header-area">
                                                            <h4>Transfer KAC</h4>
                                                            <p>
                                                                you need to enter amount and Telegram UserName for internal transfer .
                                                            </p>
                                                        </div>
                                                        <div class="form-area">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <form action="#">

                                                                        <div class="form-group">
                                                                            <label for="">Receiver UserName</label>
                                                                            <div class="input-group mb-3">
                                                                                <input type="text" class="form-control" id="ReceiverUserName" name="ReceiverUserName" placeholder="Receiver UserName" aria-label="Receiver UserName" aria-describedby="SearchUserForTransfer">
                                                                                <button class="btn btn-outline-primary text-white" type="button" id="SearchUserForTransfer"><i class="fa fa-search"></i> Search</button>
                                                                            </div>
                                                                        </div>

                                                                        <div id="TransferStep2" style="display: none">




                                                                            <div class="d-flex flex-column justify-content-center text-center ">
                                                                                <input type="hidden" id="ReceiverUserID">
                                                                                <input type="hidden" id="ReceiverUserUserNameVal">
                                                                                <div class="col-12">
                                                                                    <img src="" alt="User Image" id="ReceiverUserImage" class="rounded-pill" />
                                                                                </div>
                                                                                <div class="col-12 mt-3">
                                                                                    <h4 id="ReceiverUserUserName"></h4>
                                                                                </div>
                                                                            </div>




                                                                            <hr style="border: 1px solid white;" class="mt-5">
                                                                            <div class="form-group mt-5">

                                                                                <label for="">Amount</label>
                                                                                <input type="text" id="TransferAmount" name="TransferAmount" class="input-field" placeholder="Amount" min="2000">

                                                                                <span class="d-block mt-3">  Fee : <span id="TransferFee">0</span> KAC </span>
                                                                                <span class="d-block"> Total : <span id="TotalAmount">0</span> KAC </span>
                                                                            </div>



                                                                            <button type="button" id="SubmitTransferButton" class="mybtn mybtn-success">Transfer</button>





                                                                        </div>

                                                                    </form>

                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="notice-area">
                                                            <p><span>Transfer fee:</span> Your Transfer will also have 10% Fee for covering the transaction fee.</p>
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

