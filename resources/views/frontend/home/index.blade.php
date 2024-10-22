@extends('frontend.layouts.master')

@section('content')
    <!--=============================
            BANNER START
        ==============================-->
    @include('frontend.home.components.slider')
    <!--=============================
               BANNER END
           ==============================-->

             <!--=============================
               MENU ITEM START
           ==============================-->
    @include('frontend.home.components.menu-item')
    <!--=============================
               MENU ITEM END
           ==============================-->

    <!--=============================
               WHY CHOOSE START
           ==============================-->
    @include('frontend.home.components.why-choose')
    <!--=============================
               WHY CHOOSE END
           ==============================-->


    <!--=============================
               OFFER ITEM START
           ==============================-->
    @include('frontend.home.components.offer-item')

 <!--=============================
               OFFER ITEM END
           ==============================-->


    <!--=============================
              TESTIMONIAL  START
           ==============================-->
    @include('frontend.home.components.testimonial')
    <!--=============================
               TESTIMONIAL END
           ==============================-->


    <!--=============================
               COUNTER START
           ==============================-->
    @include('frontend.home.components.counter')
    <!--=============================
               COUNTER END
           ==============================-->
@endsection
