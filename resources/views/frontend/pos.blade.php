@extends('layouts.frontend')

@section('title')
    Point of Purchase Displays From Concept To Completion
@endsection
@section('meta_description', 'Point of Purchase (POP) displays that enhance your customer\'s shopping experience and drive sales for your business.')
@section('content')
    @include('frontend/section/pos-hero')

    @include('frontend/section/pos-displays')

    @include('frontend/section/client')

    @include('frontend/section/pos-project')

    @include('frontend/section/pos-tour')

    @include('frontend/section/contact-us')

    <!-- <section class="instagram_section" id="instafeed">
    </section> -->

@endsection

@section('scrolltotop')
    <div class="scroll_down">
        <p>SCROLL</p>
        <img src="https://dd63psqcl1xsv.cloudfront.net/images/scroll_down.svg" alt="Scroll Down">
    </div>
@endsection
