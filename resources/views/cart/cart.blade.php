@extends('layouts.app')
@section('style')
    <style>
        .productImage {
            border: 0.702726px solid #E9E9E9;
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.05);

            height: 90px;
            border-radius: 16px;
        }

        .main-card {
            background: #FFFFFF;
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.05);
            border-radius: 15px;
        }

       .summery-box{
            background: #FFFFFF;
            box-shadow: 0px 4px 4px rgba(0, 0, 0, 0.05);
            border-radius: 15px;
        }
    </style>
@endsection
@section('content')

    <!-- Banner Section Start -->
    <section class="banner-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="banner-contain-3 section-b-space section-t-space hover-effect p-0">
                        {{--                        <img src="../assets/images/veg-3/banner/3.png" class="img-fluid bg-img" alt="">--}}
                        <div class="banner-detail theme-second-color position-relative  p-0">
                            <div>
                                <h3 class="my-3 theme-second-color">{{trans('website.Your cart',[],session()->get('locale'))}}</h3>
                                <h4 class="text-content fw-300  theme-second-color text-decoration-underline cursor-pointer" onclick="location.href = '{{url('/products')}}'">
                                 {{trans('website.Not ready to checkout? Continue Shopping',[],session()->get('locale'))}}
                                 </h4>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Section End -->




    <!-- Cart Section Start -->
    <section class="cart-section section-b-space">
        <div class="container-fluid-lg">
            <div class="row g-sm-5 g-3">
                <div class="col-xxl-7">
                    <div class="cart-table bg-white">
                        <div class="table-responsive-xl pb-2" id="cartContainerBody">

                        </div>
                    </div>
                </div>

                <div class="col-xxl-5">
                    <div class="summery-box p-sticky">
                        <div class="summery-header">
                            <h3 class="theme-second-color">{{trans('website.Order Summary',[],session()->get('locale'))}}</h3>
                        </div>


                        <div class="summery-contain">
                            {{--                            <div class="coupon-cart">--}}
                            {{--                                <h6 class="text-content mb-2">Coupon Apply</h6>--}}
                            {{--                                <div class="mb-3 coupon-box input-group">--}}
                            {{--                                    <input type="email" class="form-control" id="exampleFormControlInput1"--}}
                            {{--                                        placeholder="Enter Coupon Code Here...">--}}
                            {{--                                    <button class="btn-apply">Apply</button>--}}
                            {{--                                </div>--}}
                            {{--                            </div>--}}
                            <ul>
                                <li>
                                    <h4>{{trans('website.Subtotal',[],session()->get('locale'))}}</h4>
                                    <h4 class="price" id="subtotal">00</h4>
                                </li>

                                {{--                                <li>--}}
                                {{--                                    <h4>Coupon Discount</h4>--}}
                                {{--                                    <h4 class="price">(-) 0.00</h4>--}}
                                {{--                                </li>--}}

                                <li class="align-items-start">
                                    <h4>{{trans('website.Shipping',[],session()->get('locale'))}}</h4>
                                    <h4 class="price text-end" id="shipping">00</h4>
                                </li>
                            </ul>
                        </div>

                        <ul class="summery-total">
                            <li class="list-total border-top-0">
                                <h4>{{trans('website.Total',[],session()->get('locale'))}}</h4>
                                <h4 class="price theme-color" id="total_cart">00</h4>
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
                                    <span id="total_price_after_discount"> </span> {{trans('website.LE',[],session()->get('locale'))}} </a>
                            </li>
                        </ul>

                        <div class="button-group cart-button">
                            <ul>
                                @if(Auth::user())
                                    <li>
                                        <button onclick="location.href = '{{url('/getCheckout')}}';"
                                                class="btn background-dark-mint proceed-btn fw-bold text-white">
                                           {{trans('website.Checkout',[],session()->get('locale'))}}
                                        </button>
                                    </li>
                                @else
                                    <li>
                                        <button onclick="location.href = '{{url('/beforeregister')}}';"
                                                class="btn  background-dark-mint proceed-btn fw-bold text-white">
                                             {{trans('website.Checkout',[],session()->get('locale'))}}
                                        </button>
                                    </li>
                                @endif

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Cart Section End -->



@endsection

