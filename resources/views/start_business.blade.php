@extends('layouts.app')
@section('style')
    <style>
        [dir=ltr] .textleft {
            text-align: left;
        }

        [dir=rtl] .textleft {
            text-align: right;
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
                            <div class="home-contain rounded-0 p-0 background-size-cover" >
                                <img src="../assets/images/images/start-bussinis.jpg"
                                     class="img-fluid bg-img blur-up lazyload" alt="" >
                                <div class="home-detail home-big-space p-center-left home-overlay position-relative">
                                    <div class="container-fluid-lg row" id="aboutUsTitle">
                                        <div class="col-md-10">
                                            <h1 class="heding-2 text-white ">{{trans('website.Start A Business',[],session()->get('locale'))}}</h1>
                                            <h2 class="heding-2 text-white  w-75">{{trans('website.Sell quality products that people use every day.',[],session()->get('locale'))}}
                                            </h2>
                                        </div>
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
                    <h2 class="theme-second-color textleft mb-4">{{trans('website.Making money with 4U netting Hub',[],session()->get('locale'))}}</h2>

                    <p class="textleft">{{trans('website.Sellquality',[],session()->get('locale'))}}</p>


<br>
                      <button class="btn background-dark-mint mt-sm-4 btn-md  text-white fw-bold"
                        onclick="location.href = '/common_questions';">{{trans('website.See How To Make Money',[],session()->get('locale'))}}
                </button>
                </div>

            </div>
            <div class="col-6">

                <img src="../assets/images/images/startbusinis11.png"
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
                <img src="../assets/images/images/startbusinis21.png"
                class="blur-up lazyload blog_explore_image w-100" alt="">
            </div>
            <div class="col-6" style="display: flex; justify-content: center ;align-items: center">

                <div class="title   w-50">
                    <h2 class="theme-second-color textleft mb-4">{{trans('website.Tools To Help You In Your Business',[],session()->get('locale'))}}</h2>

                    <p class="textleft">{{trans('website.4U netting hub make your business easy',[],session()->get('locale'))}}</p>


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
                    <h2 class="theme-second-color mb-4 textleft"> {{trans('website.High Quality Products',[],session()->get('locale'))}}

</h2>

                    <p class="textleft">{{trans('website.All our products: personal care',[],session()->get('locale'))}}
                    </p>


<br>
                      <button class="btn background-dark-mint mt-sm-4 btn-md  text-white fw-bold"
                        onclick="location.href = '/products';">{{trans('website.Get started',[],session()->get('locale'))}}
                </button>
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
                     <h2 class="theme-second-color mb-4 textleft">{{trans('website.Go faster',[],session()->get('locale'))}}

</h2>

                    <p class="textleft">{{trans('website.ask about your free courses',[],session()->get('locale'))}}
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
        <div class="row pt-4 pb-4">
            <div class="col-6" style="display: flex; justify-content: center ;align-items: center">
                <div class="title  w-50">
                    <h2 class="theme-second-color mb-4 textleft">{{trans('website.Start Earning Extra Income',[],session()->get('locale'))}}

</h2>

                    <p class="textleft">
                       {{trans('website.click register now',[],session()->get('locale'))}}
                       </p>


<br>
                      <button class="btn background-dark-mint mt-sm-4 btn-md  text-white fw-bold"
                        onclick="location.href = '/joinus';">{{trans('website.Get started',[],session()->get('locale'))}}
                </button>
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
