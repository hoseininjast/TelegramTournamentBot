import {
    redirect,
} from "../utilities.js";

const PendingStatusButton = document.querySelector("#StatusPending");
const RunningStatusButton = document.querySelector("#StatusRunning");
const FinishedStatusButton = document.querySelector("#StatusFinished");

const TournamentDetailButtons = document.querySelectorAll(".TournamentDetail");






function FilterTournaments(Status) {
    $('.Tournamnet').hide(400);
    $('.TournamnetStatus-' + Status).show(400);

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



