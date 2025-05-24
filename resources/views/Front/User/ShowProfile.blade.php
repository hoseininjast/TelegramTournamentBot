@extends('layouts.Front.Master')

@section('content')
    <!-- Breadcrumb Area Start -->
    <section class="breadcrumb-area gamer-profile pt-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="bc-content">
                        <div class="left">
                            <section class="gamer-profile-top BackgroundImageUnset">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-lg-12 text-center">
                                            <div class="gamer-profile-top-inner">
                                                <div class="profile-photo">
                                                    <div class="img">
                                                        <img id="ProfileImage" src="{{$User->Image}}" alt="" class="rounded-pill" />
                                                    </div>
                                                </div>
                                            </div>
                                            <h3 id="ProfileUsername"> {{$User->UserName}} </h3>
                                            <p id="ProfileJoinDate"> {{\Carbon\Carbon::parse($User->created_at)->diffInDays()}} Days</p>

                                            <div class="d-flex justify-content-around">
                                                <button href="#" class="mybtn mybtn-primary mybtn-pill-10" onclick="ShowComingSoon()"> <i class="fa fa-user-plus"></i> Follow</button>
                                                <button class="mybtn mybtn-primary mybtn-pill-10" onclick="ShowComingSoon()"> <i class="fa fa-envelope"></i> Message</button>
                                                <button class="mybtn mybtn-primary mybtn-pill-25" id="GiftButton" data-toggle="modal" data-target="#GiftModal"> <i class="fa-solid fa-hand-holding-heart"></i> Gift</button>


                                            </div>



                                        </div>
                                    </div>
                                </div>
                            </section>

                        </div>
                        <div class="right">
                            <div class="player-wrapper">
                                <span>Stars</span>
                                <h6 id="Championship">{{$User->Stars()->count()}}</h6>
                            </div>
                            <ul>
                                <li>
                                    <a href="#">
                                        <img src="{{asset('Front/images/gamer/c2.png')}}" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="{{asset('Front/images/ui/gold.png')}}" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="{{asset('Front/images/ui/silver.png')}}" alt="">
                                    </a>
                                </li>
                                <li>
                                    <a href="#">
                                        <img src="{{asset('Front/images/ui/bronze.png')}}" alt="">
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Area End -->

    <!-- Gamer Profile area Start -->
    <section class="gamer-profile-top">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="gamer-profile-top-inner">
                        <div class="g-p-t-counters row">
                            <div class="g-p-t-single-counter">
                                <div class="img">
                                    <img src="{{asset('Front/images/gamer/c1.png')}}" alt="">
                                </div>
                                <div class="content">
                                    <h4 id="TournamentsJoined">{{$User->Tournaments()->count()}}</h4>
                                    <span>Total Tours</span>
                                </div>
                            </div>

                            <div class="g-p-t-single-counter">
                                <div class="img">
                                    <img src="{{asset('Front/images/gamer/a1.png')}}" alt="">
                                </div>
                                <div class="content">
                                    <h4 id="TotalGames">{{$User->TotalGames()}}</h4>
                                    <span>Total Games</span>
                                </div>
                            </div>

                            <div class="g-p-t-single-counter">
                                <div class="img">
                                    <img src="{{asset('Front/images/gamer/c2.png')}}" alt="">
                                </div>
                                <div class="content">
                                    <h4 id="TournamentsWinned">{{$User->TournamentsWon()->count()}}</h4>
                                    <span>Win Ratio</span>
                                </div>
                            </div>
                            <div class="g-p-t-single-counter">
                                <div class="img">
                                    <img src="{{asset('Front/images/gamer/c3.png')}}" alt="">
                                </div>
                                <div class="content">
                                    <h4 id="ReferralCount">{{$User->Referrals()->count()}}</h4>
                                    <span>User's invited</span>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Gamer Profile  area End -->

    <!-- User Menu Area Start -->
    <div class="usermenu-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="usermenu-inner">
                        <div class="left-area">

                            <ul>
                                <li>
                                    <a data-Section="Overview" id="OverviewButton"  class="ProfileSectionButtons active">Overview</a>
                                </li>
                                <li>
                                    <a data-Section="Income" id="IncomeButton" class="ProfileSectionButtons "  >Income</a>
                                </li>
                                <li>
                                    <a data-Section="Transactions" id="TransactionsButton"  class="ProfileSectionButtons " >Transactions</a>
                                </li>
                                <li>
                                    <a data-Section="PlayHistory" id="PlayHistoryButton"  class="ProfileSectionButtons " >Play History</a>
                                </li>
                                <li>
                                    <a data-Section="Achievement" id="AchievementButton" class=" "  onclick="ShowComingSoon()" >Achievement</a>
                                </li>
                                <li>
                                    <a data-Section="GroupsClans" id="GroupsClansButton" class=" "  onclick="ShowComingSoon()" >Groups & Clans</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- User Menu Area End -->

    <!-- User Main Content Area Start -->
    <section class="user-main-dashboard">
        <div class="container">
            <div  id="MainDashboardSectionDiv">
                <div class="MainDashboardSections" id="Overview" >
                    <div class="row">
                        <div class="col-xl-3 col-lg-4">
                            <aside>
                                <div class="about">
                                    <h4>About Me</h4>
                                    <p>
                                        {{$User->Bio ?? 'not set'}}
                                    </p>
                                    <ul>
                                        <li>
                                            <p><i class="fas fa-map-marked-alt"></i> @if($User->Country != null || $User->City != null) {{$User->Country .' ' . $User->City}} @else not set @endif</p>
                                        </li>
                                        <li>
                                            <p> <i class="fas fa-calendar-alt"></i> Member Since {{$User->created_at->format('d M Y')}}</p>
                                        </li>
                                    </ul>
                                </div>
                                <div class="rank-area">
                                    <div class="top-area">
                                        <div class="left">
                                            <img src="{{asset('images/Levels/1.png')}}" alt="">
                                        </div>
                                        <div class="right">
                                            <p>Rank: <span>1</span></p>
                                        </div>
                                    </div>
                                    <div class="bottom-area">
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100" style="width: 10%">10%</div>
                                        </div>
                                        <a href="#" onclick="ShowComingSoon()">View all Ranks <i class="fas fa-chevron-right"></i></a>
                                    </div>
                                </div>
                                <div class="achievment-area">
                                    <div class="header-area">
                                        <h4>Achievements</h4>
                                        <a href="#" onclick="ShowComingSoon()">All Rewards <i class="fas fa-chevron-right"></i></a>
                                    </div>
                                    <ul>
                                        <li>
                                            <div class="s-a">
                                                <img src="{{asset('Front/images/gamer/a1.png')}}" alt="">
                                                <span>Tournaments <br>
											Joined</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="s-a">
                                                <img src="{{asset('Front/images/gamer/a2.png')}}" alt="">
                                                <span>Tournaments <br>
											Winned</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="s-a">
                                                <img src="{{asset('Front/images/gamer/a3.png')}}" alt="">
                                                <span>Play <br>
											1 Game</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="s-a">
                                                <img src="{{asset('Front/images/gamer/a4.png')}}" alt="">
                                                <span>Login <br>
											Daily</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="s-a">
                                                <img src="{{asset('Front/images/gamer/a5.png')}}" alt="">
                                                <span>10 Tournaments <br>
											Won</span>
                                            </div>
                                        </li>
                                        <li>
                                            <div class="s-a">
                                                <img src="{{asset('Front/images/gamer/a6.png')}}" alt="">
                                                <span>10 Friends <br>
											Referred</span>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </aside>
                        </div>
                        <div class="col-xl-9 col-lg-8">
                            <main>
                                <div class="main-box">
                                    <div class="header-area">
                                        <h4>Games Playing</h4>
                                    </div>
                                    <div class="table-responsive">
                                        <table class="table table-borderless">
                                            <tbody>
                                            @foreach(\App\Models\Games::all() as $game)
                                                @php
                                                    $allTournamentsCount = count($User->JoinedTournamentsWithGame($game->id));
                                                    $JoinedTournaments = $User->TournamentsWonWithGame($game->id)->count();
                                                    if($JoinedTournaments != 0){
                                                        $WinRatio = ($JoinedTournaments * 100) / $allTournamentsCount;
                                                    }else{
                                                        $WinRatio = 0;
                                                    }
                                                @endphp
                                                <tr>
                                                    <td>
                                                        <div class="game-info">
                                                            <img src="{{$game->Image}}" alt="">
                                                            <div class="content">
                                                                <h6>{{$game->Name}}</h6>
                                                                <span>{{$game->Description}}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="ratio">
                                                            <span>Win Ratio</span>
                                                            <h4>{{number_format($WinRatio , 0)}}%</h4>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="ratio">
                                                            <span>Win Count</span>
                                                            <h4>{{$JoinedTournaments}}</h4>
                                                        </div>
                                                    </td>
                                                </tr>
                                            @endforeach


                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </main>
                        </div>
                    </div>
                </div>

                <div class="MainDashboardSections" id="Income"  style="display: none">
                    <div class="row">
                        <div class="col-xl-3 col-lg-4">
                            <div class="erning-box">
                                <div class="left">
                                    <h4>${{$User->PaymentHistory()->where('Currency' , 'KAT')->where('Type' , 'In')->sum('Amount')}}</h4>
                                    <p>
                                        Total Win
                                    </p>
                                </div>
                                <div class="right">
                                    <img src="{{asset('Front/images/g1.png')}}" alt="">
                                </div>
                            </div>
                            <div class="erning-box">
                                <div class="left">
                                    <h4>${{$User->PaymentHistory()->where('Currency' , 'KAT')->max('Amount')}}</h4>
                                    <p>
                                        The Biggest Win
                                    </p>
                                </div>
                                <div class="right">
                                    <img src="{{asset('Front/images/g2.png')}}" alt="">
                                </div>
                            </div>
                            <div class="erning-box">
                                <div class="left">
                                    <h4>${{$User->PaymentHistory()->where('Currency' , 'KAT')->where('Type' , 'Out')->where('TransactionHash' , '!=' , null)->sum('Amount')    }}</h4>
                                    <p>
                                        Withdrawn
                                    </p>
                                </div>
                                <div class="right">
                                    <img src="{{asset('Front/images/g3.png')}}" alt="">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="MainDashboardSections" id="Transactions"  style="display: none">

                    <div class="main-box affiliate-box">












                        <div class="aff-table">
                            <div class="header-area">
                                <h4>Transaction History</h4>
                            </div>
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Description</th>
                                        <th>Amount</th>
                                        <th>Type</th>
                                        <th>Currency</th>
                                        <th>Date</th>

                                    </tr>
                                    </thead>
                                    <tbody id="">
                                    @foreach($User->PaymentHistory as $history)

                                        @if($history->TransactionHash)
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$history->Description}} : <a href="{{$history->TransactionHash}}" target="_blank">PolygonScan</a> </td>
                                                <td>${{$history->Amount}}</td>
                                                <td>{{$history->Type}}</td>
                                                <td>{{$history->Currency}}</td>
                                                <td>{{\Carbon\Carbon::parse($history->created_at)->format('Y/M/d')}}</td>

                                            </tr>
                                        @else
                                            <tr>
                                                <td>{{$loop->iteration}}</td>
                                                <td>{{$history->Description}}</td>
                                                <td>${{$history->Amount}}</td>
                                                <td>{{$history->Type}}</td>
                                                <td>{{$history->Currency}}</td>
                                                <td>{{\Carbon\Carbon::parse($history->created_at)->format('Y/M/d')}}</td>

                                            </tr>
                                        @endif

                                    @endforeach

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>


                </div>

                <div class="MainDashboardSections" id="PlayHistory"  style="display: none">
                    <main>
                        <div class="main-box">
                            <div class="header-area">
                                <h4>Tournaments</h4>
                            </div>
                            <div class="table-responsive">
                                <table class="table table-borderless">
                                    <tbody>
                                    @foreach($User->JoinedTournaments() as $tournament)
                                        <tr>
                                            <td>
                                                <div class="game-info">
                                                    <img src="{{$tournament->Image}}" alt="">
                                                    <div class="content">
                                                        <h6>{{$tournament->Name}}</h6>
                                                        <span>{{$tournament->Description}}</span>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <a href="{{route('Front.Tournaments.Detail' , $tournament->id)}}" class="mybtn mybtn-primary mybtn-pill-20">Details</a>
                                            </td>
                                        </tr>
                                    @endforeach


                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </main>
                </div>


            </div>
        </div>
    </section>

    <div class="modal" id="GiftModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Gift</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="d-flex flex-column justify-content-center text-center ">
                        <input type="hidden" id="ReceiverUserID" value="{{$User->id}}">
                        <input type="hidden" id="ReceiverUserUserNameVal" value="{{$User->UserName}}">
                        <div class="col-12">
                            <img width="100" src="{{$User->Image ? $User->Image : 'https://kryptoarena.fun/images/Users/DefaultProfile.png' }}" alt="User Image" id="ReceiverUserImage" class="rounded-pill" />
                        </div>
                        <div class="col-12 mt-3">
                            <h4 id="ReceiverUserUserName">{{$User->UserName}}</h4>
                        </div>
                    </div>




                    <hr style="border: 1px solid white;" >
                    <div class="form-group mt-5">

                        <label for="">Amount</label>
                        <input type="text" id="TransferAmount" name="TransferAmount" class="form-control GiftTransferAmount" placeholder="Enter KAC Amount" min="2000">

                        <span class="d-block mt-3">  Fee : <span id="TransferFee">0</span> KAC </span>
                        <span class="d-block"> Total : <span id="TotalAmount">0</span> KAC </span>

                        <span class="d-block"> min transfer is 2000 KAC </span>


                    </div>



                    <button type="button" id="SubmitTransferButton" class="mybtn mybtn-success mybtn-pill-90">Transfer</button>


                </div>

            </div>
        </div>
    </div>




    <!-- User Main Content Area End -->
    <div class="forged-fixed-bottom-bar"></div>



@endsection

@section('js')
    @vite('resources/js/Front/Profile.js')
    <script>
        function ShowComingSoon(){
            Swal.fire({
                icon: 'info',
                text: 'this section will coming soon',
            });
        }

    </script>
@endsection

