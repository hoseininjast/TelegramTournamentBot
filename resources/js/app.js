import './bootstrap';

import { init, backButton,closingBehavior,hapticFeedback , retrieveLaunchParams , isTMA } from '@telegram-apps/sdk';











window.addEventListener("DOMContentLoaded", async () => {
    $('#FooterBar').show();

    if(isTMA()){
        init();
        const { initDataRaw, initData } = retrieveLaunchParams();

        console.log(initData);
        console.log('----------');
        console.log('----------');
        console.log('----------');
        console.log(initDataRaw);

        const User = initData.user();

        $('#UserUsername').html('Welcome Back ' + User.username);
        $('#UserImage').src(User.photoUrl);

        if(route('Front.Games') == window.location.href){
            backButton.unmount();

        }else{
            backButton.mount();
            backButton.show();
        }


        if (closingBehavior.mount.isAvailable()) {
            closingBehavior.mount();
        }
        if (closingBehavior.enableConfirmation.isAvailable()) {
            closingBehavior.enableConfirmation();
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
