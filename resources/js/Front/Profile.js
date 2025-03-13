import {
    ShowToast,
    deleteSession,
    setSession,
    ReadSession, redirect, copyContent
} from "../utilities.js";
import moment from "moment/moment.js";

import {init, initData, isTMA} from "@telegram-apps/sdk";



const UpdateProfileButton = document.querySelector("#UpdateProfileButton");

const AffiliateButton = document.querySelector("#AffiliateButton");
const SettingButton = document.querySelector("#SettingButton");


const ReferralidCopyIcon = document.querySelector("#ReferralidCopyIcon");
const MyInviteLink = document.querySelector("#MyInviteLink");



let TelegramUser;
let User;
let ReferralUsers;
let ReferralCount;
let ReferralIncome;
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
            ReferralUsers = response.Data.ReferralUsers;
            ReferralCount = response.Data.ReferralCount;
            ReferralIncome = response.Data.ReferralIncome;
            TournamentsJoined = response.Data.TournamentsJoined;
            TournamentsWinned = response.Data.TournamentsWinned;
        }
    });

}




function ChangeSections(Section) {

    $('.MainDashboardSections').hide(400);
    $('#' + Section + 'Section').show(400);


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

        var ReferralLink = 'https://t.me/krypto_arena_bot?startapp=' + TelegramUser.id;

        $('#ProfileJoinDate').text(days + ' Days')
        $('#ReferralCountinTable').text(ReferralCount)
        $('#ReferralCount').text(ReferralCount)
        $('#TournamentsJoined').text(TournamentsJoined)
        $('#TournamentsWinned').text(TournamentsWinned)
        $('#Championship').text(TournamentsWinned)

        $('#UserID').val(User.id)
        $('#UserName').val(User.UserName)
        $('#PlatoID').val(User.PlatoID)
        $('#WalletAddress').val(User.WalletAddress)
        $('#TonWalletAddress').val(User.TonWalletAddress)
        $('#PlatoID').val(User.PlatoID)
        $('#MyInviteLink').text(ReferralLink)

        $("#ReferralIncome").text('$' + ReferralIncome);

        $(ReferralUsers).each(async function (index, User) {


            let key = index + 1;
            let startTime = moment(User.created_at).format("YY/M/D");
            let Name = User.UserName ? User.UserName : User.FirstName + ' ' + User.LastName;
            let Image = User.Image ? User.Image : 'https://kryptoarena.fun/images/Users/DefaultProfile.png';
            let row = `<tr>
                                            <td>`+ key  +`</td>
                                            <td><img style='width: 30px;height: 30px' class="rounded-pill" src="`+ Image +`" alt="user profile" ></td>
                                            <td>`+ Name  +`</td>
                                            <td>`+User.PlatoID+`</td>
                                            <td>`+startTime+`</td>
                                        </tr>`;


            $('#ReferralHistoryTable').append(row);

        });





        ReferralidCopyIcon.addEventListener("click", () =>
            copyContent(ReferralLink)
        );

        MyInviteLink.addEventListener("click", () =>
            copyContent(ReferralLink)
        );



        $('#ProfileImage').attr('src' , User.Image)

        Swal.close()

    }else{
        GetUser(76203510)

    }

});


