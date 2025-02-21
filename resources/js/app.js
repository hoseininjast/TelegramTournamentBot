import './bootstrap';

import { init, backButton,closingBehavior,hapticFeedback , initDataUser , isTMA } from '@telegram-apps/sdk';











window.addEventListener("DOMContentLoaded", async () => {
    $('#FooterBar').show();

    if(isTMA()){
        init();

        const UserData = initDataUser;

        console.log(UserData)
        // const User = initData.user();

        // $('#UserUsername').html('Welcome Back ' + User.username);
        // $('#UserImage').src(User.photoUrl);

        console.log(route('Front.Games'))
        if(route('Front.Games') == window.location.href){
            backButton.unmount();
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
