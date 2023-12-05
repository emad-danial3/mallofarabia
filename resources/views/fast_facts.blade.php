@extends('layouts.app')
@section('style')
    <style>
       .title h2{
          color:rgba(25, 151, 183, 1);
       }
        .blog-section .blog-box{
           border-radius: 30px;
       }
        .blog-section .blog-box .blog-box-image{
           border-radius: 30px;
       }
     .ratio_45{
       box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.15);
border-radius: 16px;
       }

     .slick-dots{
         display: none;
     }
    </style>
@endsection
@section('content')


    <!-- Home Section Start -->
    <section class="home-section-2 home-section-bg pt-0 overflow-hidden">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-12">
                    <div class="slider-animate">
                        <div>
                            <div class="home-contain rounded-0 p-0 background-size-cover">
                                <img src="../assets/images/images/fast_factsbg.png"
                                     class="img-fluid bg-img blur-up lazyload" alt="">
                                <div class="home-detail home-big-space p-center-left home-overlay position-relative">
                                    <div class="container-fluid-lg">
                                        <div>

                                            <h1 class="heding-2 text-white">{{trans('website.FAST FACTS',[],session()->get('locale'))}}</h1>
                                            <h3 class="content-2 text-white w-50"> {{trans('website.if you have free',[],session()->get('locale'))}}</h3>

                                        </div>
                                    </div>
                                </div>
                                  <h5 class="text-center mx-auto text-white pb-4">{{trans('website.We make 350+ high-quality',[],session()->get('locale'))}}</h5>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Home Section End -->


{{--    <!-- Banner Section Start -->--}}
{{--    <section class="banner-section mb-4">--}}
{{--        <div class="container-fluid-lg">--}}
{{--            <div class="row">--}}
{{--                <div class="col-12">--}}
{{--                    <h2 class="my-3 text-dark-mint">Our Products</h2>--}}
{{--                </div>--}}
{{--                <div class="col-12">--}}


