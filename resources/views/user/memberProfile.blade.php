@extends('layouts.app')
@section('style')
    <style>
        .js-copytextarea {
            width: 100%;
            height: 29px;
            border-radius: 5px;
            background-color: rgb(231, 231, 231);
            color: rgb(68, 68, 68);
            font-size: 20px;
            resize: none;
            text-align: center;
        }

        .identitycard {
            position: absolute;
            top: 0px;
            right: 0;
            left: 0;
            opacity: 0;
            width: 100%;
            cursor: pointer;
            height: 100%;
        }

        #chartStatusBar * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .status-bar {
            width: 80%;
            display: flex;
            gap: 34px;
            align-items: center;
            justify-content: space-between;
            margin: 50px auto 0 auto;
            padding-bottom: 40px;
        }

        .status-bar .status {
            position: relative;
            width: 100%;
            height: 70px;
            border-top: 1px solid black;
        }

        .status-bar .status.disabled {
            opacity: .4;
        }

        .uploaded {
            display: flex;
            justify-content: center;
            align-items: center;
        }


        [dir=ltr] .status-bar .status .leftCorner {
            position: absolute;
            top: -16px;
            left: -40px;
            display: flex;
            align-items: center;
            flex-direction: column;
        }

        [dir=ltr] .status-bar .status .rightCorner {
            position: absolute;
            top: -16px;
            right: -40px;
            display: flex;
            align-items: center;
            flex-direction: column;
        }

        [dir=rtl] .status-bar .status .leftCorner {
            position: absolute;
            top: -16px;
            right: -40px;
            display: flex;
            align-items: center;
            flex-direction: column;
        }

        [dir=rtl] .status-bar .status .rightCorner {
            position: absolute;
            top: -16px;
            left: -40px;
            display: flex;
            align-items: center;
            flex-direction: column;
        }

        @media (max-width: 768px) {
            .status-bar {
                width: 60%;
            }
        }

        .logo {
            text-align: left !important;
        }

        .user-dashboard-section .dashboard-left-sidebar .profile-box .profile-contain .profile-image .cover-icon {
            left: 0% !important;
        }

        #closebtn {
            border: 1px solid #eee;
            float: right;
        }

        .number-box {
            box-shadow: unset;
            border: 1px solid #8563a5;
        }

        #welcome_program .modal-content {
            background: linear-gradient(93.44deg, #5E54A4 2.7%, #AF74A6 129.05%);
            box-shadow: 0px 6px 6px rgba(0, 0, 0, 0.1);
            border-radius: 15px;
            width: 660px;
        }

        #welcome_program .modal-body {
            width: 660px;
        }

        @media all and (max-width: 620px) {
            #welcome_program .modal-content {
                background: linear-gradient(93.44deg, #5E54A4 2.7%, #AF74A6 129.05%);
                box-shadow: 0px 6px 6px rgba(0, 0, 0, 0.1);
                border-radius: 15px;
                width: 100%;
            }

            #welcome_program .modal-body {
                width: 100%
            }

            #welcome_program {
                height: unset;
            }

            .home-page .carousel-item img {
                height: 300px !important;
            }


        }


        #welcome_program ol li {
            background-color: unset;
            border: 0px;
            color: white;
            list-style-type: none;
        }

        #welcome_program ol li::before {
            content: ". ";
            font-size: larger;
        }

        #welcome_program ol li {
            padding: 0.2rem .2rem;
            font-size: 16px;
        }
    </style>
