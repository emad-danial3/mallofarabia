@extends('layouts.app')
@section('style')
    <style>
        .wishlist-button {
            width: 39px;
        }
        .productparent{
                box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.1);
                border-radius: 20px;
        }

    </style>
@endsection
@section('content')

    <!-- Banner Section Start -->
<section class="banner-section pt-0">
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="banner-contain-3 section-b-space section-t-space hover-effect">
                    {{--                        <img src="../assets/images/veg-3/banner/3.png" class="img-fluid bg-img" alt="">--}}
                    <div class="banner-detail p-center text-dark position-relative text-center p-0">
                        <div class="text-center">
                            <h2 class="my-3 text-dark-mint">{{trans('website.Favorites',[],session()->get('locale'))}}</h2>
                            <h4 class="text-content fw-300">
                                {{trans('website.Favorites products',[],session()->get('locale'))}}
                                </h4>
                             <button class="btn background-dark-mint mt-sm-4 btn-md  text-white fw-bold mx-auto"
                        onclick="location.href = '/products';">
                                 {{trans('website.Shop All',[],session()->get('locale'))}}
                </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Banner Section End -->


    <!-- Wishlist Section Start -->
    <section class="wishlist-section section-b-space">
        <div class="container-fluid-lg">
            <div class="row g-sm-3 g-2 justify-content-around" id="cartContainerBody">
                <div class="col-xxl-3 col-lg-4 col-md-6 col-12 product-box-contain">
                    <div class="product-box-3 h-100 ">
                        <div class="product-header">
                            <div class="product-image">
                                <a href="product-left-thumbnail.html">
                                    <img src="../assets/images/cake/product/2.png" class="img-fluid blur-up lazyload"
                                         alt="">
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
                                <a href="product-left-thumbnail.html">
                                    <h5 class="name theme-second-color">Fresh Bread and Pastry Flour 200 g</h5>
                                </a>
                                <h6 class="unit mt-1">250 ml</h6>
                                <h5 class="price">
                                    <span class="theme-color">$08.02</span>
                                    <del>$15.15</del>
                                </h5>

                                <div class="add-to-cart-box bg-white mt-2">
                                    <button class="btn btn-add-cart addcart-button">Add
                                        <span class="add-icon bg-light-gray">
                                            <i class="fa-solid fa-plus"></i>
                                        </span>
                                    </button>
                                    <div class="cart_qty qty-box">
                                        <div class="input-group bg-white">
                                            <button type="button" class="qty-left-minus bg-gray" data-type="minus"
                                                    data-field="">
                                                <i class="fa fa-minus" aria-hidden="true"></i>
                                            </button>
                                            <input class="form-control input-number qty-input" type="text"
                                                   name="quantity" value="0">
                                            <button type="button" class="qty-right-plus bg-gray" data-type="plus"
                                                    data-field="">
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
    </section>
    <!-- Wishlist Section End -->


@endsection

