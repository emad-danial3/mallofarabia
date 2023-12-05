<!-- Home Section Start -->
{{--<section class="home-section-2 home-section-bg pt-0 overflow-hidden">--}}
{{--    <div class="container-fluid p-0">--}}
{{--        <div class="row">--}}
{{--            <div class="col-12">--}}
{{--                <div class="slider-animate">--}}
{{--                    <div>--}}
{{--                        <div class="home-contain rounded-0 p-0">--}}
{{--                            <img src="{{asset('assets/images/grocery/banner/1.jpg')}}"--}}
{{--                                 class="img-fluid bg-img blur-up lazyload" alt="">--}}
{{--                            <div class="home-detail home-big-space p-center-left home-overlay position-relative justify-content-center">--}}

{{--                                <div class="container-fluid-lg" style="padding-top: 200px;margin-bottom: -35px;">--}}
{{--                                    <div>--}}
{{--                                        <div class="btnShopNow" onclick="location.href = '{{url('/products')}}';">Shop--}}
{{--                                            Now--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</section>--}}
<!-- Home Section End -->

<div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
    <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
        <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="3" aria-label="Slide 4"></button>
    </div>
    <div class="carousel-inner home-page">
        @if($bannersCount > 0)
        <div class="carousel-item active">
            <img src="{{url($banners[0]['url'])}}" class="d-block w-100" alt="...">
            <div class="carousel-caption">
{{--                @if($banners[0]['title_ar'])--}}
{{--                <h2 class="heding-2 text-dark-mint">--}}
{{--                    @if(session()->get('locale')=='ar')--}}
{{--                        {{$banners[0]['title_ar']}}--}}
{{--                    @else--}}
{{--                        {{$banners[0]['title_en']}}--}}
{{--                    @endif--}}
{{--                </h2>--}}
{{--                @endif--}}
{{--                @if($banners[0]['description_ar'])--}}
{{--                <div class="mt-3 mb-3">--}}
{{--                    <p class="text-content lh-base">--}}
{{--                         @if(session()->get('locale')=='ar')--}}
{{--                        {{$banners[0]['description_ar']}}--}}
{{--                    @else--}}
{{--                        {{$banners[0]['description_en']}}--}}
{{--                    @endif--}}
{{--                    </p>--}}
{{--                </div>--}}
{{--                @endif--}}

                @if($banners[0]['button_url'])
                <div class="btnShopNow" onclick="location.href = '{{$banners[0]['button_url']}}';">
                        @if(session()->get('locale')=='ar')
                        {{$banners[0]['button_ar']}}
                    @else
                        {{$banners[0]['button_en']}}
                    @endif
                </div>
                @endif
            </div>

        </div>
        @endif
            @if($bannersCount > 1)
        <div class="carousel-item">
            <img src="{{url($banners[1]['url'])}}" class="d-block w-100" alt="...">
            <div class="carousel-caption">
                <h2 class="heding-2 text-dark-mint">
{{--                    @if(session()->get('locale')=='ar')--}}
{{--                        {{$banners[1]['title_ar']}}--}}
{{--                    @else--}}
{{--                        {{$banners[1]['title_en']}}--}}
{{--                    @endif--}}
                </h2>
                <div class="mt-3 mb-3">
                    <p class="text-content lh-base">
{{--                         @if(session()->get('locale')=='ar')--}}
{{--                        {{$banners[1]['description_ar']}}--}}
{{--                    @else--}}
{{--                        {{$banners[1]['description_en']}}--}}
{{--                    @endif--}}
                    </p>
                </div>

                <div class="btnShopNow" onclick="location.href = '{{$banners[1]['button_url']}}';">
                        @if(session()->get('locale')=='ar')
                        {{$banners[1]['button_ar']}}
                    @else
                        {{$banners[1]['button_en']}}
                    @endif
                </div>
            </div>

        </div>
        @endif
       @if($bannersCount > 2)
        <div class="carousel-item">
            <img src="{{url($banners[2]['url'])}}" class="d-block w-100" alt="...">
            <div class="carousel-caption">
                <h2 class="heding-2 text-dark-mint">
{{--                    @if(session()->get('locale')=='ar')--}}
{{--                        {{$banners[2]['title_ar']}}--}}
{{--                    @else--}}
{{--                        {{$banners[2]['title_en']}}--}}
{{--                    @endif--}}
                </h2>
                <div class="mt-3 mb-3">
                    <p class="text-content lh-base">
{{--                         @if(session()->get('locale')=='ar')--}}
{{--                        {{$banners[2]['description_ar']}}--}}
{{--                    @else--}}
{{--                        {{$banners[2]['description_en']}}--}}
{{--                    @endif--}}
                    </p>
                </div>

                <div class="btnShopNow" onclick="location.href = '{{$banners[2]['button_url']}}';">
                        @if(session()->get('locale')=='ar')
                        {{$banners[2]['button_ar']}}
                    @else
                        {{$banners[2]['button_en']}}
                    @endif
                </div>
            </div>

        </div>
        @endif
       @if($bannersCount > 3)
        <div class="carousel-item">
            <img src="{{url($banners[3]['url'])}}" class="d-block w-100" alt="...">
            <div class="carousel-caption">
                <h2 class="heding-2 text-dark-mint">
{{--                    @if(session()->get('locale')=='ar')--}}
{{--                        {{$banners[3]['title_ar']}}--}}
{{--                    @else--}}
{{--                        {{$banners[3]['title_en']}}--}}
{{--                    @endif--}}
                </h2>
                <div class="mt-3 mb-3">
                    <p class="text-content lh-base">
{{--                         @if(session()->get('locale')=='ar')--}}
{{--                        {{$banners[3]['description_ar']}}--}}
{{--                    @else--}}
{{--                        {{$banners[3]['description_en']}}--}}
{{--                    @endif--}}
                    </p>
                </div>

                <div class="btnShopNow" onclick="location.href = '{{$banners[3]['button_url']}}';">
                        @if(session()->get('locale')=='ar')
                        {{$banners[3]['button_ar']}}
                    @else
                        {{$banners[3]['button_en']}}
                    @endif
                </div>
            </div>

        </div>
        @endif

    </div>
    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
    </button>
    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
    </button>
