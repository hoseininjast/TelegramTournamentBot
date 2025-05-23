import {
    ShowToast,
    deleteSession,
    setSession,
    ReadSession, redirect, ShowAlert,
} from "../utilities.js";
import moment from "moment/moment.js";

import {init, initData, isTMA} from "@telegram-apps/sdk";
import { restClient } from "coinmarketcap-js";



const InvoiceButton = document.querySelector("#InvoiceButton");
const CheckStatusButton = document.querySelector("#CheckStatusButton");
const CancelButton = document.querySelector("#CancelButton");

const PolygonButton = document.querySelector("#PolygonButton");
const TonButton = document.querySelector("#TonButton");
const USDTPOLButton = document.querySelector("#USDTPOLButton");
const USDTTONButton = document.querySelector("#USDTTONButton");
const TokenButtons = document.querySelectorAll(".TokenButtons");


const PriceButtons = document.querySelectorAll(".PriceButton");


const SubmitButton = document.querySelector("#SubmitButton");
const MaxWithdrawButton = document.querySelector("#MaxWithdrawButton");


const SearchUserForTransfer = document.querySelector("#SearchUserForTransfer");
const SubmitTransferButton = document.querySelector("#SubmitTransferButton");
const TransferAmountInput = document.querySelector("#TransferAmount");



const SwapAmount = document.querySelector("#SwapAmount");
const SubmitSwapButton = document.querySelector("#SubmitSwapButton");



let Token = 'Polygon';
let Amount = 1;
let PaymentID = null;

const PolygonAddress = '0xBa0B19631E0233e1E4Ee16c16c03519FAFfE3E7b';
const TonAddress = 'UQCdkjHiAApGpT63O_6A1dttQ6B2o9FliiPuQoFnZJWyevmT';
const USDTPOLAddress = '0xBa0B19631E0233e1E4Ee16c16c03519FAFfE3E7b';
const USDTTONAddress = 'UQCdkjHiAApGpT63O_6A1dttQ6B2o9FliiPuQoFnZJWyevmT';




let TelegramUser;
let User;

function GetUser(UserID){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        async: false,
        cache: false,
    });

    $.ajax({
        url: route('V1.User.Find' , UserID),
        success: function (response) {
            User = response.Data.User;
        }
    });

}




function ChangeSections(Section) {
    $('.ProfileSectionButtons').removeClass('active');
    $('#' + Section + 'Button').addClass('active');

    $('.MainDashboardSections').hide(400);
    $('#' + Section + 'Section').show(400);


    $('html, body').animate({
        scrollTop: $('#' + Section + 'Section').offset().top
    }, 400);

}


async function CreateInvoice() {
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        async: false,
        cache: false,
    });

    $.ajax({
        url: route('V1.Payment.Create'),
        data: {
            PaymentMethod : Token,
            Price : Amount,
            UserID : User.id,
        },
        success: function (response) {
            if (response.Code == 200 ) {
                setSession('payment_id' , response.PaymentID)
                setSession('pay_address' , response.Data.pay_address)
                setSession('pay_amount' , response.Data.pay_amount)
                setSession('payment_status' , 'Pending')
                setSession('selected_plan' , response.Data.selected_plan)

                $('#OrderIdVal').val(response.Data.order_id)
                $('#PaymentIDVal').val(response.PaymentID)
                PaymentID = response.PaymentID;

                $('#DepositAmount').val(response.Data.pay_amount)
                $('#WalletAddress').val(response.Data.pay_address)
                $('#PaymentMethod').text(Token)
                $('#Amount').text(Amount)
                $('#OrderID').text(response.Data.order_id)

                if(Token == 'Polygon'){
                    var PaymentAddress = "https://metamask.app.link/send/"+response.Data.pay_address+"@137?value=" + response.Data.pay_amount +"e18";
                    $('#PaymentButton').attr('href' , PaymentAddress).show(400);
                }else if(Token == 'USDTPOL'){
                    var PaymentAmountUSDT = parseFloat(response.Data.pay_amount).toFixed(6);
                    var PaymentAddress = "https://metamask.app.link/send/0xc2132D05D31c914a87C6611C10748AEb04B58e8F@137/transfer?address="+ response.Data.pay_address +"&uint256=" + PaymentAmountUSDT;
                    $('#PaymentButton').attr('href' , PaymentAddress).show(400);
                }else if(Token == 'TON'){
                    var PaymentAddress = "https://app.tonkeeper.com/transfer/"+ response.Data.pay_address +"?amount=" + response.Data.pay_amount;
                    $('#PaymentButton').attr('href' , PaymentAddress).show(400);
                }else{
                    $('#PaymentButton').hide(400).attr('href' , "#");
                }




            }else{
                Swal.fire({
                    icon: "warning",
                    title: "Payment gateway problem",
                    text: response.message,
                });

            }

        }
    });






    $('#PaymentArea').show(400)

    $('html, body').animate({
        scrollTop: $('#PaymentArea').offset().top
    }, 1000);
}


