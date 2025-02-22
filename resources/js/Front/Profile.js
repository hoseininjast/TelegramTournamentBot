import {
    ShowToast,
    deleteSession,
    setSession,
    ReadSession, redirect,
} from "../utilities.js";
import moment from "moment/moment.js";

import {init, initData, isTMA} from "@telegram-apps/sdk";


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
        var days = endDate.diff(currentDate, 'days')

        console.log(User.UserName)
        $('#ProfileJoinDate').text(days)

    }else{
        GetUser(76203510)


        $('#ProfileUsername').text(User.UserName)

        const currentDate = moment(new Date(), 'YYYY-MM-DD');
        var endDate = moment(User.created_at, "YYYY-MM-DD");
        var days = currentDate.diff(endDate, 'days')

        console.log(User.UserName)
        $('#ProfileJoinDate').text(days + ' Days')
        $('#ReferralCount').text(ReferralCount)
        $('#TournamentsJoined').text(TournamentsJoined)
        $('#TournamentsWinned').text(TournamentsWinned)
        $('#Championship').text(TournamentsWinned)
        // $('#ProfileImage').attr('src' , User.Image)
    }

});


