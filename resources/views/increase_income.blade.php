@extends('layouts.app')
@section('style')
    <style>
        .textleft {
            text-align: left;
        }

        .text-content2 {
            color: #A16EA5;
        }

        .steps {
            width: 80px;
            height: 80px;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: auto;
            color: white;

            border-radius: 20px;
            font-size: 3rem;
        }

        .sub_title {
            color: #979797;
        }
        [dir=ltr] .step_arrow {
           rotate: unset;
        }

        [dir=rtl] .step_arrow {
            rotate: 180deg;
        }

    </style>
@endsection
@section('content')

    <!-- Banner Section Start -->
    <section class="banner-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="banner-contain-3 section-b-space section-t-space hover-effect">
                        {{--                        <img src="../assets/images/veg-3/banner/3.png" class="img-fluid bg-img" alt="">--}}
                        <div class="banner-detail p-center text-dark position-relative text-center p-0">
                            <div>
                                <h2 class="my-3 text-dark-mint">{{trans('website.Earn More',[],session()->get('locale'))}}</h2>
                                <h4 class="text-content2 fw-300 w-75 text-center mx-auto">
                                  {{trans('website.Incredible Sale For Incredible People',[],session()->get('locale'))}}

                                </h4>
                                <h3 class="fw-300 text-dark-mint">
                                    {{trans('website.Every 2000 LE You Sell, You Will Gain 1000 LE',[],session()->get('locale'))}}

                                </h3>
                                <button class="btn background-dark-mint mt-sm-4 btn-md mx-auto text-white fw-bold"
                                        onclick="location.href = '/joinus';">{{trans('website.Get started',[],session()->get('locale'))}}
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Section End -->




    <!-- Team Section Start -->
    <section class=" text-center p-0">
        <div class="container-fluid text-center">
            <div class="row pt-4 pb-2">
                <div class="col-12 banner-contain-3" style="display: flex; justify-content: center ;align-items: center">
                    <div class=" text-center ">
                        <h2 class=" text-dark-mint mb-4 textleft">{{trans('website.Cover',[],session()->get('locale'))}}</h2>
                        <br>
                    </div>
                </div>

                <div class="col-1"></div>
                <div class="col-10">
                    <div class="row justify-content-center">
    <iframe src="{{ asset('downloads/nettinghub flyer print.pdf') }}" width="50%" height="600">
            This browser does not support PDFs. Please download the PDF to view it: <a href="{{ asset('downloads/nettinghub flyer print.pdf') }}">Download PDF</a>
    </iframe>
</div>
                </div>
                 <div class="col-1"></div>
            </div>
        </div>
    </section>
    <!-- Team Section End -->


    <!-- Team Section Start -->
    <section class=" text-center p-0">
        <div class="container-fluid text-center">
            <div class="row pt-4 pb-2">
                <div class="col-12 banner-contain-3" style="display: flex; justify-content: center ;align-items: center">
                    <div class=" text-center ">
                        <br><br>
                        <h2 class=" text-dark-mint mb-4 textleft">{{trans('website.Presentation',[],session()->get('locale'))}}</h2>
                        <br>
                    </div>
                </div>

                <div class="col-1"></div>
                <div class="col-10">
                    <div class="row justify-content-center">
    <iframe src="{{ asset('downloads/4u presentation JULY.pdf') }}" width="50%" height="600">
            This browser does not support PDFs. Please download the PDF to view it: <a href="{{ asset('downloads/4u presentation JULY.pdf') }}">Download PDF</a>
    </iframe>
</div>
                </div>
                 <div class="col-1"></div>
            </div>
        </div>
    </section>
    <!-- Team Section End -->


    <!-- Team Section Start -->
    <section class=" text-center p-0">
        <div class="container-fluid text-center">
            <div class="row pt-4 pb-2">
                <div class="col-12 banner-contain-3" style="display: flex; justify-content: center ;align-items: center">
                    <div class=" text-center ">
                        <br><br>
                        <h2 class=" text-dark-mint mb-4 textleft">{{trans('website.video',[],session()->get('locale'))}}</h2>
                        <br>
                    </div>
                </div>

                <div class="col-1"></div>
                <div class="col-10">
                    <video width="100%" height="600" controls>
      <source src="{{ asset('downloads/4U Netting Hub.mp4') }}" type="video/mp4">
    Your browser does not support the video tag.
