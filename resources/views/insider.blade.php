@extends('layouts.app')
@section('style')
    <style>
        .textleft{
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
                    <div class="banner-detail p-center text-dark position-relative text-center p-0">
                        <div>
                            <h2 class="my-3 text-dark-mint">{{trans('website.4U Netting Hub Insider',[],session()->get('locale'))}}</h2>
                            <h4 class="text-content fw-300">{{trans('website.Read news, stories, answers to questions',[],session()->get('locale'))}}</h4>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Banner Section End -->




{{--<!-- Team Section Start -->--}}
{{--<section class=" text-center p-0">--}}
{{--    <div class="container-fluid text-center">--}}
{{--        <div class="row pt-4 pb-2">--}}
{{--            <div class="col-6" style="display: flex; justify-content: center ;align-items: center">--}}

{{--                <div class="title w-50">--}}
{{--                    <h2 class=" theme-second-color mb-4 textleft">{{trans('website.4U Netting Hub STORIES',[],session()->get('locale'))}}</h2>--}}
{{--                    <p class="textleft">{{trans('website.if you have free time you can build your business',[],session()->get('locale'))}}</p>--}}


{{--<br>--}}
{{--                      <button class="btn background-dark-mint mt-sm-4 btn-md  text-white fw-bold"--}}
{{--                        onclick="location.href = '/testimonials';">{{trans('website.READ TESTIMONIALS',[],session()->get('locale'))}}--}}
{{--                </button>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--            <div class="col-6">--}}

{{--                <img src="../assets/images/images/fruit.png"--}}
{{--                class="blur-up lazyload blog_explore_image w-100" alt="">--}}


{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</section>--}}
{{--<!-- Team Section End -->--}}

<!-- Team Section Start -->
<section class=" text-center p-0">
    <div class="container-fluid text-center">
        <div class="row pt-4 pb-4">
            <div class="col-6">
                <img src="../assets/images/images/blog image.png"
                class="blur-up lazyload blog_explore_image w-100" alt="">
            </div>
            <div class="col-6" style="display: flex; justify-content: center ;align-items: center">

                <div class="title   w-50">
                    <h2 class="theme-second-color textleft mb-4">{{trans('website.COMMON QUESTIONS',[],session()->get('locale'))}}</h2>

                    <p class="textleft">{{trans('website.Curious about 4u',[],session()->get('locale'))}}</p>


<br>
                      <button class="btn background-dark-mint mt-sm-4 btn-md  text-white fw-bold"
                        onclick="location.href = '/common_questions';">{{trans('website.GET ANSWERS',[],session()->get('locale'))}}
                </button>
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
                    <h2 class="theme-second-color mb-4 textleft">{{trans('website.FAST FACTS',[],session()->get('locale'))}}
</h2>

                    <p class="textleft">{{trans('website.if you have free',[],session()->get('locale'))}}</p>


<br>
                      <button class="btn background-dark-mint mt-sm-4 btn-md  text-white fw-bold"
                        onclick="location.href = '/fast_facts';">{{trans('website.GET THE FACTS',[],session()->get('locale'))}}
                </button>
                </div>

            </div>
               <div class="col-6">
                <img src="../assets/images/images/Rectangle 12391.png"
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
