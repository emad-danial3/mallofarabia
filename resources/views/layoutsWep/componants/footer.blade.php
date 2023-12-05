<!-- Footer Section Start -->
<footer class="section-t-space">
    <div class="container-fluid-lg">
        <div class="service-section">
            <div class="row g-3">
                <div class="col-12">
                    <div class="service-contain">

                        <div class="service-box">
                            {{--                            <div class="service-image">--}}
                            {{--                                <img src="../assets/svg/product.svg" class="blur-up lazyload" alt="">--}}
                            {{--                            </div>--}}

                            <div class="service-detail">
                                <h3 class="text-white"> {{trans('website.New Products',[],session()->get('locale'))}}</h3>
                            </div>
                        </div>

                        <div class="service-box">
                            {{--                            <div class="service-image">--}}
                            {{--                                <img src="../assets/svg/delivery.svg" class="blur-up lazyload" alt="">--}}
                            {{--                            </div>--}}

                            <div class="service-detail">
                                <h3 class="text-white">{{trans('website.Free Delivery For Order Over 250 LE',[],session()->get('locale'))}}</h3>
                            </div>
                        </div>

                        <div class="service-box">
                            {{--                            <div class="service-image">--}}
                            {{--                                <img src="../assets/svg/discount.svg" class="blur-up lazyload" alt="">--}}
                            {{--                            </div>--}}

                            <div class="service-detail cursor-pointer">
                                <h3 class="text-white">{{trans('website.Mega Discounts For Members',[],session()->get('locale'))}} </h3>
                            </div>
                        </div>

                        <div class="service-box">
                            {{--                            <div class="service-image">--}}
                            {{--                                <img src="../assets/svg/market.svg" class="blur-up lazyload" alt="">--}}
                            {{--                            </div>--}}

                            <div class="service-detail">
                                <h3 class="text-white">{{trans('website.Best Price On The Market',[],session()->get('locale'))}}</h3>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-footer section-t-space">
            <div class="row g-md-4 g-3">
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="footer-logo">
                        <div class="theme-logo">
                            <a href="{{url('/')}}">
                                <img src="../assets/images/logo/logo-2.png" class="blur-up lazyload" alt="" style="width: 250px;height: 200px">
                            </a>
                        </div>

                        <div class="footer-logo-contain">
                            <p></p>

                            <ul class="address">
                                <li>
                                   <i class="fa fa-home text-dark-mint" aria-hidden="true"></i>

                                    <a href="javascript:void(0)"  class="text-white">{{trans('website.company_address',[],session()->get('locale'))}}</a>
                                </li>
                                {{--                                <li>--}}
                                {{--                                    <i data-feather="mail"></i>--}}
                                {{--                                    <a href="javascript:void(0)">4usupport@nettinghub.com</a>--}}
                                {{--                                </li>--}}
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-xl-2 col-lg-3 col-md-4 col-sm-6">
                    <div class="footer-title">
                        <h4 class="text-top-header">{{trans('website.Categories',[],session()->get('locale'))}}</h4>
                    </div>

                    <div class="footer-contain">
                        <ul>
                            @inject('filters', 'App\Models\Filter')
                            @if($filters->where('is_available', 1)->count() != 0)
                                @foreach($filters->where('is_available', 1)->take(7)->get() as $filter)
                                    <li>
                                        <a href="{{url('/products?filter_id='.$filter->id)}}" class="text-content text-white">{{$filter->name_en}}</a>
                                    </li>
                                @endforeach
                            @endif
                        </ul>
                    </div>
                </div>

                <div class="col-xl col-lg-2 col-sm-3">
                    <div class="footer-title">
                        <h4 class="text-top-header">{{trans('website.Legal',[],session()->get('locale'))}}</h4>
                    </div>

                    <div class="footer-contain">
                        <ul>
                            <li>
                                <a href="{{url('/terms')}}" class="text-content text-white">{{trans('website.Terms & Conditions',[],session()->get('locale'))}}</a>
                            </li>
                            <li>
                                <a href="{{url('/privacy')}}" class="text-content text-white">{{trans('website.Privacy',[],session()->get('locale'))}}</a>
                            </li>
                            <li>
                                <a href="{{url('/refund')}}" class="text-content text-white">{{trans('website.Refund Policy',[],session()->get('locale'))}}</a>
                            </li>
                            {{--                            <li>--}}
                            {{--                                <a href="{{url('/contactus')}}" class="text-content">Contact Us</a>--}}
                            {{--                            </li>--}}
                        </ul>
                    </div>
                </div>

                <div class="col-xl-2 col-sm-3">
                    <div class="footer-title">
                        <h4 class="text-top-header">{{trans('website.Help Center',[],session()->get('locale'))}}</h4>
                    </div>

                    <div class="footer-contain">
                        <ul>
                            <li>
                                <a href="{{url('memberProfile')}}" class="text-content text-white">{{trans('website.Your order',[],session()->get('locale'))}}</a>
                            </li>
                            <li>
                                <a href="{{url('memberProfile')}}" class="text-content text-white">{{trans('website.Your Account',[],session()->get('locale'))}}</a>
                            </li>
                            <li>
                                <a href="{{url('memberProfile')}}" class="text-content text-white">{{trans('website.Track Your Order',[],session()->get('locale'))}}</a>
                            </li>
                            <li>
                                <a href="{{url('wishlist')}}" class="text-content text-white">{{trans('website.Your Wishlist',[],session()->get('locale'))}}</a>
                            </li>
                            {{--                            <li>--}}
                            {{--                                <a href="search.html" class="text-content">Search</a>--}}
                            {{--                            </li>--}}
                            {{--                            <li>--}}
                            {{--                                <a href="faq.html" class="text-content">FAQ</a>--}}
                            {{--                            </li>--}}
                        </ul>
                    </div>
                </div>

                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="footer-title">
                        <h4><a href="{{url('/contactus')}}" class="text-content text-top-header">{{trans('website.Contact Us',[],session()->get('locale'))}}</a></h4>

                    </div>

                    <div class="footer-contact">
                        <ul>
                            <li>
                                <div class="footer-number">
                                   <i class="fa fa-phone text-dark-mint" aria-hidden="true"></i>
                                    <div class="contact-number">
                                        <a href="{{url('/contactus')}}" class="delivery-login-box">
                                            <h6 class="text-content text-white">{{trans('website.Hotline',[],session()->get('locale'))}}</h6>
                                            <h5 class="text-white">17125</h5>
                                        </a>
                                    </div>

                                </div>
                            </li>
                            <li>
                                <div class="footer-number">
                                    <i class="fa-brands fa-whatsapp text-dark-mint" style="font-size: 1.4em"></i>
                                    <div class="contact-number">
                                        <a href="https://wa.me/201222436850" class="delivery-login-box" target="_blank">
                                            <h6 class="text-content text-white">{{trans('website.Whatsapp',[],session()->get('locale'))}}</h6>
                                            <h5 class="text-white">+201222436850</h5>
                                        </a>
                                    </div>

                                </div>
                            </li>

                            <li>
                                <div class="footer-number">
                                   <i class="fa fa-envelope text-dark-mint" aria-hidden="true"></i>
                                    <div class="contact-number">
                                        <h6 class="text-content text-white">{{trans('website.Email Address',[],session()->get('locale'))}}</h6>
                                        <a href="mailto:support@4unettinghub.com"><h5 class="text-white">support@4unettinghub.com</h5></a>
                                    </div>
                                </div>
                            </li>

                            <li class="social-app mb-0">
{{--                                <h5 class="mb-2 text-content">Download Our App :</h5>--}}
                                <ul>
                                    <li class="mb-0">
                                        <a href="https://play.google.com/store/apps/details?id=com.akhnaton.nettinghub4u" target="_blank">
                                            <img src="../assets/images/playstore.svg" class="blur-up lazyload"
                                                 alt="">
                                        </a>
                                    </li>
                                    <li class="mb-0">
                                        <a href="https://apps.apple.com/us/app/4u-netting-hub/id6449465428" target="_blank">
                                            <img src="../assets/images/appstore.svg" class="blur-up lazyload"
                                                 alt="">
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="sub-footer section-small-space">
            <div class="reserve">
                <h6 class="text-content text-white">{{trans('website.©2023 4U NettingHub All rights reserved',[],session()->get('locale'))}}</h6>
            </div>

            <div class="payment">
{{--                <img src="../assets/images/payment/1.png" class="blur-up lazyload" alt="">--}}
            </div>

             <div class="social-link">

                <ul>
                    <li>
                        <a href="https://www.facebook.com/4UNettingHub?mibextid=ZbWKwL" target="_blank">

                            <img src="../assets/images/social/facebook.png" class="blur-up lazyload"
                                                 alt="">

                        </a>
                    </li>
                    <li>
                        <a href="https://twitter.com/NettingHub?t=g2QQUYqKGfDqF8blRjPxRw&s=08" target="_blank">
                            <img src="../assets/images/social/twitter.png" class="blur-up lazyload"
                                                 alt="">
                        </a>
                    </li>
                    <li>
                        <a href="https://instagram.com/4unettinghub?igshid=MzRlODBiNWFlZA==" target="_blank">
                           <img src="../assets/images/social/instagram.png" class="blur-up lazyload"
                                                 alt="">
                        </a>
                    </li>
                    <li class="right-side m-2">
                        <a href="https://youtube.com" class="btn p-0" target="_blank">
                            <img src="../assets/images/social/youtube.png" class="blur-up lazyload"
                                                 alt="">
                        </a>
                    </li>
                    {{--                    <li>--}}
                    {{--                        <a href="https://in.pinterest.com/" target="_blank">--}}
                    {{--                            <i class="fa-brands fa-pinterest-p"></i>--}}
                    {{--                        </a>--}}
                    {{--                    </li>--}}
                    <li>
                        <a href="https://api.whatsapp.com/send/?phone=201222436850" target="_blank">
                            <img src="../assets/images/social/whatsapp.png" class="blur-up lazyload"
                                                 alt="">
                        </a>
                    </li>
                    <li>
                        <a href="https://www.tiktok.com/@netting.hub?_t=8dGrrLoe6OU&_r=1" target="_blank">
                            <img src="../assets/images/social/tiktok.png" class="blur-up lazyload"
                                                 alt="">
                        </a>
                    </li>

                </ul>
            </div>

        </div>
    </div>
</footer>
<!-- Footer Section End -->
