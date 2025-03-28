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
    }else if(route().current('Front.Tournaments.Champions') ){
        $('.NavbarButtons').removeClass('active')
        $('#Navbar-Champions').addClass('active')
    }else if(route().current('Front.Profile.Wallet') ){
        $('.NavbarButtons').removeClass('active')
        $('#Navbar-Wallet').addClass('active')
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
        var ProfileImage = User.Image ? User.Image : 'https://kryptoarena.fun/images/Users/DefaultProfile.png';


        var Charge = parseFloat(User.Charge).toFixed(2) * 1000;
        $('#NavbarUsername').html( User.UserName);
        $('#NavbarCharge').html("<i class='fa fa-coins text-warning mr-1'></i>" + Charge);
        $('#NavbarProfileImage').attr('src', ProfileImage);


        if(route().current('Front.Tournaments.Champions')){
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
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'GET',
            async: false,
            cache: false,
        });

        $.ajax({
            url: route('V1.User.Find' , '76203510'),
            success: function (response) {
                User = response.Data.User;
            }
        });

        var ProfileImage = User.Image ? User.Image : 'https://kryptoarena.fun/images/Users/DefaultProfile.png';


        var Charge = parseFloat(User.Charge).toFixed(2) * 1000;
        $('#NavbarUsername').html( User.UserName);
        $('#NavbarCharge').html("<i class='fa fa-coins text-warning mr-1'></i>" + Charge);
        $('#NavbarProfileImage').attr('src', ProfileImage);

    }


});
