import {
    redirect,
} from "../utilities.js";

import { initData} from '@telegram-apps/sdk';


const JoinTournamentButtons = document.querySelectorAll(".JoinButton");

let User;

function CheckTournamentJoinStatus(TourID){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        async: false,
        cache: false,
    });
    $.ajax({
        url: route('V1.Tournaments.JoinStatus'),
        data: {
            TournamentID: TourID,
            UserID: User.id,
        },
        success: function (response) {
            if (response.Code == 1 ) {
                $('.mybtn2').attr('disabled' , true)
                $('.mybtn2').text('joined');
            }else if(response.Code == 2){
                $('.mybtn2').attr('disabled' , false)
                $('.mybtn2').text('Join');
            }

        }
    });
}



function JoinTournament(TourID){



    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        async: false,
        cache: false,
    });
    $.ajax({
        url: route('V1.Tournaments.Join'),
        data: {
            TournamentID: TourID,
            UserID: User.id,
        },
        success: function (response) {
            if (response.Code == 200 || response.Code == 201) {
                ShowToast('success' , response.Message);
                $('.mybtn2').attr('disabled' , true)
                $('.mybtn2').text('joined');
            }else if(response.Code == 300 || response.Code == 301 || response.Code == 302){
                ShowToast('warning' , response.Message);
            }else if(response.Code == 400){
                ShowToast('error' , response.Message);
            }

        }
    });

    redirect(route('Front.Tournaments.Detail' , [ plan.getAttribute('data-TournamentID')  ]) );

}


JoinTournamentButtons.forEach((plan) => plan.addEventListener('click', (event) => {
    JoinTournament(plan.getAttribute('data-TournamentID'))
}));



window.addEventListener("DOMContentLoaded", async () => {

    initData.restore();
    const InitData = initData;
    User = InitData.user();

});


