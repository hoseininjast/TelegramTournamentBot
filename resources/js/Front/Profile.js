import {
    ShowToast,
    deleteSession,
    setSession,
    ReadSession, redirect, copyContent
} from "../utilities.js";
import moment from "moment/moment.js";

import {init, initData, isTMA} from "@telegram-apps/sdk";



const UpdateProfileButton = document.querySelector("#UpdateProfileButton");

const AffiliateButton = document.querySelector("#AffiliateButton");
const SettingButton = document.querySelector("#SettingButton");


const ReferralidCopyIcon = document.querySelector("#ReferralidCopyIcon");
const MyInviteLink = document.querySelector("#MyInviteLink");



let TelegramUser;
let User;
let ReferralUsers;
let ReferralCount;
let ReferralIncome;
let TournamentsJoined;
let TournamentsWinned;


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
            ReferralUsers = response.Data.ReferralUsers;
            ReferralCount = response.Data.ReferralCount;
            ReferralIncome = response.Data.ReferralIncome;
            TournamentsJoined = response.Data.TournamentsJoined;
            TournamentsWinned = response.Data.TournamentsWinned;
        }
    });

}

function LoadReferralPlans(){
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
                                                <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%"> <div>Done <i class="fa fa-check text-success"></i></div> </div>
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


}

function ShowLoading(){
    Swal.fire({
        title: "Updating...",
        html: "Please wait a moment"
    });
    Swal.showLoading()
}

AffiliateButton.addEventListener("click", () =>
    ChangeSections('Affiliate')
);

SettingButton.addEventListener("click", () =>
    ChangeSections('Setting')
);

UpdateProfileButton.addEventListener("click", () =>
    ShowLoading()
);




window.addEventListener("DOMContentLoaded", async () => {
    if(isTMA()) {
        init();
        initData.restore();
        const InitData = initData;
        TelegramUser = InitData.user();

        GetUser(TelegramUser.id)
        LoadReferralPlans()
        $('#ProfileUsername').text(User.UserName)

        const currentDate = moment(new Date(), 'YYYY-MM-DD');
        var endDate = moment(User.created_at, "YYYY-MM-DD");
        var days = currentDate.diff(endDate, 'days')

        var ReferralLink = 'https://t.me/krypto_arena_bot?startapp=' + TelegramUser.id;

        $('#ProfileJoinDate').text(days + ' Days')
        $('#ReferralCountinTable').text(ReferralCount)
        $('#ReferralCount').text(ReferralCount)
        $('#TournamentsJoined').text(TournamentsJoined)
        $('#TournamentsWinned').text(TournamentsWinned)
        $('#Championship').text(TournamentsWinned)

        $('#UserID').val(User.id)
        $('#UserName').val(User.UserName)
        $('#PlatoID').val(User.PlatoID)
        $('#WalletAddress').val(User.WalletAddress)
        $('#TonWalletAddress').val(User.TonWalletAddress)
        $('#PlatoID').val(User.PlatoID)
        $('#MyInviteLink').text(ReferralLink)

        $("#ReferralIncome").text('$' + ReferralIncome);

        $(ReferralUsers).each(async function (index, User) {


            let key = index + 1;
            let startTime = moment(User.created_at).format("YY/M/D");
            let Name = User.UserName ? User.UserName : User.FirstName + ' ' + User.LastName;
            let Image = User.Image ? User.Image : 'https://kryptoarena.fun/images/Users/DefaultProfile.png';
            let row = `<tr>
                                            <td>`+ key  +`</td>
                                            <td><img style='width: 30px;height: 30px' class="rounded-pill" src="`+ Image +`" alt="user profile" ></td>
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



        $('#ProfileImage').attr('src' , User.Image)

        Swal.close()

    }else{
        GetUser(76203510)
        LoadReferralPlans()
    }

});


