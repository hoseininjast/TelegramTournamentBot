import {
    ShowToast,
    deleteSession,
    setSession,
    ReadSession, redirect,
} from "../utilities.js";
import moment from "moment/moment.js";

import {init, initData, isTMA} from "@telegram-apps/sdk";
import { restClient } from "coinmarketcap-js";



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
const USDTPOLAddress = '0xBa0B19631E0233e1E4Ee16c16c03519FAFfE3E7b';
const TonAddress = 'UQCdkjHiAApGpT63O_6A1dttQ6B2o9FliiPuQoFnZJWyevmT';
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
    }, 2000);

}


async function CreateInvoice() {
    const rest = restClient(import.meta.env.VITE_CMC_API_KEY)
    const result = await rest.crypto.latestQuotes({symbol: "MATIC"});
    console.log(result);
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



    }else{
        GetUser(76203510)


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


        $('#ProfileImage').attr('src' , User.Image)
    }

});


