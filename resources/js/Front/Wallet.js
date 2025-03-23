import {
    ShowToast,
    deleteSession,
    setSession,
    ReadSession, redirect,
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


let Token = 'Polygon';
let Amount = 1;

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

                $('#DepositAmount').val(response.Data.pay_amount)
                $('#WalletAddress').val(response.Data.pay_address)
                $('#PaymentMethod').text(Token)
                $('#Amount').text(Amount)
                $('#OrderID').text(response.Data.order_id)

                if(Token == 'Polygon'){
                    var PaymentAddress = "https://metamask.app.link/send/"+response.Data.pay_address+"@137?value=" + response.Data.pay_amount +"e18";
                    $('#PaymentButton').attr('href' , PaymentAddress).show(400);
                }else if(Token == 'USDTPOL'){
                    var PaymentAddress = "https://metamask.app.link/send/0xc2132D05D31c914a87C6611C10748AEb04B58e8F@137/transfer?address="+ response.Data.pay_address +"&uint256=" + response.Data.pay_amount;
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
        url: route('V1.Payment.Check' , ),
        data: {
            PaymentID: ReadSession('payment_id'),
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

TokenButtons.forEach((plan) => plan.addEventListener('click', (event) => {
    Token = plan.getAttribute('data-Token');
}));



PriceButtons.forEach((plan) => plan.addEventListener('click', (event) => {
    Amount = plan.getAttribute('data-Amount');
}));



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


    }else{
        GetUser(76203510)

    }

});


