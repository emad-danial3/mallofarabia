@extends('layouts.app')
@section('style')
    <style>

        [dir=ltr] .textleft {
            text-align: left;
        }

        [dir=rtl] .textleft {
            text-align: right;
        }
.home-section-2 .home-contain .home-detail{
 background-color: rgba(55,55,55,.5);
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
                                <img src="../assets/images/images/about112.png"
                                     class="img-fluid bg-img blur-up lazyload" alt="">
                                <div class="home-detail home-big-space p-center-left home-overlay position-relative">
                                    <div class="container-fluid-lg row" id="aboutUsTitle">
                                        <div class="col-md-2"></div>
                                        <div class="col-md-10">
                                            <h1 class="heding-2 text-white ">{{trans('website.THIS IS 4U NETTING HUB',[],session()->get('locale'))}}</h1>
                                            <h4 class="content-2 text-white w-75 ">
                                                {{trans('website.Learn about the company history',[],session()->get('locale'))}}

                                            </h4>

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




    <!-- Team Section Start -->
    <section class=" text-center p-0">
        <div class="container-fluid text-center">
            <div class="row pt-4 pb-2">
                <div class="col-6" style="display: flex; justify-content: center ;align-items: center">

                    <div class="title   w-50">
                        <h2 class="theme-second-color textleft mb-4">{{trans('website.Helping and encouraging people to live better life',[],session()->get('locale'))}}</h2>

                        <p class="textleft">{{trans('website.Our members contribute to our mission',[],session()->get('locale'))}}</p>


                        <br>

                    </div>

                </div>
                <div class="col-6">

                    <img src="../assets/images/images/about22.png"
                         class="blur-up lazyload blog_explore_image w-100" alt="">


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
                    <img src="../assets/images/images/about 31.png"
                         class="blur-up lazyload blog_explore_image w-100" alt="">
                </div>
                <div class="col-6" style="display: flex; justify-content: center ;align-items: center">

                    <div class="title   w-50">
                        <h2 class="theme-second-color textleft mb-4">{{trans('website.4U nettinghub business',[],session()->get('locale'))}}</h2>

                        <p class="textleft">{{trans('website.is a direct sales company',[],session()->get('locale'))}}</p>


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
                        <h2 class="theme-second-color mb-4 textleft">{{trans('website.Life at 4U Netting Hub',[],session()->get('locale'))}}

                        </h2>

                        <p class="textleft">
                            {{trans('website.Work with truly exceptional people',[],session()->get('locale'))}}
                        </p>


                        <br>

                    </div>

                </div>
                <div class="col-6">
                    <img src="../assets/images/images/start55.png"
                         class="blur-up lazyload blog_explore_image w-100" alt="">
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
                    <img src="../assets/images/images/startbusinis33.png"
                         class="blur-up lazyload blog_explore_image w-100" alt="">
                </div>
                <div class="col-6" style="display: flex; justify-content: center ;align-items: center">
                    <div class="title  w-50">
                        <h2 class="theme-second-color mb-4 textleft">{{trans('website.SATISFACTION GUARANTEE',[],session()->get('locale'))}}

                        </h2>

                        <p class="textleft">


                            {{trans('website.Our 100% satisfaction guarantee and customer',[],session()->get('locale'))}}
                            <br>
                            <br>
                        <ul class="list-group">
                            <li class="list-group-item textleft"> {{trans('website.Low cost, Low-risk Opportunity',[],session()->get('locale'))}}</li>
                            <li class="list-group-item textleft"> {{trans('website.100% Satisfaction Guarantee',[],session()->get('locale'))}}</li>
                            <li class="list-group-item textleft"> {{trans('website.Warranty Programs',[],session()->get('locale'))}}</li>
                            <li class="list-group-item textleft"> {{trans('website.Customer Service',[],session()->get('locale'))}}</li>
                            <li class="list-group-item textleft"> {{trans('website.The Right to Know',[],session()->get('locale'))}}</li>

                        </ul>
                        </p>
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
            <div class="row pt-4 pb-2">
                <div class="col-12 banner-contain-3" style="display: flex; justify-content: center ;align-items: center">
                    <div class=" text-center ">
                        <br><br>
{{--                        <h2 class=" text-dark-mint mb-4 textleft">{{trans('website.video',[],session()->get('locale'))}}</h2>--}}
                        <br>
                    </div>
                </div>

                <div class="col-1"></div>
                <div class="col-10">
                    <video width="100%" height="600" controls>
      <source src="{{ asset('downloads/Media1.mp4') }}" type="video/mp4">
    Your browser does not support the video tag.
</video>
                </div>
                 <div class="col-1"></div>
            </div>
        </div>
    </section>
    <!-- Team Section End -->



    <!-- Team Section Start -->
    <section class=" text-center p-0 homecategories">
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