@section('java_script')
    <script>

        var allProductsArray = [];
        var myTimeout        = null;
        $(document).ready(function () {
            $('#cartContainerBody').html('');
            var userWishlist = localStorage.getItem('user_wishlist');
            let arrLength    = JSON.parse(userWishlist);
            if (!userWishlist || userWishlist == null || userWishlist == '' || userWishlist.length == 0 || arrLength.length == 0) {
                $('#cartContainerBody').html('<h4 class="text-center">No Data</h4>');
                var allWishProducts = [];
                const myJSON        = JSON.stringify(allWishProducts);
                localStorage.setItem("user_wishlist", myJSON);
                $('#herderWishlistCount').html(0)
            }
            else {
                allProductsArray = JSON.parse(userWishlist);
                const cartLength = allProductsArray.length;
               $('#herderWishlistCount').html(cartLength)
                for (let iiii = 0; iiii < cartLength; iiii++) {
                    var proObjff = allProductsArray[iiii];

                    $("#cartContainerBody").append(
                        '<div class="col-xxl-3 col-lg-4 col-md-6 col-12 product-box-contain productparent "  id="productparent' + proObjff['id'] + '">' +
                        ' <div class="product-box-3 h-100 bg-white">' +
                        '<div class="product-header">' +
                        '<div class="product-image">' +
                        '<a href="product-details/'+proObjff['id']+'">' +
                        '<img src="' + proObjff['image'] + '" class="img-fluid blur-up lazyload" alt=""> </a>' +

                        '<div class="product-header-top">' +
                        '<button class="btn wishlist-button close_button" onclick="removeFromWishlist(' + proObjff['id'] + ')" >x</button>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="product-footer">' +
                        '<div class="product-detail text-center">' +
                        '<a href="product-details/'+proObjff['id']+'">' +
                        '<h5 class="name theme-second-color">' + proObjff['name'] + '</h5></a>' +

                        '<h5 class="price">' +
                        '<span class="theme-color">' + proObjff['price'] + ' LE</span>' +
                        '<del>' + proObjff['product_price_old'] + ' LE </del>' +
                        '<span class="offer theme-color">('+proObjff['product_discount_old']+' % off)</span>'+
                        '</h5>' +
                           '<h4 class="price">'+


                        '<a href="{{url('joinus')}}" class="btn theme-bg-color view-button icon text-white fw-bold btn-md">'+"{{trans('website.VIP member price',[],session()->get('locale'))}}"+' &nbsp; '+


                        '<span i>' + proObjff['price_after_discount'] +  " {{trans('website.LE',[],session()->get('locale'))}}"+' </span></a> </h4>'+


                         '<button class="btn btn-md add-cart-button icon  bg-white w-100 mt-2 " onclick="saveProductToCart(' + proObjff['id'] + ')">'+"{{trans('website.Add To Cart',[],session()->get('locale'))}}"+'</button>'+
                        '</div>' +
                        '</div>' +

                        '</div>' +
                        '</div>' + '\n');
                }
            }
        });

        function removeFromWishlist(produt_id) {
            const indexOfObject = allProductsArray.findIndex(object => {
                return object.id == produt_id;
            });
            allProductsArray.splice(indexOfObject, 1);
            $("#productparent" + produt_id).hide("slow");
            if (allProductsArray.length < 1) {
                myTimeout = setTimeout(myStopFunction, 1000);
            }
            const myJSON = JSON.stringify(allProductsArray);
            localStorage.setItem("user_wishlist", myJSON);
            $('#herderWishlistCount').html(allProductsArray.length)
        }
        function saveProductToCart(produt_id) {
console.log("sdsdsd",produt_id)
            const indexOfObject = allProductsArray.findIndex(object => {
                return object.id == produt_id;
            });

                console.log("indexOfObject",indexOfObject)
                 var newnewProduct2 = {
                            'id': allProductsArray[indexOfObject]['id'],
                            'name': allProductsArray[indexOfObject]['name'],
                            'image': allProductsArray[indexOfObject]['image'],
                            'price': allProductsArray[indexOfObject]['price'],
                            'price_after_discount': allProductsArray[indexOfObject]['price_after_discount'],
                            'flag': allProductsArray[indexOfObject]['flag'],
                            'total': 0,
                            'quantity': 1
                        }
                 var userCart       = localStorage.getItem('user_cart');
                 if (!userCart || userCart == null || userCart == '' || userCart.length == 0) {
                    var allProductsNN = [];
                    allProductsNN.push(newnewProduct2);
                    const myJSON = JSON.stringify(allProductsNN);
                    localStorage.setItem("user_cart", myJSON);
                    $('#herderCardCount').html('1')
                    $('#herderCardTotalCount').html(newnewProduct2.price);
                    let upto = (newnewProduct2.price - (newnewProduct2.price * .3))
                    $('#herderUpToTotalCount').html('LE ' + upto)
                }else{
                    var allProductsNew = JSON.parse(userCart);

                     var el_exist_inarraycard = allProductsNew.find((e) => e.id == newnewProduct2.id);
                    if (el_exist_inarraycard) {
                        var newnewProductcard = {
                            'id': allProductsArray[indexOfObject]['id'],
                            'name': allProductsArray[indexOfObject]['name'],
                            'image': allProductsArray[indexOfObject]['image'],
                            'price': allProductsArray[indexOfObject]['price'],
                            'price_after_discount': allProductsArray[indexOfObject]['price_after_discount'],
                            'flag': allProductsArray[indexOfObject]['flag'],
                            'total': 0,
                            'quantity': (parseInt(el_exist_inarraycard.quantity) + parseInt(1))
                        }
                        const indx         = allProductsNew.findIndex(v => v.id == el_exist_inarraycard.id);
                        allProductsNew.splice(indx, indx >= 0 ? 1 : 0);
                        allProductsNew.push(newnewProductcard);
                    }
                    else {
                        allProductsNew.push(newnewProduct2);
                    }
                    const myJSON1122 = JSON.stringify(allProductsNew);
                    localStorage.setItem("user_cart", myJSON1122);
                    const cartLength = allProductsNew.length;


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
                    $('#herderCardTotalCount').html( total_cart + ' LE')
                    let upto = (total_cart - (total_cart * .3))
                    $('#herderUpToTotalCount').html( upto + ' LE')

                 }

               swal({
                    text: "{{trans('website.Add Product To Cart',[],session()->get('locale'))}}",
                    title: "Successful",
                    timer: 1500,
                    icon: "success",
                    buttons: false,
                });

        }

        function myStopFunction() {
            $('#cartContainerBody').html('<h4 class="text-center">No Data</h4>');
            clearTimeout(myTimeout);
        }
    </script>
@endsection
