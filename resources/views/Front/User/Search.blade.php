@extends('layouts.Front.Master')

@section('content')
    <!-- Raffle area Start -->
    <section class="raffle-filter">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="search-area">
                        <form>
                            <input type="text" id="Username" placeholder="Search Users">
                            <button type="button" id="SearchButton"><i class="fas fa-search"></i></button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="raffles-section pt-5" id="Results" style="display: none">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="winner-lists">
                        <div class="header-area">
                            <h4 class="title">
                                Users
                            </h4>
                        </div>
                        <div id="Users">

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Raffle area End -->

@endsection

@section('js')
    @vite('resources/js/Front/Search.js')

@endsection

