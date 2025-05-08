import {
    redirect,
    ShowAlert
} from "../utilities.js";

import {initData, isTMA} from '@telegram-apps/sdk';

const BackToDetailsButton = document.querySelector("#BackToDetailsButton");

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

    Swal.fire({
        title: "Are you sure?",
        text: "Do you want to join this tournament and Pay entry fee?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#6aff39",
        cancelButtonColor: "#d33",
        confirmButtonText: "Yes , Join Now !",
        cancelButtonText: "No , Cancel !"
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.showLoading();
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
                    Swal.close()
                    if (response.Code == 200 || response.Code == 201) {
                        ShowAlert('success' , response.Message);
                        $('.JoinButton').attr('disabled' , true).text('joined');
                    }else if(response.Code == 300 || response.Code == 301 || response.Code == 302){
                        ShowAlert('warning' , response.Message);
                    }else if(response.Code == 400){
                        Swal.fire({
                            icon: 'error',
                            title: response.Message,
                            showDenyButton: true,
                            showCancelButton: false,
                            confirmButtonText: "Join Channel",
                            denyButtonText: `Close`
                        }).then((result) => {
                            /* Read more about isConfirmed, isDenied below */
                            if (result.isConfirmed) {
                                redirect('https://t.me/krypto_arena')
                            } else if (result.isDenied) {
                                Swal.fire("you cannot join tournaments without joining our channel", "", "info");
                            }
                        });

                    }

                }
            });
        }
    });




    // redirect(route('Front.Tournaments.Detail' , [ plan.getAttribute('data-TournamentID')  ]) );

}


JoinTournamentButtons.forEach((plan) => plan.addEventListener('click', (event) => {
    JoinTournament(plan.getAttribute('data-TournamentID'))
}));


BackToDetailsButton.addEventListener("click", () =>
    history.back()
);



window.addEventListener("DOMContentLoaded", async () => {

    if(isTMA()){
        initData.restore();
        const InitData = initData;
        User = InitData.user();
        var TourID = $('#TournamentID').val()
        CheckTournamentJoinStatus(TourID)
    }

});