function CheckPayment(){


    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        async: false,
        cache: false,
    });
    $.ajax({
        url: route('V1.Payment.Check' ),
        data: {
            PaymentID: $('#PaymentIDVal').val(),
        },
        success: function (response) {


            if (response.Code == 4) {
                ShowToast('success' , 'Payment paid successfully')
                deleteSession('payment_id')
                deleteSession('pay_address')
                deleteSession('pay_amount')
                deleteSession('payment_status')
                deleteSession('selected_plan')
                $('#PaymentArea').hide(400)
                $('#PaymentSuccessArea').show(400)


            }

            else if(response.Code == 5){

                $('#ErrorHandler').text(response.Message).show(400)
                deleteSession('payment_id')
                deleteSession('pay_address')
                deleteSession('pay_amount')
                deleteSession('payment_status')
                ShowToast('error' , response.Message)
            }

            else if(response.Code == 3){
                $('#ErrorHandler').show(400)
                deleteSession('payment_id')
                deleteSession('pay_address')
                deleteSession('pay_amount')
                deleteSession('payment_status')
                ShowToast('error' , response.Message)
            }
            else{
                $('#ConfirmingHandler').show(400)
                $('#ConfirmingHandler-Text').text(response.Message)
                ShowToast('success' , response.Message)
            }

        }
    });

}



function CancelPayment() {
    setSession('payment_status' , 'NoPending')
    deleteSession('payment_id')
    deleteSession('pay_address')
    deleteSession('pay_amount')
    deleteSession('payment_status')
    $('#PaymentArea').hide(400)

}


InvoiceButton.addEventListener("click", () =>
    CreateInvoice()
);


CancelButton.addEventListener("click", () =>
    CancelPayment()
);


CheckStatusButton.addEventListener("click", () =>
    CheckPayment()
);

MaxWithdrawButton.addEventListener("click", () =>
    $('#WithdrawAmount').val(User.KAT)
);
SubmitButton.addEventListener("click", () =>
    MakeWithdraw()
);
SubmitTransferButton.addEventListener("click", () =>
    MakeTransfer()
);
SubmitSwapButton.addEventListener("click", () =>
    MakeSwap()
);

function CalculateFeeAndTotal(){
    var Amount = $('#TransferAmount').val();
    if(Amount == 0 || Amount == null){
        $('#TransferFee').text(0).removeClass('text-danger').addClass('text-success')
        $('#TotalAmount').text(0).removeClass('text-danger').addClass('text-success')
    }else{
        var Amount = parseInt(Amount)




        if(Amount > (User.Charge * 1000 )){
            ShowAlert('error' , 'You do not have enough KAC to transfer.');
            var Fee =  ( (Amount / 100) * 10 );
            var Total = Amount + Fee ;

            $('#TransferFee').text(Fee).addClass('text-danger').removeClass('text-success')
            $('#TotalAmount').text(Total).addClass('text-danger').removeClass('text-success')
        }else{
            var Fee =  ( (Amount / 100) * 10 );
            var Total = Amount + Fee ;

            $('#TransferFee').text(Fee).removeClass('text-danger').addClass('text-success')
            $('#TotalAmount').text(Total).removeClass('text-danger').addClass('text-success')
        }

    }





}



