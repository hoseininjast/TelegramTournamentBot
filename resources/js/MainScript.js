import {
    ShowToast,
    deleteSession,
    setSession,
    ReadSession, redirect,
} from "./utilities.js";
import { init, backButton } from '@telegram-apps/sdk';

let SelectedMode = 'Free';

const LoadGamesFreeButton = document.querySelector("#LoadGamesFree");
const LoadGamesPaidButton = document.querySelector("#LoadGamesPaid");
const PlayGameButtons = document.querySelectorAll(".PlayGame");


const initPage = async () => {
    init();
    backButton.mount();
    const off = backButton.onClick(() => {
        off();
        window.history.back();
    });
};





function GetGames(Mode) {
    SelectedMode = Mode;
    $('#GameSection').show(400);

}




LoadGamesFreeButton.addEventListener("click", () =>
    GetGames('Free')
);

LoadGamesPaidButton.addEventListener("click", () =>
    GetGames('Paid')
);

PlayGameButtons.forEach((plan) => plan.addEventListener('click', (event) => {
    redirect(route('Front.Tournaments.List' , [ plan.getAttribute('data-GameID') , 'free' ]) );
}));


window.addEventListener("DOMContentLoaded", async () => {
    await initPage();
});


