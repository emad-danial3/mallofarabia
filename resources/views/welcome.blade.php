@extends('layouts.app')
@section('style')
    <style>
        .btnShopNow {
            background: #1e96b9;
            color: #fff;
            padding: .5rem 1rem;
            font-size: 1.2rem;
            font-weight: 600;
            border: none;
            border-radius: 2rem;
            cursor: pointer;
            transition-duration: 0.4s;
            width: 220px;
            margin: auto;
        }

        .btnShopNow:hover {
            background: #fff;
            box-shadow: 0px 2px 20px 10px #97B1BF;
            color: #000;
        }

        .home-page .carousel-caption {
            /*top: 10%;*/
        }

        .home-page .carousel-item img {
            height: 600px !important;
        }

        .home-page .carousel-caption .text-content {
            max-width: 330px;
            margin: auto;
        }

        .BecomeARep {
            color: #1e96b9 !important;
            font-size: 18px !important;
        }

        .cursor-pointer {
            cursor: pointer;
        }

        .brandItem {
            /*height: 260px!important;*/
            background-size: contain !important;
            min-height: 15.64rem;
            height: auto;
            padding: 2rem;
            border: 1px solid #d0d0d0;
            border-radius: 12px;
            box-shadow: 0 2px 5px 0 rgba(0, 0, 0, .05);
            -webkit-box-shadow: 0 2px 5px 0 rgba(0, 0, 0, .05);
        }

        .welcome-progran-gift-ima {
            text-align: center;
            align-items: center;
        }

        .product-option {
            justify-content: center !important;
            width: 60% !important;
        }



        #demo {
            background-color: #f5f0f5;
        }

        .newsletter-section .newsletter-box-3:after {
            background-image: url(../assets/images/background/newsletterbg.png);
            background-size: cover;
            background-position: center center;
            background-repeat: no-repeat;
            display: block;
            z-index: -1;
        }


        @media (max-width: 1660px) {
            .service-contain .service-box + .service-box::before {
                left: -50px;
            }
        }

        .newsletter-section .newsletter-box {
            border-radius: 0px;
        }

        .blog_explore_image {
            width: 100%;
            height: 500px;
        }

              @media all and (max-width: 620px) {

            #carouselExampleCaptions, .home-page .carousel-item img {
                height: 330px !important;
            }


        }

        .mainsliderhomepage .slick-prev {
            right: 100%;
            top: 45%
        }

        .mainsliderhomepage .slick-next {
            right: -40px;
            top: 45%
        }

        .mainsliderhomepage .slick-next, .slick-prev {
            background-color: #1997B7 !important;
            color: white !important;
            border-radius: 50% !important;
        }

        .mainsliderhomepage .slick-next::before, .slick-prev::before {
            color: white !important;
            opacity: 1 !important;
        }

        [dir=rtl] .arrow-slider .slick-next {
            left: 100% !important;
        }

        .product-image-last {
            border-radius: 40px;
            margin-bottom: 5px;
            box-shadow: 0px 1.88353px 1.88353px rgba(0, 0, 0, 0.1);
        }

        .product-parent-last {
            background-color: white;
            border: 1px solid #e7e7e7;
            border-radius: 40px !important;
            margin: 0px;
        }

        .home-brands .blog-box .blog-box-image {
            border-radius: 25px !important;
        }

        #imageParent {
            background-size: contain;
        }

    </style>
@endsection
@section('content')
    @include('layoutsWep.componants.messages')
    @include('layoutsWep.componants.bnner_section')
    @include('layoutsWep.componants.category_section')
{{--    @include('layoutsWep.componants.welcome_program_section')--}}
    {{--    @include('layoutsWep.componants.subscriber')--}}


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
                                            class="btn theme-bg-color view-button icon text-white fw-bold btn-md">
                                        View More Details
                                    </button> &nbsp;

                                    <button class="btn btn-md add-cart-button icon saveProductToCart showsaveaddtcart">
                                        {{trans('website.Add To Cart',[],session()->get('locale'))}}
                                    </button>


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



            var productId          = '';
            var productName        = '';
            var productImage       = '';
            var productPrice       = '';
            var productPriceOld    = '';
            var productDiscountOld = '';
            var productFlag        = '';
            var priceAfterDiscount = '';

            $(".viewProductModel").click(function () {

                console.log("dssdsd", $(this).attr('price_after_discount'))
                productId          = $(this).attr('id');
                productName        = $(this).attr('product_name');
                productImage       = $(this).attr('product_image');
                productPrice       = $(this).attr('product_price');
                priceAfterDiscount = $(this).attr('price_after_discount');
                productFlag        = $(this).attr('product_flag');
                $('#productQuantity').val(1);
                $('#productName').html(productName);
                $('#productPrice').html(productPrice);
                $('#price_after_discount').html(priceAfterDiscount);
                $('#productPriceOld').html($(this).attr('product_price_old'));
                $('#productDiscountOld').html($(this).attr('product_discount_old'));
                $('#productImage').attr('src', $(this).attr('product_image'));
                $('#productDescription').html($(this).attr('product_description'));
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
                    'total': 0,
                }
                var userWishlist    = localStorage.getItem('user_wishlist');
                if (!userWishlist || userWishlist == null || userWishlist == '' || userWishlist.length == 0) {
                    var allWishProducts = [];
                    allWishProducts.push(newProductwhish);
                    const myJSON = JSON.stringify(allWishProducts);
                    localStorage.setItem("user_wishlist", myJSON);
                    $('#herderWishlistCount').html(1);
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

            $(".addcart-button").click(function () {

                productId          = $(this).attr('product_id');
                productName        = $(this).attr('product_name');
                productPrice       = $(this).attr('product_price');
                priceAfterDiscount = $(this).attr('price_after_discount');
                productDiscountOld = $(this).attr('product_discount_old');
                productImage       = $(this).attr('product_image');
                productFlag        = $(this).attr('product_flag');
                var newProduct2    = {
                    'id': productId,
                    'name': productName,
                    'image': productImage,
                    'price': productPrice,
                    'price_after_discount': priceAfterDiscount,
                    'product_discount_old': productDiscountOld,
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
                            'product_discount_old': productDiscountOld,
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
                if(productQuantity > 0){


                var newProduct      = {
                    'id': productId,
                    'name': productName,
                    'image': productImage,
                    'price': productPrice,
                    'price_after_discount': priceAfterDiscount,
                    'product_discount_old': productDiscountOld,
                    'flag': productFlag,
                    'total': 0,
                    'quantity': productQuantity
                }
                var userCart        = localStorage.getItem('user_cart');
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
                            'product_discount_old': productDiscountOld,
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
                }
            });

            $(".apperonloade").removeClass('d-none')

        });
    </script>
@endsection

