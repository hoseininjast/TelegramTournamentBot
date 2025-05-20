
import {init, initData, isTMA} from "@telegram-apps/sdk";



const ProfileSectionButtons = document.querySelectorAll(".ProfileSectionButtons");



let TelegramUser;
let User;

function ChangeSections(Section) {

    $('.MainDashboardSections').hide(400);
    $('.ProfileSectionButtons').removeClass('active');
    $('#' + Section).show(400);
    $('#' + Section + 'Button').addClass('active');
    $('html, body').animate({
        scrollTop: $('#MainDashboardSectionDiv').offset().top
    }, 1000);


}


ProfileSectionButtons.forEach((button) => button.addEventListener('click', (event) => {
    ChangeSections(button.getAttribute('data-Section'))
}));


window.addEventListener("DOMContentLoaded", async () => {
    if(isTMA()) {
        init();
        initData.restore();
        const InitData = initData;
        TelegramUser = InitData.user();

    }

});


