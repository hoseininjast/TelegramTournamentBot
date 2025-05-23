import './bootstrap';

import { init, backButton ,closingBehavior,closeMiniApp,hapticFeedback , initData , isTMA ,requestFullscreen  } from '@telegram-apps/sdk';

let TelegramUser;
let User;

const App_ENV = import.meta.env.VITE_APP_ENV;



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
    }else if( route().current('Front.Profile.Search') ){
        $('.NavbarButtons').removeClass('active')
        $('#Navbar-Search').addClass('active')
    }else if(route().current('Front.TaskAndInvite.index') ){
        $('.NavbarButtons').removeClass('active')
        $('#Navbar-TaskAndInvite').addClass('active')
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

        if (requestFullscreen.isAvailable()) {
            await requestFullscreen();
        }

        GetUser( ReferralID)
        var ProfileImage = User.Image ? User.Image : 'https://kryptoarena.fun/images/Users/DefaultProfile.png';


        var Charge = parseFloat(User.Charge).toFixed(2) * 1000;
        $('#NavbarUsername').html( User.UserName);
        $('#NavbarCharge').html("<i class='fa fa-coins text-warning mr-1'></i>" + Charge);
        $('#NavbarKATCharge').html(User.KAT);
        $('#NavbarProfileImage').attr('src', ProfileImage);


        if(route().current('Front.Profile.index')){
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
        const closing = closingBehavior.onClick(() => {
            closeMiniApp();
        });
    }else{
       if(App_ENV == 'local'){
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
           $('#NavbarKATCharge').html(User.KAT);
           $('#NavbarProfileImage').attr('src', ProfileImage);
       }
    }


});
