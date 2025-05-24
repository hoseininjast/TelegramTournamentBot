import {
    ShowToast,
    deleteSession,
    setSession,
    ReadSession, redirect, copyContent
} from "../utilities.js";
import moment from "moment/moment.js";

import {init, initData, isTMA} from "@telegram-apps/sdk";



const UpdateProfileButton = document.querySelector("#UpdateProfileButton");
const UpdatePlatformButton = document.querySelector("#UpdatePlatformButton");

const PlatformButton = document.querySelector("#PlatformButton");
const SettingButton = document.querySelector("#SettingButton");





let TelegramUser;
let User;
let Stars;
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
            Stars = response.Data.Stars;
            ReferralCount = response.Data.ReferralCount;
            TournamentsJoined = response.Data.TournamentsJoined;
            TournamentsWinned = response.Data.TournamentsWinned;
        }
    });

}






function ChangeSections(Section) {

    $('.MainDashboardSections').hide(400);
    $('#' + Section + 'Section').show(400);
    $('html, body').animate({
        scrollTop: $('#MainDashboardSectionDiv').offset().top
    }, 1000);


}

function UpdateProfile(){
    Swal.fire({
        title: "Updating...",
        html: "Please wait a moment"
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        async: false,
        cache: false,
    });

    $.ajax({
        url: route('V1.Profile.Update' ),
        data: {
            UserID: User.id,
            UserName: $('#UserName').val(),
            WalletAddress: $('#WalletAddress').val(),
            KryptoArenaID: $('#KryptoArenaID').val(),
            Bio: $('#Bio').val(),
            Country: $('#Country').val(),
            City: $('#City').val(),
        },
        success: function (response) {
            if(response.Data.Code == 200){
                Swal.fire({
                    icon: 'success',
                    text: response.Data.Message,
                });
                setTimeout(
                    function() {
                        window.location.reload();
                    }, 2000);

            }else{
                Swal.fire({
                    icon: 'error',
                    text: 'please try again' ,
                });
            }
        }
    });

}

function UpdatePlatform(){
    Swal.fire({
        title: "Updating...",
        html: "Please wait a moment"
    });
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        async: false,
        cache: false,
    });

    $.ajax({
        url: route('V1.Profile.UpdatePlatform' ),
        data: {
            UserID: User.id,
            PlatoID: $('#PlatoID').val(),
        },
        success: function (response) {
            if(response.Data.Code == 200){
                Swal.fire({
                    icon: 'success',
                    text: response.Data.Message,
                });
                setTimeout(
                    function() {
                        window.location.reload();
                    }, 2000);
            }else{
                Swal.fire({
                    icon: 'error',
                    text: response.Data.Message ,
                });
            }
        }
    });

}


PlatformButton.addEventListener("click", () =>
    ChangeSections('Platform')
);

SettingButton.addEventListener("click", () =>
    ChangeSections('Setting')
);

UpdateProfileButton.addEventListener("click", () =>
    UpdateProfile()
);

UpdatePlatformButton.addEventListener("click", () =>
    UpdatePlatform()
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
        $('#KryptoArenaID').val(User.KryptoArenaID)
        $('#Bio').val(User.Bio)
        $('#Country').val(User.Country)
        $('#City').val(User.City)




        $('#PlatoID').val(User.PlatoID)
        $('#WalletAddress').val(User.WalletAddress)


        $('#ProfileImage').attr('src' , User.Image)

        Swal.close()

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
        $('#Stars').text(Stars)

        $('#UserID').val(User.id)
        $('#UserIDForPlato').val(User.id)
        $('#UserName').val(User.UserName)



        $('#KryptoArenaID').val(User.KryptoArenaID)
        $('#Bio').val(User.Bio)
        $('#Country').val(User.Country)
        $('#City').val(User.City)




        $('#PlatoID').val(User.PlatoID)
        $('#WalletAddress').val(User.WalletAddress)



        Swal.close()
    }

});


