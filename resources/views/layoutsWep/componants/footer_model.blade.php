<!-- Location Modal Start -->
<div class="modal location-modal fade theme-modal" id="locationModal" tabindex="-1"
     aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Choose your Delivery Location</h5>
                <p class="mt-1 text-content">Enter your address and we will specify the offer for your area.</p>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            <div class="modal-body">
                <div class="location-list">
                    <div class="search-input">
                        <input type="search" class="form-control" placeholder="Search Your Area">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </div>

                    <div class="disabled-box">
                        <h6>Select a Location</h6>
                    </div>

                    <ul class="location-select custom-height">
                        <li>
                            <a href="javascript:void(0)">
                                <h6>Alabama</h6>
                                <span>Min: $130</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>Arizona</h6>
                                <span>Min: $150</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>California</h6>
                                <span>Min: $110</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>Colorado</h6>
                                <span>Min: $140</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>Florida</h6>
                                <span>Min: $160</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>Georgia</h6>
                                <span>Min: $120</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>Kansas</h6>
                                <span>Min: $170</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>Minnesota</h6>
                                <span>Min: $120</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>New York</h6>
                                <span>Min: $110</span>
                            </a>
                        </li>

                        <li>
                            <a href="javascript:void(0)">
                                <h6>Washington</h6>
                                <span>Min: $130</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Location Modal End -->

<!-- Cookie Bar Box Start -->
<div class="cookie-bar-box" style="display: none">
    <div class="cookie-box">
        <div class="cookie-image">
            <img src="../assets/images/cookie-bar.png" class="blur-up lazyload" alt="">
            <h2>Cookies!</h2>
        </div>

        <div class="cookie-contain">
            <h5 class="text-content">We use cookies to make your experience better</h5>
        </div>
    </div>

    <div class="button-group">
        <button class="btn privacy-button">Privacy Policy</button>
        <button class="btn ok-button">OK</button>
    </div>
</div>
<!-- Cookie Bar Box End -->

<!-- Deal Box Modal Start -->
<div class="modal fade theme-modal deal-modal" id="deal-box" tabindex="-1" aria-labelledby="exampleModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-fullscreen-sm-down">
        <div class="modal-content">
            <div class="modal-header">
                <div>
                    <h5 class="modal-title w-100" id="deal_today">Hot Sale</h5>
                    <p class="mt-1 text-content">Recommended deals for you.</p>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            </div>
            {{--                <div class="modal-body">--}}
            {{--                    <div class="deal-offer-box">--}}
            {{--                        <ul class="deal-offer-list">--}}
            {{--                            <li class="list-1">--}}
            {{--                                <div class="deal-offer-contain">--}}
            {{--                                    <a href="shop-left-sidebar.html" class="deal-image">--}}
            {{--                                        <img src="../assets/images/vegetable/product/10.png" class="blur-up lazyload"--}}
            {{--                                            alt="">--}}
            {{--                                    </a>--}}

            {{--                                    <a href="shop-left-sidebar.html" class="deal-contain">--}}
            {{--                                        <h5>Blended Instant Coffee 50 g Buy 1 Get 1 Free</h5>--}}
            {{--                                        <h6>$52.57 <del>57.62</del> <span>500 G</span></h6>--}}
            {{--                                    </a>--}}
            {{--                                </div>--}}
            {{--                            </li>--}}

            {{--                            <li class="list-2">--}}
            {{--                                <div class="deal-offer-contain">--}}
            {{--                                    <a href="shop-left-sidebar.html" class="deal-image">--}}
            {{--                                        <img src="../assets/images/vegetable/product/11.png" class="blur-up lazyload"--}}
            {{--                                            alt="">--}}
            {{--                                    </a>--}}

            {{--                                    <a href="shop-left-sidebar.html" class="deal-contain">--}}
            {{--                                        <h5>Blended Instant Coffee 50 g Buy 1 Get 1 Free</h5>--}}
            {{--                                        <h6>$52.57 <del>57.62</del> <span>500 G</span></h6>--}}
            {{--                                    </a>--}}
            {{--                                </div>--}}
            {{--                            </li>--}}

            {{--                            <li class="list-3">--}}
            {{--                                <div class="deal-offer-contain">--}}
            {{--                                    <a href="shop-left-sidebar.html" class="deal-image">--}}
            {{--                                        <img src="../assets/images/vegetable/product/12.png" class="blur-up lazyload"--}}
            {{--                                            alt="">--}}
            {{--                                    </a>--}}

            {{--                                    <a href="shop-left-sidebar.html" class="deal-contain">--}}
            {{--                                        <h5>Blended Instant Coffee 50 g Buy 1 Get 1 Free</h5>--}}
            {{--                                        <h6>$52.57 <del>57.62</del> <span>500 G</span></h6>--}}
            {{--                                    </a>--}}
            {{--                                </div>--}}
            {{--                            </li>--}}

            {{--                            <li class="list-1">--}}
            {{--                                <div class="deal-offer-contain">--}}
            {{--                                    <a href="shop-left-sidebar.html" class="deal-image">--}}
            {{--                                        <img src="../assets/images/vegetable/product/13.png" class="blur-up lazyload"--}}
            {{--                                            alt="">--}}
            {{--                                    </a>--}}

            {{--                                    <a href="shop-left-sidebar.html" class="deal-contain">--}}
            {{--                                        <h5>Blended Instant Coffee 50 g Buy 1 Get 1 Free</h5>--}}
            {{--                                        <h6>$52.57 <del>57.62</del> <span>500 G</span></h6>--}}
            {{--                                    </a>--}}
            {{--                                </div>--}}
            {{--                            </li>--}}
            {{--                        </ul>--}}
            {{--                    </div>--}}
            {{--                </div>--}}
        </div>
    </div>
