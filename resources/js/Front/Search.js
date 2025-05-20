import {
    ShowToast,
    redirect, ShowAlert
} from "../utilities.js";
import moment from "moment/moment.js";
import {init, initData, isTMA} from "@telegram-apps/sdk";



const SearchButton = document.querySelector("#SearchButton");


function Search(){
    var Username = $('#Username').val();

    if(Username == null){
        ShowAlert('warning' , 'please enter the username for searching');
    }else{




        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            type: 'POST',
            async: false,
            cache: false,
        });

        $.ajax({
            url: route('V1.User.SearchAll' ),
            data: {
                UserName:   Username
            },
            success: function (response) {

                if(response.Data.Code == 1){
                    $('#Results').show(400)

                    $('#Users').empty()

                    $(response.Data.Users).each(async function (index, User) {

                        var Image = User.Image ? User.Image : 'https://kryptoarena.fun/images/Users/DefaultProfile.png';
                        let Name = User.UserName ? User.UserName : User.FirstName + ' ' + User.LastName;

                        const currentDate = moment(new Date(), 'YYYY-MM-DD');
                        var endDate = moment(User.created_at, "YYYY-MM-DD");
                        var days = currentDate.diff(endDate, 'days')


                        let row = `<div class="single-winner">
                            <div class="img p-3">
                                <img src="`+Image+`" class="User-Image rounded-pill" alt="">
                            </div>
                            <div class="content">
                                <div class="top-content">
                                    <div class="lc">
                                        <h6>`+ Name +`</h6>
                                        <span>`+days+` Days</span>
                                    </div>
                                    <a href="`+ route('Front.Profile.Show' , User.id)+`" class="mybtn mybtn-primary mybtn-pill-10">Profile</a>
                                </div>
                            </div>
                        </div>`;


                        $('#Users').append(row);

                    });

                }else{

                }

            }
        });



    }

}


SearchButton.addEventListener("click", () =>
    Search()
);