TransferAmountInput.addEventListener("keyup", (element) =>
    CalculateFeeAndTotal()
);

SwapAmount.addEventListener("keyup", (element) =>
    CalculateFeeAndTotalForSwap()
);

SearchUserForTransfer.addEventListener("click", () =>
    SearchUserForTransfering()
);

TokenButtons.forEach((plan) => plan.addEventListener('click', (event) => {
    Token = plan.getAttribute('data-Token');
    $('.TokenButtons').removeClass('TokenButtonSelected')
    $('#' + plan.id).addClass('TokenButtonSelected')
    $('.AmountDiv').show(400)
    $('html, body').animate({
        scrollTop: $('.AmountDiv').offset().top
    }, 1000);

}));



PriceButtons.forEach((plan) => plan.addEventListener('click', (event) => {
    DepositAmountSelected(plan)
}));

function DepositAmountSelected(element){
    Amount = element.getAttribute('data-Amount');
    $('.PriceButton').removeClass('mybtn-success')
    $(element.id).addClass('TokenButtonSelected')
    $('#SelectedAmount').text('$' + Amount);
    $('#InvoiceButton').show(400)

}


function LoadTransactionTable(){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        async: false,
        cache: false,
    });
    $.ajax({
        url: route('V1.PaymentHistory.List' ),
        data: {
            UserID: User.id,
        },
        success: function (response) {

            $('#TransactionTable').empty()
            var key = 0;
            $(response.Data.History).each(async function (index, History) {
                let HistoryDate = moment(History.created_at).format("YY/M/D HH:mm");
                key = index + 1;
                if(History.TransactionHash != null){
                    var row = `<tr>
                                                            <td>`+key +`</td>
                                                            <td>`+ History.Description + ` : <a href="`+History.TransactionHash + `" target="_blank">PolygonScan</a> </td>
                                                            <td>$`+History.Amount+`</td>
                                                            <td>`+ History.Type +`</td>
                                                            <td>`+ History.Currency +`</td>
                                                            <td>`+HistoryDate+`</td>
                                                        </tr>`;
                }else{
                    var row = `<tr>
                                                            <td>`+key +`</td>
                                                            <td>`+ History.Description+`</td>
                                                            <td>$`+History.Amount+`</td>
                                                            <td>`+ History.Type +`</td>
                                                            <td>`+ History.Currency +`</td>
                                                            <td>`+ HistoryDate+`</td>
                                                        </tr>`;
                }

                $('#TransactionTable').append(row);
            });


        }
    });
}

function LoadWithdrawSection(){

    $('#CurrentKATBalance').text(User.KAT);
    $('#SwapKATBalance').text(User.KAT);
    $('#SwapKACBalance').text(User.Charge * 1000);
    $('#PayingAddress').val(User.WalletAddress);

}

function SearchUserForTransfering(){

    var ReceiverUserName = $('#ReceiverUserName').val();

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        async: false,
        cache: false,
    });

    $.ajax({
        url: route('V1.User.Search' ),
        data: {
          UserName:   ReceiverUserName
        },
        success: function (response) {
            if(response.Data.Code == 1){
                var ReceiverUser = response.Data.User;
                $('#ReceiverUserID').val(ReceiverUser.id)
                $('#ReceiverUserImage').attr('src', ReceiverUser.Image);
                $('#ReceiverUserUserName').text(ReceiverUser.UserName)
                $('#ReceiverUserUserNameVal').val(ReceiverUser.UserName)

                $('#TransferStep2').show(400);

            }else{
                ShowAlert('error' , response.Data.Message);
                $('#ReceiverUserID').empty()
                $('#ReceiverUserUserNameVal').empty()
                $('#ReceiverUserImage').attr('src', 'https://kryptoarena.fun/images/Users/DefaultProfile.png');
                $('#ReceiverUserUserName').empty()
                $('#TransferStep2').hide(400);
            }
        }
    });

}

