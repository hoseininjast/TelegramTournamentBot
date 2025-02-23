import {
    ShowToast,
    deleteSession,
    setSession,
    ReadSession, redirect,
} from "../utilities.js";
import moment from "moment/moment.js";

import {init, initData, isTMA} from "@telegram-apps/sdk";
import { restClient } from "coinmarketcap-js";



const UpdateProfileButton = document.querySelector("#UpdateProfileButton");

const AffiliateButton = document.querySelector("#AffiliateButton");
const WalletButton = document.querySelector("#WalletButton");
const SettingButton = document.querySelector("#SettingButton");

const InvoiceButton = document.querySelector("#InvoiceButton");

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
let ReferralCount;
let TournamentsJoined;
let TournamentsWinned;


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
            ReferralCount = response.Data.ReferralCount;
            TournamentsJoined = response.Data.TournamentsJoined;
            TournamentsWinned = response.Data.TournamentsWinned;
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
        type: 'GET',
        async: false,
        cache: false,
    });

    let CryptoPrice , WalletAddress;

    if(Token == 'MATIC' ){
        WalletAddress = PolygonAddress;
        $.ajax({
            url: route('V1.Payment.GetPrice' , Token),
            success: function (response) {
                CryptoPrice = response.Price.MATIC.quote.USD.price;
                console.log(CryptoPrice)
                return response.Price.MATIC.quote.USD.price;


            }
        });
        CryptoPrice = parseFloat(CryptoPrice).toFixed(6)

    }else if(Token == 'TON' ){
        WalletAddress = TonAddress;
        $.ajax({
            url: route('V1.Payment.GetPrice' , Token),
            success: function (response) {
                CryptoPrice = response.Price.TON.quote.USD.price;
                return response.Price.TON.quote.USD.price;

            }
        });
        CryptoPrice = parseFloat(CryptoPrice).toFixed(6)
    }else if(Token == 'USDTPOL' ){
        WalletAddress = USDTPOLAddress;
        CryptoPrice = 1;
    }else if(Token == 'USDTTON' ){
        WalletAddress = USDTTONAddress;
        CryptoPrice = 1;
    }

    let payable = Amount / CryptoPrice;
    console.log(CryptoPrice)
    console.log(Amount)
    console.log(payable)

    $('#WalletAddress').val(WalletAddress)
    $('#DepositAmount').val(payable)

    $('#PaymentArea').show(400)
}

AffiliateButton.addEventListener("click", () =>
    ChangeSections('Affiliate')
);

WalletButton.addEventListener("click", () =>
    ChangeSections('Wallet')
);

SettingButton.addEventListener("click", () =>
    ChangeSections('Setting')
);

InvoiceButton.addEventListener("click", () =>
    CreateInvoice()
);

UpdateProfileButton.addEventListener("click", () =>
    Swal.fire({
        title: "Updating...",
        html: "Please wait a moment"
    }),
    Swal.showLoading()
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
        $('#ReferralCount').text(ReferralCount)
        $('#TournamentsJoined').text(TournamentsJoined)
        $('#TournamentsWinned').text(TournamentsWinned)
        $('#Championship').text(TournamentsWinned)

        $('#UserID').val(User.id)
        $('#UserName').val(User.UserName)
        $('#PlatoID').val(User.PlatoID)
        $('#MyInviteLink').val('https://t.me/KryptoArenaBot?startapp=' + TelegramUser.id)


        $('#ProfileImage').attr('src' , User.Image)


    }else{
        GetUser(76203510)



    }

});


