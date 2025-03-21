import {
    ShowToast,
    deleteSession,
    setSession,
    ReadSession, redirect,
} from "../utilities.js";

let SelectedMode = 'Free';

const LoadGamesFreeButton = document.querySelector("#LoadGamesFree");
const LoadGamesPaidButton = document.querySelector("#LoadGamesPaid");
const PlayGameButtons = document.querySelectorAll(".PlayGame");


const initPage = async () => {

};





function GetGames(Mode) {
    SelectedMode = Mode;
    $('#GameSection').show(400);
    $('html, body').animate({
        scrollTop: $("#GameRow").offset().top
    }, 2000);

}




LoadGamesFreeButton.addEventListener("click", () =>
    GetGames('Free')
);

LoadGamesPaidButton.addEventListener("click", () =>
    GetGames('Paid')
);

PlayGameButtons.forEach((plan) => plan.addEventListener('click', (event) => {
    redirect(route('Front.Tournaments.List' , [ plan.getAttribute('data-GameID') , SelectedMode ]) );
}));


window.addEventListener("DOMContentLoaded", async () => {
    await initPage();
});