</div>
<!-- Deal Box Modal End -->

<!-- Tap to top start -->
<div class="theme-option">
    <div class="setting-box">
        <button class="btn setting-button">
{{--            <i class="fa-brands fa-whatsapp"></i>--}}
             <img src="../assets/images/social/whatsapp.png" width="60" class="blur-up lazyload"
                                                 alt="">
        </button>

        <div class="theme-setting-2">
            <div class="theme-box">
                <ul>
                    <li>
                        <div class="theme-setting-button color-picker">
                            <form class="form-control">
                                <input type="hidden" class="form-control form-control-color" id="colorPick"
                                       value="#8563a5" title="Choose your color">
                            </form>
                        </div>
                    </li>

                    <li>
                        <div class="w-100 ">
                            <h3>How Can Help You ?
                                <br>
                                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

                                <div class="row">
                                    <div class="col-10">
                                        <textarea class="form-control w-100 mt-2" id="exampleFormControlTextarea1" rows="1"></textarea>
                                    </div>
                                    <div class="col-2">
                                        <h3 class="delivery-login-box mt-2 mr-1">
                                            <i onclick="sendWhatsAppMessage()" class="fa-solid fa-arrow-right whatsappSentButton cursor-pointer"></i>
                                        </h3>
                                    </div>
                                </div>

                                <br>
                            </h3>
                        </div>

                    </li>

                </ul>
            </div>
        </div>
    </div>

    <div class="back-to-top">
        <a id="back-to-top" href="#">
            <i class="fas fa-chevron-up"></i>
        </a>
    </div>
</div>
<!-- Tap to top end -->

<!-- Bg overlay Start -->
<div class="bg-overlay"></div>
<!-- Bg overlay End -->

<script>
    function sendWhatsAppMessage() {
        var shareamumembershipurl = $('textarea#exampleFormControlTextarea1').val();
        let urlPath               = 'https://wa.me/201222436850?text=' + shareamumembershipurl;
        window.open(urlPath, '_blank');
    }
</script>


