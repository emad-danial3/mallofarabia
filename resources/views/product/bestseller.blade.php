@extends('layouts.app')
@section('style')
    <style>
        body {
            font-family: 'Karla', 'Arial', sans-serif;
            font-weight: 500;
            background: rgba(247, 117, 96, 1);
            background: linear-gradient(45deg,
            #0f3443, #34e89e);
        }

        p {
            padding: 0;
            margin: 0;
        }

        .wrapper {
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        .filter-price {
            width: 220px;
            border: 0;
            padding: 0;
            margin: 0;
        }

        .price-title {
            position: relative;
            color: #000;
            font-size: 14px;
            line-height: 1.2em;
            font-weight: 400;
        }

        .price-field {
            position: relative;
            width: 100%;
            height: 36px;
            box-sizing: border-box;
            background: rgba(248, 247, 244, 0.2);
            padding-top: 15px;
            padding-left: 16px;
            border-radius: 3px;
        }

        .price-field input[type=range] {
            position: absolute;
        }

        /* Reset style for input range */

        .price-field input[type=range] {
            width: 188px;
            height: 4px;
            border: 0;
            outline: 0;
            box-sizing: border-box;
            border-radius: 5px;
            pointer-events: none;
            -webkit-appearance: none;
        }

        .price-field input[type=range]::-webkit-slider-thumb {
            -webkit-appearance: none;
        }

        .price-field input[type=range]:active,
        .price-field input[type=range]:focus {
            outline: 0;
        }

        .price-field input[type=range]::-ms-track {
            width: 188px;
            height: 2px;
            border: 1px solid #fff;
            outline: 0;
            box-sizing: border-box;
            border-radius: 5px;
            pointer-events: none;
            background: transparent;
            color: transparent;

        }

        /* Style toddler input range */

        .price-field input[type=range]::-webkit-slider-thumb {
            /* WebKit/Blink */
            position: relative;
            -webkit-appearance: none;
            margin: 0;
            border: 2px solid #fff;
            outline: 0;
            border-radius: 50%;
            height: 20px;
            width: 20px;
            margin-top: -8px;
            background-color: var(--theme-color);
            cursor: pointer;
            pointer-events: all;
            z-index: 100;
        }

        .price-field input[type=range]::-moz-range-thumb {
            /* Firefox */
            position: relative;
            appearance: none;
            margin: 0;
            border: 1px solid #fff;
            outline: 0;
            border-radius: 50%;
            height: 20px;
            width: 20px;
            margin-top: -10px;
            background-color: var(--theme-color);
            cursor: pointer;
            pointer-events: all;
            z-index: 100;
        }

        .price-field input[type=range]::-ms-thumb {
            /* IE */
            position: relative;
            appearance: none;
            margin: 0;
            border: 1px solid #fff;
            outline: 0;
            border-radius: 50%;
            height: 20px;
            width: 20px;
            margin-top: -10px;
            background-color: var(--theme-color);
            cursor: pointer;
            pointer-events: all;
            z-index: 100;
        }

        /* Style track input range */

        .price-field input[type=range]::-webkit-slider-runnable-track {
            /* WebKit/Blink */
            width: 188px;
            height: 4px;
            cursor: pointer;
            background: var(--theme-color);
            border-radius: 5px;
        }

        .price-field input[type=range]::-moz-range-track {
            /* Firefox */
            width: 188px;
            height: 2px;
            cursor: pointer;
            background: #000;
            border-radius: 5px;
        }

        .price-field input[type=range]::-ms-track {
            /* IE */
            width: 188px;
            height: 2px;
            cursor: pointer;
            background: #000;
            border-radius: 5px;
        }

        /* Style for input value block */

        .price-wrap {
            display: flex;
            justify-content: center;
            color: #000;
            font-size: 14px;
            line-height: 1.2em;
            font-weight: 400;
            margin-bottom: 7px;
        }

        .price-wrap-1,
        .price-wrap-2 {
            display: flex;
        }

        .price-title {
            margin-right: 5px;
            backgrund: #d58e32;
        }

        .price-wrap_line {
            margin: 0 10px;
        }

        .price-wrap #one,
        .price-wrap #two {
            width: 30px;
            text-align: right;
            margin: 0;
            padding: 0;
            margin-right: 2px;
            background: 0;
            border: 0;
            outline: 0;
            color: #000;
            font-family: 'Karla', 'Arial', sans-serif;
            font-size: 14px;
            line-height: 1.2em;
            font-weight: 400;
        }

        .price-wrap label {
            text-align: right;
        }

        /* Style for active state input */

        .price-field input[type=range]:hover::-webkit-slider-thumb {
            box-shadow: 0 0 0 0.5px #000;
            transition-duration: 0.3s;
        }

        .price-field input[type=range]:active::-webkit-slider-thumb {
            box-shadow: 0 0 0 0.5px #000;
            transition-duration: 0.3s;
        }

        .goToSearch {
            background-color: #1e96b9;
        }

        .product-option {
            justify-content: center !important;
            width: 60% !important;
        }

        .shop-section .left-box {
            padding: 15px;
            border: 1px solid #ddd;
        }

        .accordion-item {
            border: unset;
        }

        .product-header {
            border: 1.03743px solid #E9E9E9;
            box-shadow: 0px 2.24873px 2.24873px rgba(0, 0, 0, 0.05);
            border-radius: 20.7486px;
            height: 230px;
        }

        .product-box-3 {
            background-color: #f7f6fa !important;
            padding: 0px;
            border-radius: 20px;
        }
    </style>
@endsection
@section('content')

    <!-- Shop Section Start -->
    <section class="section-b-space shop-section">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-custome-3">
                    <div class="left-box wow fadeInUp">
                        <div class="shop-left-sidebar">
                            <div class="row">
                                <div class="col-12">
                                    <div class="breadscrumb-contain">
                                        <h2 class="theme-second-color"> &nbsp; Category</h2><br>
                                    </div>
                                </div>

                                <div class="col-md-12">


                                    <div class="accordion" id="accordionExample">
                                        @if($categories)
                                            @foreach($categories as $category)
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingTwo{{$category->id}}">
                                                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo{{$category->id}}" aria-expanded="false" aria-controls="collapseTwo{{$category->id}}">
                                                            {{$category->name_en}}
                                                        </button>
                                                    </h2>
                                                    <div id="collapseTwo{{$category->id}}" class="accordion-collapse collapse" aria-labelledby="headingTwo{{$category->id}}" data-bs-parent="#accordionExample">
                                                        <div class="accordion-body" style="padding: 10px 0px">
                                                            <div class="list-group">
                                                                @if(!empty($category->sub))
                                                                    @foreach($category->sub as $subcategory)
                                                                        <a href="{{url('/products?category_id='.$subcategory->id)}}" class="list-group-item list-group-item-action">
                                                                            &nbsp; &nbsp;
                                                                            <i class="fa-solid fa-circle"></i> &nbsp;
                                                                            {{$subcategory->name_en}}
                                                                        </a>
                                                                    @endforeach
                                                                @endif

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif

                                    </div>

                                </div>
                            </div>

                            <div class="row">
                                <div class="col-xxl-12 col-lg-12 ">
                                    <div class=" wow fadeInUp  pb-4  ">
                                        <div class="">
                                            <div class="back-button">
                                                <h3><i class="fa-solid fa-arrow-left"></i> Back</h3>
                                            </div>

                                            <div class="accordion" id="accordionExample">
                                                <div class="col-12 border-1">
                                                    <hr>
                                                </div>
                                                <div class="col-12">
                                                    <div class="breadscrumb-contain">
                                                        <h3 class="theme-second-color"> &nbsp; Filter</h3><br>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header" id="headingThree">
                                                        <button class="accordion-button collapsed" type="button"
                                                                data-bs-toggle="collapse" data-bs-target="#collapseThree"
                                                                aria-expanded="false" aria-controls="collapseThree">
                                                            <span> &nbsp; Price </span>
                                                        </button>
                                                    </h2>
                                                    <div id="collapseThree" class="accordion-collapse collapse show"
                                                         aria-labelledby="headingThree">


                                                        <div class="wrapper">
                                                            <fieldset class="filter-price">

                                                                <div class="price-field">
                                                                    <input type="range" min="0" max="1000" value="0" id="lower">
                                                                    <input type="range" min="0" max="1000" value="1000" id="upper">
                                                                </div>
                                                                <div class="price-wrap">
                                                                    <div class="price-wrap-1">
                                                                        <input id="one">
                                                                        <label for="one"> LE</label>
                                                                    </div>
                                                                    <div class="price-wrap_line">-</div>
                                                                    <div class="price-wrap-2">
                                                                        <input id="two">
                                                                        <label for="two"> LE</label>
                                                                    </div>
                                                                </div>
                                                            </fieldset>
                                                        </div>
                                                        <button type="button" class="btn  text-white goToSearch p-2 mx-auto">
                                                            GO
                                                        </button>
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

                <div class="col-custome-9">
                    <div class="show-button">
{{--                        <div class="filter-button d-inline-block d-lg-none">--}}
{{--                            <a><i class="fa-solid fa-filter"></i> Filter Menu</a>--}}
{{--                        </div>--}}

                        <div class="top-filter-menu">
                            {{--                            <div class="category-dropdown">--}}
                            {{--                                <h5 class="text-content">Sort By :</h5>--}}
                            {{--                                <div class="dropdown">--}}
                            {{--                                    <button class="dropdown-toggle" type="button" id="dropdownMenuButton1"--}}
                            {{--                                            data-bs-toggle="dropdown">--}}
                            {{--                                        <span>Most Popular</span> <i class="fa-solid fa-angle-down"></i>--}}
                            {{--                                    </button>--}}
                            {{--                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">--}}
                            {{--                                        <li>--}}
                            {{--                                            <a class="dropdown-item" id="pop" href="javascript:void(0)">Popularity</a>--}}
                            {{--                                        </li>--}}
                            {{--                                        <li>--}}
                            {{--                                            <a class="dropdown-item" id="low" href="javascript:void(0)">Low - High--}}
                            {{--                                                Price</a>--}}
                            {{--                                        </li>--}}
                            {{--                                        <li>--}}
                            {{--                                            <a class="dropdown-item" id="high" href="javascript:void(0)">High - Low--}}
                            {{--                                                Price</a>--}}
                            {{--                                        </li>--}}
                            {{--                                        <li>--}}
                            {{--                                            <a class="dropdown-item" id="rating" href="javascript:void(0)">Average--}}
                            {{--                                                Rating</a>--}}
                            {{--                                        </li>--}}
                            {{--                                        <li>--}}
                            {{--                                            <a class="dropdown-item" id="aToz" href="javascript:void(0)">A - Z Order</a>--}}
                            {{--                                        </li>--}}
                            {{--                                        <li>--}}
                            {{--                                            <a class="dropdown-item" id="zToa" href="javascript:void(0)">Z - A Order</a>--}}
                            {{--                                        </li>--}}
                            {{--                                        <li>--}}
                            {{--                                            <a class="dropdown-item" id="off" href="javascript:void(0)">% Off - Hight To--}}
                            {{--                                                Low</a>--}}
                            {{--                                        </li>--}}
                            {{--                                    </ul>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}

                            <div class="d-none d-md-block">
                                <h2 class="theme-second-color"> Best sellers</h2>
                            </div>
                            <div class="grid-option d-none d-md-block">
                                <ul>
                                    <li class="three-grid">
                                        <a href="javascript:void(0)">
                                            <img src="../assets/svg/grid-3.svg" class="blur-up lazyload" alt="">
                                        </a>
                                    </li>
                                    <li class="grid-btn d-xxl-inline-block d-none active">
                                        <a href="javascript:void(0)">
                                            <img src="../assets/svg/grid-4.svg"
                                                 class="blur-up lazyload d-lg-inline-block d-none" alt="">
                                            <img src="../assets/svg/grid.svg"
                                                 class="blur-up lazyload img-fluid d-lg-none d-inline-block" alt="">
                                        </a>
                                    </li>
                                    <li class="list-btn">
                                        <a href="javascript:void(0)">
                                            <img src="../assets/svg/list.svg" class="blur-up lazyload" alt="">
                                        </a>
                                    </li>
                                </ul>
                            </div>

                        </div>

                        {{--                        <div class="filter-category">--}}
                        {{--                            <ul>--}}
                        {{--                                <li>--}}
                        {{--                                    <a href="javascript:void(0)">Vegetable</a>--}}
                        {{--                                </li>--}}
                        {{--                                <li>--}}
                        {{--                                    <a href="javascript:void(0)">Fruit</a>--}}
                        {{--                                </li>--}}
                        {{--                                <li>--}}
                        {{--                                    <a href="javascript:void(0)">Fresh</a>--}}
                        {{--                                </li>--}}
                        {{--                                <li>--}}
                        {{--                                    <a href="javascript:void(0)">Milk</a>--}}
                        {{--                                </li>--}}
                        {{--                                <li>--}}
                        {{--                                    <a href="javascript:void(0)">Meat</a>--}}
                        {{--                                </li>--}}
                        {{--                            </ul>--}}
                        {{--                        </div>--}}
                    </div>

                    <div
                        class="row g-sm-4 g-3 product-list-section row-cols-xl-3 row-cols-lg-2 row-cols-md-3 row-cols-2">


                        @if($products)
                            @if($products->count() >0)
                                @foreach($products as  $product )
                                    <div>
                                        <div class="product-box-3 h-100 wow fadeInUp bg-white">
                                            <div class="product-header bg-white mb-2">
                                                <div class="product-image h-100">
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
                                                               product_server_quantity="{{$product->quantity}}"
                                                               data-bs-target="#view">
                                                                <i data-feather="eye"></i>
                                                            </a>
                                                        </li>

                                                        {{--                                                        <li data-bs-toggle="tooltip" data-bs-placement="top" title="Compare">--}}
                                                        {{--                                                            <a href="compare.html">--}}
                                                        {{--                                                                <i data-feather="refresh-cw"></i>--}}
                                                        {{--                                                            </a>--}}
                                                        {{--                                                        </li>--}}

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
                                            </div>
                                            <div class="product-footer">
                                                <div class="product-detail p-2 text-center">
                                                    @if($product->category_name)
                                                        <span class="span-name theme-second-color">{{$product->category_name}}</span>
                                                    @endif

                                                    <a href="{{url('product-details/'.$product->id)}}">
                                                        <h5 class="name theme-second-color"> {!! session()->get('locale') =='en' ? (strlen($product->name_en) <40 ? $product->name_en ."<hr style='height:0px!important;margin: 1.5rem 0;'> " : $product->name_en  ) : (strlen($product->name_ar) <100 ? $product->name_ar . "<hr style='height:0px!important;margin: 1.5rem 0;'> ": $product->name_ar) !!}</h5>
                                                    </a>
                                                    <h5 class="price text-muted">Price
                                                        <span class="text-muted">{{$product->price}} LE </span>

                                                       @if($product->old_discount > 0)
                                                            <del> {{$product->old_price}} LE</del>
                                                        <span
                                                            class="offer theme-second-color">({{$product->old_discount}} % off)</span>
                                                        @endif
                                                    </h5>
                                                    <h5 class="price">
                                                        <a
                                                            @if(Auth::user()&&Auth::user()->stage == '2' && Auth::user()->user_type == 'member')
                                                            href="{{url('segment_commission')}}"
                                                            @elseif(Auth::user()&&Auth::user()->stage == '1' && Auth::user()->user_type == 'normal_user')
                                                            href="{{url('memberProfile')}}"
                                                            @else
                                                            href="{{url('joinus')}}"
                                                            @endif
                                                            class="btn theme-bg-color view-button icon text-white fw-bold btn-md">
                                                            VIP member price
                                                            &nbsp; {{$product->price_after_discount}} LE
                                                        </a>
                                                    </h5>
                                                         @if($product->stock_status == 'in stock')
                                                    <div class="add-to-cart-box background-dark-mint align-bottom mx-auto">
                                                        <button class="btn btn-add-cart addcart-button text-white "
                                                                product_id="{{$product->id}}"
                                                                product_name="{{$product->name_en}}"
                                                                product_flag="{{$product->flag}}"
                                                                product_image="{{$product->image}}"
                                                                product_price="{{$product->price}}"
                                                                price_after_discount="{{$product->price_after_discount}}"
                                                                product_price_old="{{$product->old_price}}"
                                                                product_discount_old="{{$product->old_discount}}"
                                                        >
                                                            {{trans('website.Add To Cart',[],session()->get('locale'))}}
                                                        </button>
                                                    </div>
                                                     @else
                                                                <button class="btn mx-auto text-danger">
                                                                  {{trans('website.out stock',[],session()->get('locale'))}}
                                                                </button>
                                                            @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <h2 class="col-md-12 text-center w-100">{{trans('website.No Data',[],session()->get('locale'))}}</h2>
                            @endif
                        @endif

                    </div>


                    <nav class="custome-pagination">
                        @if (isset($products) && $products->lastPage() > 1)
                            <ul class="pagination justify-content-center">
                            @php
                                $interval = isset($interval) ? abs(intval($interval)) : 3 ;
                                $from = $products->currentPage() - $interval;
                                if($from < 1){
                                  $from = 1;
                                }

                                $to = $products->currentPage() + $interval;
                                if($to > $products->lastPage()){
                                  $to = $products->lastPage();
                                }
                            @endphp
                            <!-- first/previous -->
                                @if($products->currentPage() > 1)
                                    <li class="page-item">
                                        <a href="{{ $products->url(1)."&name=".app('request')->input('name')."&min_price=".app('request')->input('min_price')."&max_price=".app('request')->input('max_price')}}" aria-label="First" class="page-link">
                                            <span aria-hidden="true" class="h4">&laquo;</span>
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <a href="{{ $products->url($products->currentPage() - 1)."&name=".app('request')->input('name')."&min_price=".app('request')->input('min_price')."&max_price=".app('request')->input('max_price') }}" aria-label="Previous" class="page-link">
                                            <span aria-hidden="true" class="h4">&lsaquo;</span>
                                        </a>
                                    </li>
                                @endif
                            <!-- links -->
                                @for($i = $from; $i <= $to; $i++)
                                    @php
                                        $isCurrentPage = $products->currentPage() == $i;
                                    @endphp
                                    <li class="page-item {{ $isCurrentPage ? 'active' : '' }}" style="padding: 5px">
                                        <a class="page-link" href="{{ !$isCurrentPage ? $products->url($i)."&name=".app('request')->input('name')."&min_price=".app('request')->input('min_price')."&max_price=".app('request')->input('max_price') : '' }}">
                                            {{ $i }}
                                        </a>
                                    </li>
                                @endfor
                            <!-- next/last -->
                                @if($products->currentPage() < $products->lastPage())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $products->url($products->currentPage() + 1)."&name=".app('request')->input('name')."&min_price=".app('request')->input('min_price')."&max_price=".app('request')->input('max_price') }}" aria-label="Next">
                                            <span aria-hidden="true" class="h4">&rsaquo;</span>
                                        </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $products->url($products->lastpage())."&name=".app('request')->input('name')."&min_price=".app('request')->input('min_price')."&max_price=".app('request')->input('max_price') }}" aria-label="Last">
                                            <span aria-hidden="true" class="h4">&raquo;</span>
                                        </a>
                                    </li>
                                @endif
                            </ul>
                        @endif
                    </nav>

                </div>
            </div>
        </div>
    </section>
    <!-- Shop Section End -->

    <!-- Quick View Modal Box Start -->
    <div class="modal fade theme-modal view-modal" id="view" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header p-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row g-sm-4 g-2">
                        <div class="col-lg-6">
                            <div class="slider-image">
                                <img id="productImage" src="../assets/images/product/category/1.jpg" class="img-fluid blur-up lazyload"
                                     alt="">
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="right-sidebar-modal">
                                <h4 class="title-name" id="productName">Peanut Butter Bite Premium Butter Cookies 600
                                    g</h4>

                                <h4 class="price">Price
                                    &nbsp;<span class="theme-color" id="productPrice">100 </span> LE
                                </h4>
                                <h4 class="price">


                                    <a
                                        @if(Auth::user()&&Auth::user()->stage == '2' && Auth::user()->user_type == 'member')
                                        href="{{url('segment_commission')}}"
                                        @elseif(Auth::user()&&Auth::user()->stage == '1' && Auth::user()->user_type == 'normal_user')
                                        href="{{url('memberProfile')}}"
                                        @else
                                        href="{{url('joinus')}}"
                                        @endif

                                        class="btn theme-bg-color view-button icon text-white fw-bold btn-md">
                                        VIP member price &nbsp; &nbsp;

                                        <span id="price_after_discount"> </span>
                                        <span> LE &nbsp; </span>
                                    </a>
                                </h4>

                                <div class="product-detail">
                                    <h4>Product Details :</h4>
                                    <p id="productDescription"></p>
                                </div>
                                <br>
                                <br>
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
                                <br>
                                <br>
                                <br>

                                <div class="modal-button">

                                    <button id="viewMoreDetails"
                                            class="btn theme-bg-color view-button icon text-white fw-bold btn-md ">
                                        View More Details
                                    </button> &nbsp;
                                    @if($product->stock_status == 'in stock')
                                    <button class="btn btn-md add-cart-button icon saveProductToCart showsaveaddtcart">
                                        {{trans('website.Add To Cart',[],session()->get('locale'))}}
                                    </button>
                                     @else
                                                                <button class="btn mx-auto text-danger heidsaveaddtcart">
                                                                  {{trans('website.out stock',[],session()->get('locale'))}}
                                                                </button>
                                                            @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Quick View Modal Box End -->

