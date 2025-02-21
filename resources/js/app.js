import './bootstrap';

import { init, backButton ,closingBehavior,hapticFeedback , initData, initDataChat, initDataUser , isTMA  } from '@telegram-apps/sdk';










window.addEventListener("DOMContentLoaded", async () => {
    $('#FooterBar').show();

    if(isTMA()){
        init();
        initData.restore();
        const InitData = initData;
        const User = InitData.user();


        $('#UserUsername').html('Welcome Back ' + User.username);
        $('#UserImage').attr('src',User.photoUrl);

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
