import {
    ShowToast,
    deleteSession,
    setSession,
    ReadSession, redirect,
} from "../utilities.js";
import moment from "moment/moment.js";

import {init, initData, isTMA} from "@telegram-apps/sdk";



const UpdateProfileButton = document.querySelector("#UpdateProfileButton");

const AffiliateButton = document.querySelector("#AffiliateButton");
const SettingButton = document.querySelector("#SettingButton");



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


function ShowLoading(){
    Swal.fire({
        title: "Updating...",
        html: "Please wait a moment"
    });
    Swal.showLoading()
}

AffiliateButton.addEventListener("click", () =>
    ChangeSections('Affiliate')
);

SettingButton.addEventListener("click", () =>
    ChangeSections('Setting')
);

UpdateProfileButton.addEventListener("click", () =>
    ShowLoading()
);



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


    }

});


