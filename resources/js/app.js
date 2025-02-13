import './bootstrap';

import { init, backButton,closingBehavior,hapticFeedback , retrieveLaunchParams } from '@telegram-apps/sdk';


const { initDataRaw, initData } = retrieveLaunchParams();
const User = initData.user();

$('#logs').text(User);
$('#UserUsername').html('Welcome Back ' + User.username);
$('#UserImage').src(User.photoUrl);

init();
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