{{--                    <div class="accordion" id="accordionExample">--}}
{{--                        <div class="accordion-item">--}}
{{--                            <h2 class="accordion-header" id="headingOne1">--}}
{{--                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOn1" aria-expanded="true" aria-controls="collapseOn1">--}}
{{--                                  Why haven’t i heard of 4U Netting Hub products ?--}}
{{--                                </button>--}}
{{--                            </h2>--}}
{{--                            <div id="collapseOn1" class="accordion-collapse collapse show" aria-labelledby="headingOne1" data-bs-parent="#accordionExample">--}}
{{--                                <div class="accordion-body text-secondary w-75">--}}
{{--                                    When you place an order of 250 EGP paid value, you will get free--}}
{{--                                    shipping.--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="accordion-item">--}}
{{--                            <h2 class="accordion-header" id="headingThree1">--}}
{{--                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThre3" aria-expanded="false" aria-controls="collapseThre3">--}}
{{--                                  Free shipping ?--}}
{{--                                </button>--}}
{{--                            </h2>--}}
{{--                            <div id="collapseThre3" class="accordion-collapse collapse" aria-labelledby="headingThree1" data-bs-parent="#accordionExample">--}}
{{--                                <div class="accordion-body">--}}

{{--                                    Cashback Quarterly 10% Up to 15% and annually cashback in your Bank Misr--}}
{{--                                    Account--}}
{{--                                    How?--}}
{{--                                    -When you reach total sales 2000 EGP within 3 months, an account will be--}}
{{--                                    opened with your name at Bank Misr and you will get 200 EGP as cashback--}}
{{--                                    in your bank account.--}}
{{--                                    - When you reach total sales 4000 EGP within 3 months, an account will--}}
{{--                                    be opened with your name at bank Misr and you will get 400 EGP as--}}
{{--                                    cashback in your bank account.--}}

{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}

{{--                                <div class="accordion-item">--}}
{{--                                    <h2 class="accordion-header" id="heading5">--}}
{{--                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">--}}
{{--                                          Cashback ?--}}
{{--                                        </button>--}}
{{--                                    </h2>--}}
{{--                                    <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#accordionExample">--}}
{{--                                        <div class="accordion-body">--}}

{{--                                                - Start with yourself and add 5 new members in your personal group every--}}
{{--                                                month.--}}
{{--                                                -Train each member in your group to add another 5 members.--}}
{{--                                                - Follow up with your members so that each member makes a monthly order--}}
{{--                                                minimum 250 EGP--}}

{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="accordion-item">--}}
{{--                                    <h2 class="accordion-header" id="heading6">--}}
{{--                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">--}}
{{--                                            A Real opportunity to increase your income with EVA's monthly commissions ?--}}
{{--                                        </button>--}}
{{--                                    </h2>--}}
{{--                                    <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#accordionExample">--}}
{{--                                        <div class="accordion-body">--}}

{{--                                                - A monthly bonus when you add members in your personal group (1st--}}
{{--                                                generation G1) and add members in your next group (2nd generation G2)--}}
{{--                                                according to certain segments and conditions to get a real and very--}}
{{--                                                special income on a monthly basis .--}}

{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="accordion-item">--}}
{{--                                    <h2 class="accordion-header" id="heading7">--}}
{{--                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse7" aria-expanded="false" aria-controls="collapse7">--}}
{{--                                            Important tips for developing and managing your business successfully ?--}}
{{--                                        </button>--}}
{{--                                    </h2>--}}
{{--                                    <div id="collapse7" class="accordion-collapse collapse" aria-labelledby="heading7" data-bs-parent="#accordionExample">--}}
{{--                                        <div class="accordion-body">--}}

{{--                                                - Continuous communication with your group members to encourage them to--}}
{{--                                                place at least one order each month.--}}
{{--                                                - Make sure to communicate with your group leader to benefit from his--}}
{{--                                                experience.--}}
{{--                                                - Send the catalogue to everyone you know through direct communication--}}
{{--                                                or through different social media platforms.--}}
{{--                                                - Continue to offer the idea of participating in your group to all you--}}
{{--                                                know and offer the idea of increasing the opportunity of income for--}}
{{--                                                them.--}}

{{--                                            </strong>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                                <div class="accordion-item">--}}
{{--                                    <h2 class="accordion-header" id="heading8">--}}
{{--                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse8" aria-expanded="false" aria-controls="collapse8">--}}
{{--                                          - Other benefits for members and sales leaders ?--}}
{{--                                        </button>--}}
{{--                                    </h2>--}}
{{--                                    <div id="collapse8" class="accordion-collapse collapse" aria-labelledby="heading8" data-bs-parent="#accordionExample">--}}
{{--                                        <div class="accordion-body">--}}

{{--                                                - Every member will get a free catalog for each new version.--}}
{{--- Members will get his monthly commission during the first week of the following month.--}}
{{--- Members can place the order through the website or mobile application or through the hotline or go to our nearest branch.--}}
{{---Every member can get a monthly report showing his sales and the sales of his group of the 1st and 2nd generation to help him in good follow-up and get the highest possible income.--}}
{{--- Participate in some vital exhibitions and important events with the company and invite sales leaders to participate without incurring any expenses to help them attract new members and present the idea of income opportunity professionally.--}}


{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}

{{--                    </div>--}}


{{--                </div>--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
{{--    <!-- Banner Section End -->--}}


    <!-- Banner Section Start -->
    <section class="banner-section ">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <h2 class="my-3 text-dark-mint">{{trans('website.Our Company',[],session()->get('locale'))}}</h2>
                </div>
                <div class="col-12">


                    <div class="accordion" id="accordionExampl1">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">

                                    {{trans('website.A real opportunity to increase your income with EVA’s monthly commissions ?',[],session()->get('locale'))}}
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#accordionExampl1">
                                <div class="accordion-body text-secondary w-75">
                                    {{trans('website.A monthly bonus when you add members in your personal',[],session()->get('locale'))}}
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                 {{trans('website.Become A Rep',[],session()->get('locale'))}}
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExampl1">
                                <div class="accordion-body">
                                     {{trans('website.Exclusive discounts for members only up to 30%',[],session()->get('locale'))}}

                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">

                                    {{trans('website.Other benefits for members and sales leader ?',[],session()->get('locale'))}}
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExampl1">
                                <div class="accordion-body">
                                     {{trans('website.The member gets a free catalog for each',[],session()->get('locale'))}}

                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </section>
    <!-- Banner Section End -->




    <!-- Blog Section Start -->
    <section class="blog-section">
        <div class="container-fluid-lg text-center">
            <div class="title text-center">
                <h2 class="my-3 ">{{trans('website.4U Netting Hub Insider',[],session()->get('locale'))}}</h2>
                            <h4 class="text-center fw-300 w-75 mx-auto lh-base">
                                {{trans('website.Read news, stories, answers to questions',[],session()->get('locale'))}}
                            </h4>
            </div>

            <div class="slider-4-blog arrow-slider slick-height insider-bottom-section" >
                <div class="p-2">
                    <div class="blog-box ratio_45">
                        <div class="blog-box-image">
                            <a href="/testimonials">
                                <img src="../assets/images/images/fruit.png" class="blur-up lazyload w-100" alt="">
                            </a>
                        </div>

                        <div class="blog-detail">

                            <a href="/testimonials">
                                <h3>4U Netting Hub STORIES</h3>
                            </a>

                        </div>
                    </div>
                </div>

                <div class="p-2">
                    <div class="blog-box ratio_45">
                        <div class="blog-box-image">
                            <a href="/common_questions">
                                <img src="../assets/images/images/blog image.png" class="blur-up lazyload w-100" alt="">
                            </a>
                        </div>

                        <div class="blog-detail">

                            <a href="/common_questions">
                                <h3>{{trans('website.COMMON QUESTIONS',[],session()->get('locale'))}}</h3>
                            </a>

                        </div>
                    </div>
                </div>

                <div class="p-2">
                    <div class="blog-box ratio_45">
                        <div class="blog-box-image">
                            <a href="/fast_facts">
                                <img src="../assets/images/images/Rectangle 12391.png" class="blur-up lazyload w-100" alt="">
                            </a>
                        </div>

                        <div class="blog-detail">

                            <a href="/fast_facts">
                                <h3>{{trans('website.FAST FACTS',[],session()->get('locale'))}}</h3>
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Blog Section End -->


    <!-- Team Section Start -->
    <section class=" text-center p-0 mt-4  homecategories">
        <div class="container-fluid text-center">
            <div class="row pt-4 pb-4">
                <div class="col-12">
                    @include('layoutsWep.componants.buttomcontact')
                </div>
            </div>
        </div>
    </section>
    <!-- Team Section End -->

@endsection