</video>
                </div>
                 <div class="col-1"></div>
            </div>
        </div>
    </section>
    <!-- Team Section End -->


    <!-- Team Section Start -->
    <section class=" text-center p-0">
        <div class="container-fluid text-center">
            <div class="row pt-4 pb-2">
                <div class="col-6" style="display: flex; justify-content: center ;align-items: center">

                    <div class="title w-50">
                        <h2 class=" theme-second-color mb-4 textleft">{{trans('website.How to earn ?',[],session()->get('locale'))}}</h2>
                        <p class="textleft">
{{trans('website.When you buy your personal needs',[],session()->get('locale'))}}

                        </p>


                        <br>
                    </div>

                </div>
                <div class="col-6">

                    <img src="../assets/images/images/earn1.png"
                         class="blur-up lazyload blog_explore_image w-50" alt="">


                </div>
            </div>
        </div>
    </section>
    <!-- Team Section End -->

    <!-- Team Section Start -->
    <section class=" text-center p-0">
        <div class="container-fluid text-center">
            <div class="row pt-4 pb-4">
                <div class="col-6">
                    <img src="../assets/images/images/earn2.png"
                         class="blur-up lazyload blog_explore_image w-75" alt="">
                </div>
                <div class="col-6" style="display: flex; justify-content: center ;align-items: center">

                    <div class="title   w-50">
                        <h2 class="theme-second-color textleft mb-4">{{trans('website.Free shipping ?',[],session()->get('locale'))}}</h2>

                        <p class="textleft"> {{trans('website.When you place an order of 250 EGP paid value, you will get free shipping.',[],session()->get('locale'))}} </p>


                        <br>

                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- Team Section End -->

    <!-- Team Section Start -->
    <section class=" text-center p-0">
        <div class="container-fluid text-center">
            <div class="row pt-4 pb-4">
                <div class="col-6" style="display: flex; justify-content: center ;align-items: center">
                    <div class="title  w-50">
                        <h2 class="theme-second-color mb-4 textleft">{{trans('website.Cashback ?',[],session()->get('locale'))}}
                        </h2>

                        <p class="textleft">
                            {{trans('website.Cashback Quarterly 10% Up to 15% and',[],session()->get('locale'))}}
{{trans('website.Cashback Quarterly 10% Up to 15% and',[],session()->get('locale'))}}


                        <br>
                        <button class="btn background-dark-mint mt-sm-4 btn-md  text-white fw-bold"
                                onclick="location.href = '/beforeregister';">{{trans('website.Discover More',[],session()->get('locale'))}}
                        </button>
                    </div>

                </div>
                <div class="col-6">
                    <img src="../assets/images/images/earn3.png"
                         class="blur-up lazyload blog_explore_image w-50" alt="">
                </div>
            </div>
        </div>
    </section>
    <!-- Team Section End -->



    <!-- Banner Section Start -->
    <section class="banner-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="banner-contain-3 section-b-space section-t-space hover-effect">
                        {{--                        <img src="../assets/images/veg-3/banner/3.png" class="img-fluid bg-img" alt="">--}}
                        <div class="banner-detail p-center text-dark position-relative text-center p-0">
                            <div>
                                <h2 class="my-3 text-dark-mint w-75 mx-auto">
{{trans('website.How dose your monthly income reach from',[],session()->get('locale'))}}
                                     <span class="text-content2"> 1000 {{trans('website.LE',[],session()->get('locale'))}}</span>
                                  {{trans('website.to',[],session()->get('locale'))}}   <span class="text-content2">10000 {{trans('website.LE',[],session()->get('locale'))}}</span> ?

                                </h2>
                                <div class="row">
                                    <div class="col-md-3">

                                        <div class="steps bg-second-color">
                                            1
                                        </div>
                                        <div class="sub_title pt-2">
                                            {{trans('website.Start with yourself and add 5 new members in your personal group every month.',[],session()->get('locale'))}}
                                        </div>

                                    </div>
                                    <div class="col-md-2"><img src="../assets/images/images/arrow11.png"
                                                               class="blur-up lazyload blog_explore_image w-50 step_arrow" alt="">
                                    </div>
                                    <div class="col-md-3">
                                        <div class="steps bg-second-color">
                                            2
                                        </div>
                                        <div class="sub_title pt-2">
                                            {{trans('website.Train each member in your group to add another 5 members.',[],session()->get('locale'))}}

                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <img src="../assets/images/images/arrow11.png"
                                                               class="blur-up lazyload blog_explore_image w-50 step_arrow" alt="">
                                    </div>
                                    <div class="col-md-2">
                                        <div class="steps bg-second-color">
                                            3
                                        </div>
                                        <div class="sub_title pt-2">
                                            {{trans('website.Follow up with your members so that each member makes a monthly order minimum 250 EGP',[],session()->get('locale'))}}

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
    <!-- Banner Section End -->

    <!-- Team Section Start -->
    <section class=" text-center p-0">
        <div class="container-fluid text-center">
            <div class="row pt-4 pb-4">
                <div class="col-5">
                    <img src="../assets/images/images/earn4.png"
                         class="blur-up lazyload blog_explore_image w-75" alt="">
                </div>
                <div class="col-7" style="display: flex; justify-content: center ;align-items: center">

                    <div class="title   w-75">
                        <h2 class="theme-second-color textleft mb-4">
                            {{trans('website.A real opportunity to increase your income with EVA’s monthly commissions ?',[],session()->get('locale'))}}
                            </h2>

                        <p class="textleft">
{{trans('website.A monthly bonus when you add members in your personal',[],session()->get('locale'))}}


                        </p>


                        <br>

                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- Team Section End -->



@endsection
