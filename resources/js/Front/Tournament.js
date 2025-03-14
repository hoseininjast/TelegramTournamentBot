import {
    redirect,
    ShowAlert
} from "../utilities.js";

import {initData, isTMA} from '@telegram-apps/sdk';


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
                $('.JoinButton').attr('disabled' , true)
                $('.JoinButton').text('joined');
            }else if(response.Code == 2){
                $('.JoinButton').attr('disabled' , false)
                $('.JoinButton').text('Join');
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
                ShowAlert('success' , response.Message);
                $('.JoinButton').attr('disabled' , true).text('joined');
            }else if(response.Code == 300 || response.Code == 301 || response.Code == 302){
                ShowAlert('warning' , response.Message);
            }else if(response.Code == 400){
                ShowAlert('error' , response.Message);
            }

        }
    });

    // redirect(route('Front.Tournaments.Detail' , [ plan.getAttribute('data-TournamentID')  ]) );

}


JoinTournamentButtons.forEach((plan) => plan.addEventListener('click', (event) => {
    JoinTournament(plan.getAttribute('data-TournamentID'))
}));



window.addEventListener("DOMContentLoaded", async () => {

    if(isTMA()){
        initData.restore();
        const InitData = initData;
        User = InitData.user();
        var TourID = $('#TournamentID').val()
        CheckTournamentJoinStatus(TourID)
    }

});


