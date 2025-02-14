import {
    redirect,
} from "../utilities.js";


const PendingStatusButton = document.querySelector("#StatusPending");
const RunningStatusButton = document.querySelector("#StatusRunning");
const FinishedStatusButton = document.querySelector("#StatusFinished");

const TournamentDetailButtons = document.querySelectorAll(".TournamentDetail");


const initPage = async () => {

};





function FilterTournaments(Status) {
    $('.Tournamnet').show(400);
    $('.TournamnetStatus-' + Status).hide(400);

}




PendingStatusButton.addEventListener("click", () =>
    FilterTournaments('Pending')
);

RunningStatusButton.addEventListener("click", () =>
    FilterTournaments('Running')
);
FinishedStatusButton.addEventListener("click", () =>
    FilterTournaments('Finished')
);

TournamentDetailButtons.forEach((plan) => plan.addEventListener('click', (event) => {
    redirect(route('Front.Tournaments.Detail' , [ plan.getAttribute('data-TournamentID')  ]) );
}));


window.addEventListener("DOMContentLoaded", async () => {
    await initPage();
});


