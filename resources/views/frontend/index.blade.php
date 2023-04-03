@extends('layouts.frontend')

@section('title')
    Get Your Product Picked Up and Purchased
@endsection

@section('meta_description', 'From concept to completion we expertly design, manufacture and install retail visual merchandising projects for clients worldwide.')
    

@section('content')
    @include('frontend/section/hero')

    @include('frontend/section/service')

    @include('frontend/section/project')

    @include('frontend/section/team')
<!--
    <section class="instagram_section" id="instafeed">
    </section> -->

@endsection

@section('scrolltotop')
    <div class="scroll_down">
        <p>SCROLL</p>
        <img src="https://dd63psqcl1xsv.cloudfront.net/images/scroll_down.svg" alt="Scroll Down">
    </div>
@endsection
