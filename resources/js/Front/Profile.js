
import {init, initData, isTMA} from "@telegram-apps/sdk";
import {ShowAlert} from "../utilities.js";



const ProfileSectionButtons = document.querySelectorAll(".ProfileSectionButtons");

const TransferAmountInput = document.querySelector("#TransferAmount");
const SubmitTransferButton = document.querySelector("#SubmitTransferButton");



let TelegramUser;
let User;


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
        }
    });

}

function ChangeSections(Section) {

    $('.MainDashboardSections').hide(400);
    $('.ProfileSectionButtons').removeClass('active');
    $('#' + Section).show(400);
    $('#' + Section + 'Button').addClass('active');
    $('html, body').animate({
        scrollTop: $('#MainDashboardSectionDiv').offset().top
    }, 1000);


}

function MakeTransfer(){
    var TransferAmount = $('#TransferAmount').val();
    var ReceiverUserID = $('#ReceiverUserID').val();
    var ReceiverUserUserName = $('#ReceiverUserUserNameVal').val();


    var SenderBalance = parseFloat(User.Charge).toFixed(2) * 1000;
    TransferAmount =  parseInt(TransferAmount)
    var Fee = ( (TransferAmount / 100) * 10);
    var NeededBalance = TransferAmount + Fee;

    if(TransferAmount < 2000){
        ShowAlert('error' , 'Your entered amount is under minimum , You must move at least 2000 KAC.');
        return;
    }
    if(SenderBalance < NeededBalance){
        ShowAlert('error' , 'You do not have enough KAC to transfer.');
    }else{
        Swal.fire({
            title: "Are you sure?",
            html: `
    Are you sure to Transfer with this details?<br>
    Amount : <b>`+TransferAmount+`</b> KAC <br>
    Fee : <b>`+Fee+`</b> KAC <br>
    Total : <b>`+NeededBalance+`</b> KAC <br>
    Receiver User : <b>`+ReceiverUserUserName+`</b>
  `,
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#6aff39",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes , Transfer Now !",
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
                    url: route('V1.Payment.Transfer'),
                    data: {
                        UserID: User.id,
                        Amount: TransferAmount,
                        ReceiverUserID: ReceiverUserID,
                    },
                    success: function (response) {
                        if (response.Data.Code == 1 ) {
                            ShowAlert('success' , response.Data.Message);
                            setTimeout(
                                function() {
                                    window.location.reload();
                                }, 1000);
                        }else {
                            ShowAlert('error' , response.Data.Message);
                        }

                    }
                });
            }
        });
    }


}

function CalculateFeeAndTotal(){
    var Amount = $('#TransferAmount').val();
    if(Amount == 0 || Amount == null){
        $('#TransferFee').text(0).removeClass('text-danger').addClass('text-success')
        $('#TotalAmount').text(0).removeClass('text-danger').addClass('text-success')
    }else{
        var Amount = parseInt(Amount)




        if(Amount > (User.Charge * 1000 )){
            ShowAlert('error' , 'You do not have enough KAC to transfer.');
            var Fee =  ( (Amount / 100) * 10 );
            var Total = Amount + Fee ;

            $('#TransferFee').text(Fee).addClass('text-danger').removeClass('text-success')
            $('#TotalAmount').text(Total).addClass('text-danger').removeClass('text-success')
        }else{
            var Fee =  ( (Amount / 100) * 10 );
            var Total = Amount + Fee ;

            $('#TransferFee').text(Fee).removeClass('text-danger').addClass('text-success')
            $('#TotalAmount').text(Total).removeClass('text-danger').addClass('text-success')
        }

    }





}

ProfileSectionButtons.forEach((button) => button.addEventListener('click', (event) => {
    ChangeSections(button.getAttribute('data-Section'))
}));



SubmitTransferButton.addEventListener("click", () =>
    MakeTransfer()
);

TransferAmountInput.addEventListener("keyup", (element) =>
    CalculateFeeAndTotal()
);


window.addEventListener("DOMContentLoaded", async () => {
    if(isTMA()) {
        init();
        initData.restore();
        const InitData = initData;
        TelegramUser = InitData.user();
        GetUser(TelegramUser.id)
    }else{
        if(App_ENV == 'local'){
            GetUser(76203510)
        }

    }

});


