import './bootstrap';

import { init, backButton,closingBehavior,hapticFeedback , retrieveLaunchParams , isTMA } from '@telegram-apps/sdk';







// const User = initData.user();


// $('#UserUsername').html('Welcome Back ' + User.username);
// $('#UserImage').src(User.photoUrl);



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

        backButton.mount();
        if (backButton.show.isAvailable()) {
            backButton.show();
        }
        if (closingBehavior.mount.isAvailable()) {
            closingBehavior.mount();
            closingBehavior.isMounted(); // true
        }
        if (closingBehavior.enableConfirmation.isAvailable()) {
            closingBehavior.enableConfirmation();
            closingBehavior.isConfirmationEnabled(); // true
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
