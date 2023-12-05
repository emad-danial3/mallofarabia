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
                                <img src="../assets/images/images/bgcommonq.png"
                                     class="img-fluid bg-img blur-up lazyload" alt="">
                                <div class="home-detail home-big-space p-center-left home-overlay position-relative">
                                    <div class="container-fluid-lg">
                                        <div>

                                            <h1 class="heding-2 text-white">{{trans('website.COMMON QUESTIONS',[],session()->get('locale'))}}</h1>
                                            <h3 class="content-2 text-white w-50"> {{trans('website.Curious about 4u',[],session()->get('locale'))}}</h3>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Home Section End -->


    <!-- Banner Section Start -->
    <section class="banner-section ">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <h2 class="my-3 text-dark-mint">{{trans('website.About 4U NETTING HUB',[],session()->get('locale'))}}</h2>
                </div>
                <div class="col-12">


                    <div class="accordion" id="accordionExampl1">

                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                             {{trans('website.Free shipping ?',[],session()->get('locale'))}}
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#accordionExampl1">
                                <div class="accordion-body">
                                    {{trans('website.When you place an order of 250 EGP paid value, you will get free shipping.',[],session()->get('locale'))}}

                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                   {{trans('website.Cashback ?',[],session()->get('locale'))}}
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#accordionExampl1">
                                <div class="accordion-body">
{{trans('website.Cashback Quarterly 10% Up to 15% and',[],session()->get('locale'))}}


                                </div>
                            </div>
                        </div>
                    </div>


                </div>

            </div>
        </div>
    </section>
    <!-- Banner Section End -->



    <!-- Banner Section Start -->
    <section class="banner-section mb-4">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <h2 class="my-3 text-dark-mint">{{trans('website.Our Products',[],session()->get('locale'))}}</h2>
                </div>
                <div class="col-12">


                    <div class="accordion" id="accordionExample">
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading5">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse5" aria-expanded="false" aria-controls="collapse5">

{{trans('website.How dose your monthly income reach from',[],session()->get('locale'))}}
                                     <span class="text-content2"> 1000 {{trans('website.LE',[],session()->get('locale'))}}</span>
                                  {{trans('website.to',[],session()->get('locale'))}}   <span class="text-content2">10000 {{trans('website.LE',[],session()->get('locale'))}}</span> ?


                                        </button>
                                    </h2>
                                    <div id="collapse5" class="accordion-collapse collapse" aria-labelledby="heading5" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
                                            {{trans('website.Start with yourself and add 5 new members in your personal group every month.',[],session()->get('locale'))}}



                                        </div>
                                    </div>
                                </div>
                                <div class="accordion-item">
                                    <h2 class="accordion-header" id="heading6">
                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse6" aria-expanded="false" aria-controls="collapse6">


                                            {{trans('website.A real opportunity to increase your income with EVA’s monthly commissions ?',[],session()->get('locale'))}}
                                        </button>
                                    </h2>
                                    <div id="collapse6" class="accordion-collapse collapse" aria-labelledby="heading6" data-bs-parent="#accordionExample">
                                        <div class="accordion-body">
{{trans('website.A monthly bonus when you add members in your personal',[],session()->get('locale'))}}

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
