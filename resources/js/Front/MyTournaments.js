import {
    redirect,
} from "../utilities.js";
import {initData , isTMA} from "@telegram-apps/sdk";
import moment from "moment";

const PendingStatusButton = document.querySelector("#StatusPending");
const RunningStatusButton = document.querySelector("#StatusRunning");
const FinishedStatusButton = document.querySelector("#StatusFinished");

const TournamentDetailButtons = document.querySelectorAll(".TournamentDetail");

let User;





function GetTournaments(Mode){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        async: false,
        cache: false,
    });
    $.ajax({
        url: route('V1.Tournaments.MyTournaments' ),
        data : {
            UserID : 76203510,
            Mode : Mode
        },
        success: function (response) {
            $('#TournamentsDiv').empty()
            $(response.Data.Tournaments).each(async function (index, Tournament) {
                let awards = '';
                $(Tournament.Awards).each(async function (index, Award) {
                    awards += '$' +Award + '\n';
                });
                let startTime = moment(Tournament.Start).format("YY/M/D HH:mm");
                let endTime = moment(Tournament.End).format("YY/M/D HH:mm");
                let row = `<div class="col-lg-12 Tournamnet TournamnetStatus-`+ Tournament.Status +`">
									<div class="single-turnaments">
										<div class="left-area">
											<div class="single-play">
												<div class="image">
													<img src="`+ Tournament.Image+`" alt="">
													 <h4>`+Tournament.Name+`</h4>
												</div>
												<div class="contant">
                                                    <button type="button"  class="mybtn2 TournamentDetail" data-TournamentID="`+Tournament.id+`">Details</button>
												</div>
											</div>
											<h4>`+Tournament.PlayerCount+` Players</h4>
										</div>
										<div class="right-area">
											<div class="r-top-area">
												<div class="list">
													<p>
														Mode : `+Tournament.Mode+`
													</p>
													<span></span>
													<p>
														Type : `+ Tournament.Type+`
													</p>
												</div>
											</div>
											<div class="r-bottom-area">
												<div class="rr-area">
													<h5>Prize pool</h5>
													<div class="d-flex justify-content-around">
													    <p>`+awards+`</p>
                                                    </div>
													<div class="time-area">
														<h6>`+startTime +` - `+endTime+`</h6>
														<img src="/Front/images/bg-time.png" alt="">
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>`;

                $('#TournamentsDiv').append(row);

            });


        }
    });
}






PendingStatusButton.addEventListener("click", () =>
    GetTournaments('Pending')
);

RunningStatusButton.addEventListener("click", () =>
    GetTournaments('Running')
);
FinishedStatusButton.addEventListener("click", () =>
    GetTournaments('Finished')
);



window.addEventListener("DOMContentLoaded", async () => {
    if(isTMA()){
        initData.restore();
        const InitData = initData;
        User = InitData.user();
    }
});



TournamentDetailButtons.forEach((plan) => plan.addEventListener('click', (event) => {
    console.log(plan.getAttribute('data-tournamentid'));
    redirect(route('Front.Tournaments.Detail' , [ plan.getAttribute('data-tournamentid')  ]) );
}));



