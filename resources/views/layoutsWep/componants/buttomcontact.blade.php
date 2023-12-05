
                <!-- Banner Section Start -->
                <section class="banner-section pb-5">
                    <div class="">
                        <div class="row gy-lg-0 gy-3">
                            <div class="col-lg-5">

                                <div class="title text-center" style="margin: auto;display: contents;">
                                    <h2 class="text-center mb-2"><img src="../assets/images/images/message.png"  alt="" width="50" height="50"></h2>
                                    <h2 class="text-center theme-second-color mb-1">{{trans('website.Contact Us',[],session()->get('locale'))}}</h2>
                                    <h3 class="text-center text-secondary w-50 text-center mx-auto">{{trans('website.Our support team is here to help by phone or email.',[],session()->get('locale'))}}</h3>
                                     <button class="btn background-dark-mint mt-sm-4 btn-md mx-auto text-white fw-bold"
                                                    onclick="location.href = '/contactus';">{{trans('website.Learn More',[],session()->get('locale'))}}
                                            </button>
                                </div>
                            </div>
                            <div class="col-lg-2 d-flex d-none .d-sm-none d-md-block d-lg-block ">
                                <img src="../assets/images/images/vertical.png"  class="mx-auto" alt="" width="2" height="200">
                            </div>
                            <div class="col-lg-5">
                                <div class="title text-center" style="margin: auto;display: contents;">
                                    <h2 class="text-center mb-2"><img src="../assets/images/images/arrow.png"  alt="" width="50" height="50"></h2>
                                    <h2 class="text-center theme-second-color mb-1"> {{trans('website.Start A Business',[],session()->get('locale'))}}</h2>
                                    <h3 class="text-center text-secondary w-100 text-center mx-auto">{{trans('website.Sell quality products that people use every day.',[],session()->get('locale'))}}</h3>
                                     <button class="btn background-dark-mint mt-sm-4 btn-md mx-auto text-white fw-bold"
                                                    onclick="location.href = '/start_business';">{{trans('website.Learn More',[],session()->get('locale'))}}
                                            </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                <!-- Banner Section End -->