function MakeWithdraw(){
    var WithdrawAmount = $('#WithdrawAmount').val();
    var PayingAddress = $('#PayingAddress').val();

    if(WithdrawAmount < 1){
        ShowAlert('error' , 'you must withdraw at least 2 KAT');
    }else{
        Swal.fire({
            title: "Are you sure?",
            html: `
    Are you sure to withdraw with this details?<br>
    Amount : <b>`+WithdrawAmount+`</b><br>
    Address : <b>`+PayingAddress+`</b>
  `,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#6aff39",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes , Withdraw Now !",
            cancelButtonText: "No , Cancel !"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.showLoading();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    async: false,
                    cache: false,
                });
                $.ajax({
                    url: route('V1.Withdraw.Create'),
                    data: {
                        Amount: WithdrawAmount,
                        PayingAddress: PayingAddress,
                        UserID: User.id,
                    },
                    success: function (response) {
                        Swal.close()
                        if (response.Data.Code == 200 ) {
                            ShowAlert('success' , response.Data.Message);
                            window.location.reload()
                        }else {
                            ShowAlert('error' , response.Data.Message);
                        }

                    }
                });
            }
        });
    }


}

function MakeTransfer(){
    var TransferAmount = $('#TransferAmount').val();
    var ReceiverUserID = $('#ReceiverUserID').val();
    var ReceiverUserUserName = $('#ReceiverUserUserNameVal').val();


    var SenderBalance = parseFloat(User.Charge).toFixed(2) * 1000;
    TransferAmount =  parseInt(TransferAmount)
    var Fee = ( (TransferAmount / 100) * 10);
    var NeededBalance = TransferAmount + Fee;

    console.log(SenderBalance)
    if(TransferAmount < 2000){
        ShowAlert('error' , 'Your entered amount is under minimum , You must move at least 2000 KAC.');
        return;
    }
    if(SenderBalance < NeededBalance){
        ShowAlert('error' , 'You do not have enough KAC to transfer.');
    }else{
        Swal.fire({
            title: "Are you sure?",
            html: `
    Are you sure to Transfer with this details?<br>
    Amount : <b>`+TransferAmount+`</b> KAC <br>
    Fee : <b>`+Fee+`</b> KAC <br>
    Total : <b>`+NeededBalance+`</b> KAC <br>
    Receiver User : <b>`+ReceiverUserUserName+`</b>
  `,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#6aff39",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes , Transfer Now !",
            cancelButtonText: "No , Cancel !"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.showLoading();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    async: false,
                    cache: false,
                });
                $.ajax({
                    url: route('V1.Payment.Transfer'),
                    data: {
                        UserID: User.id,
                        Amount: TransferAmount,
                        ReceiverUserID: ReceiverUserID,
                    },
                    success: function (response) {
                        if (response.Data.Code == 1 ) {
                            ShowAlert('success' , response.Data.Message);
                            setTimeout(
                                function() {
                                    window.location.reload();
                                }, 2000);
                        }else {
                            ShowAlert('error' , response.Data.Message);
                        }

                    }
                });
            }
        });
    }


}


function CalculateFeeAndTotalForSwap(){
    var Amount = $('#SwapAmount').val();
    if(Amount == 0 || Amount == null){
        $('#SwapFee').text(0).removeClass('text-danger').addClass('text-success')
        $('#SwapTotalAmount').text(0).removeClass('text-danger').addClass('text-success')
        $('#ReceivedKACAmount').text(0).removeClass('text-danger').addClass('text-success')
    }else{
        var Amount = parseInt(Amount)

        var FeePercent = null;
        if(Amount <= 10){
            FeePercent = 6;
        }else if(Amount > 10 && Amount <= 50){
            FeePercent = 3;
        }else if(Amount > 50 ){
            FeePercent = 1;
        }



        if(Amount > (User.KAT )){
            ShowAlert('error' , 'You do not have enough KAT to Swap.');
            var Fee =  ( (Amount / 100) * FeePercent );
            Fee = parseFloat(Fee).toFixed(2)
            var Total = Amount  ;
            var ReceivedKAC = (Amount * 1000) - (Fee * 1000);


            $('#SwapFee').text(Fee).addClass('text-danger').removeClass('text-success')
            $('#SwapTotalAmount').text(Total).addClass('text-danger').removeClass('text-success')
            $('#ReceivedKACAmount').text(ReceivedKAC).addClass('text-danger').removeClass('text-success')
        }else{
            var Fee =  ( (Amount / 100) * FeePercent );
            Fee = parseFloat(Fee).toFixed(2)
            var Total = Amount  ;
            var ReceivedKAC = (Amount * 1000) - (Fee * 1000);



            $('#SwapFee').text(Fee).removeClass('text-danger').addClass('text-success')
            $('#SwapTotalAmount').text(Total).removeClass('text-danger').addClass('text-success')
            $('#ReceivedKACAmount').text(ReceivedKAC).removeClass('text-danger').addClass('text-success')

        }

    }





}


