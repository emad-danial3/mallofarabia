<!-- Quick View Modal Box Start -->
<div class="modal fade theme-modal view-modal" id="welcome_program" tabindex="-1" aria-labelledby="exampleModalLabel"
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

                    <div class="col-lg-12 p-4">

                        <div class="slider-image pb-1 welcome-progran-gift-ima">
                            <img src="../assets/images/gift0.png" class="img-fluid blur-up lazyload"
                                 alt="">
                        </div>

                        <div class="right-sidebar-modal">
                            <h6 class="title-name text-center text-white" id="productName">
                                @if(session()->get('locale')=='ar')
                                     انضم إلى برنامجنا الترحيبي لمدة 3 أشهر

                                @else
                                    Join our 3 Months program
                                @endif
                            </h6>
                            <ol class="list-group list-group-numbered">
                                <li class="list-group-item">
                                     @if(session()->get('locale')=='ar')
                                     البرنامج لمدة 3 أشهر C1 و C2 و C3
                                         @else
                                         The program is for 3 months C1, C2 & C3

                                @endif
                                </li>
                                <li class="list-group-item">
                                     @if(session()->get('locale')=='ar')
                                          الحد الأدنى للطلب 250 جنيه

                                @else
                                  Minimum order 250 LE
                                @endif
                                </li>
                                <li class="list-group-item">
                                     @if(session()->get('locale')=='ar')
                                            يتم دفع رسوم الهدية (49 جنيه) (70٪ إلى 80٪) خصم.
                                         @else
                                          A fee is paid for the gift (49 LE) (70% to 80%) Discount.

                                @endif
                                </li>
                                <li class="list-group-item">
                                     @if(session()->get('locale')=='ar')
                                          الهدية تستحق فور اكتمال الطلب بـ 250 جنيه خلال
                                    الشهر

                                         @else
                                 The gift is redeemed immediatel when complete 250LE during
                                    the month
                                @endif
                                </li>
                            </ol>


                            <div>


                                  @if(Auth::user()&&Auth::user()->stage == '2' && Auth::user()->user_type == 'member')

                                        @elseif(Auth::user()&&Auth::user()->stage == '1' && Auth::user()->user_type == 'normal_user')
                                    <h1>Become A Member</h1>
                                        @else
                                        <a href="{{url('beforeregister')}}" class="btn background-dark-mint view-button icon text-white fw-bold btn-md w-50 mx-auto mt-3">
                                    Join now</a>
                                        @endif



                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
<!-- Quick View Modal Box End -->
