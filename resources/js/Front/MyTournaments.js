import {
    redirect,
} from "../utilities.js";
import {initData , isTMA} from "@telegram-apps/sdk";
import moment from "moment";

const PendingStatusButton = document.querySelector("#StatusPending");
const RunningStatusButton = document.querySelector("#StatusRunning");
const FinishedStatusButton = document.querySelector("#StatusFinished");


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
            UserID : User.id,
            Mode : Mode
        },
        success: function (response) {
            $('#TournamentsDiv').empty()
            $(response.Data.Tournaments).each(async function (index, Tournament) {
                let awards = '';
                $(Tournament.Awards).each(async function (index, Award) {
                    var image = index.Parse
                    if(index <= 3){
                        awards += `<div class="col-4">
                                    <div class="single-prize">
                                        <img src="/Front/images/prize/`+( parseInt(index) + 1) +`.png" alt="">
                                        <span>$`+Award+`</span>
                                    </div>
                                </div>`;
                    }else{
                        awards += `<span>$` + Award+ `</span>`;
                    }

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
                                                    <button type="button"  class="btn btn-primary btn-lg rounded-pill TournamentDetail" data-TournamentID="`+Tournament.id+`">Details</button>
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
													<h5>Prize's</h5>
													<div class="row">
													` + awards+ `
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

            const TournamentDetailButtons = document.querySelectorAll(".TournamentDetail");


            TournamentDetailButtons.forEach((plan) => plan.addEventListener('click', (event) => {
                redirect(route('Front.Tournaments.Detail' , [ plan.getAttribute('data-TournamentID')  ]) );
            }));

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





