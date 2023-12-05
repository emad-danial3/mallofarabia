<!-- Blog Section Start -->
<section class="product-section text-center pb-4">
    <div class="container-fluid-lg text-center">
        <div class="title text-center">
            <h2 class="text-center theme-second-color mb-1">
                {{trans('website.Quality Products',[],session()->get('locale'))}}
                </h2>
            <h3 class="text-center theme-second-color">{{trans('website.Shop By Categories',[],session()->get('locale'))}}</h3>
        </div>
        <div class="row">
            <div class="col-12 home-brands">
                <div class="slider-5 ratio_87">
                    @if($filters)
                        @foreach($filters as $filter)
                            <div>
                                <div class="blog-box">
                                    <div class="blog-box-image">
                                        <a href="{{url('/products?filter_id='.$filter->id)}}" class="blog-image">
                                            <img src="{{url($filter->image)}}" class="bg-img blur-up lazyload"
                                                 alt="">
                                        </a>
                                    </div>

                                    <div class="blog-detail">
                                        <h5>{{$filter->name_en}}</h5>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Blog Section End -->



    <!-- Blog Section Start -->
    <section class="blog-section homecategories pb-4">
        <div class="container-fluid-lg text-center">
            <div class="title text-center">
                <div class="title text-center">
                 <h2 class="text-center theme-second-color mb-2">
                     {{trans('website.Shop By Brands',[],session()->get('locale'))}}
                 </h2>
            </div>
            </div>

            <div class="slider-4-blog arrow-slider slick-height mainsliderhomepage">



                 @if($brandsCategories)
                        @foreach($brandsCategories as $brand)
                             <div>
                    <div class=" blog-box ratio_45 border-0 mx-auto">
                        <div class="blog-box-image mx-auto">
                            <a href="{{url('/products?category_id='.$brand->id)}}"   style="width: 200px!important;height: 200px!important;background-color: white;border-radius: 50%!important;margin: auto;background-size:contain" id="imageParent">
                                <img src="{{$brand->image}}" class="blur-up bg-img bg_size_content" alt="" >
                            </a>
                        </div>

                        <div class="blog-detail">
                            <a href="">
                                <h3>{{$brand->name_en}}</h3>
                            </a>
                        </div>
                    </div>
                </div>
                        @endforeach
                    @endif






            </div>
<button class="btn background-dark-mint mt-sm-4 btn-md mx-auto text-white fw-bold mb-4"
                        onclick="location.href = '/products';">
    {{trans('website.Show All',[],session()->get('locale'))}}

                </button>
        </div>
    </section>
    <!-- Blog Section End -->



{{--<!-- Team Section Start -->--}}
{{--<section class="team-section section-lg-space ">--}}
{{--    <div class="container-fluid-lg ">--}}
{{--        <div class="row">--}}

{{--            <div class="col-6">--}}

{{--                <img src="../assets/images/images/brose.png"--}}
{{--                class="blur-up lazyload blog_explore_image" alt="">--}}


{{--            </div>--}}
{{--            <div class="col-6" style="display: flex; justify-content: center ;align-items: center">--}}

{{--                <div class="title text-left">--}}
{{--                    <h2 class=" theme-second-color mb-2">{{trans('website.Explore Our',[],session()->get('locale'))}}</h2>--}}
{{--                    <h3 class=" theme-second-color">{{trans('website.News & Updates',[],session()->get('locale'))}}</h3>--}}
{{--                    <p class="w-75 lh-base">--}}
{{--                        {{trans('website.Let us write articles with up-to-date',[],session()->get('locale'))}}--}}
{{--                    </p>--}}


{{--<br>--}}
{{--                      <button class="btn background-dark-mint mt-sm-4 btn-md text-white fw-bold"--}}
{{--                        onclick="location.href = '/blog';">{{trans('website.Show All',[],session()->get('locale'))}}--}}
{{--                </button>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</section>--}}
{{--<!-- Team Section End -->--}}


<!-- Banner Section Start -->
<section class="banner-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="banner-contain-3 section-b-space section-t-space hover-effect">
                    {{--                        <img src="../assets/images/veg-3/banner/3.png" class="img-fluid bg-img" alt="">--}}
                    <div class="banner-detail p-center text-dark position-relative text-center p-0">
                        <div>
                            <h2 class="my-3 text-dark-mint">
                                {{trans('website.4U Netting Hub Insider',[],session()->get('locale'))}}
                                </h2>
                            <h4 class="text-content fw-300">{{trans('website.Read news, stories, answers to questions',[],session()->get('locale'))}}</h4>
                            <button class="btn background-dark-mint mt-sm-4 btn-md mx-auto text-white fw-bold"
                                    onclick="location.href = '/insider';">{{trans('website.Show All',[],session()->get('locale'))}}
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Banner Section End -->

