import {redirect} from "../utilities.js";


const PlatoButton = document.querySelector("#PlatoButton");
const InvitersButton = document.querySelector("#InvitersButton");

const RedirectToProfile = document.querySelectorAll(".RedirectToProfile");




function ChangeSections(Section) {

    $('.LeaderboardSections').hide(400);
    $('#' + Section ).show(400);
    $('html, body').animate({
        scrollTop: $('.latest-arcive').offset().top
    }, 1000);


}


RedirectToProfile.forEach((button) => button.addEventListener('click', (event) => {
    redirect(route('Front.Profile.Show' , button.getAttribute('data-UserID')) )
}));



PlatoButton.addEventListener("click", () =>
    ChangeSections('PlatoLeaderboard')
);

InvitersButton.addEventListener("click", () =>
    ChangeSections('InvitersLeaderboard')
);