@endsection

@section('java_script')
    <script>

        $(document).ready(function () {
            var base_url  = window.location;
            var url       = new URL(base_url);
            var name      = url.searchParams.get("name");
            var min_price = url.searchParams.get("min_price");
            var max_price = url.searchParams.get("max_price");
            if (name && name != '' && name > '') {
                $('#generalSearch').val(name);
            }
            if (min_price && min_price != '' && min_price > '' && (max_price && max_price != '' && max_price > '')) {
                document.querySelector('#two').value   = max_price;
                document.querySelector('#one').value   = min_price;
                document.querySelector('#upper').value = max_price;
                document.querySelector('#lower').value = min_price;
            }

            var productId             = '';
            var productName           = '';
            var productImage          = '';
            var productPrice          = '';
            var productFlag           = '';
            var priceAfterDiscount    = '';
            var productPriceOld       = '';
            var productDiscountOld    = '';
            var productServerQuantity = 0;

            $(".viewProductModel").click(function () {

                productId             = $(this).attr('id');
                productName           = $(this).attr('product_name');
                productImage          = $(this).attr('product_image');
                productPrice          = $(this).attr('product_price');
                priceAfterDiscount    = $(this).attr('price_after_discount');
                productFlag           = $(this).attr('product_flag');
                productServerQuantity = $(this).attr('product_server_quantity');
                $('#productQuantity').val(1);
                $('#productName').html(productName);
                $('#productPrice').html(productPrice);
                $('#price_after_discount').html(priceAfterDiscount);
                $('#productPriceOld').html($(this).attr('product_price_old'));
                $('#productDiscountOld').html($(this).attr('product_discount_old'));
                $('#productImage').attr('src', $(this).attr('product_image'));
                $('#productDescription').html($(this).attr('product_description'));
            });

            $(".addcart-button").click(function () {

                productId          = $(this).attr('product_id');
                productName        = $(this).attr('product_name');
                productPrice       = $(this).attr('product_price');
                priceAfterDiscount = $(this).attr('price_after_discount');
                productImage       = $(this).attr('product_image');
                productFlag        = $(this).attr('product_flag');
                var newProduct2    = {
                    'id': productId,
                    'name': productName,
                    'image': productImage,
                    'price': productPrice,
                    'price_after_discount': priceAfterDiscount,
                    'flag': productFlag,
                    'total': 0,
                    'quantity': 1
                }
                var userCart       = localStorage.getItem('user_cart');
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
                    timer: 1500,
                    icon: "success",
                    buttons: false,
                });
            });

            $(".saveProductToCart").click(function () {
                var productQuantity = $('#productQuantity').val();

                if (Number(productQuantity) > Number(productServerQuantity)) {
                    alert("Quantity not available");
                }
                else {
                    var newProduct = {
                        'id': productId,
                        'name': productName,
                        'image': productImage,
                        'price': productPrice,
                        'price_after_discount': priceAfterDiscount,
                        'flag': productFlag,
                        'total': 0,
                        'quantity': productQuantity
                    }
                    var userCart   = localStorage.getItem('user_cart');
                    if (!userCart || userCart == null || userCart == '' || userCart.length == 0) {
                        var allProducts = [];
                        allProducts.push(newProduct);
                        const myJSON = JSON.stringify(allProducts);
                        localStorage.setItem("user_cart", myJSON);
                        $('#herderCardCount').html('1')
                        $('#herderCardTotalCount').html(productPrice);
                        let upto = (productPrice - (productPrice * .3))
                        $('#herderUpToTotalCount').html('LE ' + upto)
                    }
                    else {
                        var allProductsArray = JSON.parse(userCart);
                        var el_exist_inarray = allProductsArray.find((e) => e.id == newProduct.id);
                        if (el_exist_inarray) {
                            var newnewProduct = {
                                'id': productId,
                                'name': productName,
                                'image': productImage,
                                'price': productPrice,
                                'price_after_discount': priceAfterDiscount,
                                'flag': productFlag,
                                'total': 0,
                                'quantity': (parseInt(el_exist_inarray.quantity) + parseInt(productQuantity))
                            }
                            const indx        = allProductsArray.findIndex(v => v.id == el_exist_inarray.id);
                            allProductsArray.splice(indx, indx >= 0 ? 1 : 0);
                            allProductsArray.push(newnewProduct);
                        }
                        else {
                            allProductsArray.push(newProduct);
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
                        timer: 1500,
                        icon: "success",
                        buttons: false,
                    });

                    setTimeout(function () {
                        hideModal();
                    }, 800);

                }
            });

            $("#viewMoreDetails").click(function () {
                let url = '/product-details/' + productId;
                window.open(url, '_self');
            });
            $(".goToSearch").click(function () {
                let url = '/products?min_price=' + document.querySelector('#one').value + '&max_price=' + document.querySelector('#two').value;
                window.open(url, '_self');
            });

            $(".addToWishlist").click(function () {

                productId          = $(this).attr('id');
                productName        = $(this).attr('product_name');
                productImage       = $(this).attr('product_image');
                productPrice       = $(this).attr('product_price');
                productPriceOld    = $(this).attr('product_price_old');
                productDiscountOld = $(this).attr('product_discount_old');
                priceAfterDiscount = $(this).attr('price_after_discount');
                productFlag        = $(this).attr('product_flag');

                var newProductwhish = {
                    'id': productId,
                    'name': productName,
                    'image': productImage,
                    'product_price_old': productPriceOld,
                    'product_discount_old': productDiscountOld,
                    'price': productPrice,
                    'price_after_discount': priceAfterDiscount,
                    'flag': productFlag,
                    'quantity': 1,
                    'total': 0
                }
                var userWishlist    = localStorage.getItem('user_wishlist');
                if (!userWishlist || userWishlist == null || userWishlist == '' || userWishlist.length == 0) {
                    var allWishProducts = [];
                    allWishProducts.push(newProductwhish);
                    const myJSON = JSON.stringify(allWishProducts);
                    localStorage.setItem("user_wishlist", myJSON);
                    $('#herderWishlistCount').html(1)
                }
                else {
                    var allProductsArray = JSON.parse(userWishlist);
                    var el_exist_inarray = allProductsArray.find((e) => e.id == newProductwhish.id);
                    if (el_exist_inarray) {
                        var newnewProduct2 = {
                            'id': productId,
                            'name': productName,
                            'image': productImage,
                            'product_price_old': productPriceOld,
                            'product_discount_old': productDiscountOld,
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
                        allProductsArray.push(newProductwhish);
                    }
                    const myJSON = JSON.stringify(allProductsArray);
                    localStorage.setItem("user_wishlist", myJSON);
                    $('#herderWishlistCount').html(allProductsArray.length);
                }
            });
        });


        var lowerSlider = document.querySelector('#lower');
        var upperSlider = document.querySelector('#upper');

        document.querySelector('#two').value = upperSlider.value;
        document.querySelector('#one').value = lowerSlider.value;

        var lowerVal = parseInt(lowerSlider.value);
        var upperVal = parseInt(upperSlider.value);

        upperSlider.oninput = function () {
            lowerVal = parseInt(lowerSlider.value);
            upperVal = parseInt(upperSlider.value);

            if (upperVal < lowerVal + 4) {
                lowerSlider.value = upperVal - 4;
                if (lowerVal == lowerSlider.min) {
                    upperSlider.value = 4;
                }
            }
            document.querySelector('#two').value = this.value
        };

        lowerSlider.oninput = function () {
            lowerVal = parseInt(lowerSlider.value);
            upperVal = parseInt(upperSlider.value);
            if (lowerVal > upperVal - 4) {
                upperSlider.value = lowerVal + 4;
                if (upperVal == upperSlider.max) {
                    lowerSlider.value = parseInt(upperSlider.max) - 4;
                }
            }
            document.querySelector('#one').value = this.value
        };

        function hideModal() {
            $('#view').modal('hide');
        }
    </script>
@endsection