function MakeSwap(){
    var Amount = $('#SwapAmount').val();
    Amount = parseInt(Amount)

    var SenderBalance = parseInt(User.KAT)


    var FeePercent = null;
    if(Amount <= 10){
        FeePercent = 6;
    }else if(Amount > 10 && Amount <= 50){
        FeePercent = 3;
    }else if(Amount > 50 ){
        FeePercent = 1;
    }

    var Fee =  ( (Amount / 100) * FeePercent );
    Fee = parseFloat(Fee).toFixed(2)
    var Total = Amount  ;
    var ReceivedKAC = (Amount * 1000) - (Fee * 1000);



    var NeededBalance = Amount ;

    if(Amount < 1){
        ShowAlert('error' , 'Your entered amount is under minimum , You must Swap at least 1 KAT.');
        return;
    }
    if(SenderBalance < NeededBalance){
        ShowAlert('error' , 'You do not have enough KAT to SWAP.');
    }else{
        Swal.fire({
            title: "Are you sure?",
            html: `
    Are you sure to Swap with this details?<br>
    Amount : <b>`+Amount+`</b> KAT <br>
    Fee : <b>`+Fee+`</b> KAT <br>
    Total : <b>`+Total+`</b> KAT <br>
    Received KAC : <b>`+ReceivedKAC+`</b> KAC
  `,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#6aff39",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes , Swap Now !",
            cancelButtonText: "No , Cancel !"
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.showLoading();
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    type: 'POST',
                    async: false,
                    cache: false,
                });
                $.ajax({
                    url: route('V1.Payment.Swap'),
                    data: {
                        UserID: User.id,
                        Amount: Amount,
                    },
                    success: function (response) {
                        if (response.Data.Code == 1 ) {
                            ShowAlert('success' , response.Data.Message);
                            setTimeout(
                                function() {
                                    window.location.reload();
                                }, 2000);
                        }else {
                            ShowAlert('error' , response.Data.Message);
                        }

                    }
                });
            }
        });
    }


}

window.addEventListener("DOMContentLoaded", async () => {
    if(isTMA()) {
        init();
        initData.restore();
        const InitData = initData;
        TelegramUser = InitData.user();

        GetUser(TelegramUser.id)

        $('#ProfileUsername').text(User.UserName)

        const currentDate = moment(new Date(), 'YYYY-MM-DD');
        var endDate = moment(User.created_at, "YYYY-MM-DD");
        var days = currentDate.diff(endDate, 'days')

        $('#ProfileJoinDate').text(days + ' Days')
        $('#ProfileImage').attr('src' , User.Image)
        LoadTransactionTable();
        LoadWithdrawSection();
        var Charge = parseFloat(User.Charge).toFixed(2) * 1000;
        $('#CurrentKACBalance').text(Charge);


    }else{
        GetUser(76203510)
        $('#ProfileUsername').text(User.UserName)

        const currentDate = moment(new Date(), 'YYYY-MM-DD');
        var endDate = moment(User.created_at, "YYYY-MM-DD");
        var days = currentDate.diff(endDate, 'days')

        $('#ProfileJoinDate').text(days + ' Days')
        $('#ProfileImage').attr('src' , User.Image)
        LoadTransactionTable();
        LoadWithdrawSection();
        var Charge = parseFloat(User.Charge).toFixed(2) * 1000;
        $('#CurrentKACBalance').text(Charge);
    }

});