<!-- Newsletter Section Start -->
<section class="newsletter-section ">
    <div class="">
        <div class="newsletter-box newsletter-box-2 newsletter-box-3">
            <div class="newsletter-contain py-5">
                <div class="container">
                    <div class="row">
                        <div class="col-xxl-4 col-lg-5 col-md-7 col-sm-9 offset-xxl-2 offset-md-1">
                            <div class="newsletter-detail">
                                <h2>4U Netting Hub</h2>
                                <h4 class="text-white">
                                    {{trans('website.Learn about the company',[],session()->get('locale'))}}
                                </h4>
                                <br>
                                <br>
                                <div class="input-box mt-2">
                                    <button class="sub-btn btn bg-white text-dark-mint" style="right: unset" onclick="location.href = '/about';">{{trans('website.Discover More',[],session()->get('locale'))}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Newsletter Section End -->

<!-- Product Section Start -->
<section class="product-section bestSaller">
    <div class="container-fluid-lg">
        <div class="row g-sm-4 g-3">

            <div class="col-xxl-12 col-xl-12 text-center">
                <div class="">
                    <div class="title text-center mb-2">
                        <h2 class="text-center theme-second-color mb-1">{{trans('website.Our Best Seller',[],session()->get('locale'))}}</h2>

                        <button class="btn background-dark-mint mt-sm-4 btn-md mx-auto text-white fw-bold mb-3"
                                onclick="location.href = '/bestseller';">{{trans('website.Show All',[],session()->get('locale'))}}
                        </button>

                    </div>
                </div>

                <div class="section-b-space">
                    <div class="border-row overflow-hidden">
                        <div class="slider-user no-arrow">

                            @if($saveProducts)
                                @foreach($saveProducts as $product)
                                    <div>
                                        <div class="row pt-2">
                                            <div class="col-12 px-0 border-0 product-parent-last" >
                                                <div class="product-box border-0 p-0">
                                                    <div class="product-image product-image-last mb-3">
                                                        <a href="{{url('product-details/'.$product->id)}}">
                                                            <img src="{{$product->image}}"
                                                                 class="img-fluid blur-up lazyload h-75" alt="">
                                                        </a>
                                                        <ul class="product-option">
                                                            <li data-bs-toggle="tooltip" data-bs-placement="top" title="View">
                                                                <a href="javascript:void(0)" data-bs-toggle="modal"
                                                                   class="viewProductModel"
                                                                   id="{{$product->id}}"
                                                                   product_name="{{$product->name_en}}"
                                                                   product_flag="{{$product->flag}}"
                                                                   product_image="{{$product->image}}"
                                                                   product_price="{{$product->price}}"
                                                                   price_after_discount="{{$product->price_after_discount}}"
                                                                   product_price_old="{{$product->old_price}}"
                                                                   product_discount_old="{{$product->old_discount}}"
                                                                   product_description="{{$product->description_en}}"
                                                                   stock_status="{{$product->stock_status}}"
                                                                   data-bs-target="#view">
                                                                    <i data-feather="eye"></i>
                                                                </a>
                                                            </li>

                                                            {{--                                                            <li data-bs-toggle="tooltip" data-bs-placement="top"--}}
                                                            {{--                                                                title="Compare">--}}
                                                            {{--                                                                <a href="compare.html">--}}
                                                            {{--                                                                    <i data-feather="refresh-cw"></i>--}}
                                                            {{--                                                                </a>--}}
                                                            {{--                                                            </li>--}}

                                                            <li data-bs-toggle="tooltip" data-bs-placement="top"
                                                                title="Wishlist">
                                                                <a href="javascript:void(0)" class="notifi-wishlist addToWishlist"
                                                                   id="{{$product->id}}"
                                                                   product_name="{{$product->name_en}}"
                                                                   product_flag="{{$product->flag}}"
                                                                   product_image="{{$product->image}}"
                                                                   product_price="{{$product->price}}"
                                                                   price_after_discount="{{$product->price_after_discount}}"
                                                                   product_price_old="{{$product->old_price}}"
                                                                   product_discount_old="{{$product->old_discount}}"
                                                                   product_description="{{$product->description_en}}"
                                                                >
                                                                    <i data-feather="heart"></i>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                    <div class="product-detail">
                                                        {{--                                                        @if($product->category_name)--}}
                                                        {{--                                                            <span class="span-name">{{$product->category_name}}</span>--}}
                                                        {{--                                                        @endif--}}
                                                        @if($product->excluder_flag == 'Y')
{{--                                                        <span class="span-name text-danger">--}}
{{--                                                            {{trans('website.special offer static price',[],session()->get('locale'))}}--}}
{{--                                                        </span>--}}
                                                             <br>
                                                        @endif
                                                        <a href="{{url('product-details/'.$product->id)}}">
                                                            <h6 class="name theme-second-color w-75 mx-auto">
                                                                {{session()->get('locale') =='en' ? $product->name_en :$product->name_ar}}
                                                            </h6>
                                                        </a>

                                                        <h5 class="sold text-content">
                                                            <span class="text-secondary price"> {{$product->price}} {{trans('website.LE',[],session()->get('locale'))}}</span>

                                                            @if($product->old_discount > 0)
                                                                 <del class="text-secondary"> {{$product->old_price}}{{trans('website.LE',[],session()->get('locale'))}}
                                                            </del>
                                                            <span class="theme-second-color price"> ({{$product->old_discount}} % {{trans('website.off',[],session()->get('locale'))}} )</span>
                                                            @endif
                                                        </h5>
                                                        <div class="add-to-cart-box mx-auto bg-white pb-3">
                                                         @if($product->stock_status == 'in stock')
                                                            <button class="btn btn-add-cart addcart-button"
                                                                    product_id="{{$product->id}}"
                                                                    product_name="{{$product->name_en}}"
                                                                    product_flag="{{$product->flag}}"
                                                                    product_image="{{$product->image}}"
                                                                    product_price="{{$product->price}}"
                                                                    price_after_discount="{{$product->price_after_discount}}"
                                                                    product_price_old="{{$product->old_price}}"
                                                                    product_discount_old="{{$product->old_discount}}"
                                                            >
                                                                <i class="fa-solid fa-cart-shopping text-dark-mint"></i>
                                                                &nbsp;
                                                                {{trans('website.Add To Cart',[],session()->get('locale'))}}
                                                            </button>
                                                            @else
                                                                <button class="btn mx-auto text-danger">
                                                                  {{trans('website.out stock',[],session()->get('locale'))}}
                                                                </button>
                                                            @endif
                                                        </div>


                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>




                @include('layoutsWep.componants.buttomcontact')



                <br>
                <br>
                <br>
            </div>
        </div>
    </div>
</section>
<!-- Product Section End -->