@section('java_script')
    <script>

        var allProductsArray           = [];
        var subtotal                   = 0;
        var shipping                   = 0;
        var showshipping               = 0;
        var total_cart                 = 0;
        var total_price_after_discount = 0;

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
                $('#herderCardTotalCount').html(0)
                $('#herderUpToTotalCount').html(0);
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
                        '<div id="productparent' + proObjff['id'] + '" class="card mb-3 w-100 border-0 main-card"><div class="row g-0"><div class="col-md-3"><div class="d-flex align-items-center justify-content-center h-100">' +
                        '<img src="' + proObjff['image'] + '" class="img-fluid productImage mx-auto" alt="..."></div></div>' +
                        ' <div class="col-md-9"><div class="card-body">' +
                        ' <a href="/product-details/' + proObjff['id'] + '" >' +
                        '<h4 class="card-title name theme-second-color">' + proObjff['name'] + '</h4></a>' +
                        '<p class="card-text mb-0">Quantity</p>' +
                        '<div class="cart_qty qty-box">' +
                        '<div class="input-group w-50">' +
                        '<button type="button" class="qty-left-minus bg-gray" data-type="minus" data-field="" onclick="decreaseQuantity(' + proObjff['id'] + ')"> <i class="fa fa-minus" aria-hidden="true"></i> </button>' +
                        ' <input class="form-control input-number qty-input" type="number" name="quantity" value="' + proObjff['quantity'] + '" min="1" id="proQuantity' + proObjff['id'] + '">  &nbsp;  ' +
                        ' <button type="button" class="qty-right-plus bg-gray" data-type="plus" data-field="" onclick="increaseQuantity(' + proObjff['id'] + ')"> <i class="fa fa-plus" aria-hidden="true"></i></button>' +
                        '</div></div>' +

                        '<h5 class="card-text">' + proObjff['price'] + '   LE </h5>' +
                        ' <p class="card-text mb-0 theme-second-color"> {{trans('website.VIP member price',[],session()->get('locale'))}}</p>' +
                        '<div class="row"><div class="col-md-8">' + proObjff['price_after_discount'] + ' LE </div><div class="col-md-4">' +
                        '<a href="javascript:void(0)" onclick="removeFromCart(' + proObjff['id'] + ')" class="text-danger text-decoration-underline">{{trans('website.Remove',[],session()->get('locale'))}}</a> </div></div></div></div></div></div>'
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
                $('#total_price_after_discount').html(Math.round((total_price_after_discount*100)/100));
                $('#herderCardTotalCount').html(total_cart + ' LE')
                let upto = (total_cart - (total_cart * .3))
                $('#herderUpToTotalCount').html(upto + ' LE')
            }
        });


        function reCalculateCart() {
            subtotal                   = 0;
            shipping                   = 0;
            showshipping               = 0;
            total_cart                 = 0;
            total_price_after_discount = 0;
            for (let ii = 0; ii < allProductsArray.length; ii++) {
                var proObjff               = allProductsArray[ii];
                proObjff['total']          = (Number(proObjff['price']) * parseInt(proObjff['quantity']));
                subtotal                   = (Number(subtotal) + Number(proObjff['total']));
                total_cart                 = (Number(total_cart) + Number(proObjff['total']));
                total_price_after_discount = (Number(total_price_after_discount) + Number(proObjff['price_after_discount']) * parseInt(proObjff['quantity']));
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
            $('#total_price_after_discount').html(Math.round((total_price_after_discount*100)/100));
        }

        function removeFromCart(produt_id) {
            const indexOfObject = allProductsArray.findIndex(object => {
                return object.id == produt_id;
            });
            allProductsArray.splice(indexOfObject, 1);
            $("#productparent" + produt_id).hide();
            if (allProductsArray.length < 1) {
                $('#cartContainerBody').html('<h4 class="text-center">No Data</h4>');
                $('#subtotal').html(0);
                $('#shipping').html(0);
                $('#total_cart').html(0);
                $('#total_price_after_discount').html(0);
                $('#herderCardTotalCount').html(0)
                $('#herderUpToTotalCount').html(0)
            }
            else {
                reCalculateCart();
            }
            const myJSON = JSON.stringify(allProductsArray);
            localStorage.setItem("user_cart", myJSON);
            const cartLength = allProductsArray.length;
            $('#herderCardCount').html(cartLength)
            $('#herderCardTotalCount').html(total_cart + ' LE')
            let upto = (total_cart - (total_cart * .3))
            $('#herderUpToTotalCount').html(upto + ' LE')
        }


        function increaseQuantity(produt_id) {

            const indexOfObject = allProductsArray.findIndex(object => {
                return object.id == produt_id;
            });

            if ( allProductsArray[indexOfObject]['quantity'] < 6 || !(allProductsArray[indexOfObject]['flag'] ==5)) {
                allProductsArray[indexOfObject]['quantity'] = Number(allProductsArray[indexOfObject]['quantity']) + 1;
                allProductsArray[indexOfObject]['total']    = Number(allProductsArray[indexOfObject]['total']) + Number(allProductsArray[indexOfObject]['price']);

                reCalculateCart();

                $("#proQuantity" + produt_id).val(allProductsArray[indexOfObject]['quantity']);
                $("#proTotal" + produt_id).html(allProductsArray[indexOfObject]['total']);

                const myJSON = JSON.stringify(allProductsArray);
                localStorage.setItem("user_cart", myJSON);
                const cartLength = allProductsArray.length;
                $('#herderCardCount').html(cartLength)
                $('#herderCardTotalCount').html(total_cart + ' LE')
                let upto = (total_cart - (total_cart * .3))
                $('#herderUpToTotalCount').html(upto + ' LE')
            }
        }

        function decreaseQuantity(produt_id) {
            const indexOfObject = allProductsArray.findIndex(object => {
                return object.id == produt_id;
            });

            allProductsArray[indexOfObject]['quantity'] = Number(allProductsArray[indexOfObject]['quantity']) - 1;
            allProductsArray[indexOfObject]['total']    = Number(allProductsArray[indexOfObject]['total']) - Number(allProductsArray[indexOfObject]['price']);

            reCalculateCart();

            $("#proQuantity" + produt_id).val(allProductsArray[indexOfObject]['quantity']);
            $("#proTotal" + produt_id).html(allProductsArray[indexOfObject]['total']);


            if (allProductsArray[indexOfObject]['quantity'] < 1) {
                $("#productparent" + produt_id).remove();
                allProductsArray.splice(indexOfObject, 1);
            }
            if (allProductsArray.length < 1) {
                $('#cartContainerBody').html('<h4 class="text-center">No Data</h4>');
                $('#subtotal').html(0);
                $('#shipping').html(0);
                $('#total_cart').html(0);
                $('#total_price_after_discount').html(0);
                $('#herderCardTotalCount').html(0)
                $('#herderUpToTotalCount').html(0)
            }

            const myJSON = JSON.stringify(allProductsArray);
            localStorage.setItem("user_cart", myJSON);
            const cartLength = allProductsArray.length;
            $('#herderCardCount').html(cartLength)
            $('#herderCardTotalCount').html(total_cart + ' LE')
            let upto = (total_cart - (total_cart * .3))
            $('#herderUpToTotalCount').html(upto + ' LE')

        }


    </script>
@endsection
