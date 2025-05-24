import {
    ShowToast,
    deleteSession,
    setSession,
    ReadSession, redirect, copyContent
} from "../utilities.js";
import moment from "moment/moment.js";

import {init, initData, isTMA} from "@telegram-apps/sdk";



const AffiliateButton = document.querySelector("#AffiliateButton");
const TasksButton = document.querySelector("#TasksButton");


const ReferralidCopyIcon = document.querySelector("#ReferralidCopyIcon");
const MyInviteLink = document.querySelector("#MyInviteLink");



let TelegramUser;
let User;
let UserID;
let ReferralUsers;
let ReferralCount;
let ReferralIncome;
let TournamentsJoined;
let TournamentsWinned;


const App_ENV = import.meta.env.VITE_APP_ENV;


function GetUser(UserID){
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        async: false,
        cache: false,
    });

    $.ajax({
        url: route('V1.User.Find' , UserID),
        success: function (response) {
            User = response.Data.User;
            UserID = User.id;
            ReferralUsers = response.Data.ReferralUsers;
            ReferralCount = response.Data.ReferralCount;
            ReferralIncome = response.Data.ReferralIncome;
            TournamentsJoined = response.Data.TournamentsJoined;
            TournamentsWinned = response.Data.TournamentsWinned;
        }
    });

}

function LoadReferralPlans(){
    let ReferralIncomeCoins = 0;

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'GET',
        async: false,
        cache: false,
    });

    $.ajax({
        url: route('V1.ReferralPlan.List' ),
        success: function (response) {
            $('#ReferralPlansDiv').empty()
            var lockNewRows = false;
            var CountedReferrals  = 0;
            var RemainingReferrals  = 0;

            $(response.Data.ReferralPlans).each(async function (index, ReferralPlan) {


                var PlanStatus = await CheckReferralPlanHistory(ReferralPlan.id);
                if(PlanStatus == true){
                    ReferralIncomeCoins = (ReferralIncomeCoins + ReferralPlan.Award)  ;
                    CountedReferrals += ReferralPlan.Count;
                    let row = ` <div class="rank-area">
                                        <div class="top-area">
                                            <div class="left">
                                                <img src="`+ ReferralPlan.Image +`" alt="plan image">
                                            </div>
                                            <div class="right text-center">
                                                <p><span>`+ ReferralPlan.Name +`</span></p>
                                                <p>Count : <span>`+ ReferralPlan.Count +` people</span></p>
                                                <p>Reward : <span> <i class="fa fa-coins text-warning mr-1"></i> `+ ReferralPlan.Award * 1000+` </span></p>
                                            </div>
                                        </div>
                                        <div class="bottom-area">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"> <div>Done <i class="fa fa-check text-warning"></i></div> </div>
                                            </div>
                                            <span>`+ ReferralPlan.Description +`</span>
                                        </div>
                                    </div>`;
                    $('#ReferralPlansDiv').append(row);
                }else{
                    RemainingReferrals = ReferralCount - CountedReferrals;


                    if(lockNewRows == false){
                        let percent = (RemainingReferrals * 100) / ReferralPlan.Count;

                        let row = ` <div class="rank-area">
                                        <div class="top-area">
                                            <div class="left">
                                                <img src="`+ ReferralPlan.Image +`" alt="plan image">
                                            </div>
                                            <div class="right text-center">
                                                <p><span>`+ ReferralPlan.Name +`</span></p>
                                                <p>Count : <span>`+ ReferralPlan.Count +` people</span></p>
                                                <p>Reward : <span> <i class="fa fa-coins text-warning mr-1"></i> `+ ReferralPlan.Award * 1000 +` </span></p>
                                            </div>
                                        </div>
                                        <div class="bottom-area">
                                            <div class="progress">
                                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="`+percent+`" aria-valuemin="0" aria-valuemax="100" style="width: `+percent+`%">`+ (RemainingReferrals ) +` / `+ ReferralPlan.Count +`</div>
                                            </div>
                                            <span>`+ ReferralPlan.Description +`</span>
                                        </div>
                                    </div>`;
                        $('#ReferralPlansDiv').append(row);
                        lockNewRows = true;
                    }else{
                        let percent = (RemainingReferrals * 100) / ReferralPlan.Count;

                        let row = ` <div class="rank-area">
                                        <div class="top-area">
                                            <div class="left">
                                                <img src="`+ ReferralPlan.Image +`" alt="plan image">
                                            </div>
                                            <div class="right text-center">
                                                <p><span>`+ ReferralPlan.Name +`</span></p>
                                                <p>Count : <span>`+ ReferralPlan.Count +` people</span></p>
                                                <p>Reward : <span> <i class="fa fa-coins text-warning mr-1"></i> `+ ReferralPlan.Award * 1000 +` </span></p>
                                            </div>
                                        </div>
                                        <div class="bottom-area">
                                            <div class="text-center">
                                                <span class="text-warning">you must complete previous plan!</span>
                                            </div>
                                            <span>`+ ReferralPlan.Description +`</span>
                                        </div>
                                    </div>`;
                        $('#ReferralPlansDiv').append(row);
                    }

                }



                $("#ReferralIncome").html('<i class=" fa fa-coins text-warning mr-2" > </i>' + (ReferralIncomeCoins * 1000) );




            });

        }
    });

}





