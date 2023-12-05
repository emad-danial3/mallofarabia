@extends('layouts.app')
@section('content')

    @if($product)
        <!-- Breadcrumb Section Start -->
        <section class="breadscrumb-section pt-0">
            <div class="container-fluid-lg">
                <div class="row">
                    <div class="col-12">
                        <div class="breadscrumb-contain">
                            <h2>{{session()->get('locale') =='en' ? $product->name_en :$product->name_ar}}</h2>
                            <nav>
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="/">
                                            <i class="fa-solid fa-house"></i>
                                        </a>
                                    </li>

                                    <li class="breadcrumb-item active">
                                        {{session()->get('locale') =='en' ? $product->name_en :$product->name_ar}}
                                    </li>
                                </ol>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Breadcrumb Section End -->

        <!-- Product Left Sidebar Start -->
        <section class="product-section">
            <div class="container-fluid-lg">
                <div class="row">
                    <div class="col-xxl-11 col-xl-11 col-lg-11 wow fadeInUp">
                        <div class="row g-4">
                            <div class="col-xl-6 wow fadeInUp">
                                <div class="product-left-box">
                                    <div class="row g-2">
                                        <div class="col-xxl-10 col-lg-12 col-md-10 order-xxl-2 order-lg-1 order-md-2">
                                            <div class="product-main-2 no-arrow">
                                                <div>
                                                    <div class="slider-image">
                                                        <img src="{{url($product->image)}}" id="img-1"
                                                             data-zoom-image="{{url($product->image)}}"
                                                             class="img-fluid image_zoom_cls-0 blur-up lazyload" alt="">
                                                    </div>
                                                </div>

                                                <div>
                                                    <div class="slider-image">
                                                        <img src="../assets/images/product/category/2.jpg"
                                                             data-zoom-image="../assets/images/product/category/2.jpg"
                                                             class="img-fluid image_zoom_cls-1 blur-up lazyload" alt="">
                                                    </div>
                                                </div>

                                                <div>
                                                    <div class="slider-image">
                                                        <img src="../assets/images/product/category/3.jpg"
                                                             data-zoom-image="../assets/images/product/category/3.jpg"
                                                             class="img-fluid image_zoom_cls-2 blur-up lazyload" alt="">
                                                    </div>
                                                </div>

                                                <div>
                                                    <div class="slider-image">
                                                        <img src="../assets/images/product/category/4.jpg"
                                                             data-zoom-image="../assets/images/product/category/4.jpg"
                                                             class="img-fluid image_zoom_cls-3 blur-up lazyload" alt="">
                                                    </div>
                                                </div>

                                                <div>
                                                    <div class="slider-image">
                                                        <img src="../assets/images/product/category/5.jpg"
                                                             data-zoom-image="../assets/images/product/category/5.jpg"
                                                             class="img-fluid image_zoom_cls-4 blur-up lazyload" alt="">
                                                    </div>
                                                </div>

                                                <div>
                                                    <div class="slider-image">
                                                        <img src="../assets/images/product/category/6.jpg"
                                                             data-zoom-image="../assets/images/product/category/6.jpg"
                                                             class="img-fluid image_zoom_cls-5 blur-up lazyload" alt="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-2 col-lg-12 col-md-2 order-xxl-1 order-lg-2 order-md-1">
                                            <div class="left-slider-image-2 left-slider no-arrow slick-top">
                                                <div>
                                                    <div class="sidebar-image">
                                                        <img src="{{url($product->image)}}"
                                                             class="img-fluid blur-up lazyload" alt="">
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xl-6 wow fadeInUp" data-wow-delay="0.1s">
                                <div class="right-box-contain">
{{--                                    <h6 class="offer-top">30%  {{trans('website.off',[],session()->get('locale'))}} </h6>--}}
                                    <h2 class="name">
                                         {{session()->get('locale') =='en' ? $product->name_en :$product->name_ar}}
                                    </h2>
                                    <div class="price-rating">
                                        <h3 class="theme-color price">{{$product->price}} {{trans('website.LE',[],session()->get('locale'))}}

                                           @if($product->old_discount > 0)
                                                <del class="text-content">{{$product->old_price}} {{trans('website.LE',[],session()->get('locale'))}}</del>
                                            <span
                                                class="offer theme-color">({{$product->old_discount}} % {{trans('website.off',[],session()->get('locale'))}})</span>
                                            @endif
                                        </h3>
                                        @if($reviews&&count($reviews)>0)
                                            <div class="product-rating custom-rate">
                                                <ul class="rating">
                                                    @for($ii=0;$ii<5;$ii++)
                                                        @if($ii<$reviewsavg)
                                                            <li>
                                                                <i data-feather="star" class="fill"></i>
                                                            </li>
                                                        @else
                                                            <li>
                                                                <i data-feather="star"></i>
                                                            </li>
                                                        @endif
                                                    @endfor
                                                </ul>
                                                <span class="review">{{count($reviews)}} Customer Review</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="procuct-contain">
                                        <p>
                                             {{session()->get('locale') =='en' ? $product->description_en :$product->description_ar}}
                                        </p>
                                    </div>

                                    {{--                                <div class="product-packege">--}}
                                    {{--                                    <div class="product-title">--}}
                                    {{--                                        <h4>Weight</h4>--}}
                                    {{--                                    </div>--}}
                                    {{--                                    <ul class="select-packege">--}}
                                    {{--                                        <li>--}}
                                    {{--                                            <a href="javascript:void(0)" class="active">1/2 KG</a>--}}
                                    {{--                                        </li>--}}
                                    {{--                                        <li>--}}
                                    {{--                                            <a href="javascript:void(0)">1 KG</a>--}}
                                    {{--                                        </li>--}}
                                    {{--                                        <li>--}}
                                    {{--                                            <a href="javascript:void(0)">1.5 KG</a>--}}
                                    {{--                                        </li>--}}
                                    {{--                                        <li>--}}
                                    {{--                                            <a href="javascript:void(0)">Red Roses</a>--}}
                                    {{--                                        </li>--}}
                                    {{--                                        <li>--}}
                                    {{--                                            <a href="javascript:void(0)">With Pink Roses</a>--}}
                                    {{--                                        </li>--}}
                                    {{--                                    </ul>--}}
                                    {{--                                </div>--}}

                                    {{--                                    <div class="time deal-timer product-deal-timer mx-md-0 mx-auto" id="clockdiv-1"--}}
                                    {{--                                         data-hours="1" data-minutes="2" data-seconds="3">--}}
                                    {{--                                        <div class="product-title">--}}
                                    {{--                                            <h4>Hurry up! Sales Ends In</h4>--}}
                                    {{--                                        </div>--}}
                                    {{--                                        <ul>--}}
                                    {{--                                            <li>--}}
                                    {{--                                                <div class="counter d-block">--}}
                                    {{--                                                    <div class="days d-block">--}}
                                    {{--                                                        <h5></h5>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                    <h6>Days</h6>--}}
                                    {{--                                                </div>--}}
                                    {{--                                            </li>--}}
                                    {{--                                            <li>--}}
                                    {{--                                                <div class="counter d-block">--}}
                                    {{--                                                    <div class="hours d-block">--}}
                                    {{--                                                        <h5></h5>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                    <h6>Hours</h6>--}}
                                    {{--                                                </div>--}}
                                    {{--                                            </li>--}}
                                    {{--                                            <li>--}}
                                    {{--                                                <div class="counter d-block">--}}
                                    {{--                                                    <div class="minutes d-block">--}}
                                    {{--                                                        <h5></h5>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                    <h6>Min</h6>--}}
                                    {{--                                                </div>--}}
                                    {{--                                            </li>--}}
                                    {{--                                            <li>--}}
                                    {{--                                                <div class="counter d-block">--}}
                                    {{--                                                    <div class="seconds d-block">--}}
                                    {{--                                                        <h5></h5>--}}
                                    {{--                                                    </div>--}}
                                    {{--                                                    <h6>Sec</h6>--}}
                                    {{--                                                </div>--}}
                                    {{--                                            </li>--}}
                                    {{--                                        </ul>--}}
                                    {{--                                    </div>--}}

                                    <h3 class="mt-2">{{trans('website.Quantity',[],session()->get('locale'))}}</h3>
                                    <div class="note-box product-packege">
                                        <div class="cart_qty qty-box">
                                            <div class="input-group">
                                                <button type="button" class="qty-left-minus bg-gray"
                                                        data-type="minus" data-field="">
                                                    <i class="fa fa-minus" aria-hidden="true"></i>
                                                </button>
                                                <input class="form-control input-number qty-input" type="number"
                                                       name="quantity" value="1" min="1" id="productQuantity">
                                                <button type="button" class="qty-right-plus bg-default"
                                                        data-type="plus" data-field="">
                                                    <i class="fa fa-plus" aria-hidden="true"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                    <br>
                                    <input type="hidden" id="product_id_to_rate" value="{{$product->id}}">
                                    @if($product->stock_status == 'in stock')
                                    <button id="{{$product->id}}"
                                            product_name="{{$product->name_en}}"
                                            product_flag="{{$product->flag}}"
                                            product_image="{{$product->image}}"
                                            product_price="{{$product->price}}"
                                            price_after_discount="{{$product->price_after_discount}}"
                                            product_price_old="{{$product->old_price}}"
                                            product_discount_old="{{$product->old_discount}}"
                                            product_description="{{$product->description_en}}"
                                            product_server_quantity="{{$product->quantity}}"
                                            class="btn btn-md bg-dark cart-button text-white w-100 viewProductModel">
                                       {{trans('website.Add To Cart',[],session()->get('locale'))}}
                                    </button>
                                    @else
                                                                <button class="btn mx-auto text-danger">
                                                                  {{trans('website.out stock',[],session()->get('locale'))}}
                                                                </button>
                                                            @endif


                                    {{--                                    <div class="buy-box">--}}
                                    {{--                                        <a href="wishlist.html">--}}
                                    {{--                                            <i data-feather="heart"></i>--}}
                                    {{--                                            <span>Add To Wishlist</span>--}}
                                    {{--                                        </a>--}}

                                    {{--                                        <a href="compare.html">--}}
                                    {{--                                            <i data-feather="shuffle"></i>--}}
                                    {{--                                            <span>Add To Compare</span>--}}
                                    {{--                                        </a>--}}
                                    {{--                                    </div>--}}

                                    <div class="pickup-box">
                                        <div class="product-title">
                                            <h4>{{trans('website.Store Information',[],session()->get('locale'))}}</h4>
                                        </div>


                                        <div class="product-info">
                                            <ul class="product-info-list product-info-list-2">
                                                <li>{{trans('website.Category',[],session()->get('locale'))}} :
                                                    <a href="javascript:void(0)">{{$product->category_name}}</a></li>
                                                <li>{{trans('website.Stock',[],session()->get('locale'))}} :
                                                    <a href="javascript:void(0)">{{$product->quantity > 0 ? "In Stock":"out Stock"}}</a>
                                                </li>
                                                {{--                                                <li>Filter : <a href="javascript:void(0)">Cake,</a> <a--}}
                                                {{--                                                        href="javascript:void(0)">Backery</a></li>--}}
                                            </ul>
                                        </div>
                                    </div>


                                    <div class="pickup-box">
                                        <div class="product-title">
                                            <h4>{{trans('website.Share',[],session()->get('locale'))}}</h4>
                                        </div>

                                        <!-- Go to www.addthis.com/dashboard to customize your tools -->
                                        <div class="addthis_inline_share_toolbox_6n1d"></div>

                                    </div>
                                    @if(Auth::user()&&Auth::user()->id > 0)
                                        <div class="pickup-box">
                                            <div class="product-title">
                                                <h4>Review</h4>
                                            </div>
                                            <div class="price-rating">

                                                <div class="product-rating custom-rate">
                                                    Choose Rate &nbsp;
                                                    <ul class="rating" id="chooseRate">
                                                        <li class="1">
                                                            <i data-feather="star"></i>
                                                        </li>
                                                        <li class="2">
                                                            <i data-feather="star"></i>
                                                        </li>
                                                        <li class="3">
                                                            <i data-feather="star"></i>
                                                        </li>
                                                        <li class="4">
                                                            <i data-feather="star"></i>
                                                        </li>
                                                        <li class="5">
                                                            <i data-feather="star"></i>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                            <div class="product-title">
                                                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                                                <textarea class="form-control w-100 mt-2" id="ratingFormControlTextarea" placeholder="Enter Your Comment" rows="3"></textarea>

                                                <h3 id="saveReviewButton" class="delivery-login-box mt-3 cursor-pointer btn btn-primary bg-theme text-white">
                                                    Comment &nbsp; &nbsp;
                                                    <i class="fa-sharp fa-solid fa-circle-right  fa-2x"></i>
                                                </h3>
                                            </div>
                                        </div>
                                        @if($reviews&&count($reviews)>0)
                                            <div class="pickup-box">
                                                <div class="product-title">
                                                    <h4>{{count($reviews)}} Customer Reviews</h4>
                                                </div>
                                                @foreach($reviews as $row)
                                                    <div class="price-rating mt-2">
                                                        <div class="row">
                                                            <div class="col-md-4">
                                                                @if($row->user && $row->user->profile_photo)
                                                                    <img src="{{url($row->user->profile_photo)}}"
                                                                         class="blur-up lazyload rounded-circle" width="60" height="60" alt="">
                                                                @else
                                                                    <img src="../assets/images/inner-page/user/1.jpg"
                                                                         class="blur-up lazyload rounded-circle" width="60" height="60" alt="">
                                                                @endif
                                                            </div>
                                                            <div class="col-md-8">
                                                                <h4>{{$row->user->full_name}}</h4>
                                                                <div class="price-rating mt-1">

                                                                    <div class="product-rating custom-rate">
                                                                        <ul class="rating">
                                                                            @for($iii=1;$iii<6;$iii++)
                                                                                @if($iii<$row->rate)
                                                                                    <li>
                                                                                        <i data-feather="star" class="fill"></i>
                                                                                    </li>
                                                                                @else
                                                                                    <li>
                                                                                        <i data-feather="star"></i>
                                                                                    </li>
                                                                                @endif
                                                                            @endfor
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                                <p class="text-secondary mt-1">{{$row->created_at->format('d M Y')}}</p>
                                                            </div>
                                                            <div class="col-md-12">
                                                                <h4>{{$row->comment}}</h4>
                                                            </div>
                                                        </div>
                                                    </div>
                                                @endforeach
                                            </div>
                                        @endif
                                    @endif
                                </div>
                            </div>


                        </div>
                    </div>

                    <div class="col-xxl-1 col-xl-1 col-lg-1 d-none d-lg-block wow fadeInUp">
                        <div class="right-sidebar-box">
                            {{--                            <div class="vendor-box">--}}
                            {{--                                <div class="verndor-contain">--}}
                            {{--                                    <div class="vendor-image">--}}
                            {{--                                        <img src="../assets/images/product/vendor.png" class="blur-up lazyload" alt="">--}}
                            {{--                                    </div>--}}

                            {{--                                    <div class="vendor-name">--}}
                            {{--                                        <h5 class="fw-500">Noodles Co.</h5>--}}

                            {{--                                        <div class="product-rating mt-1">--}}
                            {{--                                            <ul class="rating">--}}
                            {{--                                                <li>--}}
                            {{--                                                    <i data-feather="star" class="fill"></i>--}}
                            {{--                                                </li>--}}
                            {{--                                                <li>--}}
                            {{--                                                    <i data-feather="star" class="fill"></i>--}}
                            {{--                                                </li>--}}
                            {{--                                                <li>--}}
                            {{--                                                    <i data-feather="star" class="fill"></i>--}}
                            {{--                                                </li>--}}
                            {{--                                                <li>--}}
                            {{--                                                    <i data-feather="star" class="fill"></i>--}}
                            {{--                                                </li>--}}
                            {{--                                                <li>--}}
                            {{--                                                    <i data-feather="star"></i>--}}
                            {{--                                                </li>--}}
                            {{--                                            </ul>--}}
                            {{--                                            <span>(36 Reviews)</span>--}}
                            {{--                                        </div>--}}

                            {{--                                    </div>--}}
                            {{--                                </div>--}}

                            {{--                                <p class="vendor-detail">Noodles & Company is an American fast-casual--}}
                            {{--                                    restaurant that offers international and American noodle dishes and pasta.</p>--}}

                            {{--                                <div class="vendor-list">--}}
                            {{--                                    <ul>--}}
                            {{--                                        <li>--}}
                            {{--                                            <div class="address-contact">--}}
                            {{--                                                <i data-feather="map-pin"></i>--}}
                            {{--                                                <h5>Address: <span class="text-content">1288 Franklin Avenue</span></h5>--}}
                            {{--                                            </div>--}}
                            {{--                                        </li>--}}

                            {{--                                        <li>--}}
                            {{--                                            <div class="address-contact">--}}
                            {{--                                                <i data-feather="headphones"></i>--}}
                            {{--                                                <h5>Contact Seller: <span class="text-content">(+1)-123-456-789</span>--}}
                            {{--                                                </h5>--}}
                            {{--                                            </div>--}}
                            {{--                                        </li>--}}
                            {{--                                    </ul>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}

                            {{--                            <!-- Trending Product -->--}}
                            {{--                            <div class="pt-25">--}}
                            {{--                                <div class="category-menu">--}}
                            {{--                                    <h3>Trending Products</h3>--}}

                            {{--                                    <ul class="product-list product-right-sidebar border-0 p-0">--}}
                            {{--                                        <li>--}}
                            {{--                                            <div class="offer-product">--}}
                            {{--                                                <a href="product-left-thumbnail.html" class="offer-image">--}}
                            {{--                                                    <img src="../assets/images/vegetable/product/23.png"--}}
                            {{--                                                         class="img-fluid blur-up lazyload" alt="">--}}
                            {{--                                                </a>--}}

                            {{--                                                <div class="offer-detail">--}}
                            {{--                                                    <div>--}}
                            {{--                                                        <a href="product-left-thumbnail.html">--}}
                            {{--                                                            <h6 class="name">Meatigo Premium Goat Curry</h6>--}}
                            {{--                                                        </a>--}}
                            {{--                                                        <span>450 G</span>--}}
                            {{--                                                        <h6 class="price theme-color">$ 70.00</h6>--}}
                            {{--                                                    </div>--}}
                            {{--                                                </div>--}}
                            {{--                                            </div>--}}
                            {{--                                        </li>--}}

                            {{--                                        <li>--}}
                            {{--                                            <div class="offer-product">--}}
                            {{--                                                <a href="product-left-thumbnail.html" class="offer-image">--}}
                            {{--                                                    <img src="../assets/images/vegetable/product/24.png"--}}
                            {{--                                                         class="blur-up lazyload" alt="">--}}
                            {{--                                                </a>--}}

                            {{--                                                <div class="offer-detail">--}}
                            {{--                                                    <div>--}}
                            {{--                                                        <a href="product-left-thumbnail.html">--}}
                            {{--                                                            <h6 class="name">Dates Medjoul Premium Imported</h6>--}}
                            {{--                                                        </a>--}}
                            {{--                                                        <span>450 G</span>--}}
                            {{--                                                        <h6 class="price theme-color">$ 40.00</h6>--}}
                            {{--                                                    </div>--}}
                            {{--                                                </div>--}}
                            {{--                                            </div>--}}
                            {{--                                        </li>--}}

                            {{--                                        <li>--}}
                            {{--                                            <div class="offer-product">--}}
                            {{--                                                <a href="product-left-thumbnail.html" class="offer-image">--}}
                            {{--                                                    <img src="../assets/images/vegetable/product/25.png"--}}
                            {{--                                                         class="blur-up lazyload" alt="">--}}
                            {{--                                                </a>--}}

                            {{--                                                <div class="offer-detail">--}}
                            {{--                                                    <div>--}}
                            {{--                                                        <a href="product-left-thumbnail.html">--}}
                            {{--                                                            <h6 class="name">Good Life Walnut Kernels</h6>--}}
                            {{--                                                        </a>--}}
                            {{--                                                        <span>200 G</span>--}}
                            {{--                                                        <h6 class="price theme-color">$ 52.00</h6>--}}
                            {{--                                                    </div>--}}
                            {{--                                                </div>--}}
                            {{--                                            </div>--}}
                            {{--                                        </li>--}}

                            {{--                                        <li class="mb-0">--}}
                            {{--                                            <div class="offer-product">--}}
                            {{--                                                <a href="product-left-thumbnail.html" class="offer-image">--}}
                            {{--                                                    <img src="../assets/images/vegetable/product/26.png"--}}
                            {{--                                                         class="blur-up lazyload" alt="">--}}
                            {{--                                                </a>--}}

                            {{--                                                <div class="offer-detail">--}}
                            {{--                                                    <div>--}}
                            {{--                                                        <a href="product-left-thumbnail.html">--}}
                            {{--                                                            <h6 class="name">Apple Red Premium Imported</h6>--}}
                            {{--                                                        </a>--}}
                            {{--                                                        <span>1 KG</span>--}}
                            {{--                                                        <h6 class="price theme-color">$ 80.00</h6>--}}
                            {{--                                                    </div>--}}
                            {{--                                                </div>--}}
                            {{--                                            </div>--}}
                            {{--                                        </li>--}}
                            {{--                                    </ul>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}

                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Product Left Sidebar End -->
    @endif

@endsection

@section('java_script')
    <script>
        $(document).ready(function () {

            var base_url              = window.location;
            var productId             = '';
            var productName           = '';
            var productImage          = '';
            var productPrice          = '';
            var productFlag           = '';
            var priceAfterDiscount    = '';
            var productPriceOld       = '';
            var productQuantity       = '';
            var productServerQuantity = 0;
            var curentUserProductRate = -1;
            var productIdToRate       = $('#product_id_to_rate').val();
            $(".viewProductModel").click(function () {
                productId             = $(this).attr('id');
                productName           = $(this).attr('product_name');
                productImage          = $(this).attr('product_image');
                productPrice          = $(this).attr('product_price');
                priceAfterDiscount    = $(this).attr('price_after_discount');
                productFlag           = $(this).attr('product_flag');
                productServerQuantity = $(this).attr('product_server_quantity');
                productQuantity       = $('#productQuantity').val();

                if (Number(productQuantity) > Number(productServerQuantity) || Number(productQuantity) < 1) {
                    alert("Quantity not available");
                }
                else {


                    var newProduct2 = {
                        'id': productId,
                        'name': productName,
                        'image': productImage,
                        'price': productPrice,
                        'price_after_discount': priceAfterDiscount,
                        'flag': productFlag,
                        'total': 0,
                        'quantity': productQuantity
                    }
                    var userCart    = localStorage.getItem('user_cart');
                    if (!userCart || userCart == null || userCart == '' || userCart.length == 0) {
                        var allProducts = [];
                        allProducts.push(newProduct2);
                        const myJSON = JSON.stringify(allProducts);
                        localStorage.setItem("user_cart", myJSON);
                        $('#herderCardCount').html('1')
                        $('#herderCardTotalCount').html(productPrice);
                        let upto = (productPrice - (productPrice * .3))
                        $('#herderUpToTotalCount').html('LE ' + upto)
                    }
                    else {
                        var allProductsArray = JSON.parse(userCart);
                        var el_exist_inarray = allProductsArray.find((e) => e.id == newProduct2.id);
                        if (el_exist_inarray) {
                            var newnewProduct2 = {
                                'id': productId,
                                'name': productName,
                                'image': productImage,
                                'price': productPrice,
                                'price_after_discount': priceAfterDiscount,
                                'flag': productFlag,
                                'total': 0,
                                'quantity': (parseInt(el_exist_inarray.quantity) + parseInt(1))
                            }
                            const indx         = allProductsArray.findIndex(v => v.id == el_exist_inarray.id);
                            allProductsArray.splice(indx, indx >= 0 ? 1 : 0);
                            allProductsArray.push(newnewProduct2);
                        }
                        else {
                            allProductsArray.push(newProduct2);
                        }
                        const myJSON = JSON.stringify(allProductsArray);
                        localStorage.setItem("user_cart", myJSON);
                        const cartLength = allProductsArray.length;

                        var subtotal   = 0;
                        var shipping   = 0;
                        var total_cart = 0;
                        for (let ii = 0; ii < cartLength; ii++) {
                            var proObjff      = allProductsArray[ii];
                            proObjff['total'] = (Number(proObjff['price']) * parseInt(proObjff['quantity']));
                            subtotal          = (Number(subtotal) + Number(proObjff['total']));
                            total_cart        = (Number(total_cart) + Number(proObjff['total']));
                        }
                        if (subtotal > 0 && subtotal < 250) {
                            shipping   = 50;
                            total_cart = subtotal + shipping;
                        }
                        $('#herderCardCount').html(cartLength)
                        $('#herderCardTotalCount').html(total_cart + ' LE')
                        let upto = (total_cart - (total_cart * .3))
                        $('#herderUpToTotalCount').html(upto + ' LE')

                    }
                    swal({
                        text: "{{trans('website.Add Product To Cart',[],session()->get('locale'))}}",
                        title: "Successful",
                        timer: 2500,
                        icon: "success",
                        buttons: false,
                    });
                }
            });

            $("#saveReviewButton").click(function () {
                $('#saveReviewButton').prop('disabled', true);
                var ratingFormControlTextarea = $('textarea#ratingFormControlTextarea').val();
                if (productIdToRate > 0 && curentUserProductRate > -1 ) {
                    var object = {
                        "rate": curentUserProductRate,
                        "product_id": productIdToRate,
                        "comment": ratingFormControlTextarea,
                    }
                    $.ajax({
                        url: "{{url('/saveProductReview')}}",
                        type: 'POST',
                        cache: false,
                        data: JSON.stringify(object),
                        contentType: "application/json; charset=utf-8",
                        traditional: true,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        processData: false,
                        success: function (response) {
                            if (response.data && response.status == 200) {
                                $('textarea#ratingFormControlTextarea').val('');
                                $("#chooseRate").html('');
                                for (let i = 1; i < 6; i++) {
                                    $("#chooseRate").append('<li class="' + i + '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></li>');
                                }
                                swal({
                                    text: "Add Comment Successful And Under Review",
                                    title: "Successful",
                                    timer: 2500,
                                    icon: "success",
                                    buttons: false,
                                });
                            }
                            else if (response.data && response.status == 401) {
                                console.log(response)
                                alert(response.message)
                            }
                        },
                        error: function (response) {
                            console.log(response)
                            alert('error');
                        }
                    });
                }else {
                    alert("enter rate and Comment")
                }

            });

            $("#chooseRate li").click(function () {
                curentUserProductRate = $(this).attr("class");
                $("#chooseRate").html('');
                for (let i = 1; i < 6; i++) {
                    if (i <= curentUserProductRate) {
                        $("#chooseRate").append('<li class="' + i + '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star fill"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></li>');
                    }
                    else {
                        $("#chooseRate").append('<li class="' + i + '"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-star"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"></polygon></svg></li>');
                    }
                }
            });

        });

    </script>

    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5d0260104fa01709"></script>

@endsection
