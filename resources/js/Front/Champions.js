

const PlatoButton = document.querySelector("#PlatoButton");
const InvitersButton = document.querySelector("#InvitersButton");




function ChangeSections(Section) {

    $('.LeaderboardSections').hide(400);
    $('#' + Section ).show(400);
    $('html, body').animate({
        scrollTop: $('.latest-arcive').offset().top
    }, 1000);


}



PlatoButton.addEventListener("click", () =>
    ChangeSections('PlatoLeaderboard')
);

InvitersButton.addEventListener("click", () =>
    ChangeSections('InvitersLeaderboard')
);
