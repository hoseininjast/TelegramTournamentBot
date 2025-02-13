@extends('layouts.Front.Master')
@section('content')
    <section class="games-filter">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="filter-wrapp">
                        <div class="left-area">
                            <a href="#" class="mybtn2"><i class="far fa-sun"></i>Select For you</a>
                            <a href="#" class="mybtn2"><i class="fas fa-dice-five"></i>New Games</a>
                            <a href="#" class="mybtn2"><i class="far fa-heart"></i>Most Popular</a>
                        </div>
                        <div class="right-area">
                            <form action="#">
                                <input type="text" placeholder="Search Games">
                                <button type="submit"><i class="fas fa-search"></i></button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