</div>


{{--<div id="demo" class="carousel slide" data-ride="carousel">--}}
{{--    <ul class="carousel-indicators">--}}
{{--        <li data-target="#demo" data-slide-to="0" class="active"></li>--}}
{{--        <li class="apperonloade" data-target="#demo" data-slide-to="1"></li>--}}
{{--        <li class="apperonloade d-none" data-target="#demo" data-slide-to="2"></li>--}}
{{--        <li class="apperonloade d-none" data-target="#demo" data-slide-to="4"></li>--}}
{{--    </ul>--}}
{{--    <div class="carousel-inner home-page">--}}
{{--        <div class="carousel-item active">--}}
{{--            <img src="{{asset('assets/images/grocery/banner/banner slider 1.png')}}" alt="Los Angeles" width="1100" height="600" style="width: 100%!important;height: 600px!important;">--}}
{{--            <div class="carousel-caption">--}}
{{--                <h2 class="heding-2 text-dark-mint">BUILD YOUR BUSINESS</h2>--}}
{{--                <div class="mt-3 mb-3">--}}
{{--                   <p class="text-content">if you have free time you can build your business by yourself and from home without any boss so the customer has the flexibility to work at any time.</p>--}}
{{--                </div>--}}

{{--                <div class="btnShopNow" onclick="location.href = '{{url('/products')}}';">Start a Business</div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="carousel-item apperonloade">--}}
{{--            <img src="{{asset('assets/images/grocery/banner/66.png')}}" alt="Chicago" width="1100" height="600" style="width: 100%!important;height: 600px!important;">--}}
{{--            <div class="carousel-caption">--}}
{{--                <h2 class="heding-2 text-dark-mint">BUILD YOUR BUSINESS</h2>--}}
{{--                <div class="mt-3 mb-3">--}}
{{--                   <h5 class="text-content">if you have free time you can build your business by yourself and from home without any boss so the customer has the flexibility to work at any time.</h5>--}}
{{--                </div>--}}

{{--                <div class="btnShopNow" onclick="location.href = '{{url('/products')}}';">Start a Business</div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="carousel-item apperonloade d-none">--}}
{{--            <img src="{{asset('assets/images/grocery/banner/3.png')}}" alt="New York" width="1100" height="600" style="width: 100%!important;height: 600px!important;">--}}
{{--             <div class="carousel-caption">--}}
{{--                <h2 class="heding-2 text-dark-mint">BUILD YOUR BUSINESS</h2>--}}
{{--                <div class="mt-3 mb-3">--}}
{{--                     <h5 class="text-content">if you have free time you can build your business by yourself and from home without any boss so the customer has the flexibility to work at any time.</h5>--}}
{{--                </div>--}}

{{--                <div class="btnShopNow" onclick="location.href = '{{url('/products')}}';">Start a Business</div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <div class="carousel-item apperonloade d-none">--}}
{{--            <img src="{{asset('assets/images/grocery/banner/4.png')}}" alt="New York" width="1100" height="600" style="width: 100%!important;height: 600px!important;">--}}
{{--             <div class="carousel-caption">--}}
{{--                <h2 class="heding-2 text-dark-mint">BUILD YOUR BUSINESS</h2>--}}
{{--                <div class="mt-3 mb-3">--}}
{{--                    <h5 class="text-content">if you have free time you can build your business by yourself and from home without any boss so the customer has the flexibility to work at any time.</h5>--}}
{{--                </div>--}}

{{--                <div class="btnShopNow" onclick="location.href = '{{url('/products')}}';">Start a Business</div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--    <a class="carousel-control-prev" href="#demo" data-slide="prev">--}}
{{--        <span class="carousel-control-prev-icon"></span>--}}
{{--    </a>--}}
{{--    <a class="carousel-control-next" href="#demo" data-slide="next">--}}
{{--        <span class="carousel-control-next-icon"></span>--}}
{{--    </a>--}}
{{--</div>--}}



