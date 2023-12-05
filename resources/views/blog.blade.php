@extends('layouts.app')
@section('style')
    <style>
        .textleft {
            text-align: left;
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
                        <div class="banner-detail p-center text-dark position-relative text-center p-0 ">
                            <div>
                                <h2 class="my-3 text-dark-mint mx-auto">Blogs</h2>
                                <h4 class="text-content fw-300 w-75 mx-auto"></h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Section End -->




    <!-- Team Section Start -->
    <section class=" text-center p-0 mb-4">
        <div class="container-fluid text-center ">
            <div class="row">
                <div class="col-md-1"></div>
                <div class="col-md-10">
                    <div class="row">
                        <div class="col-md-4">
                            <div class="card"   >
                                <img src="../assets/images/logo/1.png" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title text-dark-mint textleft">Bazar</h5>


                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                             <div class="card"   >
                                <img src="../assets/images/logo/1.png" class="card-img-top" alt="...">
                                <div class="card-body">
                                   <h5 class="card-title text-dark-mint textleft">Events</h5>

                                </div>
                            </div>
                        </div>
                        <div class="col-md-4">
                              <div class="card"   >
                                <img src="../assets/images/logo/1.png" class="card-img-top" alt="...">
                                <div class="card-body">
                                    <h5 class="card-title text-dark-mint textleft">Business Meetings</h5>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-1"></div>
            </div>
        </div>
    </section>
    <!-- Team Section End -->


    <!-- Team Section Start -->
    <section class=" text-center p-0 pb-4">
        <div class="container-fluid text-center">
            <div class="row pt-4 pb-4">
                <div class="col-6" style="display: flex; justify-content: center ;align-items: center">
                    <div class="title  w-50">
                        <h2 class="theme-second-color mb-4 textleft">{{trans('website.FAST FACTS',[],session()->get('locale'))}}
                        </h2>

                        <p class="textleft">if you have free time you can build your business by yourself and from home
                            without any boss so the customer has the flexibility to work at any time.</p>


                        <br>

                    </div>

                </div>
                <div class="col-6">
                    <img src="../assets/images/images/Rectangle 12391.png"
                         class="blur-up lazyload blog_explore_image w-75" alt="">
                </div>
            </div>
        </div>
    </section>
    <!-- Team Section End -->


    <!-- Team Section Start -->
    <section class=" text-center p-0 pb-4">
        <div class="container-fluid text-center">
            <div class="row pt-4 pb-4">
                <div class="col-6">
                    <img src="../assets/images/images/blog image.png"
                         class="blur-up lazyload blog_explore_image w-75" alt="">
                </div>
                <div class="col-6" style="display: flex; justify-content: center ;align-items: center">

                    <div class="title   w-50">
                        <h2 class="theme-second-color textleft mb-4">{{trans('website.COMMON QUESTIONS',[],session()->get('locale'))}}</h2>

                        <p class="textleft">{{trans('website.Curious about 4u',[],session()->get('locale'))}}</p>


                        <br>

                    </div>

                </div>
            </div>
        </div>
    </section>
    <!-- Team Section End -->


@endsection
