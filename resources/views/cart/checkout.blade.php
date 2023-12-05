@extends('layouts.app')
@section('style')
    <style>
        .checkout-box ,.summery-box-2{
            background: #FFFFFF;
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.05);
            border-radius: 15px;
        }
        .productImage {
            border: 0.702726px solid #E9E9E9;
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.05);

            height: 90px;
            border-radius: 16px;
        }
    </style>
@endsection
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <!-- Checkout section Start -->
    <section class="checkout-section-2 section-b-space">
        <div class="container-fluid-lg">
            <div class="row g-sm-4 g-3">
                <div class="col-lg-7">
                    <div class="left-sidebar-checkout">
                        <h2 class="theme-second-color mb-2 p-2 pl-3" >{{trans('website.Checkout',[],session()->get('locale'))}}</h2>
                        <div class="checkout-detail-box">
                            <ul>
                                <li>
                                    <div class="checkout-icon">
                                        <lord-icon target=".nav-item" src="https://cdn.lordicon.com/ggihhudh.json"
                                                   trigger="loop-on-hover"
                                                   colors="primary:#121331,secondary:#646e78,tertiary:#0baf9a"
                                                   class="lord-icon">
                                        </lord-icon>
                                    </div>
                                    <div class="checkout-box bg-white">
                                        <div class="checkout-title">
                                            <h4>

                                                <img src="../assets/svg/delivery.svg" class="blur-up lazyload" alt="">

                                              {{trans('website.Delivery Address',[],session()->get('locale'))}}  </h4>
                                        </div>

                                        <div class="checkout-detail">
                                            <div class="row g-4" id="addContiner">


                                                @if($addresses && count($addresses)>0)
                                                    <input class="form-check-input" type="hidden" value="1" id="addressesExist">
                                                    @foreach($addresses as $address)
                                                        <div class="col-xxl-6 col-lg-12 col-md-6">
                                                            <div class="delivery-address-box">
                                                                <div>
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" type="radio" value="{{$address->id}}" name="address_id" checked>
                                                                    </div>

                                                                    <div class="label">
                                                                        <label class="cursor-pointer" onclick="editAddress('{{$address->id}}','{{$address->country_id}}','{{$address->city_id}}','{{$address->area_id}}','{{$address->landmark}}','{{$address->floor_number}}','{{$address->apartment_number}}','{{$address->address}}','{{$address->receiver_name}}','{{$address->receiver_phone}}')">Edit
                                                                            <i class="fa-solid fa-pen"></i></label>
                                                                    </div>
                                                                    <ul class="delivery-address-detail">
                                                                        <li>
                                                                            <h4 class="fw-500">{{$address->country_name}}
                                                                                - {{$address->city_name}}</h4>
                                                                        </li>
                                                                        <li>
                                                                            <h6 class="text-content"><span
                                                                                    class="text-title">Area :</span>
                                                                                {{$address->area_name}}</h6>
                                                                        </li>

                                                                        <li>
                                                                            <p class="text-content"><span
                                                                                    class="text-title">Address
                                                                                                            : </span>{{$address->address}}
                                                                            </p>
                                                                        </li>
                                                                        <li>
                                                                            <p class="text-content"><span
                                                                                    class="text-title">Receiver
                                                                                                            : </span>{{$address->receiver_name}}
                                                                                , {{$address->receiver_phone}}
                                                                            </p>
                                                                        </li>


                                                                        <li>
                                                                            <h6 class="text-content mb-0"><span
                                                                                    class="text-title">Landmark
                                                                                                            :</span>
                                                                                {{$address->landmark}}</h6>
                                                                        </li>
                                                                        <li>
                                                                            <h6 class="text-content mb-0"><span
                                                                                    class="text-title">Floor Number
                                                                                                            :</span>
                                                                                {{$address->floor_number}}</h6>
                                                                        </li>
                                                                        <li>
                                                                            <h6 class="text-content mb-0"><span
                                                                                    class="text-title">Apartment Number
                                                                                                            :</span>
                                                                                {{$address->apartment_number}}
                                                                            </h6>
                                                                        </li>
                                                                    </ul>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    @endforeach
                                                @else
                                                    <input class="form-check-input" type="hidden" value="0" id="addressesExist">
                                                @endif

                                            </div>
                                            <div class="row">
                                                <div class="col-xxl-3">
                                                    <button class="btn theme-bg-color text-white btn-md w-100 mt-4 fw-bold viewProductModel" data-bs-target="#addAddress" data-bs-toggle="modal">
                                                        <i class="fa-solid fa-circle-plus fa-1x mr-2"></i> &nbsp;
                                                        {{trans('website.Add Address',[],session()->get('locale'))}}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>

                                {{--                                                                <li>--}}
                                {{--                                                                    <div class="checkout-icon">--}}
                                {{--                                                                        <lord-icon target=".nav-item" src="https://cdn.lordicon.com/oaflahpk.json"--}}
                                {{--                                                                            trigger="loop-on-hover" colors="primary:#0baf9a" class="lord-icon">--}}
                                {{--                                                                        </lord-icon>--}}
                                {{--                                                                    </div>--}}
                                {{--                                                                    <div class="checkout-box">--}}
                                {{--                                                                        <div class="checkout-title">--}}
                                {{--                                                                            <h4>Delivery Option</h4>--}}
                                {{--                                                                        </div>--}}

                                {{--                                                                        <div class="checkout-detail">--}}
                                {{--                                                                            <div class="row g-4">--}}
                                {{--                                                                                <div class="col-xxl-6">--}}
                                {{--                                                                                    <div class="delivery-option">--}}
                                {{--                                                                                        <div class="delivery-category">--}}
                                {{--                                                                                            <div class="shipment-detail">--}}
                                {{--                                                                                                <div--}}
                                {{--                                                                                                    class="form-check custom-form-check hide-check-box">--}}
                                {{--                                                                                                    <input class="form-check-input" type="radio"--}}
                                {{--                                                                                                        name="standard" id="standard" checked>--}}
                                {{--                                                                                                    <label class="form-check-label"--}}
                                {{--                                                                                                        for="standard">Standard--}}
                                {{--                                                                                                        Delivery Option</label>--}}
                                {{--                                                                                                </div>--}}
                                {{--                                                                                            </div>--}}
                                {{--                                                                                        </div>--}}
                                {{--                                                                                    </div>--}}
                                {{--                                                                                </div>--}}

                                {{--                                                                                <div class="col-xxl-6">--}}
                                {{--                                                                                    <div class="delivery-option">--}}
                                {{--                                                                                        <div class="delivery-category">--}}
                                {{--                                                                                            <div class="shipment-detail">--}}
                                {{--                                                                                                <div--}}
                                {{--                                                                                                    class="form-check mb-0 custom-form-check show-box-checked">--}}
                                {{--                                                                                                    <input class="form-check-input" type="radio"--}}
                                {{--                                                                                                        name="standard" id="future">--}}
                                {{--                                                                                                    <label class="form-check-label" for="future">Future--}}
                                {{--                                                                                                        Delivery Option</label>--}}
                                {{--                                                                                                </div>--}}
                                {{--                                                                                            </div>--}}
                                {{--                                                                                        </div>--}}
                                {{--                                                                                    </div>--}}
                                {{--                                                                                </div>--}}

                                {{--                                                                                <div class="col-12 future-box">--}}
                                {{--                                                                                    <div class="future-option">--}}
                                {{--                                                                                        <div class="row g-md-0 gy-4">--}}
                                {{--                                                                                            <div class="col-md-6">--}}
                                {{--                                                                                                <div class="delivery-items">--}}
                                {{--                                                                                                    <div>--}}
                                {{--                                                                                                        <h5 class="items text-content"><span>3--}}
                                {{--                                                                                                                Items</span>@--}}
                                {{--                                                                                                            $693.48</h5>--}}
                                {{--                                                                                                        <h5 class="charge text-content">Delivery Charge--}}
                                {{--                                                                                                            $34.67--}}
                                {{--                                                                                                            <button type="button" class="btn p-0"--}}
                                {{--                                                                                                                data-bs-toggle="tooltip"--}}
                                {{--                                                                                                                data-bs-placement="top"--}}
                                {{--                                                                                                                title="Extra Charge">--}}
                                {{--                                                                                                                <i--}}
                                {{--                                                                                                                    class="fa-solid fa-circle-exclamation"></i>--}}
                                {{--                                                                                                            </button>--}}
                                {{--                                                                                                        </h5>--}}
                                {{--                                                                                                    </div>--}}
                                {{--                                                                                                </div>--}}
                                {{--                                                                                            </div>--}}

                                {{--                                                                                            <div class="col-md-6">--}}
                                {{--                                                                                                <form--}}
                                {{--                                                                                                    class="form-floating theme-form-floating date-box">--}}
                                {{--                                                                                                    <input type="date" class="form-control">--}}
                                {{--                                                                                                    <label>Select Date</label>--}}
                                {{--                                                                                                </form>--}}
                                {{--                                                                                            </div>--}}
                                {{--                                                                                        </div>--}}
                                {{--                                                                                    </div>--}}
                                {{--                                                                                </div>--}}
                                {{--                                                                            </div>--}}
                                {{--                                                                        </div>--}}
                                {{--                                                                    </div>--}}
                                {{--                                                                </li>--}}

                                <li>
                                    <div class="checkout-icon">
                                        <lord-icon target=".nav-item" src="https://cdn.lordicon.com/qmcsqnle.json"
                                                   trigger="loop-on-hover" colors="primary:#0baf9a,secondary:#0baf9a"
                                                   class="lord-icon">
                                        </lord-icon>
                                    </div>
                                    <div class="checkout-box  bg-white">
                                        <div class="checkout-title">
                                            <h4><i data-feather="credit-card"></i>  {{trans('website.Payment Option',[],session()->get('locale'))}}</h4>
                                        </div>

                                        <div class="checkout-detail">
                                            <div class="accordion accordion-flush custom-accordion"
                                                 id="accordionFlushExample">
                                                <div class="accordion-item">
                                                    <div class="accordion-header" id="flush-headingFour">
                                                        <div class="accordion-button collapsed"
                                                             data-bs-toggle="collapse"
                                                             data-bs-target="#flush-collapseFour">
                                                            <div class="custom-form-check form-check mb-0">
                                                                <label class="form-check-label" for="only_fawry"><input
                                                                        class="form-check-input mt-0" type="radio"
                                                                        name="flexRadioDefault" id="only_fawry" value="only_fawry">
                                                                    {{trans('website.Pay OnLine',[],session()->get('locale'))}}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="flush-collapseFour"
                                                         class="accordion-collapse collapse"
                                                         data-bs-parent="#accordionFlushExample">
                                                        <div class="accordion-body">
                                                            <p class="cod-review"> {{trans('website.Pay OnLine By Credit Card',[],session()->get('locale'))}}</p>
                                                            <br>
                                                            <div class="payment">
                                                                <img src="../assets/images/payment/1.png" class="blur-up lazyload" alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="accordion-item">
                                                    <div class="accordion-header" id="flush-headingFour">
                                                        <div class="accordion-button collapsed"
                                                             data-bs-toggle="collapse"
                                                             data-bs-target="#flush-collapseFourCash">
                                                            <div class="custom-form-check form-check mb-0">
                                                                <label class="form-check-label" for="cash"><input
                                                                        class="form-check-input mt-0" type="radio"
                                                                        name="flexRadioDefault" id="cash" checked value="cash">

                                                                    {{trans('website.Pay Cash On Delivery',[],session()->get('locale'))}}

                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div id="flush-collapseFourCash"
                                                         class="accordion-collapse collapse show"
                                                         data-bs-parent="#accordionFlushExample">
                                                        <div class="accordion-body">
                                                            <p class="cod-review">{{trans('website.Pay Cash On Delivery',[],session()->get('locale'))}}</p>
                                                            <br>
                                                            <div class="payment">
                                                                <img src="../assets/images/payment/6.png" class="blur-up lazyload " alt="">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="col-lg-5">
                    <div class="right-side-summery-box">
                        <h2 class="theme-second-color mb-2 p-1 pl-3">{{trans('website.Your cart',[],session()->get('locale'))}}</h2>
                        <div class="summery-box-2 bg-white">

                            <ul class="summery-contain" id="cartContainerBody">
                            </ul>

                            <ul class="summery-total">
                                <li>
                                    <h4>{{trans('website.Subtotal',[],session()->get('locale'))}}</h4>
                                    <h4 class="price" id="subtotal">00</h4>
                                </li>


                                <li class="align-items-start">
                                    <h4>{{trans('website.Discount Amount',[],session()->get('locale'))}}</h4>
                                    <h4 class="price" id="discount_amount">0
                                        LE</h4>
                                </li>

                                <li class="align-items-start">
                                    <h4>{{trans('website.After Discount',[],session()->get('locale'))}}</h4>
                                    <h4 class="price" id="totalProductsAfterDiscount">0
                                       {{trans('website.LE',[],session()->get('locale'))}} </h4>
                                    <input type="hidden" value="0" id="save_after_discount">
                                </li>
                                <li class="align-items-start d-none" id="showGift">
                                    <h4>{{trans('website.Gift',[],session()->get('locale'))}}</h4>
                                    <h4 class="price text-end" id="showGiftPrice">00</h4>
                                </li>
                                <li class="align-items-start">
                                    <h4>{{trans('website.Shipping',[],session()->get('locale'))}}</h4>
                                    <h4 class="price text-end" id="shipping">00</h4>
                                </li>
                                <li class="align-items-start text-danger">
                                    <h4>{{trans('website.value will has commission',[],session()->get('locale'))}}</h4>
                                    <h4 class="price text-end" id="value_will_has_commission">00</h4>
                                </li>


                                {{--                                <li class="list-total border-top-0">--}}
                                {{--                                    <h4>Total Product</h4>--}}
                                {{--                                    <h4 class="price theme-color" id="total_cart">$132.58</h4>--}}
                                {{--                                </li>--}}


                                <li class="list-total">
                                    <h4> {{trans('website.Total',[],session()->get('locale'))}}</h4>
                                    <h4 class="price" id="total_order_final">0 LE</h4>
                                </li>
                                <li class="list-total">

                                </li>


                                <li class="list-total border-top-0">
                                    <h4>{{trans('website.VIP member price',[],session()->get('locale'))}} &nbsp; </h4>
                                    <a
                                        @if(Auth::user()&&Auth::user()->stage == '2' && Auth::user()->user_type == 'member')
                                        href="{{url('segment_commission')}}"
                                        @elseif(Auth::user()&&Auth::user()->stage == '1' && Auth::user()->user_type == 'normal_user')
                                        href="{{url('memberProfile')}}"
                                        @else
                                        href="{{url('joinus')}}"
                                        @endif
                                        class="btn theme-bg-color view-button icon text-white fw-bold btn-md">
                                        <span><i class="fa fa-hand-o-right" aria-hidden="true"></i>&nbsp; </span>
                                        <span id="total_price_after_discount"> </span> &nbsp; {{trans('website.LE',[],session()->get('locale'))}} </a>
                                </li>


                                <li class="list-total border-top-0">
                                    <button class="btn background-dark-mint text-white btn-md w-100 mt-2 fw-bold" id="saveOrderButton" onclick="saveOrderButton()">
                                       {{trans('website.Save Order',[],session()->get('locale'))}}
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <div class="checkout-offer d-none" id="checkout-offer">
                            <div class="summery-box-2 p-0">
                                <div class="summery-header">
                                    <div class="offer-title m-0">
                                        <div class="offer-icon">
                                            <img src="../assets/images/inner-page/offer.svg" class="img-fluid" alt="">
                                        </div>
                                        <div class="offer-name">
                                            <h6>Available Program Gift</h6>
                                        </div>
                                    </div>
                                </div>
                                <ul class="summery-contain">
                                    <li>
                                        <img id="giftimage" src=""
                                             class="img-fluid blur-up lazyloaded " alt="" width="100" height="100" >
                                        <h4><span id="giftName"></span><span>X 1</span></h4>
                                        <h4 class="price theme-color" id="giftDiscountRate"></h4>
                                    </li>
                                    <li>
                                        <h4 class="price text-danger" id="giftPrice"></h4>
                                        <br>
                                        <h4 class="price theme-color" id="giftPriceDiscountRate"></h4>
                                        <br>
                                        <h4 class="price theme-color" id="giftPriceAfter"></h4>
                                    </li>

                                </ul>
                                <li class="list-total border-top-0">
                                    <button class="btn theme-bg-color text-white btn-md w-100 mt-2 fw-bold" onclick="takeGiftButton()">
                                        Redeem Gift
                                    </button>
                                </li>
                            </div>
                        </div>


                    </div>

                </div>

            </div>
        </div>
    </section>
    <!-- Checkout section End -->




    <!-- Quick Add Address Modal Box Start -->
    <div class="modal fade theme-modal view-modal" id="addAddress" tabindex="-1" aria-labelledby="exampleModalLabel"
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
                                <h4 class="title-name mb-4" id="AddTitleAddress">{{trans('website.Add Address',[],session()->get('locale'))}}</h4>
                                <div class="row">
                                    <div class="col-12 mb-2">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-floating theme-form-floating">
                                                <input type="text" class="form-control" id="address" name="address" required autofocus placeholder="Address">
                                                <label for="address">{{trans('website.Address',[],session()->get('locale'))}}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-floating theme-form-floating">
                                                <input type="text" class="form-control" id="receiver_name" name="receiver_name" required autofocus placeholder="Receiver Name">
                                                <label for="receiver_name">{{trans('website.Receiver Name',[],session()->get('locale'))}}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-floating theme-form-floating">
                                                <input type="text" class="form-control" id="receiver_phone" name="receiver_phone" autofocus placeholder="Receiver Phone" minlength="11" maxlength="11" >
                                                <label for="receiver_phone">{{trans('website.Receiver Phone',[],session()->get('locale'))}}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 mb-1">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-floating theme-form-floating">
                                                <select name="country_id" id="country_id" class="form-control">
                                                    @foreach($countries as $country)
                                                        <option value="{{$country->id}}"> {{$country->name_en}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 mb-1">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-floating theme-form-floating ">
                                                <select name="city_id" id="city_id" class="form-control">
                                                    <option value="">{{trans('website.Choose City',[],session()->get('locale'))}}</option>
                                                    @foreach($cities as $city)
                                                        <option value="{{$city->id}}"> {{$city->name_en}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4 mb-1">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-floating theme-form-floating ">
                                                <select name="area_id" id="area_id" class="form-control">
                                                    <option value="">{{trans('website.Choose Area',[],session()->get('locale'))}}</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12 mb-2">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-floating theme-form-floating">
                                                <input type="text" class="form-control" id="landmark" name="landmark" required autofocus placeholder="Landmark">
                                                <label for="landmark">{{trans('website.Landmark',[],session()->get('locale'))}}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-floating theme-form-floating">
                                                <input type="number" min="0" class="form-control" id="floor_number" name="floor_number" required autofocus placeholder="Floor Number">
                                                <label for="floor_number">{{trans('website.Floor Number',[],session()->get('locale'))}}</label>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-6 mb-2">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-floating theme-form-floating">
                                                <input type="number" min="0" class="form-control" id="apartment_number" name="apartment_number" required autofocus placeholder="Apartment Number">
                                                <label for="apartment_number">{{trans('website.Apartment Number',[],session()->get('locale'))}}</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-6 mb-2" id="completeData" style="display: none">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-floating theme-form-floating">
                                                <div class="alert alert-danger" role="alert">
                                                 {{trans('website.Complete Data',[],session()->get('locale'))}}
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <button id="addAddressButton" onclick="addAddressButton()"
                                    class="btn background-dark-mint view-button icon text-white fw-bold btn-md mt-1">
                            {{trans('website.Add',[],session()->get('locale'))}}
                            </button>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
    <!-- Quick Add Address Modal Box End -->



@endsection

@section('java_script')
    <script>

        var allProductsArray           = [];
        var userGift                   = [];
        var userIdGift                 = 0;
        var userRedeemGift             = false;
        var subtotal                   = 0;
        var shipping                   = 0;
        var showshipping               = 0;
        var total_cart                 = 0;
        var total_price_after_discount = 0;
        var editAddressID              = 0;
        var adddreeess                 = 0;
        var paymentMethod              = 'cash';
        $(document).ready(function () {

            $('#cartContainerBody').html('');
            var userCart  = localStorage.getItem('user_cart');
            let arrLength = JSON.parse(userCart);
            if (!userCart || userCart == null || userCart == '' || userCart.length == 0 || arrLength.length == 0) {
                $('#cartContainerBody').html('<h4 class="text-center">No Data</h4>');
                $('#subtotal').html(0);
                $('#shipping').html(0);
                $('#total_cart').html(0);
                $('#total_price_after_discount').html(0);
            }
            else {

                allProductsArray = JSON.parse(userCart);
                const cartLength = allProductsArray.length;

                for (let iiii = 0; iiii < cartLength; iiii++) {
                    var proObjff               = allProductsArray[iiii];
                    proObjff['total']          = (Number(proObjff['price']) * parseInt(proObjff['quantity']));
                    subtotal                   = (Number(subtotal) + Number(proObjff['total']));
                    total_cart                 = (Number(total_cart) + Number(proObjff['total']));
                    total_price_after_discount = (Number(total_price_after_discount) + Number(proObjff['price_after_discount']) * parseInt(proObjff['quantity']));


                    $("#cartContainerBody").append(
                        ' <li><div class="row justify-content-around w-100"><div class="col-md-3">' +
                        ' <img src="' + proObjff['image'] + '" class="productImage" width="100" height="100" alt="">' +
                        '</div><div class="col-md-6 pt-1">'+
                        '<h4 class="lh-base"> ' + proObjff['name'] + ' <span> X ' + proObjff['quantity'] + '</span></h4>' +
                        '<del> '+ (proObjff['price']*proObjff['quantity'])+' LE</del>'+
                        '<h3 class="price fw-bold lh-base">' + proObjff['total'] + ' LE ' +
                        ' </h3> ' +
                        '</div>'+
                        '<div class="col-md-3 pt-1">'+
                        '<h4 class="lh-base fw-bold"> ' + '50' + ' <span> % </span></h4>' +
                        '</div>'+
                        '</div> '+
                        '</li>'+
                        ' \n'
                    );
                }

                if (subtotal > 0 && subtotal < 250) {
                    shipping                   = 50;
                    showshipping               = '50 LE';
                    total_cart                 = subtotal + shipping;
                    total_price_after_discount = total_price_after_discount + shipping;
                }
                else if (subtotal >= 250) {
                    showshipping = '<del>50 LE</del>';
                }

                $('#subtotal').html(subtotal + ' LE');
                $('#shipping').html(showshipping);
                $('#total_cart').html(total_cart + ' LE');
                $('#total_price_after_discount').html(total_price_after_discount);
            }
            var base_url = window.location.origin;
            // $("select").select2();
            if (allProductsArray.length > 0) {

                var object = {
                    "subtotal": subtotal,
                    "shipping": shipping,
                    "total_cart": total_cart,
                    "items": allProductsArray
                }
                $.ajax({
                    url: "{{url('/checkWebOrder')}}",
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
                            console.log('drow ProductsBody',response.data);
                            allProductsArray=response.data.products
                            drowProductsBody();

                            $('#total_order_final').html(response.data.total_order_final + ' LE');
                             // $('#total_price_after_discount').html(response.data.total_order_final);
                            $('#value_will_has_commission').html(response.data.value_will_has_commission + ' LE');
                            $('#save_after_discount').val(response.data.totalProductsAfterDiscount);
                            $('#discount_amount').html(response.data.discount_amount + ' LE');
                            var f_shiping = response.data.shipping == 0 ? '<del>50 LE</del>' : '50 LE';
                            $('#shipping').html(f_shiping);
                            $('#totalProductsAfterDiscount').html(response.data.totalProductsAfterDiscount + ' LE');
                            if (response.gift && response.gift.id > 0) {
                                $("#checkout-offer").removeClass('d-none');
                                $("#giftimage").attr('src', response.gift.image);
                                $("#giftName").html(response.gift.name_en);
                                $("#giftPrice").html('<del>' + response.gift.total_old_price + ' LE</del>');
                                let gift_discount=Math.round(((response.gift.total_price - response.gift.total_old_price)/response.gift.total_old_price)*100) * -1;
                                $("#giftPriceDiscountRate").html( '( '+ gift_discount + ' off )');
                                $("#giftPriceAfter").html('<h3>' +response.gift.total_price + ' LE </h3>');
                                var giftPro = {
                                    'id': response.gift.id,
                                    'name_en': response.gift.name_en,
                                    'image': response.gift.image,
                                    'price': response.gift.total_old_price,
                                    'price_after_discount': response.gift.total_price,
                                    'discount_rate': gift_discount,
                                    'flag': '5',
                                    'new_discount': gift_discount,
                                    'total': response.gift.total_price,
                                    'quantity': 1,

                                }
                                userGift.push(giftPro)
                            }
                            else {
                                $("#checkout-offer").remove();
                            }
                        }
                        else if (response.data && response.status == 201) {
                            console.log(response.data)
                            alert(response.message);
                            setTimeout(goToCart(), 1000);
                        }
                        else {
                            console.log(response)
                            alert('error')
                        }
                    },
                    error: function (error) {
                        console.log(error)
                        alert('error');
                    }
                });
            }


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
                var city_id = $("#city_id").val();
                getCities(city_id);
            });


        });

        function getCities(cityID, area_id = null) {
            let formData = new FormData();
            formData.append('city_id', cityID);
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
                                if (area_id && area_id == proObj['id']) {
                                    var oop = '<option value="' + proObj['id'] + '" selected>' + proObj['region_en'] + '</option>'
                                }
                                else {
                                    var oop = '<option value="' + proObj['id'] + '">' + proObj['region_en'] + '</option>'
                                }

                                $("#area_id").append(
                                    oop
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
        }

        function saveOrderButton() {
            // $('#saveOrderButton').prop('disabled', true);
            if (allProductsArray.length > 0) {

                var addExist = $('#addressesExist').val();
                if (addExist == 1) {
                    var radios = document.getElementsByName('address_id');

                    for (var i = 0, length = radios.length; i < length; i++) {
                        if (radios[i].checked) {
                            // do whatever you want with the checked radio
                            adddreeess = radios[i].value
                            // only one radio can be logically checked, don't check the rest
                            break;
                        }
                    }
                    var flexRadioDefault = document.getElementsByName('flexRadioDefault');

                    for (var iii = 0; iii < flexRadioDefault.length; iii++) {
                        if (flexRadioDefault[iii].checked) {
                            // do whatever you want with the checked radio
                            paymentMethod = flexRadioDefault[iii].value
                            // only one radio can be logically checked, don't check the rest
                            break;
                        }
                    }

                    var object = {
                        "address_id": adddreeess,
                        "wallet_status": paymentMethod,
                        "subtotal": subtotal,
                        "shipping": shipping,
                        "total_cart": total_cart,
                        "items": allProductsArray,
                    }
                    $.ajax({
                        url: "{{url('/saveWebOrder')}}",
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
                                console.log('response.data', response.data)
                                $('#cartContainerBody').html('<h4 class="text-center">No Data</h4>');
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

                                $('#herderUpToTotalCount').html(0)
                                swal({
                                    text: "Add Order Successful",
                                    title: "Successful",
                                    timer: 1000,
                                    icon: "success",
                                    buttons: false,
                                });
                                $('#saveOrderButton').prop('disabled', true);
                                setTimeout(goToPay(response.data.order_id), 2500);
                            }
                            else {
                                console.log(response)
                                alert('error')
                            }
                        },
                        error: function (response) {
                            console.log(response)
                            alert('error');
                        }
                    });

                }
                else {
                    alert('add address');
                    $('#saveOrderButton').prop('disabled', false);
                }
            }
            else{
                 swal({
                                    text: "Cart is empty",
                                    title: "Error",
                                    timer: 1500,
                                    icon: "error",
                                    buttons: false,
                                });
                 $('#saveOrderButton').prop('disabled', false);
            }
        }

        function takeGiftButton() {
            if (userGift && userGift.length > 0) {
                var proObjff               = userGift[0];
                userRedeemGift             = true;

                proObjff['userRedeemGift'] = true;
                allProductsArray.push(proObjff)
                let Diss=$("#giftDiscountRate").html();
                $("#cartContainerBody").append(
                     ' <li><div class="row justify-content-around w-100"><div class="col-md-3">' +
                        ' <img src="' + proObjff['image'] + '" class="productImage" width="100" height="100" alt="">' +
                        '</div><div class="col-md-6 pt-1">'+
                        '<h4 class="lh-base"> ' + proObjff['name_en'] + ' <span> X ' + proObjff['quantity'] + '</span></h4>' +
                        '<del> '+ (proObjff['price']*proObjff['quantity'])+' LE</del>'+
                        '<h3 class="price fw-bold lh-base">' +Math.round((proObjff['total'] *100)/100) + ' LE ' +
                        ' </h3> ' +
                        '</div>'+
                        '<div class="col-md-3 pt-1">'+
                        '<h3 class="lh-base fw-bold"> ' + proObjff['new_discount'] + ' <span> % </span></h3>' +
                        '</div>'+
                        '</div> '+
                        '</li>'+
                        ' \n'

                );
            }
            $("#showGift").removeClass('d-none');
            $("#showGiftPrice").html(proObjff['total'] + ' LE</del>');
            var s_a_d   = $('#save_after_discount').val();
            var n_t_o_f = parseFloat(s_a_d) + parseFloat(proObjff['total']);
            if (n_t_o_f >= 250) {
                var showshipping = '<del>50 LE</del>';
                $('#shipping').html(showshipping);
            }
            else {
                n_t_o_f = n_t_o_f + 50;
            }

            $('#total_order_final').html(n_t_o_f + ' LE');
            $("#checkout-offer").remove();
        }

        function addAddressButton() {
            $('#addAddressButton').prop('disabled', true);
            var address          = $('#address').val();
            var landmark         = $('#landmark').val();
            var floor_number     = $('#floor_number').val();
            var apartment_number = $('#apartment_number').val();
            var country_id       = $("#country_id").val();
            var city_id          = $("#city_id").val();
            var area_id          = $("#area_id").val();
            var receiver_name    = $("#receiver_name").val();
            var receiver_phone   = $("#receiver_phone").val();
            if (address && address != '' && landmark && landmark != '' && floor_number > 0 && apartment_number > 0 && country_id > 0 && city_id > 0 && area_id > 0) {

                var object = {
                    "address_id": editAddressID,
                    "address": address,
                    "landmark": landmark,
                    "floor_number": floor_number,
                    "apartment_number": apartment_number,
                    "city_id": city_id,
                    "area_id": area_id,
                    "country_id": country_id,
                    "receiver_name": receiver_name,
                    "receiver_phone": receiver_phone
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
                            if (editAddressID > 0) {
                                location.reload();
                            }
                            else {
                                $("#addContiner").append(
                                    '<div class="col-xxl-6 col-lg-12 col-md-6">' +
                                    '<div class="delivery-address-box">' + '<div>' + '<div class="form-check">' +
                                    '<input class="form-check-input" type="radio" value="' + proObjff['id'] + '" name="address_id" checked>' +
                                    '  </div> <div class="label"><label class="cursor-pointer"  onclick="editAddress(' + proObjff['id'] + ',' + proObjff['country_id'] + ',' + proObjff['city_id'] + ',' + proObjff['area_id'] + ',' + proObjff['landmark'] + ',' + proObjff['floor_number'] + ',' + proObjff['apartment_number'] + ',' + proObjff['address'] + ',' + proObjff['receiver_name'] + ',' + proObjff['receiver_phone'] + ')">Edit <i class="fa-solid fa-pen"></i></label></div>' +
                                    '<ul class="delivery-address-detail"> <li> <h4 class="fw-500">' + proObjff['country_name'] + ' - ' + proObjff['city_name'] + ' </h4> </li>' +
                                    '<li>  <span class="text-content"><span class="text-title">Area :</span>' + proObjff['area_name'] + '</span></h6></li>' +
                                    ' <li> <p class="text-content"><span class="text-title">Address: </span>' + proObjff['address'] + '</p> </li>' +
                                    ' <li> <p class="text-content"><span class="text-title">Receiver: </span>' + proObjff['receiver_name'] + ' , ' + proObjff['receiver_phone'] + '</p> </li>' +
                                    ' <li> <p class="text-content"><span class="text-title">Landmark: </span>' + proObjff['landmark'] + '</p> </li>' +
                                    ' <li> <p class="text-content"><span class="text-title">Floor Number: </span>' + proObjff['floor_number'] + '</p> </li>' +
                                    ' <li> <p class="text-content"><span class="text-title">Apartment Number: </span>' + proObjff['apartment_number'] + '</p> </li>' +
                                    '</ul> </div> </div> </div>' +
                                    ' \n'
                                );
                            }

                            swal({
                                text: "Address Added Successful",
                                title: "Successful",
                                timer: 1000,
                                icon: "success",
                                buttons: false,
                            });
                            setTimeout(function () {
                                hideModal();
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
                         $('#addAddressButton').prop('disabled', false);
                    }
                });
            }
            else {
                $('#completeData').show();
                 $('#addAddressButton').prop('disabled', false);
            }
        }

        function editAddress(address_id, country_id, city_id, area_id, landmark, floor_number, apartment_number, address, receiver_name, receiver_phone) {
            $('#addAddress').modal('show');
            editAddressID = address_id;
            $('#AddTitleAddress').html('Edit Address');
            $('#address').val(address);
            $('#landmark').val(landmark);
            $('#floor_number').val(floor_number);
            $('#apartment_number').val(apartment_number);
            $('#receiver_name').val(receiver_name);
            $('#receiver_phone').val(receiver_phone);
            $("#country_id").val(country_id);
            $("#city_id").val(city_id);
            if (city_id > 0) {
                getCities(city_id, area_id);
            }
        }

        function goToPay(Order_id) {
            if (Order_id > 0) {
                window.location = "{{url('/orderSuccess')}}" + '/' + Order_id;
            }
        }

          function drowProductsBody() {
            $('#cartContainerBody').html('');

             const cartLength = allProductsArray.length;

                for (let iiii = 0; iiii < cartLength; iiii++) {
                    var proObjff               = allProductsArray[iiii];
                    proObjff['total']          = (Number(proObjff['price_after_discount']) * parseInt(proObjff['quantity']));
                    proObjff['new_discount']=  (((Number(proObjff['price']) - (Number(proObjff['price_after_discount']))) / (Number(proObjff['price'])))) * 100;
                    proObjff['new_discount']=Math.round((proObjff['new_discount'] *100)/100)


                    $("#cartContainerBody").append(
                        ' <li><div class="row justify-content-around w-100"><div class="col-md-3">' +
                        ' <img src="' + proObjff['image'] + '" class="productImage" width="100" height="100" alt="">' +
                        '</div><div class="col-md-6 pt-1">'+
                        '<h4 class="lh-base"> ' + proObjff['name_en'] + ' <span> X ' + proObjff['quantity'] + '</span></h4>' +
                        '<del> '+ (proObjff['price']*proObjff['quantity'])+' LE</del>'+
                        '<h3 class="price fw-bold lh-base">' +Math.round((proObjff['total'] *100)/100) + ' LE ' +
                        ' </h3> ' +
                        '</div>'+
                        '<div class="col-md-3 pt-1">'+
                        '<h3 class="lh-base fw-bold"> ' + proObjff['new_discount'] + ' <span> % </span></h3>' +
                        '</div>'+
                        '</div> '+
                        '</li>'+
                        ' \n'
                    );
                }


        }


        function goToCart() {
            window.location = "{{url('/getCart')}}"
        }

        function hideModal() {
            $('#addAddress').modal('hide');
        }


    </script>
@endsection
