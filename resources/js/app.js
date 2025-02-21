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
