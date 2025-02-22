import './bootstrap';

import { init, backButton ,closingBehavior,hapticFeedback , initData , isTMA   } from '@telegram-apps/sdk';
import moment from "moment/moment.js";
import {redirect} from "./utilities.js";

let TelegramUser;
let User;


function GetUser(ReferralID = null){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        async: false,
        cache: false,
    });

    $.ajax({
        url: route('V1.User.FindOrCreate'),
        data : {
            TelegramData :   TelegramUser,
            ReferralID : ReferralID
        },
        success: function (response) {
            User = response.Data.User;
        }
    });

}





window.addEventListener("DOMContentLoaded", async () => {
    $('#FooterBar').show();

    if(route().current('Front.Games') || route().current('Front.Tournaments.Detail') || route().current('Front.Tournaments.List') ){
        $('.NavbarButtons').removeClass('active')
        $('#Navbar-Tournaments').addClass('active')
    }else if( route().current('Front.Tournaments.MyTournaments') ){
        $('.NavbarButtons').removeClass('active')
        $('#Navbar-MyTournaments').addClass('active')
    }else if(route().current('Front.Profile.index') ){
        $('.NavbarButtons').removeClass('active')
        $('#Navbar-Profile').addClass('active')
    }

    if(isTMA()){
        init();
        initData.restore();
        const InitData = initData;
        TelegramUser = InitData.user();
        var ReferralID = initData.startParam();

        GetUser( ReferralID)


        $('#UserUsername').html('Welcome Back ' + TelegramUser.username);
        $('#UserImage').attr('src', TelegramUser.photo_url );


        $('#NavbarUsername').html( User.UserName);
        $('#NavbarCharge').text(User.Charge);
        $('#NavbarProfileImage').attr('src', User.Image ? User.Image : TelegramUser.photo_url);


        if(route('Front.Games') == window.location.href){
            backButton.unmount();
            backButton.hide();
            closingBehavior.mount();
            closingBehavior.enableConfirmation();
        }else{
            backButton.mount();
            backButton.show();
        }

        if (hapticFeedback.impactOccurred.isAvailable()) {
            hapticFeedback.impactOccurred('medium');
        }
        const off = backButton.onClick(() => {
            off();
            window.history.back();
        });
    }else{
        GetUser(76203510)
    }


});