@endsection
@section('content')
    @include('layoutsWep.componants.welcome_program_section')
    @include('layoutsWep.componants.messages')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    @if(session()->has('message'))
        <div class="alert alert-primary text-center">
            {{ session()->get('message') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close" id="closebtn">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
    @endif
    <!-- User Dashboard Section Start -->
    <section class="user-dashboard-section section-b-space">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-xxl-3 col-lg-4">
                    <div class="dashboard-left-sidebar bg-white number-box">
                        <div class="close-button d-flex d-lg-none">
                            <button class="close-sidebar">
                                <i class="fa-solid fa-xmark"></i>
                            </button>
                        </div>
                        <div class="profile-box">


                            <div class="profile-contain text-left p-2">
                                <div class="profile-image m-0">
                                    <div class="position-relative logo">
                                        @if(Auth::user()->profile_photo)
                                            <img src="{{url(Auth::user()->profile_photo)}}"
                                                 class="blur-up lazyload update_img" alt="">
                                        @else
                                            <img src="../assets/images/images/user22.png"
                                                 class="blur-up lazyload update_img" alt="">
                                        @endif
                                        <div class="cover-icon cursor-pointer">
                                            <i class="fa-solid fa-pen cursor-pointer">
                                                <input type="file" id="profileImageInput" onchange="readURL(this,0);">
                                            </i>
                                        </div>

                                    </div>
                                    <div class="text-center mb-2 d-none uploadeimage">
                                        <i class="fa-solid fa-circle-check theme-color fa-2x"></i>
                                    </div>
                                </div>

                                <div class="profile-name">
                                    <h3>{{Auth::user()->full_name}}</h3>
                                    <h4 class="text-content pb-2">{{Auth::user()->email}}</h4>

                                    @if(Auth::user()&&Auth::user()->stage == '2' && Auth::user()->user_type == 'member')
                                        <h4 class="pt-2 pb-2"> {{trans('website.Membership',[],session()->get('locale'))}}
                                            # {{ !empty($membership)&&isset( $membership->id) ? $membership->id :0}}</h4>
                                        <button class="btn theme-bg-color text-white w-100 justify-content-center viewShareModel mb-2" data-bs-target="#view" data-bs-toggle="modal">
                                            <i class="fa fa-share-nodes fa-2x"></i>
                                            &nbsp; {{trans('website.Share Your Membership',[],session()->get('locale'))}}
                                        </button>

                                        <button class="btn theme-bg-color text-white w-100 justify-content-center viewShareModel" data-bs-target="#addNewG1Member" data-bs-toggle="modal">
                                            <i class="fa-solid fa-user-plus fa-2x"></i>
                                            &nbsp; {{trans('website.add child',[],session()->get('locale'))}}
                                        </button>
                                    @endif
                                    @if(Auth::user()->stage == '1' && Auth::user()->user_type == 'normal_user')
                                        <button class="btn theme-bg-color text-white w-100 justify-content-center viewProductModel" data-bs-target="#updateProfile" data-bs-toggle="modal">
                                            Become A Member
                                        </button>
                                    @endif

                                </div>
                            </div>
                        </div>

                        <ul class="nav nav-pills user-nav-pills" id="pills-tab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="pills-dashboard-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-dashboard" type="button" role="tab"
                                        aria-controls="pills-dashboard" aria-selected="true"><i data-feather="home"></i>
                                    {{trans('website.My Account',[],session()->get('locale'))}}
                                </button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-order-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-order" type="button" role="tab" aria-controls="pills-order"
                                        aria-selected="false"><i data-feather="shopping-bag"></i>
                                    {{trans('website.Orders',[],session()->get('locale'))}}
                                </button>
                            </li>

                            {{--                            <li class="nav-item" role="presentation">--}}
                            {{--                                <button class="nav-link" id="pills-wishlist-tab" data-bs-toggle="pill"--}}
                            {{--                                        data-bs-target="#pills-wishlist" type="button" role="tab"--}}
                            {{--                                        aria-controls="pills-wishlist" aria-selected="false">--}}
                            {{--                                    <i data-feather="heart"></i>--}}
                            {{--                                    Wishlist--}}
                            {{--                                </button>--}}
                            {{--                            </li>--}}

                            {{--                            <li class="nav-item" role="presentation">--}}
                            {{--                                <button class="nav-link" id="pills-card-tab" data-bs-toggle="pill"--}}
                            {{--                                        data-bs-target="#pills-card" type="button" role="tab" aria-controls="pills-card"--}}
                            {{--                                        aria-selected="false"><i data-feather="credit-card"></i> Saved Card--}}
                            {{--                                </button>--}}
                            {{--                            </li>--}}

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-address-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-address" type="button" role="tab"
                                        aria-controls="pills-address" aria-selected="false">
                                    <i data-feather="map-pin"></i>
                                    {{trans('website.Address',[],session()->get('locale'))}}

                                </button>
                            </li>

                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-profile" type="button" role="tab"
                                        aria-controls="pills-profile" aria-selected="false"><i data-feather="user"></i>
                                    {{trans('website.Profile',[],session()->get('locale'))}}
                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-Commission-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-Commission" type="button" role="tab"
                                        aria-controls="pills-Commission" aria-selected="false">
                                    <i data-feather="star"></i>
                                    {{trans('website.Your Commission',[],session()->get('locale'))}}

                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-cashback-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-cashback" type="button" role="tab"
                                        aria-controls="pills-cashback" aria-selected="false">
                                    <i data-feather="credit-card"></i>
                                    {{trans('website.Your Cashback',[],session()->get('locale'))}}

                                </button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="pills-reports-tab" data-bs-toggle="pill"
                                        data-bs-target="#pills-reports" type="button" role="tab"
                                        aria-controls="pills-reports" aria-selected="false">
                                    <i data-feather="list"></i>
                                    {{trans('website.Reports',[],session()->get('locale'))}}

                                </button>
                            </li>

                            {{--                            <li class="nav-item" role="presentation">--}}
                            {{--                                <button class="nav-link" id="pills-security-tab" data-bs-toggle="pill"--}}
                            {{--                                        data-bs-target="#pills-security" type="button" role="tab"--}}
                            {{--                                        aria-controls="pills-security" aria-selected="false">--}}
                            {{--                                    <i data-feather="shield"></i>--}}
                            {{--                                    Privacy--}}
                            {{--                                </button>--}}
                            {{--                            </li>--}}
                        </ul>
                    </div>
                </div>

                <div class="col-xxl-9 col-lg-8">
                    <button class="btn left-dashboard-show btn-animation btn-md fw-bold d-block mb-4 d-lg-none">Show
                        Menu
                    </button>
                    <div class="dashboard-right-sidebar bg-white pt-0">
                        <div class="tab-content" id="pills-tabContent">
                            <div class="tab-pane fade show active" id="pills-dashboard" role="tabpanel"
                                 aria-labelledby="pills-dashboard-tab">
                                <div class="dashboard-home">
                                    <div class="title mb-0">
                                        <h2 class="theme-second-color">

                                            {{trans('website.My Account',[],session()->get('locale'))}}
                                        </h2>
                                    </div>


                                    <div class="total-box">
                                        <div class="row g-sm-4 g-3">

                                            <div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
                                                <div class="totle-contain number-box">

                                                    <img src="../assets/images/images/Arrow - Bottom.png" class="blur-up lazyload"
                                                         alt="">
                                                    <div class="totle-detail">
                                                        <h5>Total Orders</h5>
                                                        <h3>{{$mySalesLeaderLevel['myTeamTotalSales']}} LE</h3>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
                                                <div class="totle-contain number-box">

                                                    <img src="../assets/images/images/Star.png" class="blur-up lazyload"
                                                         alt="">
                                                    <div class="totle-detail">
                                                        <h5>Total Team Orders G1</h5>
                                                        <h3>{{$mySalesLeaderLevel['totalSalesG1']}} LE</h3>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
                                                <div class="totle-contain number-box">

                                                    <img src="../assets/images/images/Menu.png"
                                                         class="blur-up lazyload" alt="">
                                                    <div class="totle-detail">
                                                        <h5>Total Team Orders G2</h5>
                                                        <h3>{{$mySalesLeaderLevel['totalSalesG2']}} LE</h3>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
                                                <div class="totle-contain number-box">

                                                    <img src="../assets/images/images/Two-user.png" class="blur-up lazyload"
                                                         alt="">
                                                    <div class="totle-detail">
                                                        <h5>Active Members</h5>
                                                        <h3>{{$mySalesLeaderLevel['myTeamMembersActivesCount']}}</h3>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
                                                <div class="totle-contain number-box">

                                                    <img src="../assets/images/images/Two-user.png" class="blur-up lazyload"
                                                         alt="">
                                                    <div class="totle-detail">
                                                        <h5>New Recruits G1</h5>
                                                        <h3>{{$mySalesLeaderLevel['myNewMembersActivesCount']}}</h3>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-xxl-4 col-lg-6 col-md-4 col-sm-6">
                                                <div class="totle-contain number-box">

                                                    <img src="../assets/images/images/Two-user.png"
                                                         class="blur-up lazyload" alt="">
                                                    <div class="totle-detail">
                                                        <h5>New Recruits sales</h5>
                                                        <h3>{{$mySalesLeaderLevel['myNewMembersSales']}} LE </h3>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                    <div class="total-box">
                                        <div class="row">
                                            <div class="col-md-12">
                                                @if($mySalesLeaderLevel['level'])
                                                    <div class="col-md-1 mt-3"></div>
                                                    <div class="col-md-5 mt-3 d-flex">
                                                        <h5> My Current Level : &nbsp; </h5>
                                                        <h4> {{$mySalesLeaderLevel['level']->title}}</h4>
                                                        <br>
                                                    </div>
                                                    @if($myNextSalesLeaderLevel)
                                                        <div class="col-md-6 mt-3 d-flex">
                                                            <h5> Next Sales Level : &nbsp; </h5>
                                                            <h4>  {{$myNextSalesLeaderLevel->title}}</h4>
                                                        </div>
                                                    @endif
                                                @endif
                                                <div class="col-md-12 mt-3">
                                                    <div class="row">
                                                        <div class="col-md-1"></div>
                                                        <div class="col-md-11" id="chartStatusBar">

                                                            <div class="status-bar">
                                                                <div class="status {{$mytotalPaidOrderThisManth > 250 ? '':'disabled'}} ">
                                                                    <div class="leftCorner">

                                                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/73/Flat_tick_icon.svg/1024px-Flat_tick_icon.svg.png" alt="checked" width="30px" height="30px">
                                                                        <p>Active Order</p>
                                                                        <p>{{$mytotalPaidOrderThisManth > 250 ? 'LE 250': 'LE' .$mytotalPaidOrderThisManth}}</p>
                                                                    </div>
                                                                </div>
                                                                <div class="status {{$mySalesLeaderLevel['level'] ? '':'disabled'}}">
                                                                    <div class="leftCorner">
                                                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/73/Flat_tick_icon.svg/1024px-Flat_tick_icon.svg.png" alt="checked" width="30px" height="30px">
                                                                        <p>Total Sales</p>
                                                                        @if($mySalesLeaderLevel['level'])
                                                                            <p>
                                                                                {{$mySalesLeaderLevel['level']->total_team_sales}}
                                                                                LE </p>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                                <div class="status  disabled">
                                                                    <div class="leftCorner">
                                                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/73/Flat_tick_icon.svg/1024px-Flat_tick_icon.svg.png" alt="checked" width="30px" height="30px">
                                                                        <p>Next Sales</p>
                                                                        @if($myNextSalesLeaderLevel)
                                                                            <p>{{$myNextSalesLeaderLevel->total_team_sales}}</p>
                                                                        @endif
                                                                    </div>
                                                                    <div class="rightCorner">
                                                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/73/Flat_tick_icon.svg/1024px-Flat_tick_icon.svg.png" alt="checked" width="30px" height="30px">
                                                                        <p>Earning</p>
                                                                        <p>1000</p>
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
                            </div>

                            <div class="tab-pane fade show" id="pills-wishlist" role="tabpanel"
                                 aria-labelledby="pills-wishlist-tab">
                                <div class="dashboard-wishlist">
                                    <div class="title">
                                        <h2>My Wishlist History</h2>
                                        <span class="title-leaf title-leaf-gray">
                                            <svg class="icon-width bg-gray">
                                                <use xlink:href="../assets/svg/leaf.svg#leaf"></use>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="row g-sm-4 g-3 number-box">
                                        <div class="col-xxl-3 col-lg-6 col-md-4 col-sm-6">
                                            <div class="product-box-3 theme-bg-white h-100">
                                                <div class="product-header">
                                                    <div class="product-image">
                                                        <a href="#">
                                                            <img src=""
                                                                 class="img-fluid blur-up lazyload" alt="">
                                                        </a>

                                                        <div class="product-header-top">
                                                            <button class="btn wishlist-button close_button">
                                                                <i data-feather="x"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="product-footer">
                                                    <div class="product-detail">
                                                        <span class="span-name">Vegetable</span>
                                                        <a href="#">
                                                            <h5 class="name">Fresh Bread and Pastry Flour 200 g</h5>
                                                        </a>
                                                        <p class="text-content mt-1 mb-2 product-content">Cheesy feet
                                                            cheesy grin brie. Mascarpone cheese and wine hard cheese the
                                                            big cheese everyone loves smelly cheese macaroni cheese
                                                            croque monsieur.</p>
                                                        <h6 class="unit mt-1">250 ml</h6>
                                                        <h5 class="price">
                                                            <span class="theme-color">$08.02</span>
                                                            <del>$15.15</del>
                                                        </h5>
                                                        <div class="add-to-cart-box mt-2">
                                                            <button class="btn btn-add-cart addcart-button"
                                                                    tabindex="0">Add
                                                                <span class="add-icon">
                                                                    <i class="fa-solid fa-plus"></i>
                                                                </span>
                                                            </button>
                                                            <div class="cart_qty qty-box">
                                                                <div class="input-group">
                                                                    <button type="button" class="qty-left-minus"
                                                                            data-type="minus" data-field="">
                                                                        <i class="fa fa-minus" aria-hidden="true"></i>
                                                                    </button>
                                                                    <input class="form-control input-number qty-input"
                                                                           type="text" name="quantity" value="0">
                                                                    <button type="button" class="qty-right-plus"
                                                                            data-type="plus" data-field="">
                                                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-3 col-lg-6 col-md-4 col-sm-6">
                                            <div class="product-box-3 theme-bg-white h-100">
                                                <div class="product-header">
                                                    <div class="product-image">
                                                        <a href="#">
                                                            <img src=""
                                                                 class="img-fluid blur-up lazyload" alt="">
                                                        </a>

                                                        <div class="product-header-top">
                                                            <button class="btn wishlist-button close_button">
                                                                <i data-feather="x"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="product-footer">
                                                    <div class="product-detail">
                                                        <span class="span-name">Vegetable</span>
                                                        <a href="#">
                                                            <h5 class="name">Peanut Butter Bite Premium Butter Cookies
                                                                600 g</h5>
                                                        </a>
                                                        <p class="text-content mt-1 mb-2 product-content">Feta taleggio
                                                            croque monsieur swiss manchego cheesecake dolcelatte
                                                            jarlsberg. Hard cheese danish fontina boursin melted cheese
                                                            fondue.</p>
                                                        <h6 class="unit mt-1">350 G</h6>
                                                        <h5 class="price">
                                                            <span class="theme-color">$04.33</span>
                                                            <del>$10.36</del>
                                                        </h5>
                                                        <div class="add-to-cart-box mt-2">
                                                            <button class="btn btn-add-cart addcart-button"
                                                                    tabindex="0">Add
                                                                <span class="add-icon">
                                                                    <i class="fa-solid fa-plus"></i>
                                                                </span>
                                                            </button>
                                                            <div class="cart_qty qty-box">
                                                                <div class="input-group">
                                                                    <button type="button" class="qty-left-minus"
                                                                            data-type="minus" data-field="">
                                                                        <i class="fa fa-minus" aria-hidden="true"></i>
                                                                    </button>
                                                                    <input class="form-control input-number qty-input"
                                                                           type="text" name="quantity" value="0">
                                                                    <button type="button" class="qty-right-plus"
                                                                            data-type="plus" data-field="">
                                                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-3 col-lg-6 col-md-4 col-sm-6">
                                            <div class="product-box-3 theme-bg-white h-100">
                                                <div class="product-header">
                                                    <div class="product-image">
                                                        <a href="#">
                                                            <img src=""
                                                                 class="img-fluid blur-up lazyload" alt="">
                                                        </a>

                                                        <div class="product-header-top">
                                                            <button class="btn wishlist-button close_button">
                                                                <i data-feather="x"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="product-footer">
                                                    <div class="product-detail">
                                                        <span class="span-name">Snacks</span>
                                                        <a href="#">
                                                            <h5 class="name">SnackAmor Combo Pack of Jowar Stick and
                                                                Jowar Chips</h5>
                                                        </a>
                                                        <p class="text-content mt-1 mb-2 product-content">Lancashire
                                                            hard cheese parmesan. Danish fontina mozzarella cream cheese
                                                            smelly cheese cheese and wine cheesecake dolcelatte stilton.
                                                            Cream cheese parmesan who moved my cheese when the cheese
                                                            comes out everybody's happy cream cheese red leicester
                                                            ricotta edam.</p>
                                                        <h6 class="unit mt-1">570 G</h6>
                                                        <h5 class="price">
                                                            <span class="theme-color">$12.52</span>
                                                            <del>$13.62</del>
                                                        </h5>
                                                        <div class="add-to-cart-box mt-2">
                                                            <button class="btn btn-add-cart addcart-button"
                                                                    tabindex="0">Add
                                                                <span class="add-icon">
                                                                    <i class="fa-solid fa-plus"></i>
                                                                </span>
                                                            </button>
                                                            <div class="cart_qty qty-box">
                                                                <div class="input-group">
                                                                    <button type="button" class="qty-left-minus"
                                                                            data-type="minus" data-field="">
                                                                        <i class="fa fa-minus" aria-hidden="true"></i>
                                                                    </button>
                                                                    <input class="form-control input-number qty-input"
                                                                           type="text" name="quantity" value="0">
                                                                    <button type="button" class="qty-right-plus"
                                                                            data-type="plus" data-field="">
                                                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-3 col-lg-6 col-md-4 col-sm-6">
                                            <div class="product-box-3 theme-bg-white h-100">
                                                <div class="product-header">
                                                    <div class="product-image">
                                                        <a href="#">
                                                            <img src=""
                                                                 class="img-fluid blur-up lazyload" alt="">
                                                        </a>

                                                        <div class="product-header-top">
                                                            <button class="btn wishlist-button close_button">
                                                                <i data-feather="x"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="product-footer">
                                                    <div class="product-detail">
                                                        <span class="span-name">Snacks</span>
                                                        <a href="#">
                                                            <h5 class="name">Yumitos Chilli Sprinkled Potato Chips 100 g
                                                            </h5>
                                                        </a>
                                                        <p class="text-content mt-1 mb-2 product-content">Cheddar
                                                            cheddar pecorino hard cheese hard cheese cheese and biscuits
                                                            bocconcini babybel. Cow goat paneer cream cheese fromage
                                                            cottage cheese cauliflower cheese jarlsberg.</p>
                                                        <h6 class="unit mt-1">100 G</h6>
                                                        <h5 class="price">
                                                            <span class="theme-color">$10.25</span>
                                                            <del>$12.36</del>
                                                        </h5>
                                                        <div class="add-to-cart-box mt-2">
                                                            <button class="btn btn-add-cart addcart-button"
                                                                    tabindex="0">Add
                                                                <span class="add-icon">
                                                                    <i class="fa-solid fa-plus"></i>
                                                                </span>
                                                            </button>
                                                            <div class="cart_qty qty-box">
                                                                <div class="input-group">
                                                                    <button type="button" class="qty-left-minus"
                                                                            data-type="minus" data-field="">
                                                                        <i class="fa fa-minus" aria-hidden="true"></i>
                                                                    </button>
                                                                    <input class="form-control input-number qty-input"
                                                                           type="text" name="quantity" value="0">
                                                                    <button type="button" class="qty-right-plus"
                                                                            data-type="plus" data-field="">
                                                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-3 col-lg-6 col-md-4 col-sm-6">
                                            <div class="product-box-3 theme-bg-white h-100">
                                                <div class="product-header">
                                                    <div class="product-image">
                                                        <a href="#">
                                                            <img src=""
                                                                 class="img-fluid blur-up lazyload" alt="">
                                                        </a>

                                                        <div class="product-header-top">
                                                            <button class="btn wishlist-button close_button">
                                                                <i data-feather="x"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="product-footer">
                                                    <div class="product-detail">
                                                        <span class="span-name">Vegetable</span>
                                                        <a href="#">
                                                            <h5 class="name">Fantasy Crunchy Choco Chip Cookies</h5>
                                                        </a>
                                                        <p class="text-content mt-1 mb-2 product-content">Bavarian
                                                            bergkase smelly cheese swiss cut the cheese lancashire who
                                                            moved my cheese manchego melted cheese. Red leicester paneer
                                                            cow when the cheese comes out everybody's happy croque
                                                            monsieur goat melted cheese port-salut.</p>
                                                        <h6 class="unit mt-1">550 G</h6>
                                                        <h5 class="price">
                                                            <span class="theme-color">$14.25</span>
                                                            <del>$16.57</del>
                                                        </h5>
                                                        <div class="add-to-cart-box mt-2">
                                                            <button class="btn btn-add-cart addcart-button"
                                                                    tabindex="0">Add
                                                                <span class="add-icon">
                                                                    <i class="fa-solid fa-plus"></i>
                                                                </span>
                                                            </button>
                                                            <div class="cart_qty qty-box">
                                                                <div class="input-group">
                                                                    <button type="button" class="qty-left-minus"
                                                                            data-type="minus" data-field="">
                                                                        <i class="fa fa-minus" aria-hidden="true"></i>
                                                                    </button>
                                                                    <input class="form-control input-number qty-input"
                                                                           type="text" name="quantity" value="0">
                                                                    <button type="button" class="qty-right-plus"
                                                                            data-type="plus" data-field="">
                                                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-3 col-lg-6 col-md-4 col-sm-6">
                                            <div class="product-box-3 theme-bg-white h-100">
                                                <div class="product-header">
                                                    <div class="product-image">
                                                        <a href="#">
                                                            <img src=""
                                                                 class="img-fluid blur-up lazyload" alt="">
                                                        </a>

                                                        <div class="product-header-top">
                                                            <button class="btn wishlist-button close_button">
                                                                <i data-feather="x"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="product-footer">
                                                    <div class="product-detail">
                                                        <span class="span-name">Vegetable</span>
                                                        <a href="#">
                                                            <h5 class="name">Fresh Bread and Pastry Flour 200 g</h5>
                                                        </a>
                                                        <p class="text-content mt-1 mb-2 product-content">Melted cheese
                                                            babybel chalk and cheese. Port-salut port-salut cream cheese
                                                            when the cheese comes out everybody's happy cream cheese
                                                            hard cheese cream cheese red leicester.</p>
                                                        <h6 class="unit mt-1">1 Kg</h6>
                                                        <h5 class="price">
                                                            <span class="theme-color">$12.68</span>
                                                            <del>$14.69</del>
                                                        </h5>
                                                        <div class="add-to-cart-box mt-2">
                                                            <button class="btn btn-add-cart addcart-button"
                                                                    tabindex="0">Add
                                                                <span class="add-icon">
                                                                    <i class="fa-solid fa-plus"></i>
                                                                </span>
                                                            </button>
                                                            <div class="cart_qty qty-box">
                                                                <div class="input-group">
                                                                    <button type="button" class="qty-left-minus"
                                                                            data-type="minus" data-field="">
                                                                        <i class="fa fa-minus" aria-hidden="true"></i>
                                                                    </button>
                                                                    <input class="form-control input-number qty-input"
                                                                           type="text" name="quantity" value="0">
                                                                    <button type="button" class="qty-right-plus"
                                                                            data-type="plus" data-field="">
                                                                        <i class="fa fa-plus" aria-hidden="true"></i>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-3 col-lg-6 col-md-4 col-sm-6">
                                            <div class="product-box-3 theme-bg-white h-100">
                                                <div class="product-header">
                                                    <div class="product-image">
                                                        <a href="#">
                                                            <img src=""
                                                                 class="img-fluid blur-up lazyload" alt="">
                                                        </a>

                                                        <div class="product-header-top">
                                                            <button class="btn wishlist-button close_button">
                                                                <i data-feather="x"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="product-footer">
                                                    <div class="product-detail">
                                                        <span class="span-name">Vegetable</span>
                                                        <a href="#">
                                                            <h5 class="name">Fresh Bread and Pastry Flour 200 g</h5>
                                                        </a>
                                                        <p class="text-content mt-1 mb-2 product-content">Squirty cheese
                                                            cottage cheese cheese strings. Red leicester paneer danish
                                                            fontina queso lancashire when the cheese comes out
                                                            everybody's happy cottage cheese paneer.</p>
                                                        <h6 class="unit mt-1">250 ml</h6>
                                                        <h5 class="price">
                                                            <span class="theme-color">$08.02</span>
                                                            <del>$15.15</del>
                                                        </h5>
                                                        <div class="add-to-cart-box mt-2">
                                                            <button class="btn btn-add-cart addcart-button"
                                                                    tabindex="0">Add
                                                                <span class="add-icon">
                                                                    <i class="fa-solid fa-plus"></i>
                                                                </span>
                                                            </button>
                                                            <div class="cart_qty qty-box">
                                                                <div class="input-group">
                                                                    <button type="button" class="qty-left-minus"
                                                                            data-type="minus" data-field="">
                                                                        <i class="fa fa-minus" aria-hidden="true"></i>
                                                                    </button>
                                                                    <input class="form-control input-number qty-input"
                                                                           type="text" name="quantity" value="0">
                                                                    <button type="button" class="qty-right-plus"
                                                                            data-type="plus" data-field="">
                                                                        <i class="fa fa-plus" aria-hidden="true"></i>
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

                            <div class="tab-pane fade show" id="pills-order" role="tabpanel"
                                 aria-labelledby="pills-order-tab">
                                <div class="dashboard-order">
                                    <div class="title">
                                        <h2>My Orders History</h2>
                                    </div>
                                    <div class="order-contain">
                                        @if($myOrders && count($myOrders) > 0)
                                            @foreach($myOrders as $order)
                                                <div class="order-box dashboard-bg-box number-box">
                                                    <div class="order-container">
                                                        <div class="order-icon">
                                                            <i data-feather="box"></i>
                                                        </div>

                                                        <div class="order-detail">
                                                            @if($order->payment_status == 'PAID')
                                                                <h4>Payment Status
                                                                    <span class="success-bg">{{$order->payment_status}}</span>
                                                                </h4>
                                                            @elseif($order->payment_status == 'PENDING')
                                                                <h4>Payment Status
                                                                    <span>{{$order->payment_status}}</span>
                                                                </h4>
                                                                 @else
                                                                <h4>Payment Status
                                                                    <span>{{$order->payment_status}}</span>
                                                                </h4>
                                                            @endif


                                                            @if($order->can_cancel == '1')
                                                                <br>
                                                                <h4>

                                                                    <button class="btn theme-bg-color text-white  justify-content-center p-1 pr-2" data-bs-target="#exampleModalCancelOrderRequest" data-bs-toggle="modal" onclick="goToSpecificCancelOrder('{{$order->id}}')">

                                                                        &nbsp; Cancel
                                                                    </button>
                                                                </h4>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="product-order-detail">
                                                        <div class="order-wrap">
                                                            <a href="{{url('/orderDetails/'.$order->id)}}">
                                                                <h3>{{$order->full_name}}</h3>
                                                            </a>
                                                            <ul class="product-size">
                                                                <li>
                                                                    <div class="size-box">
                                                                        <h6 class="text-content">Order Id : </h6>
                                                                        <a href="{{url('/orderDetails/'.$order->id)}}">
                                                                            <h5># {{$order->id}}</h5>
                                                                        </a>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="size-box">
                                                                        <h6 class="text-content">Total Order : </h6>
                                                                        <h5>{{$order->total_order}} LE</h5>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="size-box">
                                                                        <h6 class="text-content">Value has commission
                                                                            : </h6>
                                                                        <h5>{{$order->total_order}}
                                                                            LE</h5>
                                                                    </div>
                                                                </li>

                                                                <li>
                                                                    <div class="size-box">
                                                                        <h6 class="text-content">Discount Amount : </h6>
                                                                        <h5>{{$order->discount_amount}} LE</h5>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="size-box">
                                                                        <h6 class="text-content">Shipping Amount : </h6>
                                                                        <h5>{{$order->shipping_amount}} LE</h5>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="size-box">
                                                                        <h6 class="text-content">Created At : </h6>
                                                                        <h5>{{$order->created_at}}</h5>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="size-box">
                                                                        <h4 class="text-content">Payment Status : </h4>
                                                                        <h5>{{$order->payment_status}}</h5>
                                                                    </div>
                                                                </li>
                                                                <li>
                                                                    <div class="size-box">
                                                                        <h4 class="text-content">Delivery status : </h4>
                                                                        <h5>{{$order->order_status}}</h5>
                                                                    </div>
                                                                </li>

                                                            </ul>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <h3>No Data</h3>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="pills-address" role="tabpanel"
                                 aria-labelledby="pills-address-tab">
                                <div class="dashboard-address">
                                    <div class="title title-flex">
                                        <div>
                                            <h2>My Address Book</h2>

                                        </div>

                                        {{--                                        <button class="btn theme-bg-color text-white btn-sm fw-bold mt-lg-0 mt-3"--}}
                                        {{--                                                data-bs-toggle="modal" data-bs-target="#add-address">--}}
                                        {{--                                            <i data-feather="plus"--}}
                                        {{--                                               class="me-2"></i> Add New Address--}}
                                        {{--                                        </button>--}}
                                    </div>

                                    <div class="row g-sm-4 g-3">
                                        @if($addresses && count($addresses) > 0)
                                            @foreach($addresses as $address)
                                                <div class="col-xxl-4 col-xl-6 col-lg-12 col-md-6">
                                                    <div class="address-box number-box">
                                                        <div>
                                                            <div class="form-check">
                                                                <input class="form-check-input" type="radio" name="jack"
                                                                       id="flexRadioDefault2">
                                                            </div>

                                                            <div class="label">
                                                                <label>Home</label>
                                                            </div>

                                                            <div class="table-responsive address-table">
                                                                <table class="table">
                                                                    <tbody>
                                                                    <tr>
                                                                        <td colspan="2">
                                                                            {{$address->country_name}}
                                                                            - {{$address->city_name}}
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Area :</td>
                                                                        <td>
                                                                            <p>{{$address->area_name}}
                                                                            </p>
                                                                        </td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Address :</td>
                                                                        <td>
                                                                            <p>{{$address->address}}
                                                                            </p>
                                                                        </td>
                                                                    </tr>

                                                                    <tr>
                                                                        <td>Landmark :</td>
                                                                        <td>{{$address->landmark}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Floor Number :</td>
                                                                        <td>{{$address->floor_number}}</td>
                                                                    </tr>
                                                                    <tr>
                                                                        <td>Apartment Number :</td>
                                                                        <td>{{$address->apartment_number}}</td>
                                                                    </tr>


                                                                    </tbody>
                                                                </table>
                                                            </div>
                                                        </div>

                                                        <div class="button-group">

                                                            <button class="btn btn-sm add-button w-100" data-bs-toggle="modal" onclick="deleteAddress = {{$address->id}}"
                                                                    data-bs-target="#removeProfile">
                                                                <i data-feather="trash-2"></i>
                                                                Remove
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @else
                                            <h3>No Data</h3>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="pills-card" role="tabpanel"
                                 aria-labelledby="pills-card-tab">
                                <div class="dashboard-card">
                                    <div class="title title-flex">
                                        <div>
                                            <h2>My Card Details</h2>
                                            <span class="title-leaf">
                                                <svg class="icon-width bg-gray">
                                                    <use xlink:href="../assets/svg/leaf.svg#leaf"></use>
                                                </svg>
                                            </span>
                                        </div>

                                        <button class="btn theme-bg-color text-white btn-sm fw-bold mt-lg-0 mt-3"
                                                data-bs-toggle="modal" data-bs-target="#editCard"><i data-feather="plus"
                                                                                                     class="me-2"></i>
                                            Add New Card
                                        </button>
                                    </div>

                                    <div class="row g-4">
                                        <div class="col-xxl-4 col-xl-6 col-lg-12 col-sm-6">
                                            <div class="payment-card-detail">
                                                <div class="card-details">
                                                    <div class="card-number">
                                                        <h4>XXXX - XXXX - XXXX - 2548</h4>
                                                    </div>

                                                    <div class="valid-detail">
                                                        <div class="title">
                                                            <span>valid</span>
                                                            <span>thru</span>
                                                        </div>
                                                        <div class="date">
                                                            <h3>08/05</h3>
                                                        </div>
                                                        <div class="primary">
                                                            <span class="badge bg-pill badge-light">primary</span>
                                                        </div>
                                                    </div>

                                                    <div class="name-detail">
                                                        <div class="name">
                                                            <h5>Audrey Carol</h5>
                                                        </div>
                                                        <div class="card-img">
                                                            <img src="../assets/images/payment-icon/1.jpg"
                                                                 class="img-fluid blur-up lazyloaded" alt="">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="edit-card">
                                                    <a data-bs-toggle="modal" data-bs-target="#editCard"
                                                       href="javascript:void(0)"><i class="far fa-edit"></i> edit</a>
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                       data-bs-target="#removeProfile"><i
                                                            class="far fa-minus-square"></i> delete</a>
                                                </div>
                                            </div>

                                            <div class="edit-card-mobile">
                                                <a data-bs-toggle="modal" data-bs-target="#editCard"
                                                   href="javascript:void(0)"><i class="far fa-edit"></i> edit</a>
                                                <a href="javascript:void(0)"><i class="far fa-minus-square"></i>
                                                    delete</a>
                                            </div>
                                        </div>

                                        <div class="col-xxl-4 col-xl-6 col-lg-12 col-sm-6">
                                            <div class="payment-card-detail">
                                                <div class="card-details card-visa">
                                                    <div class="card-number">
                                                        <h4>XXXX - XXXX - XXXX - 1536</h4>
                                                    </div>

                                                    <div class="valid-detail">
                                                        <div class="title">
                                                            <span>valid</span>
                                                            <span>thru</span>
                                                        </div>
                                                        <div class="date">
                                                            <h3>12/23</h3>
                                                        </div>
                                                        <div class="primary">
                                                            <span class="badge bg-pill badge-light">primary</span>
                                                        </div>
                                                    </div>

                                                    <div class="name-detail">
                                                        <div class="name">
                                                            <h5>Leah Heather</h5>
                                                        </div>
                                                        <div class="card-img">
                                                            <img src="../assets/images/payment-icon/2.jpg"
                                                                 class="img-fluid blur-up lazyloaded" alt="">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="edit-card">
                                                    <a data-bs-toggle="modal" data-bs-target="#editCard"
                                                       href="javascript:void(0)"><i class="far fa-edit"></i> edit</a>
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                       data-bs-target="#removeProfile"><i
                                                            class="far fa-minus-square"></i> delete</a>
                                                </div>
                                            </div>

                                            <div class="edit-card-mobile">
                                                <a data-bs-toggle="modal" data-bs-target="#editCard"
                                                   href="javascript:void(0)"><i class="far fa-edit"></i> edit</a>
                                                <a href="javascript:void(0)"><i class="far fa-minus-square"></i>
                                                    delete</a>
                                            </div>
                                        </div>

                                        <div class="col-xxl-4 col-xl-6 col-lg-12 col-sm-6">
                                            <div class="payment-card-detail">
                                                <div class="card-details dabit-card">
                                                    <div class="card-number">
                                                        <h4>XXXX - XXXX - XXXX - 1366</h4>
                                                    </div>

                                                    <div class="valid-detail">
                                                        <div class="title">
                                                            <span>valid</span>
                                                            <span>thru</span>
                                                        </div>
                                                        <div class="date">
                                                            <h3>05/21</h3>
                                                        </div>
                                                        <div class="primary">
                                                            <span class="badge bg-pill badge-light">primary</span>
                                                        </div>
                                                    </div>

                                                    <div class="name-detail">
                                                        <div class="name">
                                                            <h5>mark jecno</h5>
                                                        </div>
                                                        <div class="card-img">
                                                            <img src="../assets/images/payment-icon/3.jpg"
                                                                 class="img-fluid blur-up lazyloaded" alt="">
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="edit-card">
                                                    <a data-bs-toggle="modal" data-bs-target="#editCard"
                                                       href="javascript:void(0)"><i class="far fa-edit"></i> edit</a>
                                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                                       data-bs-target="#removeProfile"><i
                                                            class="far fa-minus-square"></i> delete</a>
                                                </div>
                                            </div>

                                            <div class="edit-card-mobile">
                                                <a data-bs-toggle="modal" data-bs-target="#editCard"
                                                   href="javascript:void(0)"><i class="far fa-edit"></i> edit</a>
                                                <a href="javascript:void(0)"><i class="far fa-minus-square"></i>
                                                    delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="pills-profile" role="tabpanel"
                                 aria-labelledby="pills-profile-tab">
                                <div class="dashboard-profile">
                                    <div class="title">
                                        <h2>My Profile</h2>

                                    </div>

                                    <div class="profile-detail dashboard-bg-box number-box">
                                        <div class="dashboard-title">
                                            <h3>Profile Name</h3>
                                        </div>
                                        <div class="profile-name-detail">
                                            <div class="d-sm-flex align-items-center d-block">
                                                <h3>{{Auth::user()->full_name}}</h3>
                                            </div>

                                            <a href="javascript:void(0)" data-bs-toggle="modal"
                                               data-bs-target="#editProfile">Edit</a>
                                        </div>

                                        {{--                                        <div class="location-profile">--}}
                                        {{--                                            <ul>--}}
                                        {{--                                                <li>--}}
                                        {{--                                                    <div class="location-box">--}}
                                        {{--                                                        <i data-feather="map-pin"></i>--}}
                                        {{--                                                        <h6>Downers Grove, IL</h6>--}}
                                        {{--                                                    </div>--}}
                                        {{--                                                </li>--}}

                                        {{--                                                <li>--}}
                                        {{--                                                    <div class="location-box">--}}
                                        {{--                                                        <i data-feather="mail"></i>--}}
                                        {{--                                                        <h6>vicki.pope@gmail.com</h6>--}}
                                        {{--                                                    </div>--}}
                                        {{--                                                </li>--}}

                                        {{--                                                <li>--}}
                                        {{--                                                    <div class="location-box">--}}
                                        {{--                                                        <i data-feather="check-square"></i>--}}
                                        {{--                                                        <h6>Licensed for 2 years</h6>--}}
                                        {{--                                                    </div>--}}
                                        {{--                                                </li>--}}
                                        {{--                                            </ul>--}}
                                        {{--                                        </div>--}}

                                        <div class="profile-description">
                                            <p></p>
                                        </div>
                                    </div>

                                    <div class="profile-about dashboard-bg-box number-box">
                                        <div class="row">
                                            <div class="col-xxl-7">
                                                <div class="dashboard-title mb-3">
                                                    <h3>Profile About</h3>
                                                </div>

                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <tbody>
                                                        <tr>
                                                            <td>Gender :</td>
                                                            <td>{{Auth::user()->gender}}</td>
                                                        </tr>
                                                        <tr>
                                                            <td>Phone Number :</td>
                                                            <td>
                                                                {{Auth::user()->phone}}
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Address :</td>
                                                            <td>{{Auth::user()->address}}</td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>

                                                <div class="dashboard-title mb-3">
                                                    <h3>Login Details</h3>
                                                </div>

                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <tbody>
                                                        <tr>
                                                            <td>Email :</td>
                                                            <td>
                                                                <a href="javascript:void(0)">{{Auth::user()->email}}
                                                                    <span data-bs-toggle="modal"
                                                                          data-bs-target="#editProfile">Edit</span></a>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td>Password :</td>
                                                            <td>
                                                                <a href="javascript:void(0)">●●●●●●
                                                                    <span data-bs-toggle="modal"
                                                                          data-bs-target="#editProfile">Edit</span></a>
                                                            </td>
                                                        </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>


                                        </div>
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="dashboard-title">
                                                    <h3>ID Card</h3>
                                                </div>

                                                <div class="row g-4">
                                                    @if(Auth::user()&&Auth::user()->stage == '2' && Auth::user()->user_type == 'member')
                                                        <div class="col-xxl-12">

                                                            <div class="dashboard-detail">
                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <a href="{{url('/'.Auth::user()->front_id_image)}}" target="_blank">
                                                                            <img src="{{url('/'.Auth::user()->front_id_image)}}" class="blur-up lazyload" alt="" width="200" height="100">
                                                                        </a>
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <a href="{{url('/'.Auth::user()->back_id_image)}}" target="_blank">
                                                                            <img src="{{url('/'.Auth::user()->back_id_image)}}" class="blur-up lazyload" alt="" width="200" height="100">
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endif

                                                    {{--                                        <div class="col-12">--}}
                                                    {{--                                            <div class="dashboard-contant-title">--}}
                                                    {{--                                                <h4>Address Book <a href="javascript:void(0)" data-bs-toggle="modal"--}}
                                                    {{--                                                                    data-bs-target="#editProfile">Edit</a></h4>--}}
                                                    {{--                                            </div>--}}

                                                    {{--                                            <div class="row g-4">--}}
                                                    {{--                                                <div class="col-xxl-6">--}}
                                                    {{--                                                    <div class="dashboard-detail">--}}
                                                    {{--                                                        <h6 class="text-content">Default Billing Address</h6>--}}
                                                    {{--                                                        <h6 class="text-content">You have not set a default billing--}}
                                                    {{--                                                            address.</h6>--}}
                                                    {{--                                                        <a href="javascript:void(0)" data-bs-toggle="modal"--}}
                                                    {{--                                                           data-bs-target="#editProfile">Edit Address</a>--}}
                                                    {{--                                                    </div>--}}
                                                    {{--                                                </div>--}}

                                                    {{--                                                <div class="col-xxl-6">--}}
                                                    {{--                                                    <div class="dashboard-detail">--}}
                                                    {{--                                                        <h6 class="text-content">Default Shipping Address</h6>--}}
                                                    {{--                                                        <h6 class="text-content">You have not set a default shipping--}}
                                                    {{--                                                            address.</h6>--}}
                                                    {{--                                                        <a href="javascript:void(0)" data-bs-toggle="modal"--}}
                                                    {{--                                                           data-bs-target="#editProfile">Edit Address</a>--}}
                                                    {{--                                                    </div>--}}
                                                    {{--                                                </div>--}}
                                                    {{--                                            </div>--}}
                                                    {{--                                        </div>--}}
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>

                            <div class="tab-pane fade show" id="pills-Commission" role="tabpanel"
                                 aria-labelledby="pills-Commission-tab">
                                <div class="dashboard-profile">
                                    <div class="title mb-0 w-100">
                                        <div class="row w-100">
                                            <div class="col-md-9">
                                                <h2>My Tree</h2>
                                            </div>
                                            <div class="col-md-3">
                                                <h2>{{trans('website.add child',[],session()->get('locale'))}}</h2>
                                            </div>
                                        </div>


                                    </div>

                                    <div class="profile-about dashboard-bg-box number-box">
                                        <div class="row">
                                            <div class="col-md-1 text-center"><h3>You<br></h3></div>
                                            <div class="col-md-11 text-center">
                                                <i class="fa-solid fa-circle-user fa-2x"></i> &nbsp; &nbsp;
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-1 text-center"><h3>G1<br></h3>
                                                <p>{{count($mySalesLeaderLevel['myTeamG1Count'])}}</p>
                                            </div>
                                            <div class="col-md-11 text-center">
                                                @if(count($mySalesLeaderLevel['myTeamG1Count']) > 0)
                                                    @for ($i = 0; $i < count($mySalesLeaderLevel['myTeamG1Count']); $i++)
                                                        @if($i < $mySalesLeaderLevel['myNewMembersActivesCount'])
                                                            <i class="fa-solid fa-circle-user fa-2x text-primary"></i>
                                                            &nbsp;  &nbsp;
                                                        @else
                                                            <i class="fa-solid fa-circle-user fa-2x"></i> &nbsp;  &nbsp;
                                                        @endif
                                                    @endfor
                                                @endif
                                            </div>
                                        </div>
                                        <div class="row mt-2">
                                            <div class="col-md-1 text-center"><h3>G2<br></h3>
                                                <p>{{count($mySalesLeaderLevel['myTeamG2Count'])}}</p></div>
                                            <div class="col-md-11 text-center">

                                                @if(count($mySalesLeaderLevel['myTeamG2Count']) > 0)
                                                    @foreach($mySalesLeaderLevel['myTeamG2Count'] AS $member)
                                                        <i class="fa-solid fa-circle-user fa-2x"></i>  &nbsp;  &nbsp;
                                                    @endforeach
                                                @endif
                                            </div>
                                        </div>

                                    </div>

                                    <div class="title mb-0 mt-4">
                                        <h2>My Monthly Commission</h2>

                                    </div>
                                    <div class="profile-about dashboard-bg-box number-box">
                                        <div class="row">
                                            <table class="table">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Type</th>
                                                    <th scope="col">Personal Order</th>
                                                    <th scope="col">Active Team</th>
                                                    <th scope="col">G1 New</th>
                                                    <th scope="col">G1 New Sales</th>
                                                    <th scope="col">Total G1 Sales</th>
                                                    <th scope="col">Total G2 Sales</th>
                                                    <th scope="col">Total Sales PO + G1 + G2</th>
                                                    <th scope="col">Up Level</th>

                                                </tr>
                                                <tr>
                                                    <td>Required</td>
                                                    <td>{{$mytotalPaidOrderThisManth > 250 ? $mytotalPaidOrderThisManth:"Not Done Yet"}}</td>
                                                    <td>{{$mySalesLeaderLevel['myTeamMembersActivesCount']}}</td>
                                                    <td>{{$mySalesLeaderLevel['myNewMembersActivesCount']}}</td>
                                                    <td>{{$mySalesLeaderLevel['myNewMembersSales']}} LE</td>
                                                    <td>{{$mySalesLeaderLevel['totalSalesG1']}} LE</td>
                                                    <td>{{$mySalesLeaderLevel['totalSalesG2']}} LE</td>
                                                    <td>{{$mySalesLeaderLevel['myTeamTotalSales']}} LE</td>
                                                    @if(!empty($mySalesLeaderLevel['myMonthlyEarnings']))
                                                        <td>{{$mySalesLeaderLevel['myMonthlyEarnings']['upLevel']>0 ?'Yes':'No'}}</td>
                                                    @endif
                                                </tr>
                                                @if(!empty($mySalesLeaderLevel['myMonthlyEarnings']))
                                                    <tr>
                                                        <td>Percenting</td>
                                                        <td>--</td>
                                                        <td>--</td>
                                                        <td>--</td>
                                                        <td>{{($mySalesLeaderLevel['myMonthlyEarnings']['spons_b_new_r'])*100 }}
                                                            %
                                                        </td>
                                                        <td>{{($mySalesLeaderLevel['myMonthlyEarnings']['g1_bonus'])*100}}
                                                            %
                                                        </td>
                                                        <td>{{($mySalesLeaderLevel['myMonthlyEarnings']['g2_bonus'])*100}}
                                                            %
                                                        </td>
                                                        <td>--</td>
                                                        <td>--</td>
                                                    </tr>
                                                @endif

                                                </thead>
                                                @if(!empty($mySalesLeaderLevel['myMonthlyEarnings']))
                                                    <tbody>


                                                    <tr>
                                                        <td>Earn</td>
                                                        <td>--</td>
                                                        <td>--</td>
                                                        <td>--</td>
                                                        <td>{{$mySalesLeaderLevel['myMonthlyEarnings']['earnFromNewMembersSales']}}
                                                            LE
                                                        </td>
                                                        <td>{{$mySalesLeaderLevel['myMonthlyEarnings']['earnFromMembersSalesG1']}}
                                                            LE
                                                        </td>
                                                        <td>{{$mySalesLeaderLevel['myMonthlyEarnings']['earnFromMembersSalesG2']}}
                                                            LE
                                                        </td>
                                                        <td>--</td>
                                                        <td>{{$mySalesLeaderLevel['myMonthlyEarnings']['upLevel']}}LE
                                                        </td>
                                                    </tr>
                                                    </tbody>
                                                @endif
                                            </table>
                                            @if($mySalesLeaderLevel['myMonthlyEarnings'])
                                                <h3>Total Earning
                                                    : {{$mySalesLeaderLevel['myMonthlyEarnings']['total']}}
                                                    LE</h3>
                                            @endif
                                        </div>
                                    </div>


                                    @if($myNextSalesLeaderLevel)

                                        <div class="title mb-0 mt-4">
                                            <h2>Next Level Requirements</h2>
                                            <span class="title-leaf">
                                            <svg class="icon-width bg-gray">
                                                <use xlink:href="../assets/svg/leaf.svg#leaf"></use>
                                            </svg>
                                        </span>
                                        </div>
                                        <div class="profile-about dashboard-bg-box number-box">
                                            <div class="row">
                                                <table class="table">
                                                    <thead>
                                                    <tr>
                                                        <th scope="col">Level Name</th>
                                                        <th scope="col">Active Order</th>
                                                        <th scope="col">Active Team</th>
                                                        <th scope="col">G1 New</th>
                                                        <th scope="col">Total Sales</th>
                                                        <th scope="col">Up Level</th>
                                                    </tr>
                                                    <tr>
                                                        <td>{{$myNextSalesLeaderLevel->title}}</td>
                                                        <td>{{$myNextSalesLeaderLevel->min_personal_sales}} LE</td>
                                                        <td>{{$myNextSalesLeaderLevel->total_actives_team}}</td>
                                                        <td>{{$myNextSalesLeaderLevel->g1_new_recruits}}</td>
                                                        <td>{{$myNextSalesLeaderLevel->total_team_sales}} LE</td>
                                                        <td>{{$myNextSalesLeaderLevel->life_time_bonus}} LE</td>
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>



                                    @endif


                                </div>
                            </div>


                            <div class="tab-pane fade show" id="pills-cashback" role="tabpanel"
                                 aria-labelledby="pills-cashback-tab">
                                <div class="dashboard-profile">
                                    <div class="title mb-0">
                                        <h2>My Cashback</h2>

                                    </div>
                                    <div class="profile-about dashboard-bg-box number-box">
                                        <div class="row">
                                            @if(!empty($myCashbackLevel))
                                                <table class="table">
                                                    <thead>
                                                    <tr>

                                                        <th scope="col">Total Sales Orders In Quarter</th>
                                                        <th scope="col">Cashback In Quarter</th>
                                                        <th scope="col">Total Sales Orders In Annual</th>
                                                        <th scope="col">Cashback In Anuall</th>
                                                    </tr>
                                                    <tr>

                                                        <th scope="col">{{$myCashbackLevel->quarter_sales_amount}} LE
                                                        </th>
                                                        <th scope="col">{{$myCashbackLevel->quarter_sales_cash_back}}
                                                            LE
                                                        </th>
                                                        <th scope="col">{{$myCashbackLevel->annual_sales_amount}} LE
                                                        </th>
                                                        <th scope="col">{{$myCashbackLevel->annual_sales_cash_back}} LE
                                                        </th>
                                                    </tr>
                                                    <tr>
                                                        <th scope="col" colspan="5"><br>Current Cashback<br></th>
                                                    </tr>

                                                    <tr>
                                                        <th scope="col">Current Total Orders</th>
                                                        <th scope="col">My Quarter Cashback</th>
                                                        <th scope="col">My Annual Total Orders</th>
                                                        <th scope="col">My Annual Cashback</th>
                                                    </tr>
                                                    <tr>
                                                        <th scope="col">{{$mytotalPaidOrderThisQuarter}} LE</th>
                                                        <th scope="col">{{  $mytotalPaidOrderThisQuarter >= $myCashbackLevel->quarter_sales_amount ? $myCashbackLevel->quarter_sales_cash_back : 0}}
                                                            LE
                                                        </th>
                                                        <th scope="col">{{$mytotalPaidOrderThisYear }} LE</th>
                                                        <th scope="col">{{$mytotalPaidOrderThisYear >=$myCashbackLevel->annual_sales_amount ?$myCashbackLevel->annual_sales_cash_back : 0 }}
                                                            LE
                                                        </th>
                                                    </tr>
                                                    @if(!empty($myNextCashbackLevel))
                                                        <tr>
                                                            <th scope="col" colspan="5"><br>Next Level<br></th>
                                                        </tr>

                                                        <tr>

                                                            <th scope="col">Total Sales Orders In Quarter</th>
                                                            <th scope="col">Cashback In Quarter</th>
                                                            <th scope="col">Total Sales Orders In Annual</th>
                                                            <th scope="col">Cashback In Anuall</th>
                                                        </tr>
                                                        <tr>

                                                            <th scope="col">{{$myNextCashbackLevel->quarter_sales_amount}}
                                                                LE
                                                            </th>
                                                            <th scope="col">{{$myNextCashbackLevel->quarter_sales_cash_back}}
                                                                LE
                                                            </th>
                                                            <th scope="col">{{$myNextCashbackLevel->annual_sales_amount}}
                                                                LE
                                                            </th>
                                                            <th scope="col">{{$myNextCashbackLevel->annual_sales_cash_back}}
                                                                LE
                                                            </th>
                                                        </tr>
                                                    @endif
                                                    </thead>

                                                </table>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="tab-pane fade show" id="pills-reports" role="tabpanel"
                                 aria-labelledby="pills-reports-tab">
                                <div class="dashboard-profile">
                                    <div class="title mb-0">
                                        <h2>My Reports</h2>

                                    </div>
                                    <div class="profile-about dashboard-bg-box number-box">
                                        <div class="row">
                                            <div class="col-md-12"><h4>My Active Team (Current Month)</h4></div>
                                            @if(!empty($mySalesLeaderLevel['myTeamMembersActivesWithSales']))
                                                <table class="table">
                                                    <thead>
                                                    <tr>

                                                        <th scope="col">Name</th>
                                                        <th scope="col">email</th>
                                                        <th scope="col">Mobile</th>
                                                        <th scope="col">Total Sales Orders</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($mySalesLeaderLevel['myTeamMembersActivesWithSales'] as $member)


                                                        <tr>

                                                            <td>{{$member->full_name}}
                                                            </td>
                                                            <td>{{$member->email}}

                                                            </td>
                                                            <td>{{$member->phone}}
                                                            </td>
                                                            <td>{{$member->total_sales}} LE
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>

                                                </table>
                                            @endif
                                            <div class="col-md-12">
                                                <form method="post" action="{{route('ExportActiveTeamSheet')}}" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group col-12">
                                                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}" required>
                                                        <input type="hidden" name="type" value="active" required>
                                                    </div>
                                                    <div class="form-group col-12">
                                                        <button type="submit" class="btn btn-success theme-bg-color text-white">
                                                            Export Sheet
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <div class="row mt-4">
                                            <div class="col-md-12"><h4>Not Active Team (Current Month)</h4></div>
                                            @if(!empty($mySalesLeaderLevel['myTeamMembersNotActivesWithSales']))
                                                <table class="table">
                                                    <thead>
                                                    <tr>

                                                        <th scope="col">Name</th>
                                                        <th scope="col">email</th>
                                                        <th scope="col">Mobile</th>
                                                        <th scope="col">Total Sales Orders</th>

                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                    @foreach($mySalesLeaderLevel['myTeamMembersNotActivesWithSales'] as $member)
                                                        <tr>
                                                            <td>{{$member->full_name}}
                                                            </td>
                                                            <td>{{$member->email}}
                                                            </td>
                                                            <td>{{$member->phone}}
                                                            </td>
                                                            <td>{{$member->total_sales ?? 0}} LE
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                    </tbody>

                                                </table>
                                            @endif
                                            <div class="col-md-12">
                                                <form method="post" action="{{route('ExportActiveTeamSheet')}}" enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="form-group col-12">
                                                        <input type="hidden" name="user_id" value="{{Auth::user()->id}}" required>
                                                        <input type="hidden" name="type" value="not_active" required>
                                                    </div>
                                                    <div class="form-group col-12">
                                                        <button type="submit" class="btn btn-success theme-bg-color text-white">
                                                            Export Sheet
                                                        </button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="tab-pane fade show" id="pills-security" role="tabpanel"
                                 aria-labelledby="pills-security-tab">
                                <div class="dashboard-privacy">
                                    <div class="dashboard-bg-box">
                                        <div class="dashboard-title mb-4">
                                            <h3>Privacy</h3>
                                        </div>

                                        <div class="privacy-box">
                                            <div class="d-flex align-items-start">
                                                <h6>Allows others to see my profile</h6>

                                            </div>

                                            <p class="text-content">all peoples will be able to see my profile</p>
                                        </div>

                                        <div class="privacy-box">
                                            <div class="d-flex align-items-start">
                                                <h6>who has save this profile only that people see my profile</h6>
                                                <div class="form-check form-switch switch-radio ms-auto">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                           id="redio2" aria-checked="false">
                                                    <label class="form-check-label" for="redio2"></label>
                                                </div>
                                            </div>

                                            <p class="text-content">all peoples will not be able to see my profile</p>
                                        </div>

                                        <button class="btn theme-bg-color btn-md fw-bold mt-4 text-white">Save
                                            Changes
                                        </button>
                                    </div>

                                    <div class="dashboard-bg-box mt-4">
                                        <div class="dashboard-title mb-4">
                                            <h3>Account settings</h3>
                                        </div>

                                        <div class="privacy-box">
                                            <div class="d-flex align-items-start">
                                                <h6>Deleting Your Account Will Permanently</h6>
                                                <div class="form-check form-switch switch-radio ms-auto">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                           id="redio3" aria-checked="false">
                                                    <label class="form-check-label" for="redio3"></label>
                                                </div>
                                            </div>
                                            <p class="text-content">Once your account is deleted, you will be logged out
                                                and will be unable to log in back.</p>
                                        </div>

                                        <div class="privacy-box">
                                            <div class="d-flex align-items-start">
                                                <h6>Deleting Your Account Will Temporary</h6>
                                                <div class="form-check form-switch switch-radio ms-auto">
                                                    <input class="form-check-input" type="checkbox" role="switch"
                                                           id="redio4" aria-checked="false">
                                                    <label class="form-check-label" for="redio4"></label>
                                                </div>
                                            </div>

                                            <p class="text-content">Once your account is deleted, you will be logged out
                                                and you will be create new account</p>
                                        </div>

                                        <button class="btn theme-bg-color btn-md fw-bold mt-4 text-white">Delete My
                                            Account
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
    <!-- User Dashboard Section End -->



    <!-- Quick View Modal Box Start -->
    <div class="modal fade theme-modal view-modal" id="addNewG1Member" tabindex="-1" aria-labelledby="exampleModalLabel"
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
                        <div class="col-lg-12">
                            <div class="right-sidebar-modal">
                                <h4 class="title-name" id="productName">Add New Member</h4>
                            </div>
                        </div>
                        @if(Auth::user()->stage == '2' && Auth::user()->user_type == 'member')
                            <div class="input-box">
                                <form class="row g-4" method="POST" action="{{route('addNewG1Member') }}" enctype="multipart/form-data">
                                    @csrf
                                    <input type="hidden" value="{{$membership->id}}" id="parent_membership_id" name="parent_membership_id">
                                    <div class="col-4">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-floating theme-form-floating">
                                                <input type="text" class="form-control" value="{{ old('first_name') }}" id="first_name" name="first_name" required autofocus placeholder="First Name">
                                                <label for="first_name">First Name</label>
                                                @if($errors->has('first_name'))
                                                    <div class="alert alert-danger text-center" role="alert">
                                                        {{ $errors->first('first_name') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-floating theme-form-floating">
                                                <input type="text" class="form-control" value="{{ old('middle_name') }}" id="middle_name" name="middle_name" required autofocus placeholder="Middle Name">
                                                <label for="middle_name">Middle Name</label>
                                                @if($errors->has('middle_name'))
                                                    <div class="alert alert-danger text-center" role="alert">
                                                        {{ $errors->first('middle_name') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-floating theme-form-floating">
                                                <input type="text" class="form-control" value="{{ old('last_name') }}" id="last_name" name="last_name" required autofocus placeholder="Last Name">
                                                <label for="last_name">Last Name</label>
                                                @if($errors->has('last_name'))
                                                    <div class="alert alert-danger text-center" role="alert">
                                                        {{ $errors->first('last_name') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-floating theme-form-floating">
                                                <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required placeholder="Email Address">
                                                <label for="email">Email Address</label>
                                                @if($errors->has('email'))
                                                    <div class="alert alert-danger text-center" role="alert">
                                                        {{ $errors->first('email') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-floating theme-form-floating">
                                                <input type="text" minlength="11" maxlength="11" value="{{ old('phone') }}" class="form-control" id="phone" name="phone" required placeholder="Phone Number">
                                                <label for="phone">Phone Number</label>
                                                @if($errors->has('phone'))
                                                    <div class="alert alert-danger text-center" role="alert">
                                                        {{ $errors->first('phone') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-floating theme-form-floating">
                                                <input type="password" class="form-control" id="password" name="password" required autofocus placeholder="{{trans('website.password',[],session()->get('locale'))}}">
                                                <label for="password">{{trans('website.password',[],session()->get('locale'))}}</label>
                                                @if($errors->has('password'))
                                                    <div class="alert alert-danger text-center" role="alert">
                                                        {{ $errors->first('password') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-floating theme-form-floating">
                                                <input type="text" class="form-control" id="address" name="address" value="{{Auth::user()->address}}" required autofocus placeholder="address">
                                                <label for="address">Address</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-floating theme-form-floating row">
                                                <div class="col-4">

                                                    <select name="country_id" id="country_id" class="form-control">
                                                        @foreach($countries as $country)
                                                            <option value="{{$country->id}}"> {{$country->name_en}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-4">
                                                    <input type="hidden" id="old_city_id" value="{{ old('city_id')}}">
                                                    <select name="city_id" id="city_id" class="form-control">
                                                        <option value="">Choose City</option>
                                                        @foreach($cities as $city)
                                                            <option value="{{$city->id}}"> {{$city->name_en}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-4">
                                                    <input type="hidden" id="old_area_id" value="{{ old('area_id') }}">
                                                    <select name="area_id" id="area_id" class="form-control">
                                                        <option value="">Choose Area</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-floating theme-form-floating">
                                                <input type="text" class="form-control" id="nationality_id" name="nationality_id" value="{{ old('nationality_id') }}" required autofocus placeholder="Nationality Id (14 digit)" minlength="14" maxlength="14">
                                                <label for="nationality_id">Nationality Id (14 digit)</label>
                                                @if($errors->has('nationality_id'))
                                                    <div class="alert alert-danger text-center" role="alert">
                                                        {{ $errors->first('nationality_id') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-floating theme-form-floating">
                                                <div class="card">
                                                    <img class="card-img-top" src="{{asset('assets/images/identityfront.png')}}" alt="Card image" height="200">
                                                    <div class="card-body">
                                                        <button class="btn theme-bg-color text-white btn-md w-100 fw-bold" id="saveOrderButton" onclick="saveOrderButton()">
                                                            إدخل صورة البطاقة من الامام
                                                        </button>
                                                        <input type="file" accept="image/*" class="identitycard" id="front_id_image" name="front_id_image">

                                                    </div>
                                                    <div class="text-center mb-2 d-none uploadefrontimage uploaded">
                                                        Uploaded &nbsp;
                                                        <i class="fa-solid fa-circle-check theme-color fa-2x"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-floating theme-form-floating">
                                                <div class="card">
                                                    <img class="card-img-top" src="{{asset('assets/images/identityback.png')}}" alt="Card image" height="200">
                                                    <div class="card-body">

                                                        <button class="btn theme-bg-color text-white btn-md w-100 fw-bold" id="saveOrderButton" onclick="saveOrderButton()">
                                                            إدخل صورة البطاقة من الخلف
                                                        </button>

                                                        <input type="file" accept="image/*" class="identitycard" id="back_id_image" name="back_id_image">
                                                    </div>
                                                    <div class="text-center mb-2 d-none uploadebackimage uploaded">
                                                        Uploaded &nbsp;
                                                        <i class="fa-solid fa-circle-check theme-color fa-2x"></i>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="alert alert-danger text-center imagesattition d-none" role="alert">
                                            قم برفع الصور مرة اخري
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-floating theme-form-floating">
                                                <div class="form-check">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <div class="row gender">
                                                                <div class="col-md-3">
                                                                    <h5>{{trans('website.Gender',[],session()->get('locale'))}}</h5>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <input class="form-check-input" type="radio" name="gender" id="male" value="male" checked>
                                                                    <label class="form-check-label" for="male">
                                                                        {{trans('website.Male',[],session()->get('locale'))}}
                                                                    </label>
                                                                </div>
                                                                <div class="col-md-4">
                                                                    <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                                                                    <label class="form-check-label" for="female">
                                                                        {{trans('website.Female',[],session()->get('locale'))}}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="forgot-box">
                                            <div class="form-check ps-0 m-0 remember-box">
                                                <input class="checkbox_animated check-box" type="checkbox" required
                                                       id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">I
                                                    agree
                                                    with
                                                    <span>Terms</span> and <span>Privacy</span></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-animation w-100" type="submit">Add
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Quick View Modal Box End -->

    <!-- Quick View Modal Box Start -->
    <div class="modal fade theme-modal view-modal" id="exampleModalCancelOrderRequest" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-l modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header p-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row g-sm-4 g-2">
                        <div class="col-lg-12">
                            <div class="right-sidebar-modal">
                                <h4 class="title-name" id="productName">Cancel Order</h4>
                            </div>
                        </div>

                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{route('order.cancelMemberOrder')}}" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <h5 class="modal-title col-md-12" id="exampleModalLongTitle">Do You want to Cancel Order
                                    ?</h5>

                                <div class="col-md-12 ">
                                    <input type="hidden" name="order_id" id="order_id_cancel_order" class="form-control">
                                    <br>
                                    <label for="canceled_reason">Enter Reason</label>
                                    <textarea name="canceled_reason" id="canceled_reason" class="form-control" required></textarea>
                                    <br>
                                </div>


                                <br>
                                <div class="form-group col-12">
                                    <button type="submit" class="btn btn-success form-control">
                                        Yes cancel
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Quick View Modal Box End -->

    <!-- Quick View Modal Box Start -->
    <div class="modal fade theme-modal view-modal" id="updateProfile" tabindex="-1" aria-labelledby="exampleModalLabel"
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
                        <div class="col-lg-12">
                            <div class="right-sidebar-modal">
                                <h4 class="title-name" id="productName">Become a member to get big discount</h4>
                            </div>
                        </div>
                        @if(Auth::user()->stage == '1' && Auth::user()->user_type == 'normal_user')


                            <div class="input-box">
                                <form class="row g-4" method="POST" action="{{route('updateUser') }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="col-4">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-floating theme-form-floating">
                                                <input type="text" class="form-control" id="fname" name="fname" value="{{$fullName['first_name']}}" required autofocus placeholder="First Name">
                                                <label for="fname">First Name</label>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-floating theme-form-floating">
                                                <input type="text" class="form-control" id="mname" name="mname" value="{{$fullName['middle_name']}}" required autofocus placeholder="Middle Name">
                                                <label for="mname">Middle Name</label>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-floating theme-form-floating">
                                                <input type="text" class="form-control" id="lname" name="lname" value="{{$fullName['last_name']}}" required autofocus placeholder="Last Name">
                                                <label for="lname">Last Name</label>

                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-floating theme-form-floating">
                                                <input type="email" class="form-control" id="email" name="email" value="{{Auth::user()->email}}" required autofocus placeholder="Email Address" disabled>
                                                <label for="email">Email Address</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-floating theme-form-floating">
                                                <input type="text" minlength="11" maxlength="11" class="form-control" id="phone" name="phone" value="{{Auth::user()->phone}}" required autofocus placeholder="Phone Number" disabled>
                                                <label for="phone">Phone Number</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-floating theme-form-floating">
                                                <input type="text" class="form-control" id="address" name="address" value="{{Auth::user()->address}}" required autofocus placeholder="address">
                                                <label for="address">Address</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-floating theme-form-floating row">
                                                <div class="col-4">
                                                    <select name="country_id" id="country_id" class="form-control">
                                                        @foreach($countries as $country)
                                                            <option value="{{$country->id}}"> {{$country->name_en}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-4">
                                                    <select name="city_id" id="city_id" class="form-control">
                                                        <option value="">Choose City</option>
                                                        @foreach($cities as $city)
                                                            <option value="{{$city->id}}"> {{$city->name_en}}</option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                                <div class="col-4">
                                                    <select name="area_id" id="area_id" class="form-control">
                                                        <option value="">Choose Area</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-floating theme-form-floating">
                                                <input type="text" class="form-control" id="nationality_id" name="nationality_id" value="{{ old('nationality_id') }}" required autofocus placeholder="Nationality Id (14 digit)" minlength="14" maxlength="14">
                                                <label for="nationality_id">Nationality Id (14 digit)</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-floating theme-form-floating">
                                                <div class="card">
                                                    <img class="card-img-top" src="{{asset('assets/images/identityfront.png')}}" alt="Card image" height="200">
                                                    <div class="card-body">
                                                        <button class="btn theme-bg-color text-white btn-md w-100 fw-bold" id="saveOrderButton" onclick="saveOrderButton()">
                                                            إدخل صورة البطاقة من الامام
                                                        </button>
                                                        <input type="file" accept="image/*" class="identitycard" id="front_id_image" name="front_id_image">

                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-floating theme-form-floating">
                                                <div class="card">
                                                    <img class="card-img-top" src="{{asset('assets/images/identityback.png')}}" alt="Card image" height="200">
                                                    <div class="card-body">

                                                        <button class="btn theme-bg-color text-white btn-md w-100 fw-bold" id="saveOrderButton" onclick="saveOrderButton()">
                                                            إدخل صورة البطاقة من الخلف
                                                        </button>

                                                        <input type="file" accept="image/*" class="identitycard" id="back_id_image" name="back_id_image">
                                                    </div>
                                                    <div class="text-center mb-2 d-none uploadebackimage uploaded">
                                                        Uploaded &nbsp;
                                                        <i class="fa-solid fa-circle-check theme-color fa-2x"></i>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="forgot-box">
                                            <div class="form-check ps-0 m-0 remember-box">
                                                <input class="checkbox_animated check-box" type="checkbox" required
                                                       id="flexCheckDefault">
                                                <label class="form-check-label" for="flexCheckDefault">I
                                                    agree
                                                    with
                                                    <span>Terms</span> and <span>Privacy</span></label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <button class="btn btn-animation w-100" type="submit">Update
                                        </button>
                                    </div>
                                </form>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Quick View Modal Box End -->

    <!-- Quick View Modal Box Start -->
    <div class="modal fade theme-modal view-modal" id="editProfile" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-l">
            <div class="modal-content">
                <div class="modal-header p-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row g-sm-4 g-2">
                        <div class="col-lg-12">
                            <div class="right-sidebar-modal">
                                <h3 class="title-name" id="productName">Change Password</h3>
                            </div>
                        </div>

                        <div class="input-box row  mt-2">
                            <div class="col-4 mt-2">

                                <div class="form-floating theme-form-floating">
                                    <div class="form-floating theme-form-floating">
                                        <input type="text" class="form-control" id="ufname" value="{{$fullName['first_name']}}" required autofocus placeholder="First Name">
                                        <label for="ufname">First Name</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 mt-2">
                                <div class="form-floating theme-form-floating">
                                    <div class="form-floating theme-form-floating">
                                        <input type="text" class="form-control" id="umname" value="{{$fullName['middle_name']}}" required autofocus placeholder="Middle Name">
                                        <label for="umname">Middle Name</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-4 mt-2">
                                <div class="form-floating theme-form-floating">
                                    <div class="form-floating theme-form-floating">
                                        <input type="text" class="form-control" id="ulname" value="{{$fullName['last_name']}}" required autofocus placeholder="Last Name">
                                        <label for="ulname">Last Name</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 mt-4">
                                <div class="form-floating theme-form-floating">
                                    <div class="form-floating theme-form-floating">
                                        <input type="email" class="form-control" id="uemail" value="{{Auth::user()->email}}" required autofocus placeholder="Email Address">
                                        <label for="uemail">Email Address</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 mt-4">
                                <div class="form-floating theme-form-floating">
                                    <div class="form-floating theme-form-floating">
                                        <input type="text" minlength="11" maxlength="11" class="form-control" id="uphone" value="{{Auth::user()->phone}}" required autofocus placeholder="Phone Number">
                                        <label for="uphone">Phone Number</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12  mt-4">
                                <div class="form-floating theme-form-floating">
                                    <div class="form-floating theme-form-floating">
                                        <input type="password" class="form-control" id="upassword" autocomplete="off" placeholder="Password">
                                        <label for="upassword">Password (optional)</label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12  mt-4">
                                <button class="btn btn-animation w-100" id="updateUserContactInformation">Update
                                </button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Quick View Modal Box End -->

    <!-- Quick View Modal Box Start -->
    <div class="modal fade theme-modal view-modal" id="view" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-l modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header p-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row g-sm-4 g-2">
                        <div class="col-lg-12">
                            <div class="right-sidebar-modal">
                                <h5 class="title-name" id="productName">Share Your profile to other people to join us in
                                    your Tree</h5>
                                <br>
                                <br>
                                @if(Auth::user()&&Auth::user()->stage == '2' && Auth::user()->user_type == 'member')
                                    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                                    <textarea id="jsCopytextarea" readonly class="js-copytextarea">{{(!empty($membership)&&isset( $membership->id)) ? url('/joinus').'?membership='.$membership->id :''}}</textarea>
                                    <div class="alert alert-success mb-0 p-2 text-center" role="alert">
                                        Copyed !
                                    </div>
                                @endif
                            </div>
                        </div>

                        <button id="copyMembershipButton"
                                class="btn theme-bg-color view-button icon text-white fw-bold btn-md mt-1">
                            Copy
                        </button>

                        <p class="text-center mt-1 mb-1">Or Share With</p>
                        <!-- Go to www.addthis.com/dashboard to customize your tools -->
                        <div class="addthis_inline_share_toolbox_5glk"></div>

                        {{--                        <p class="h5">Copy and go to &nbsp;--}}
                        {{--                            <a href="https://web.whatsapp.com/" target="_blank"><i class="fa-brands fa-whatsapp fa-2x theme-color"></i></a>--}}
                        {{--                            &nbsp; OR &nbsp;--}}
                        {{--                            <a href="https://www.messenger.com/" target="_blank"><i class="fa-brands fa-facebook-messenger fa-2x text-primary"></i></a>--}}
                        {{--                            &nbsp;--}}
                        {{--                            to paste</p>--}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Quick View Modal Box End -->


    <!-- Remove Profile Modal Start -->
    <div class="modal fade theme-modal remove-profile" id="removeProfile" tabindex="-1"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header d-block text-center">
                    <h5 class="modal-title w-100" id="exampleModalLabel22">Are You Sure ?</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="remove-box">
                        <p>You WantTo delete Address ?</p>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-animation btn-md fw-bold" data-bs-dismiss="modal">No</button>
                    <button type="button" class="btn theme-bg-color btn-md fw-bold text-light" id="deleteAddressButton"
                            data-bs-target="#removeAddress" data-bs-toggle="modal">Yes
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade theme-modal remove-profile" id="removeAddress" tabindex="-1"
         aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title text-center" id="exampleModalLabel12">Done!</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="remove-box text-center">
                        <h4 class="text-content">It's Removed.</h4>
                    </div>
                </div>
                <div class="modal-footer pt-0">
                    <button type="button" class="btn theme-bg-color btn-md fw-bold text-light"
                            data-bs-dismiss="modal">Close
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Remove Profile Modal End -->





@endsection


@section('java_script')
    <script>
        var deleteAddress = '';
        $(document).ready(function () {

            var base_url    = window.location.origin;
            var old_city_id = $("#old_city_id").val();
            var old_area_id = $("#old_area_id").val();

            if (old_city_id > 0) {
                $("#city_id").val(old_city_id);
                $('.imagesattition').removeClass('d-none');
                let formData = new FormData();
                formData.append('city_id', old_city_id);
                let path = base_url + "/get-regions";
                console.log("path", path);
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    processData: false,
                    success: function (response) {
                        if (response) {
                            $("#area_id").html('');
                            $("#area_id").append(
                                '<option value="">Choose Area</option>'
                            );
                            if (response.regions.length > 0) {
                                for (let ii = 0; ii < response.regions.length; ii++) {
                                    let proObj = response.regions[ii];
                                    $("#area_id").append(
                                        '<option value="' + proObj['id'] + '">' + proObj['region_en'] + '</option>'
                                    );
                                }
                            }
                            $("#area_id").val(old_area_id);
                        }
                        else {
                            $("#area_id").html('');
                            $("#area_id").append(
                                '<option value="">Choose Area</option>'
                            );
                        }
                    },
                    error: function (response) {
                        console.log(response)
                        alert('error in choose');
                    }
                });
            }

            $("#back_id_image").change(function () {

                $('.uploadebackimage').removeClass('d-none');
            });
            $("#front_id_image").change(function () {

                $('.uploadefrontimage').removeClass('d-none');
            });

            window.setTimeout(function () {

                var welcome_program = localStorage.getItem('welcome_program');
                if (!welcome_program || welcome_program == null || welcome_program == '') {
                    $("#welcome_program").modal('show');
                    localStorage.setItem("welcome_program", true);
                }


            }, 1500);


            $("#country_id").change(function () {

                var country_id = $("#country_id").val();
                let formData   = new FormData();
                formData.append('country_id', country_id);
                let path = base_url + "/get-cities";
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    processData: false,
                    success: function (response) {
                        if (response) {
                            $("#city_id").html('');
                            $("#city_id").append(
                                '<option value="">Choose City</option>'
                            );
                            if (response.cities.length > 0) {

                                for (let ii = 0; ii < response.cities.length; ii++) {
                                    let proObj = response.cities[ii];
                                    $("#city_id").append(
                                        '<option value="' + proObj['id'] + '">' + proObj['name_en'] + '</option>'
                                    );
                                }
                            }
                        }
                        else {
                            $("#city_id").html('');
                            $("#city_id").append(
                                '<option value="">Choose City</option>'
                            );
                        }
                    },
                    error: function (response) {
                        console.log(response)
                        alert('error in choose');
                    }
                });


            });

            $("#city_id").change(function () {
                var city_id  = $("#city_id").val();
                let formData = new FormData();
                formData.append('city_id', city_id);
                let path = base_url + "/get-regions";
                console.log("path", path);
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    processData: false,
                    success: function (response) {
                        if (response) {
                            $("#area_id").html('');
                            $("#area_id").append(
                                '<option value="">Choose Area</option>'
                            );
                            if (response.regions.length > 0) {
                                for (let ii = 0; ii < response.regions.length; ii++) {
                                    let proObj = response.regions[ii];
                                    $("#area_id").append(
                                        '<option value="' + proObj['id'] + '">' + proObj['region_en'] + '</option>'
                                    );
                                }
                            }
                        }
                        else {
                            $("#area_id").html('');
                            $("#area_id").append(
                                '<option value="">Choose Area</option>'
                            );
                        }
                    },
                    error: function (response) {
                        console.log(response)
                        alert('error in choose');
                    }
                });
            });

            $("#profileImageInput").change(function () {
                $('.uploadeimage').addClass('d-none');
                let formData = new FormData();
                formData.append('profile_photo', $('#profileImageInput')[0].files[0]);
                $.ajax({
                    url: "{{url('/updateUserProfileImage')}}",
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    processData: false,
                    success: function (response) {
                        if (response.data) {
                            $('.uploadeimage').removeClass('d-none');

                        }
                        else {
                            alert("error ", response.message)
                        }
                    },
                    error: function (response) {
                        console.log(response)
                        alert('error in choose');
                    }
                });
            });

            $("#updateUserContactInformation").click(function () {

                let formData = new FormData();
                formData.append('fname', $('#ufname').val());
                formData.append('mname', $('#umname').val());
                formData.append('lname', $('#ulname').val());
                formData.append('email', $('#uemail').val());
                formData.append('phone', $('#uphone').val());
                formData.append('password', $('#upassword').val());
                $.ajax({
                    url: "{{url('/updateUserContactInformation')}}",
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    processData: false,
                    success: function (response) {
                        if (response.data) {
                            setTimeout(function () {
                                hideModal('editProfile')
                            }, 2000);
                            swal({
                                text: "Update User Successfully",
                                title: "Successful",
                                timer: 1500,
                                icon: "success",
                                buttons: false,
                            });
                        }
                        else {
                            alert("error ", response.message)
                        }
                    },
                    error: function (error) {
                        console.log(error.responseJSON.message)
                        alert('Error ' + error.responseJSON.message);
                    }
                });
            });


            $('.alert-success').hide();
            $("#closebtn").click(function () {
                $('.alert-primary').hide();
            });
            $("#copyMembershipButton").click(function () {
                var copyTextarea = document.querySelector('.js-copytextarea');
                copyTextarea.focus();
                copyTextarea.select();
                try {
                    var successful = document.execCommand('copy');
                    $('.alert-success').show();
                    setTimeout(function () {
                        hideModal('view')
                    }, 2000);
                } catch (err) {
                    console.log('Oops, unable to copy');
                }
            });
            $(".viewShareModel").click(function () {
                var shareamumembershipurl = $('textarea#jsCopytextarea').val();

                addthis.update('share', 'url', shareamumembershipurl);
                addthis.update('share', 'title', '4unettinghub Membership URL (' + shareamumembershipurl + ')');
                addthis.url = shareamumembershipurl;
                // addthis.title ='4unettinghub Membership URL ('+ shareamumembershipurl+')';
                // addthis.toolbox(".addthis_toolbox");

            });
            $("#deleteAddressButton").click(function () {
                if (deleteAddress > 0) {
                    var object = {
                        "address_id": deleteAddress,
                    }
                    $.ajax({
                        url: "{{url('/deleteUserAddress')}}",
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
                            if (response.data) {
                                deleteAddress = '';
                                location.reload();
                            }
                            else {
                                console.log(response)
                                alert('You Are Unauthorized');
                            }
                        },
                        error: function (response) {
                            console.log(response)
                            alert('error');
                        }
                    });
                }
            });


        });

        function hideModal(mm) {
            $('#' + mm).modal('hide');
        }

        function goToSpecificCancelOrder(order_id) {
            console.log(order_id)
            $("#order_id_cancel_order").val(order_id);
        }

        function addAddressButton() {

            var address          = $('#address').val();
            var landmark         = $('#landmark').val();
            var floor_number     = $('#floor_number').val();
            var apartment_number = $('#apartment_number').val();
            var country_id       = $("#country_id").val();
            var city_id          = $("#city_id").val();
            var area_id          = $("#area_id").val();
            if (address && address != '' && landmark && landmark != '' && floor_number > 0 && apartment_number > 0 && country_id > 0 && city_id > 0 && area_id > 0) {

                var object = {
                    "address": address,
                    "landmark": landmark,
                    "floor_number": floor_number,
                    "apartment_number": apartment_number,
                    "city_id": city_id,
                    "area_id": area_id,
                    "country_id": country_id
                }
                $.ajax({
                    url: "{{url('/addUserAddress')}}",
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
                        if (response.data) {
                            var proObjff = response.data
                            console.log('response.data', response.data)
                            $('#addressesExist').val(1)
                            // location.reload();
                            $("#addContiner").append(
                                '<div class="col-xxl-6 col-lg-12 col-md-6">' +
                                '<div class="delivery-address-box number-box">' + '<div>' + '<div class="form-check">' +
                                '<input class="form-check-input" type="radio" value="' + proObjff['id'] + '" name="address_id" checked>' +
                                '  </div> <div class="label"><label>Home</label></div>' +
                                '<ul class="delivery-address-detail"> <li> <h4 class="fw-500">' + proObjff['country_name'] + ' - ' + proObjff['city_name'] + ' </h4> </li>' +
                                '<li>  <span class="text-content"><span class="text-title">Area :</span>' + proObjff['area_name'] + '</span></h6></li>' +
                                ' <li> <p class="text-content"><span class="text-title">Address: </span>' + proObjff['address'] + '</p> </li>' +
                                ' <li> <p class="text-content"><span class="text-title">Landmark: </span>' + proObjff['landmark'] + '</p> </li>' +
                                ' <li> <p class="text-content"><span class="text-title">Floor Number: </span>' + proObjff['floor_number'] + '</p> </li>' +
                                ' <li> <p class="text-content"><span class="text-title">Apartment Number: </span>' + proObjff['apartment_number'] + '</p> </li>' +
                                '</ul> </div> </div> </div>' +
                                ' \n'
                            );


                            swal({
                                text: "Address Added Successful",
                                title: "Successful",
                                timer: 1000,
                                icon: "success",
                                buttons: false,
                            });
                            setTimeout(function () {
                                hideModal()
                            }, 800);
                        }
                        else {
                            console.log(response)
                            alert('You Are Unauthorized');
                        }
                    },
                    error: function (response) {
                        console.log(response)
                        alert('error');
                    }
                });
            }
            else {
                $('#completeData').show();
            }

        }

    </script>
    <!-- Go to www.addthis.com/dashboard to customize your tools -->
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-5d0260104fa01709"></script>

@endsection
