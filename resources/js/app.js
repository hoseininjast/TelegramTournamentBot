import './bootstrap';

import { init, backButton ,closingBehavior,hapticFeedback , initData, initDataChat, initDataUser , isTMA  } from '@telegram-apps/sdk';










window.addEventListener("DOMContentLoaded", async () => {
    $('#FooterBar').show();

    if(isTMA()){
        init();
        initData.restore();
        const InitData = initData;

        console.log(InitData)
        console.log('-----')
        console.log(InitData.user.username)
        console.log(InitData.user.photo_url)
        console.log('-----')

        // console.log(UserData.id)
        // console.log(UserData.photo_url)
        // console.log(UserData.username)
        // const User = initData.user();

        // $('#UserUsername').html('Welcome Back ' + User.username);
        // $('#UserImage').src(User.photoUrl);

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
