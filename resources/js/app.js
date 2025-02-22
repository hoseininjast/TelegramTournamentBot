import './bootstrap';

import { init, backButton ,closingBehavior,hapticFeedback , initData, initDataChat, initDataUser , isTMA  } from '@telegram-apps/sdk';
import moment from "moment/moment.js";
import {redirect} from "./utilities.js";

let TelegramUser;
let User;


function GetUser(UserID){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
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





window.addEventListener("DOMContentLoaded", async () => {
    $('#FooterBar').show();

    if(isTMA()){
        init();
        initData.restore();
        const InitData = initData;
        TelegramUser = InitData.user();

        GetUser(TelegramUser.id)

        $('#UserUsername').html('Welcome Back ' + TelegramUser.username);
        $('#UserImage').attr('src', TelegramUser.photo_url );


        $('#NavbarUsername').html('Welcome Back ' + User.UserName);
        $('#NavbarCharge').text(User.Charge);
        $('#NavbarProfileImage').attr('src', TelegramUser.photo_url );


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
    }


});