async function CheckReferralPlanHistory(PlanID) {

    var functionresponse = true;
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        type: 'POST',
        async: false,
        cache: false,
    });

    $.ajax({
        url: route('V1.ReferralPlan.Check' , UserID),
        data: {
            ReferralPlanID: PlanID,
            UserID: User.id
        },
        success: function (response) {
            if(response.Data.Code == 200){
                functionresponse =  true;
            }else{
                functionresponse =  false;
            }
        }
    });

    return functionresponse;

}



function ChangeSections(Section) {

    $('.MainDashboardSections').hide(400);
    $('#' + Section + 'Section').show(400);
    $('html, body').animate({
        scrollTop: $('#MainDashboardSectionDiv').offset().top
    }, 1000);


}



AffiliateButton.addEventListener("click", () =>
    ChangeSections('Affiliate')
);

TasksButton.addEventListener("click", () =>
    ChangeSections('Tasks')
);




window.addEventListener("DOMContentLoaded", async () => {
    if(isTMA()) {
        init();
        initData.restore();
        const InitData = initData;
        TelegramUser = InitData.user();

        GetUser(TelegramUser.id)
        LoadReferralPlans()


        var ReferralLink = 'https://t.me/krypto_arena_bot?startapp=' + TelegramUser.id;

        $('#ReferralCountinTable').text(ReferralCount)
        $('#MyInviteLink').text(ReferralLink)



        $(ReferralUsers).each(async function (index, User) {


            let key = index + 1;
            let startTime = moment(User.created_at).format("YY/M/D");
            let Name = User.UserName ? User.UserName : User.FirstName + ' ' + User.LastName;
            let Image = User.Image ? User.Image : 'https://kryptoarena.fun/images/Users/DefaultProfile.png';
            let row = `<tr>
                                            <td>`+ key  +`</td>
                                            <td><a href="`+ route('Front.Profile.Show' , User.id)+`"><img style='width: 30px;height: 30px' class="rounded-pill" src="`+ Image +`" alt="user profile" > </a></td>
                                            <td>`+ Name  +`</td>
                                            <td>`+User.PlatoID+`</td>
                                            <td>`+startTime+`</td>
                                        </tr>`;


            $('#ReferralHistoryTable').append(row);

        });





        ReferralidCopyIcon.addEventListener("click", () =>
            copyContent(ReferralLink)
        );

        MyInviteLink.addEventListener("click", () =>
            copyContent(ReferralLink)
        );


        Swal.close()

    }else{
        if(App_ENV == 'local'){
            GetUser(76203510)
            LoadReferralPlans()


            var ReferralLink = 'https://t.me/krypto_arena_bot?startapp=76203510';

            $('#ReferralCountinTable').text(ReferralCount)
            $('#MyInviteLink').text(ReferralLink)



            $(ReferralUsers).each(async function (index, User) {


                let key = index + 1;
                let startTime = moment(User.created_at).format("YY/M/D");
                let Name = User.UserName ? User.UserName : User.FirstName + ' ' + User.LastName;
                let Image = User.Image ? User.Image : 'https://kryptoarena.fun/images/Users/DefaultProfile.png';
                let row = `<tr>
                                            <td>`+ key  +`</td>
                                            <td><a href="`+ route('Front.Profile.Show' , User.id)+`"><img style='width: 30px;height: 30px' class="rounded-pill" src="`+ Image +`" alt="user profile" > </a></td>
                                            <td>`+ Name  +`</td>
                                            <td>`+User.PlatoID+`</td>
                                            <td>`+startTime+`</td>
                                        </tr>`;


                $('#ReferralHistoryTable').append(row);

            });





            ReferralidCopyIcon.addEventListener("click", () =>
                copyContent(ReferralLink)
            );

            MyInviteLink.addEventListener("click", () =>
                copyContent(ReferralLink)
            );


            Swal.close()
        }
    }

});


