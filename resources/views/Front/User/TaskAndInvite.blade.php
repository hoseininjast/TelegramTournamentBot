@extends('layouts.Front.Master')

@section('content')

    <!-- User Menu Area Start -->
    <div class="usermenu-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="t-t-s-nav">
                        <div class="row">
                            <div class="col-6">
                                <a class="nav-link text-center mybtn mybtn-primary mybtn-pill-10   ProfileSectionButtons" id="AffiliateButton" data-Section="Affiliate"  > Invite</a>
                            </div>
                            <div class="col-6">
                                <a class="nav-link text-center mybtn mybtn-primary  mybtn-pill-10 ProfileSectionButtons" id="TasksButton" data-Section="Tasks"  > Tasks</a>
                            </div>
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
            <div class="row">
                <div class="col-xl-12" id="MainDashboardSectionDiv">
                    <main class="MainDashboardSections" id="AffiliateSection" >
                        <div class="main-box affiliate-box">
                            <div class="header-area">
                                <h4>Referral Program</h4>
                                <p>
                                    Get a lifetime reward for inviting new people!
                                </p>
                            </div>
                            <div class="referral-link-area">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="left">
                                            <h4 class="title">Copy Referral Link <i class="fas fa-file" id="ReferralidCopyIcon" ></i></h4>

                                            <div class="aff-code">
                                                <span>
                                                    <span id="MyInviteLink" onclick="copyContent(this.value)"></span>
                                                </span>


                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>

                            <div class="header-area mt-5 mb-0">
                                <h4>Referral Status</h4>
                            </div>

                            <div class="earning-info-area mt-0">

                                <div class="s-info">
                                    <img src="{{asset('Front/images/user/a1.png')}}" alt="">
                                    <div class="content">
                                        <h4 id="ReferralCountinTable">0</h4>
                                        <p>Referral Count</p>
                                    </div>
                                </div>
                                <div class="s-info">
                                    <img src="{{asset('Front/images/user/a2.png')}}" alt="">
                                    <div class="content">
                                        <h4 id="ReferralIncome">0</h4>
                                        <p>Earned Referral</p>
                                    </div>
                                </div>

                            </div>


                            <div class="user-main-dashboard">

                                <aside>
                                    <div class="about">
                                        <h4>Referral Plan</h4>
                                        <p> here you can see all our Referral plans and see your progress , also for completing each plan you will get rewards </p>

                                    </div>
                                   <div id="ReferralPlansDiv">

                                   </div>



                                </aside>

                            </div>



                            <div class="aff-table">
                                <div class="header-area">
                                    <h4>Referral History</h4>
                                </div>
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Image</th>
                                            <th>User Name</th>
                                            <th>Plato ID</th>
                                            <th>Date</th>
                                        </tr>
                                        </thead>
                                        <tbody id="ReferralHistoryTable">


                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </main>

                    <main class="MainDashboardSections" id="TasksSection" style="display: none">
                        <div class="main-box affiliate-box">
                            <div class="header-area">
                                <h4>Tasks</h4>
                                <p>
                                    do a task and get rewards.
                                </p>
                            </div>



                            <div class="user-main-dashboard">

                                <aside>
                                    <div class="about">
                                        <h4>Deposit Tasks</h4>
                                        <p>on your deposit you will get a bonus charge.</p>

                                    </div>
                                    <div id="ReferralPlansDiv">
                                        <div class="rank-area">
                                            <div class="top-area">
                                                <div class="left">
                                                    <img src="{{asset('images/Rank/Bronze.png')}}" alt="plan image">
                                                </div>
                                                <div class="right text-center">
                                                    <p><span>First Deposit</span></p>
                                                    <p>Condition : <span>You must at least deposit $3</span></p>
                                                    <p>Reward : <span> <i class="fa fa-coins text-warning mr-1"></i>20% Bonus </span></p>
                                                </div>
                                            </div>
                                            <div class="bottom-area">
                                                <div class="text-center">
                                                    <span class="text-warning">task is open and you can start it</span>
                                                </div>
                                                <span>on your first deposit you will get 20% bonus</span>

                                                <a href="{{route('Front.Profile.Wallet')}}" class="btn btn-primary btn-sm btn-block mt-2">Start</a>

                                            </div>
                                        </div>
                                        <div class="rank-area">
                                            <div class="top-area">
                                                <div class="left">
                                                    <img src="{{asset('images/Rank/Silver.png')}}" alt="plan image">
                                                </div>
                                                <div class="right text-center">
                                                    <p><span>Second Deposit</span></p>
                                                    <p>Condition : <span>You must at least deposit $6</span></p>
                                                    <p>Reward : <span> <i class="fa fa-coins text-warning mr-1"></i>30% Bonus </span></p>
                                                </div>
                                            </div>
                                            <div class="bottom-area">
                                                <div class="text-center">
                                                    <span class="text-warning">you must complete previous task!</span>
                                                </div>
                                                <span>on your second deposit you will get 30% bonus</span>
                                            </div>
                                        </div>
                                        <div class="rank-area">
                                            <div class="top-area">
                                                <div class="left">
                                                    <img src="{{asset('images/Rank/Bronze.png')}}" alt="plan image">
                                                </div>
                                                <div class="right text-center">
                                                    <p><span>Third Deposit</span></p>
                                                    <p>Condition : <span>You must at least deposit $9</span></p>
                                                    <p>Reward : <span> <i class="fa fa-coins text-warning mr-1"></i>40% Bonus </span></p>
                                                </div>
                                            </div>
                                            <div class="bottom-area">
                                                <div class="text-center">
                                                    <span class="text-warning">you must complete previous task!</span>
                                                </div>
                                                <span>on your third deposit you will get 40% bonus</span>
                                            </div>
                                        </div>
                                    </div>



                                </aside>

                            </div>




                        </div>
                    </main>


                </div>
            </div>
        </div>
    </section>




    <!-- User Main Content Area End -->
    <div class="forged-fixed-bottom-bar"></div>



@endsection

@section('js')
    @vite('resources/js/Front/TaskAndInvite.js')
@endsection

