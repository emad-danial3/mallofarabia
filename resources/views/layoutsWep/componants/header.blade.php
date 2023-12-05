<style>
    @keyframes translating {
        0% {
            transform: translateY(0px);
        }
        50% {
            transform: translateY(-8px);
        }
        100% {
            transform: translateY(0px);
        }
    }
    .brochureanimation {
        animation: translating 2s ease-in-out infinite;
    }
</style>
<header class="pb-0">
    <div class="header-top">
        <div class="container-fluid">
            <div class="row">
                <div class="col-xxl-3 d-xxl-block d-none">
                    <div class="top-left-header">
                        <i class="iconly-Location icli text-white"></i>
                        <span class="text-white">{{trans('website.company_address',[],session()->get('locale'))}}</span>
                    </div>
                </div>

                <div class="col-xxl-6 col-lg-9 d-lg-block d-none">
                    <div class="header-offer">
                        <div class="notification-slider">
                            <div>
                                <div class="timer-notification">
                                    <h3>
                                        {{trans('website.Free Delivery For Order Over 250 LE',[],session()->get('locale'))}}
                                        <a href="{{url('/products')}}" class="text-top-header">
                                            {{trans('website.Shop Now',[],session()->get('locale'))}}
                                        </a>
                                    </h3>
                                </div>
                            </div>
                            <div>
                                <div class="timer-notification">
                                    <h3>
                                        {{trans('website.Welcome to 4U store',[],session()->get('locale'))}}
                                        <a href="{{url('/products')}}" class="text-top-header">80 %
                                            {{trans('website.Discount',[],session()->get('locale'))}}

                                        </a>
                                    </h3>
                                </div>
                            </div>

                            <div>
                                <div class="timer-notification">
                                    <h3>
                                        {{trans('website.Special Price For Member',[],session()->get('locale'))}}
                                        <a

                                            @if(Auth::user()&&Auth::user()->stage == '2' && Auth::user()->user_type == 'member')
                                            href="{{url('segment_commission')}}"
                                            @elseif(Auth::user()&&Auth::user()->stage == '1' && Auth::user()->user_type == 'normal_user')
                                            href="{{url('memberProfile')}}"
                                            @else
                                            href="{{url('joinus')}}"
                                            @endif

                                            class="text-top-header">

                                            {{trans('website.Join Us',[],session()->get('locale'))}}
                                            <i class="fa-solid fa-hand-pointer"></i></a>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-3">
                    <ul class="about-list right-nav-about">
                        <li class="right-nav-list">
                            <div class="dropdown theme-form-select">
                                <button class="btn dropdown-toggle" type="button" id="select-language"
                                        data-bs-toggle="dropdown" aria-expanded="false">
                                    @if(session()->get('locale')=='ar')
                                        <span>اللغة العربية</span>
                                    @else
                                        <span>English</span>
                                    @endif
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="select-language">
                                    <li onclick="changeLanguage('en')">
                                        <a class="dropdown-item" href="{{url('lang','en') }}" id="english">
                                            <img src="../assets/images/country/united-kingdom.png"
                                                 class="img-fluid blur-up lazyload" alt="">
                                            <span>English</span>
                                        </a>
                                    </li>
                                    <li onclick="changeLanguage('ar')">
                                        <a class="dropdown-item" href="{{url('lang','ar') }}" id="english">
                                            <img src="../assets/images/country/ar.png"
                                                 class="img-fluid blur-up lazyload" alt="">
                                            <span>اللغة العربية</span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        {{--                        <li class="right-nav-list">--}}
                        {{--                            <div class="dropdown theme-form-select">--}}
                        {{--                                <button class="btn dropdown-toggle" type="button" id="select-dollar"--}}
                        {{--                                        data-bs-toggle="dropdown" aria-expanded="false">--}}
                        {{--                                    <span>USD</span>--}}
                        {{--                                </button>--}}
                        {{--                                <ul class="dropdown-menu dropdown-menu-end sm-dropdown-menu"--}}
                        {{--                                    aria-labelledby="select-dollar">--}}
                        {{--                                    <li>--}}
                        {{--                                        <a class="dropdown-item" id="aud" href="javascript:void(0)">AUD</a>--}}
                        {{--                                    </li>--}}
                        {{--                                    <li>--}}
                        {{--                                        <a class="dropdown-item" id="eur" href="javascript:void(0)">EUR</a>--}}
                        {{--                                    </li>--}}
                        {{--                                    <li>--}}
                        {{--                                        <a class="dropdown-item" id="cny" href="javascript:void(0)">CNY</a>--}}
                        {{--                                    </li>--}}
                        {{--                                </ul>--}}
                        {{--                            </div>--}}
                        {{--                        </li>--}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="top-nav top-header sticky-header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-12 newoldnav">
                    <div class="header-nav">
                        <div class="header-nav-middle">
                            <div class="main-nav navbar navbar-expand-xl navbar-light navbar-sticky">
                                <div class="offcanvas offcanvas-collapse order-xl-2" id="primaryMenu">
                                    <div class="offcanvas-header navbar-shadow">
                                        <h5>Menu</h5>
                                        <button class="btn-close lead" type="button" data-bs-dismiss="offcanvas"
                                                aria-label="Close"></button>
                                    </div>
                                    <div class="offcanvas-body">
                                        <ul class="navbar-nav">
                                            <li class="nav-item">
                                                <a class="nav-link theme-second-color" href="{{url('/')}}"
                                                >{{trans('auth.attributes.home',[],session()->get('locale'))}}
                                                </a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link theme-second-color" href="{{url('products')}}"
                                                >{{trans('auth.attributes.products',[],session()->get('locale'))}}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link theme-second-color brochureanimation" href="{{url('digitalBrochure')}}"
                                                >{{trans('auth.attributes.brochure',[],session()->get('locale'))}}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link theme-second-color" href="{{url('increase_income')}}"
                                                >{{trans('auth.attributes.earn more',[],session()->get('locale'))}}</a>
                                            </li>
                                            <li class="nav-item theme-color">
                                                <a class="nav-link theme-second-color"

                                                   @if(Auth::user()&&Auth::user()->stage == '2' && Auth::user()->user_type == 'member')
                                                   href="{{url('segment_commission')}}"
                                                   @elseif(Auth::user()&&Auth::user()->stage == '1' && Auth::user()->user_type == 'normal_user')
                                                   href="{{url('memberProfile')}}"
                                                   @else
                                                   href="{{url('joinus')}}"
                                                    @endif

                                                >4U VIP</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link theme-second-color" href="{{url('specialoffers')}}"
                                                >{{trans('auth.attributes.special offers',[],session()->get('locale'))}}</a>
                                            </li>
                                            <li class="nav-item">
                                                <a class="nav-link theme-second-color" href="{{url('about')}}"
                                                >{{trans('auth.attributes.about_us',[],session()->get('locale'))}}</a>


                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="navbar-top header-nav-middle">
                        <button class="navbar-toggler d-xl-none d-inline navbar-menu-button" type="button"
                                data-bs-toggle="offcanvas" data-bs-target="#primaryMenu">
                                <span class="navbar-toggler-icon">
                                    <i class="fa-solid fa-bars"></i>
                                </span>
                        </button>
                        <a href="{{url('/')}}" class="web-logo nav-logo">
                            <img src="../assets/images/logo/1.png" class="img-fluid blur-up lazyload" alt="" style="height: 90px;">
                        </a>

                        <div class="middle-box header-nav">


                            <div class="header-nav-middle">
                                <div class="main-nav navbar navbar-expand-xl navbar-light navbar-sticky">
                                    <div class="offcanvas offcanvas-collapse order-xl-2" id="primaryMenu">
                                        <div class="offcanvas-header navbar-shadow">
                                            <h5>Menu</h5>
                                            <button class="btn-close lead" type="button" data-bs-dismiss="offcanvas"
                                                    aria-label="Close"></button>
                                        </div>
                                        <div class="offcanvas-body">
                                            <ul class="navbar-nav">
                                                <li class="nav-item">
                                                    <a class="nav-link theme-second-color" href="{{url('/')}}"
                                                    >{{trans('auth.attributes.home',[],session()->get('locale'))}}
                                                    </a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link theme-second-color" href="{{url('products')}}"
                                                    >{{trans('auth.attributes.products',[],session()->get('locale'))}}</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link theme-second-color brochureanimation" href="{{url('digitalBrochure')}}"
                                                    >{{trans('auth.attributes.brochure',[],session()->get('locale'))}}</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link theme-second-color" href="{{url('increase_income')}}"
                                                    >{{trans('auth.attributes.earn more',[],session()->get('locale'))}}</a>
                                                </li>
                                                <li class="nav-item theme-color">
                                                    <a class="nav-link theme-second-color"

                                                       @if(Auth::user()&&Auth::user()->stage == '2' && Auth::user()->user_type == 'member')
                                                       href="{{url('segment_commission')}}"
                                                       @elseif(Auth::user()&&Auth::user()->stage == '1' && Auth::user()->user_type == 'normal_user')
                                                       href="{{url('memberProfile')}}"
                                                       @else
                                                       href="{{url('joinus')}}"
                                                        @endif


                                                    >4U VIP</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link theme-second-color" href="{{url('specialoffers')}}"
                                                    >{{trans('auth.attributes.special offers',[],session()->get('locale'))}}</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link theme-second-color" href="{{url('about')}}"
                                                    >{{trans('auth.attributes.about_us',[],session()->get('locale'))}}</a>


                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            {{--                            <div class="location-box p-0">--}}
                            {{--                                <button class="btn location-button">--}}

                            {{--                                    <a class="nav-link" href="{{url('joinus')}}">--}}
                            {{--                                        <img src="../assets/images/logo/vip.png" alt="" style="height: 35px;border-radius: 5px">--}}
                            {{--                                        <span class="locat-name BecomeARep"> VIP membership</span>--}}
                            {{--                                    </a>--}}
                            {{--                                </button>--}}
                            {{--                            </div>--}}
                            {{--                            <div class="search-box">--}}
                            {{--                                <div class="input-group">--}}
                            {{--                                    <input type="search" class="form-control" placeholder="What are you looking for ?" id="generalSearch"--}}
                            {{--                                           aria-label="Recipient's username" aria-describedby="button-addon2">--}}
                            {{--                                    <button class="btn" type="button" id="button-addon2">--}}
                            {{--                                        <i data-feather="search"></i>--}}
                            {{--                                    </button>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                        </div>

                        <div class="rightside-box">
                            <div class="search-full">
                                <div class="input-group">
                                    <button class="input-group-text btn" type="button" id="goToSearch">
                                        <img src="../assets/images/svg/search7.png"
                                             class="img-1 blur-up lazyload" alt="">
                                    </button>
                                    <input type="text" class="form-control search-type" placeholder="{{trans('website.What are you looking for ?',[],session()->get('locale'))}}" id="generalSearch">
                                    <span class="input-group-text close-search">
                                            <i data-feather="x" class="font-light"></i>
                                        </span>
                                </div>
                            </div>
                            <ul class="right-side-menu">
                                <li class="right-side">
                                    <div class="delivery-login-box">
                                        <div class="delivery-icon">
                                            <div class="search-box">
                                                <i data-feather="search"></i>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="right-side">
                                    <div class="delivery-login-box">
                                        <div class="delivery-icon">
                                            <div class="search-box">
                                                <div class="input-group">
                                                    {{--                                                                                 <input type="search" class="form-control" placeholder="What are you looking for ?" id="generalSearch"--}}
                                                    {{--                                                                                        aria-label="Recipient's username" aria-describedby="button-addon2">--}}
                                                    {{--                                                                                 <button class="btn" type="button" >--}}
                                                    {{--                                                                                     <i data-feather="search"></i>--}}
                                                    {{--                                                                                 </button>--}}

                                                    <a id="button-addon22" href="javascript:void(0)" class="btn p-0 position-relative header-wishlist search-type">
                                                        <img src="../assets/images/svg/search7.png"
                                                             class="img-1 blur-up lazyload" alt="">
                                                        <div class="delivery-detail">
                                                            <h5 class="theme-second-color newFont">
                                                                &nbsp; {{trans('auth.attributes.search',[],session()->get('locale'))}}</h5>
                                                        </div>
                                                    </a>

                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>


                                <li class="right-side">
                                    <a href="{{url('/wishlist')}}" class="btn p-0 position-relative header-wishlist">
                                        <img src="../assets/images/svg/heart.png"
                                             class="img-1 blur-up lazyload" alt="">
                                        &nbsp; <h5 class="theme-second-color" id="herderWishlistCount">0</h5>
                                    </a>
                                </li>
                                <li class="right-side">
                                    <div class="onhover-dropdown header-badge">
                                        <button type="button" class="btn p-0 position-relative header-wishlist">
                                            <img src="../assets/images/svg/cart2.png"
                                                 class="img-1 blur-up lazyload" alt=""> &nbsp;
                                            <h5 class="theme-second-color" id="herderCardCount">0</h5>

                                        </button>

                                        <div class="onhover-div">
                                            <ul class="cart-list">
                                                {{--                                                <li class="product-box-contain">--}}
                                                {{--                                                    <div class="drop-cart">--}}
                                                {{--                                                        <a href="product-left-thumbnail.html" class="drop-image">--}}
                                                {{--                                                            <img src="../assets/images/vegetable/product/1.png"--}}
                                                {{--                                                                 class="blur-up lazyload" alt="">--}}
                                                {{--                                                        </a>--}}

                                                {{--                                                        <div class="drop-contain">--}}
                                                {{--                                                            <a href="product-left-thumbnail.html">--}}
                                                {{--                                                                <h5>Fantasy Crunchy Choco Chip Cookies</h5>--}}
                                                {{--                                                            </a>--}}
                                                {{--                                                            <h6><span>1 x</span> $80.58</h6>--}}
                                                {{--                                                            <button class="close-button close_button">--}}
                                                {{--                                                                <i class="fa-solid fa-xmark"></i>--}}
                                                {{--                                                            </button>--}}
                                                {{--                                                        </div>--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                </li>--}}

                                                {{--                                                <li class="product-box-contain">--}}
                                                {{--                                                    <div class="drop-cart">--}}
                                                {{--                                                        <a href="product-left-thumbnail.html" class="drop-image">--}}
                                                {{--                                                            <img src="../assets/images/vegetable/product/2.png"--}}
                                                {{--                                                                 class="blur-up lazyload" alt="">--}}
                                                {{--                                                        </a>--}}

                                                {{--                                                        <div class="drop-contain">--}}
                                                {{--                                                            <a href="product-left-thumbnail.html">--}}
                                                {{--                                                                <h5>Peanut Butter Bite Premium Butter Cookies 600 g--}}
                                                {{--                                                                </h5>--}}
                                                {{--                                                            </a>--}}
                                                {{--                                                            <h6><span>1 x</span> $25.68</h6>--}}
                                                {{--                                                            <button class="close-button close_button">--}}
                                                {{--                                                                <i class="fa-solid fa-xmark"></i>--}}
                                                {{--                                                            </button>--}}
                                                {{--                                                        </div>--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                </li>--}}
                                            </ul>

                                            <div class="price-box">
                                                <h5>{{trans('website.Total',[],session()->get('locale'))}} :</h5>
                                                <h4 class="theme-color fw-bold" id="herderCardTotalCount"></h4>
                                            </div>
                                            <div class="price-box">
                                                <h5>{{trans('website.VIP member price',[],session()->get('locale'))}}
                                                    :</h5>
                                                <h4 class="theme-color fw-bold" id="herderUpToTotalCount"></h4>
                                            </div>

                                            <div class="button-group">
                                                <a href="{{url('getCart')}}" class="btn btn-sm cart-button">
                                                    {{trans('website.View Cart',[],session()->get('locale'))}}
                                                </a>
                                                <a href="{{url('/getCheckout')}}" class="btn btn-sm cart-button theme-bg-color
                                                    text-white">{{trans('website.Checkout',[],session()->get('locale'))}}</a>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="right-side onhover-dropdown">
                                    <div class="delivery-login-box">
                                        {{--                                        <div class="delivery-icon">--}}
                                        {{--                                            @guest--}}
                                        {{--                                                <a class="theme-second-color" href="{{ url('login') }}"> <i data-feather="user"></i></a>--}}
                                        {{--                                            @else--}}
                                        {{--                                                <a class="theme-second-color" href="{{ url('memberProfile') }}"> <i data-feather="user"></i></a>--}}
                                        {{--                                            @endguest--}}
                                        {{--                                        </div>--}}
                                        <div class="delivery-detail">
                                            @guest
                                                <h4>
                                                    <a class="theme-second-color newFont" href="{{ url('login') }}">{{trans('auth.attributes.login',[],session()->get('locale'))}} </a>
                                                </h4>
                                            @else
                                                <h4>
                                                    <a class="theme-second-color" href="{{ url('memberProfile') }}">{{ substr(Auth::user()->full_name, 0, strpos(Auth::user()->full_name, ' '))}}</a>
                                                </h4>
                                            @endguest
                                        </div>
                                    </div>
                                    @guest
                                    @else
                                        <div class="onhover-div onhover-div-login">
                                            <ul class="user-box-name">

                                                <li class="nav-item">
                                                    <a class="nav-link theme-second-color" href="{{ url('memberProfile') }}"> {{trans('website.Profile',[],session()->get('locale'))}}</a>
                                                </li>
                                                <li class="nav-item">
                                                    <a class="nav-link theme-second-color" id="logoutButton" href=""> {{trans('website.Logout',[],session()->get('locale'))}}</a>
                                                </li>

                                            </ul>
                                        </div>
                                    @endguest
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    var base_url = window.location.origin;
    $(document).ready(function () {

        $("#goToSearch").click(function () {
            var searinput = $('#generalSearch').val();
            if (searinput && searinput != '') {
                let url = base_url + '/products?name=' + searinput
                window.open(url, "_self");
            }
        });


        $("#generalSearch").on('keypress', function (e) {
            if (e.which == 13) {
                var searinput = $('#generalSearch').val();
                if (searinput && searinput != '') {
                    let url = base_url + '/products?name=' + searinput
                    window.open(url, "_self");
                }
            }
        });

        $("#logoutButton").click(function () {

            $('#subtotal').html(0);
            $('#shipping').html(0);
            $('#total_cart').html(0);
            $('#total_price_after_discount').html(0);
            allProductsArray = [];
            const myJSON     = JSON.stringify(allProductsArray);
            localStorage.setItem("user_cart", myJSON);
            const cartLength = allProductsArray.length;
            $('#herderCardCount').html(cartLength)
            $('#herderCardTotalCount').html(0)

            var allWishProducts = [];
            const myJSONn       = JSON.stringify(allWishProducts);
            localStorage.setItem("user_wishlist", myJSONn);
            $('#herderWishlistCount').html(0)
        });

    });

    function changeLanguage(lang) {
        if (lang == 'ar') {
            $("html").attr("dir", "rtl");
            $("body").removeClass("ltr");
            $("body").addClass("rtl");
            $("#rtl-link").attr("href", "../assets/css/vendors/bootstrap.rtl.css");
            localStorage.setItem("website_lang", 'ar');
        }
        else {
            $("html").attr("dir", "ltr");
            $("body").removeClass("rtl");
            $("body").addClass("ltr");
            $("#rtl-link").attr("href", "../assets/css/vendors/bootstrap.css");
            localStorage.setItem("website_lang", 'en');
        }
    }


</script>
