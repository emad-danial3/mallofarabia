@extends('AdminPanel.layouts.main')
@section('content')

    <style type="text/css">
        .select2-container .select2-selection--single {
            height: 40px !important;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            top: 7px !important;
        }

        .amount_view {
            margin: 5px;
        }

        .table-striped tbody tr:nth-of-type(odd) button {
            background-color: white;
        }

        .table button {
            border-radius: 5px;
        }
    </style>
    <link rel="stylesheet" href="{{url('dashboard')}}/plugins/select2/css/select2.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <div class="loader">
        <img class="card-img-top cartimage"
             src="{{asset('test/img/Loading_icon.gif')}}" alt="Card image cap">
    </div>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('orderHeaders.index')}}">Orders</a></li>

                    </ol>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="container-fluid">
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <!-- form start -->
                        <form action="{{(isset($code))?route('orderHeaders.update',$code):route('orderHeaders.store')}}"
                              method="post" enctype="multipart/form-data">
                            @include('AdminPanel.layouts.messages')
                            @csrf
                            <input type="hidden" id="admin_id" value="{{Auth::guard('admin')->user()->id}}"/>
                            <input type="hidden" id="store_id" value="{{Auth::guard('admin')->user()->store_id}}"/>

                            <div class="alert alert-primary" role="alert" id="infoMessage" style="display: none">

                            </div>

                            <div class="card-body" style="border-bottom: 1px solid #e7e7e7;margin-bottom: 3px">
                                <input type="hidden" id="order_exist_id" value="" />
                                <div class="row mb-4" id="mainSearch">
                                    <div class="col-md-6">
                                        <input type="search" id="old_order_id" class="form-control"
                                               placeholder="enter old order"/>

                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-default mb-2 w-75" type="button"
                                                onclick="getOldOrder()">
                                            <i class="fa-solid fa-search"></i> get order
                                        </button>
                                    </div>
                                </div>
                                <div class="row d-none " id="mainorder">
                                    <div class="col-md-12 mb-4"> <h1 class="text-center">Order</h1> </div>
                                    <div class="col-md-6 mb-4">
                                        <h4>Order ID : <span id="orderExistId"></span></h4>
                                        <h4>Order total : <span id="orderExistTotal"></span></h4>
                                        <h4>Product Count : <span id="ProductCount"></span></h4>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <h4>Order Products</h4>
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th scope="col">P_ID</th>
                                                <th scope="col">Name</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Code</th>
                                            </tr>
                                            </thead>
                                            <tbody id="oldProductContainer">

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <hr>
                                    </div>
                                    <div class="col-md-12">
                                        <h1 class="text-center">Return Products</h1>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="md-form">


                                            <div class="row">


                                                <div class="col-md-10">
                                                    <h5></h5>
                                                </div>

                                                <div class="col-md-2">
                                                    <button class="btn btn-default mb-1" type="button"
                                                            onclick="removeAllItems()">
                                                        <i class="fa-solid fa-trash-can"></i> All
                                                    </button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-12" id="finaltablepr">
                                                    <table class="table table-striped">
                                                        <thead>
                                                        <tr>
                                                            <th scope="col">P_ID</th>
                                                            <th scope="col">Image</th>
                                                            <th scope="col">Name</th>
                                                            <th scope="col">Price</th>
                                                            <th scope="col">Quantity</th>
                                                            <th scope="col">Actions</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody id="cartProductContainer">
                                                        <tr id="nodata">
                                                            <th scope="row" colspan="6" class="text-center">
                                                                No Data
                                                            </th>
                                                        </tr>

                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>


                                        </div>

                                    </div>
                                    <div class="col-md-6">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <h3>Barcode</h3>
                                                <div class="input-group">
                                                    <div class="form-outline md-form w-100">
                                                        <input type="search" id="barcode" class="form-control"
                                                               placeholder="Search Product barcode" autofocus/>

                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h3>Product Name</h3>
                                                <div class="input-group">
                                                    <div class="form-outline md-form w-100">
                                                        <input type="search" id="proname" class="form-control"
                                                               placeholder="Search Product Name En"/>
                                                        <br>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <h3>Item Code</h3>
                                                <div class="input-group">
                                                    <div class="form-outline md-form w-100">
                                                        <input type="search" id="procode" class="form-control"
                                                               placeholder="Code"/>
                                                        <br>
                                                        <br>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>


                                    </div>

                                </div>
                            </div>

                            &nbsp; &nbsp;
                            <button  onclick="saveOrderButton()" type="button" class="btn btn-primary" >
                                Save Order
                            </button>
                        </form>
                        <br>

                        <div class="row" id="invoice"
                             style="    border: 1px solid #e7e7e7; margin-left: 3px; padding: 10px; border-radius: 5px; display: none">
                            <div class="col-md-12">
                                <h2>Invoice</h2>
                                <hr>
                            </div>
                            <div class="col-md-3">
                                <h3>Total Products: </h3>
                            </div>
                            <div class="col-md-3">
                                <h3 id="totalProducts"></h3>
                            </div>
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-3">
                                <h3>Discount Percentage : </h3>
                            </div>
                            <div class="col-md-3">
                                <h3 id="discountPercentage"></h3>
                            </div>
                            <div class="col-md-6">
                            </div>


                            <div class="col-md-3">
                                <h3>Total After Discount : </h3>
                            </div>
                            <div class="col-md-3">
                                <h3 id="totalProductsAfterDiscount"></h3>
                            </div>
                            <div class="col-md-6">
                            </div>
                            <div class="col-md-3">
                                <h3>Total Order : </h3>
                            </div>
                            <hr>
                            <div class="col-md-3">
                                <h3 id="totalOrder"></h3>
                            </div>
                            <div class="col-md-6">
                            </div>

                            <div class="col-md-3">
                                <h3>Order Id : </h3>
                            </div>
                            <div class="col-md-3">
                                <input type="number" disabled id="order_id"></input>
                            </div>
                            <div class="col-md-6">
                            </div>

                            {{--                            <div class="col-md-4 mt-2 mb-4">--}}
                            {{--                                <button type="button" class="btn btn-primary" id="payOrderButtonFunction">--}}
                            {{--                                    Pay Cash--}}
                            {{--                                </button>--}}
                            {{--                                <h1 id="payOrderFunctionmessage" class="d-none" onclick="location.reload();">Order Paid--}}
                            {{--                                    Done</h1>--}}
                            {{--                            </div>--}}
                            {{--                            <div class="col-md-4 mt-2 mb-4">--}}
                            {{--                                <button type="button" class="btn btn-primary" id="payOrderButtonVisa">--}}
                            {{--                                    Pay Visa--}}
                            {{--                                </button>--}}
                            {{--                                <h1 id="payOrdermessageVisa" class="d-none" onclick="location.reload();">Order Paid--}}
                            {{--                                    Done</h1>--}}
                            {{--                            </div>--}}
                            <div class="col-md-4 mt-2 mb-4">
                                <button type="button" class="btn btn-primary" onclick="addNewOrder();">
                                    Add New Order
                                </button>
                            </div>
                            <div class="col-md-12 mt-2 mb-4">
                                <br>
                                <br>
                                <br>
                            </div>

                        </div>


                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
                <!-- right column -->
                <div class="col-md-6">

                </div>
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->


        <!-- Modal -->
        <div class="modal fade" id="exampleModalCenter" role="dialog" aria-labelledby="exampleModalCenterTitle"
             aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle"> Clients </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row step-1">
                            <div class="col-md-12 choose_client">

                                <div class="form-group">
                                    <label for="created_for_user_id">Search Clients</label>

                                    <select style="width: 100%;" class="select2 form-control" name="client_id" id="client_id">
                                        <option  selected value="" disabled> Search</option>
                                        @foreach($clients as $client)
                                            <option value="{{$client->id}}"
                                                    id="{{$client->id}}">{{$client->name .' '. $client->mobile }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <button class="btn btn-success mt-2" id="add_new_client_btn">add new</button>
                            </div>
                            <div class="d-none col-md-12 add_new_client row">

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new_user_name">User Name</label>
                                        <input class="form-control" name="new_user_name" type="text" id="new_user_name"
                                               placeholder="User Name">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label for="new_user_phone">User Phone</label>
                                        <input class="form-control" type="text" id="new_user_phone"
                                               name="new_user_phone" placeholder="User Phone" minlength="11" maxlength="11">
                                    </div>
                                </div>
                                <button class="btn btn-success  mt-2" id="choose_client_btn">choose client</button>
                            </div>


                        </div>
                        <div class="row  step-2 d-none">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="f_total_order">Total Order <span id="f_total_order"></span></label>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="amount">Pay Cash</label>
                                    <input class="form-control" name="cash" type="number" id="cash_amount"
                                           placeholder="collected cash">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label c for="amount">Pay Visa</label>
                                    <input class="form-control" name="visa_amount" type="number" id="visa_amount"
                                           placeholder="visa amount">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="amount">Visa reference number (if pay Visa)</label>
                                    <input class="form-control" name="visa_reference" type="number" id="visa_reference"
                                           placeholder="visa reference number">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="remainder" style="color: red">Remainder :  <span id="remainder">0</span></label>
                                </div>
                            </div>

                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary show_payment">Next</button>
                        <button type="button" class="btn btn-primary  d-none show_client_select">Previous</button>
                        <button type="button" class="btn btn-primary save_oder d-none" onclick="saveOrderButton()">Save
                            Order
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="exampleModalCurrentDiscount" tabindex="-1" role="dialog"
             aria-labelledby="exampleModalCurrentDiscountTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLongTitle">Current Discount</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="edit_current_discount">Discount</label>
                                    <input class="form-control" type="number" min="0" max="100" value="0"
                                           id="edit_current_discount">
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" onclick="saveCurrentDiscount()">Save</button>
                    </div>
                </div>
            </div>
        </div>

    </section>
    @push('scripts')
        <script src="{{url('dashboard')}}/plugins/select2/js/select2.min.js"></script>
        <script type="text/javascript">

            cartProducts = [];
            const myJSON = JSON.stringify(cartProducts);
            localStorage.setItem("admin_cart", myJSON);
            $("#cartProductContainer").html('');
            $("#cartProductContainer").append(
                '<tr id="nodata"><th scope="row" colspan="6" class="text-center">No Data </th> </tr>'
            );

            // users filter
            var allCurrentUsers = <?php echo json_encode($clients); ?>;
            var allCurrentUsersData = allCurrentUsers;
            var total_cart = 0;
            var base_url = window.location.origin;
            var url_string = (window.location).href;
            var url = new URL(url_string);
            var message = url.searchParams.get("message");

            var cartProducts = [];
            var allProductsArray = [];
            $(document).ready(function () {

                $('#cash_amount,#visa_amount').on('keyup', function () {
                    var cash_amount =Number($('#cash_amount').val()) ;
                    var visa_amount =Number($('#visa_amount').val()) ;
                    var summ=cash_amount+visa_amount;

                    if(summ>total_cart){
                        var rem=summ-total_cart;
                        $('#remainder').html(rem);
                    }else {
                        $('#remainder').html(0);
                    }
                });

                $('#save_button').on('click', function () {
                    $('#exampleModalCenter').modal('show');
                    $('.select2').select2();
                });

                $('.show_payment').on('click', function () {
                    $('.step-1').addClass('d-none');
                    $('.step-2').removeClass('d-none');
                    $("#f_total_order").html(total_cart);
                    $(this).addClass('d-none');
                    $('.show_client_select').removeClass('d-none');
                    $('.save_oder').removeClass('d-none');
                });
                $('.show_client_select').on('click', function () {
                    $('.step-2').addClass('d-none');
                    $('.step-1').removeClass('d-none');
                    $(this).addClass('d-none');
                    $('.show_payment').removeClass('d-none');
                });
                $('#add_new_client_btn,#choose_client_btn').on('click', function () {
                    $('.add_new_client').toggleClass('d-none');
                    $('.choose_client').toggleClass('d-none');

                });
                $('#currentDiscount').html($('#edit_current_discount').val());


                if (message && message != '') {
                    $("#infoMessage").show('slow');
                    $("#infoMessage").html(message);
                    setTimeout(function () {
                        $("#infoMessage").hide('slow');
                    }, 5000);

                    if (message == 'Operation done successfully') {
                        cartProducts = [];
                        const myJSONdone = JSON.stringify(cartProducts);
                        localStorage.setItem("admin_cart", myJSONdone);
                    }
                }

                var admin_cart = localStorage.getItem('admin_cart');
                let arrLength = JSON.parse(admin_cart);
                if (!admin_cart || admin_cart == null || admin_cart == '' || admin_cart.length == 0 || arrLength.length == 0) {
                    $("#nodata").show();
                    $("#totalHeaderAdminCart").html(0);
                    $("#totalHeaderAfterDiscount").html(0);
                    total_cart = 0;
                } else {
                    $("#nodata").hide();
                    $('#save_button').removeAttr('disabled');
                    allProductsArray = JSON.parse(admin_cart);
                    cartProducts = allProductsArray;
                    total_cart = 0;
                    const cartLength = allProductsArray.length;

                    for (let iiii = 0; iiii < cartLength; iiii++) {
                        var proObjff = allProductsArray[iiii];
                        $("#cartProductContainer").append(
                            ' <tr id="productparent' + proObjff['id'] + '"> <th scope="row"> ' + proObjff['id'] + ' </th><th scope="row"><img class="card-img-top cartimage" src="' + proObjff['image'] + '" alt="Card image cap"></th><td> ' + proObjff['name'] + ' </td><td>' + proObjff['price'] + '</td><td><button class="increase-decrease" type="button" onclick="decreaseQuantity(' + proObjff['id'] + ')"> - </button><span  class="amount_view" id="proQuantity' + proObjff['id'] + '">' + proObjff['quantity'] + '</span><button class="increase-decrease" type="button" onclick="increaseQuantity(' + proObjff['id'] + ')"> + </button></td><td ><button  type="button" onclick="removeFromCart(' + proObjff['id'] + ')" style="border: 0px;color: red;">X</button></td></tr>'
                        );
                        total_cart = (Number(total_cart) + (Number(proObjff['price']) * Number(proObjff['quantity'])));
                    }
                    $("#totalHeaderAdminCart").html(total_cart);
                    var afdis = total_cart - (total_cart * $('#edit_current_discount').val() / 100);
                    $("#totalHeaderAfterDiscount").html(afdis);
                }

                $(".addToCartButton").click(function () {

                    var productId = $(this).attr('id');
                    var productName = $(this).attr('product_name');
                    var productFlag = $(this).attr('product_flag');
                    var productPrice = $(this).attr('product_price');
                    var productImage = $(this).attr('product_image');
                    var productQuantity = $('#product' + productId).val();
                    if (productQuantity > 0) {


                        var el_exist_inarray = cartProducts.find((e) => e.id == productId);
                        if (el_exist_inarray) {
                            var mainobj = {
                                'id': productId,
                                'name': productName,
                                'image': productImage,
                                'price': productPrice,
                                'flag': productFlag,
                                'quantity': parseInt(parseInt(el_exist_inarray['quantity']) + parseInt(productQuantity))
                            }
                            removeFromCart(productId)
                        } else {
                            var mainobj = {
                                'id': productId,
                                'name': productName,
                                'image': productImage,
                                'price': productPrice,
                                'flag': productFlag,
                                'quantity': productQuantity
                            }
                        }
                        cartProducts.push(mainobj);
                        const myJSON = JSON.stringify(cartProducts);
                        localStorage.setItem("admin_cart", myJSON);
                        total_cart = (Number(total_cart) + (Number(mainobj['price']) * Number(mainobj['quantity'])));

                        $("#totalHeaderAdminCart").html(total_cart);
                        var afdis = (total_cart - total_cart * $('#edit_current_discount').val() / 100);
                        $("#totalHeaderAfterDiscount").html(afdis);
                        $("#nodata").hide();
                        $('#product' + productId).val(1);
                        $('#save_button').removeAttr('disabled');
                        $("#cartProductContainer").append(
                            ' <tr id="productparent' + productId + '"> <th scope="row"> ' + productId + ' </th><th scope="row"><img class="card-img-top cartimage" src="' + productImage + '" alt="Card image cap"></th><td> ' + productName + ' </td><td>' + productPrice + '</td><td><button class="increase-decrease" type="button" onclick="decreaseQuantity(' + productId + ')"> - </button><span class="amount_view"  id="proQuantity' + productId + '">' + mainobj['quantity'] + '</span><button class="increase-decrease" type="button" onclick="increaseQuantity(' + productId + ')"> +</button></td><td ><button type="button" onclick="removeFromCart(' + productId + ')" style="border: 0px;color: red;">X</button></td></tr>'
                        );
                        swal({
                            text: "{{trans('website.Add Product To Cart',[],session()->get('locale'))}}",
                            title: "Successful",
                            timer: 1500,
                            icon: "success",
                            buttons: false,
                        });
                    }
                });


                $("#proname").change(function () {
                    getpro();
                });
                $("#barcode").change(function () {
                    getpro();
                });
                $("#procode").change(function () {
                    getpro();
                });

                $("#category_id").change(function () {
                    getpro();
                });

                function getpro() {

                    var proname = $("#proname").val();
                    var procode = $("#procode").val();
                    var barcode = $("#barcode").val();
                    let formData = new FormData();

                    formData.append('name', proname);
                    formData.append('barcode', barcode);
                    formData.append('code', procode);
                    let path = base_url + "/orderHeaders/getAllproducts";
                    // console.log("path", path);
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
                            if (response.data) {

                                $("#productsSearchContainer").html('');
                                // console.log(response.data);
                                if (response.data.length > 0) {
                                    for (let ii = 0; ii < response.data.length; ii++) {
                                        let proObj = response.data[ii];
                                        $("#productsSearchContainer").append(
                                            '<div class="col-md-12"><div class="card"> <img class="card-img-top cartimage" src="' + base_url + '/' + proObj['image'] + '" " alt="Card image cap"> <div class="card-body"> <h5 class="product-title">' + proObj['name_en'] +
                                            '</h5><h6> Price : ' + proObj['price'] + '</h6> <h6>' + 'Quantity &nbsp; <input type="number" min="1" value="1" class="border border-primary rounded text-center w-50" id="product' + proObj['id'] + '"> </h6>' +
                                            ' <br> <button type="button" class="btn btn-primary addToCartButton w-100" onclick="addToCartFunction(this)" id="' + proObj['id'] + '" product_name="' + proObj['name_en'] + '" product_flag="' + proObj['flag'] + '" product_price="' + proObj['price'] + '" product_image="' + proObj['image'] + '" >' +
                                            'Add To Cart </button> </div> </div> </div>'
                                            + ' \n'
                                        );
                                    }

                                    if ((barcode && barcode != '' && barcode > '') || (procode && procode != '' && procode > '')  ) {

                                        let proObjBar = response.data[0];
                                        var el_exist_inarray = cartProducts.find((e) => e.id == proObjBar['id']);
                                        if (el_exist_inarray) {
                                            var mainobj = {
                                                'id': proObjBar['id'],
                                                'name': proObjBar['name_en'],
                                                'image': proObjBar['image'],
                                                'price': proObjBar['price'],
                                                'flag': proObjBar['flag'],
                                                'quantity': parseInt(parseInt(el_exist_inarray['quantity']) + 1)
                                            }
                                            removeFromCart(proObjBar['id'])
                                        } else {
                                            var mainobj = {
                                                'id': proObjBar['id'],
                                                'name': proObjBar['name_en'],
                                                'image': proObjBar['image'],
                                                'price': proObjBar['price'],
                                                'flag': proObjBar['flag'],
                                                'quantity': 1
                                            }
                                        }
                                        cartProducts.push(mainobj);
                                        const myJSON = JSON.stringify(cartProducts);
                                        localStorage.setItem("admin_cart", myJSON);
                                        total_cart = (Number(total_cart) + (Number(mainobj['price']) * Number(mainobj['quantity'])));
                                        $("#totalHeaderAdminCart").html(total_cart);
                                        var afdis = total_cart - (total_cart * $('#edit_current_discount').val() / 100);
                                        $("#totalHeaderAfterDiscount").html(afdis);
                                        $("#nodata").hide();
                                        $('#save_button').removeAttr('disabled');
                                        $("#cartProductContainer").append(
                                            ' <tr id="productparent' + proObjBar['id'] + '"> <th scope="row"> ' + proObjBar['id'] + ' </th><th scope="row"><img class="card-img-top cartimage" src="' + proObjBar['image'] + '" alt="Card image cap"></th><td> ' + proObjBar['name_en'] + ' </td><td>' + proObjBar['price'] + '</td><td><button class="increase-decrease" type="button" onclick="decreaseQuantity(' + proObjBar['id'] + ')"> - </button><span class="amount_view" id="proQuantity' + proObjBar['id'] + '">' + mainobj['quantity'] + '</span><button class="increase-decrease" type="button" onclick="increaseQuantity(' + proObjBar['id'] + ')">+ </button></td><td > <button type="button" onclick="removeFromCart(' + proObjBar['id'] + ')" style="border: 0px;color: red;">X</button> </td></tr>'
                                        );
                                        $("#barcode").val('');

                                    }
                                } else {
                                    $("#productsSearchContainer").html('');
                                    $('#productsSearchContainer').append('<div class="col-md-12"> <h3 class="text-center">No Data</h3></div>');

                                }

                            } else {
                                $("#productsSearchContainer").html('');
                                $('#productsSearchContainer').append('<div class="col-md-12"> <h3 class="text-center">No Data</h3></div>');

                            }
                        },
                        error: function (response) {
                            console.log(response)
                            alert('error');
                        }
                    });
                }
            });

            function addToCartFunction(el) {
                var productId = $(el).attr('id');
                var productName = $(el).attr('product_name');
                var productPrice = $(el).attr('product_price');
                var productImage = $(el).attr('product_image');
                var productFlag = $(el).attr('product_flag');
                var productQuantity = $('#product' + productId).val();

                var el_exist_inarray = cartProducts.find((e) => e.id == productId);
                if (el_exist_inarray) {
                    var mainobj = {
                        'id': productId,
                        'name': productName,
                        'image': productImage,
                        'price': productPrice,
                        'flag': productFlag,
                        'quantity': parseInt(parseInt(el_exist_inarray['quantity']) + parseInt(productQuantity))
                    }
                    removeFromCart(productId)
                } else {
                    var mainobj = {
                        'id': productId,
                        'name': productName,
                        'image': productImage,
                        'price': productPrice,
                        'flag': productFlag,
                        'quantity': productQuantity
                    }
                }
                cartProducts.push(mainobj);
                const myJSON = JSON.stringify(cartProducts);
                localStorage.setItem("admin_cart", myJSON);
                total_cart = (Number(total_cart) + (Number(mainobj['price']) * Number(mainobj['quantity'])));

                $("#totalHeaderAdminCart").html(total_cart);
                var afdis = total_cart - (total_cart * $('#edit_current_discount').val() / 100);
                $("#totalHeaderAfterDiscount").html(afdis);
                $("#nodata").hide();
                $('#save_button').removeAttr('disabled');
                $("#cartProductContainer").append(
                    ' <tr id="productparent' + productId + '"> <th scope="row"> ' + productId + ' </th><th scope="row"><img class="card-img-top cartimage" src="' + productImage + '" alt="Card image cap"></th><td> ' + productName + ' </td><td>' + productPrice + '</td><td><button class="increase-decrease" type="button" onclick="decreaseQuantity(' + productId + ')"> - </button><span class="amount_view" id="proQuantity' + productId + '">' + mainobj['quantity'] + '</span><button class="increase-decrease" type="button" onclick="increaseQuantity(' + productId + ')">+ </button></td><td > <button type="button" onclick="removeFromCart(' + productId + ')" style="border: 0px;color: red;">X</button> </td></tr>'
                );
                swal({
                    text: "{{trans('website.Add Product To Cart',[],session()->get('locale'))}}",
                    title: "Successful",
                    timer: 1500,
                    icon: "success",
                    buttons: false,
                });
            }

            function removeFromCart(produt_id) {
                const indexOfObject = cartProducts.findIndex(object => {
                    return object.id == produt_id;
                });
                total_cart = (Number(total_cart) - (Number(cartProducts[indexOfObject]['price']) * Number(cartProducts[indexOfObject]['quantity'])));
                $("#totalHeaderAdminCart").html(total_cart);
                var afdis = total_cart - (total_cart * $('#edit_current_discount').val() / 100);
                $("#totalHeaderAfterDiscount").html(afdis);
                cartProducts.splice(indexOfObject, 1);
                const myJSON = JSON.stringify(cartProducts);
                localStorage.setItem("admin_cart", myJSON);
                $("#productparent" + produt_id).remove();
                if (cartProducts.length < 1) {
                    $("#nodata").show();
                    $("#totalHeaderAdminCart").html(0);
                    $("#totalHeaderAfterDiscount").html(0);
                    $('#save_button').prop('disabled', true);
                }
            }

            $("#payOrderButtonFunction").click(function () {
                console.log("payOrder Button Function");
                let path = base_url + "/orderHeaders/makeOrderPayInAdmin";
                var order_id = $('#order_id').val();
                var ff = {
                    "order_id": order_id,
                    "wallet_status": "cash"
                }
                $.ajax({
                    url: path,
                    type: 'POST',
                    cache: false,
                    data: JSON.stringify(ff),
                    contentType: "application/json; charset=utf-8",
                    traditional: true,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    processData: false,
                    success: function (response) {
                        if (response.data) {
                            console.log(response.data);
                            $('#save_button').prop('disabled', true);
                            $('#payOrderButtonFunction').prop('disabled', true);
                            $('#payOrderButtonVisa').prop('disabled', true);
                            $('#payOrderFunctionmessage').show();
                            cartProducts = [];
                            const myJSON = JSON.stringify(cartProducts);
                            localStorage.setItem("admin_cart", myJSON);
                            $("#nodata").show();
                            $("#cartProductContainer").html('');

                            printOrder(order_id);
                        } else {

                            alert('error');
                        }
                    },
                    error: function (response) {
                        console.log(response)
                        alert('error');
                    }
                });
            });

            $("#payOrderButtonVisa").click(function () {

                console.log("payOrder Button payOrder Button Visa");
                let path = base_url + "/orderHeaders/makeOrderPayInAdmin";
                var order_id = $('#order_id').val();
                var ff = {
                    "order_id": order_id,
                    "wallet_status": "visa"
                }
                $.ajax({
                    url: path,
                    type: 'POST',
                    cache: false,
                    data: JSON.stringify(ff),
                    contentType: "application/json; charset=utf-8",
                    traditional: true,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    processData: false,
                    success: function (response) {
                        if (response.data) {
                            console.log(response.data);
                            $('#save_button').prop('disabled', true);
                            $('#payOrderButtonFunction').prop('disabled', true);
                            $('#payOrderButtonVisa').prop('disabled', true);
                            $('#payOrdermessageVisa').show();
                            cartProducts = [];
                            const myJSON = JSON.stringify(cartProducts);
                            localStorage.setItem("admin_cart", myJSON);
                            $("#nodata").show();
                            $("#cartProductContainer").html('');

                            printOrder(order_id);
                        } else {
                            console.log(response)
                            alert('error');
                        }
                    },
                    error: function (response) {
                        console.log(response)
                        alert('error');
                    }
                });
            });

            function getOldOrder() {
                var old_order_id=$('#old_order_id').val();
                if(old_order_id > 0){
                    let path = base_url + "/orderHeaders/getOldOrder";

                    var ff = {
                        "old_order": old_order_id,
                    }

                    $.ajax({
                        url: path,
                        type: 'POST',
                        cache: false,
                        data: JSON.stringify(ff),
                        contentType: "application/json; charset=utf-8",
                        traditional: true,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        processData: false,
                        success: function (response) {
                            if (response.data) {
                                console.log(response.data);
                                $('#mainorder').removeClass('d-none');
                                $('#mainSearch').addClass('d-none');
                                $('#order_exist_id').val(response.data.order.id);
                                $('#orderExistId').html(response.data.order.id);
                                $('#orderExistTotal').html(response.data.order.total_order);
                                $('#ProductCount').html(response.data.lines.length);

                                for (let iiiil = 0; iiiil < response.data.lines.length; iiiil++) {
                                    var proObjff = response.data.lines[iiiil];
                                    $("#oldProductContainer").append(
                                        ' <tr id="productparent' + proObjff['product_id'] + '"> <th scope="row"> ' + proObjff['product_id'] + ' </th><td> ' + proObjff['full_name'] + ' </td><td> ' + proObjff['quantity'] + ' </td><td> ' + proObjff['oracle_short_code'] + ' </td></tr>'
                                    );
                                    total_cart = (Number(total_cart) + (Number(proObjff['price']) * Number(proObjff['quantity'])));
                                }

                            }else {
                                alert('on order');
                            }
                        },
                        error: function (response) {
                            console.log(response)
                            alert('error');
                        }
                    });
                }else {
                    alert("enter order  id");
                }
            }
            function removeAllItems() {
                $('#save_button').prop('disabled', true);
                $('#payOrderButtonFunction').prop('disabled', true);
                $('#payOrderFunctionmessage').show();
                cartProducts = [];
                total_cart = 0;
                const myJSON = JSON.stringify(cartProducts);
                localStorage.setItem("admin_cart", myJSON);
                $("#cartProductContainer").html('');
                $("#totalHeaderAdminCart").html(0);
                $("#totalHeaderAfterDiscount").html(0);
                $("#nodata").show();
                $("#cartProductContainer").append(
                    '<tr id="nodata"><th scope="row" colspan="6" class="text-center">No Data </th> </tr>'
                );
            }

            function increaseQuantity(produt_id) {
                const indexOfObject = cartProducts.findIndex(object => {
                    return object.id == produt_id;
                });
                total_cart = (Number(total_cart) + Number(cartProducts[indexOfObject]['price']));
                cartProducts[indexOfObject]['quantity'] = Number(cartProducts[indexOfObject]['quantity']) + 1;
                $("#totalHeaderAdminCart").html(total_cart);
                var afdis = total_cart - (total_cart * $('#edit_current_discount').val() / 100);
                $("#totalHeaderAfterDiscount").html(afdis);
                $("#proQuantity" + produt_id).html(cartProducts[indexOfObject]['quantity']);
                const myJSON = JSON.stringify(cartProducts);
                localStorage.setItem("admin_cart", myJSON);
            }

            function decreaseQuantity(produt_id) {
                const indexOfObject = cartProducts.findIndex(object => {
                    return object.id == produt_id;
                });
                total_cart = (Number(total_cart) - Number(cartProducts[indexOfObject]['price']));
                cartProducts[indexOfObject]['quantity'] = Number(cartProducts[indexOfObject]['quantity']) - 1;
                $("#totalHeaderAdminCart").html(total_cart);
                var afdis = total_cart - (total_cart * $('#edit_current_discount').val() / 100);
                $("#totalHeaderAfterDiscount").html(afdis);
                $("#proQuantity" + produt_id).html(cartProducts[indexOfObject]['quantity']);

                if (cartProducts[indexOfObject]['quantity'] < 1) {
                    $("#productparent" + produt_id).remove();
                    cartProducts.splice(indexOfObject, 1);
                }
                if (cartProducts.length < 1) {
                    $("#nodata").show();
                    $("#totalHeaderAdminCart").html(0);

                    $("#totalHeaderAfterDiscount").html(0);
                }
                const myJSON = JSON.stringify(cartProducts);
                localStorage.setItem("admin_cart", myJSON);
            }

            function saveOrderButton() {

                var order_exist_id=$('#order_exist_id').val();
                if(order_exist_id > 0){
                    $("#exampleModalCenter").modal('hide');
                    $('.loader').show();
                    var created_for_user_id = $('#created_for_user_id').val();
                    var new_user_name = $('#new_user_name').val();
                    var client_id = $('#client_id').val();
                    var new_user_phone = $('#new_user_phone').val();
                    var new_discount = $('#edit_current_discount').val();
                    $('#currentDiscount').html($('#edit_current_discount').val());
                    var admin_id = $('#admin_id').val();
                    var store_id = $('#store_id').val();
                    let path = base_url + "/orderHeaders/CalculateProductsAndShipping";

                    var ff = {
                        "user_id": created_for_user_id > 1 ? created_for_user_id : 1,
                        "created_for_user_id": created_for_user_id > 1 ? created_for_user_id : 1,
                        "client_id": client_id,
                        "new_discount": new_discount,
                        "order_exist_id": order_exist_id,
                        "admin_id": admin_id,
                        "store_id": store_id,
                        "items": cartProducts
                    }


                    $.ajax({
                        url: path,
                        type: 'POST',
                        cache: false,
                        data: JSON.stringify(ff),
                        contentType: "application/json; charset=utf-8",
                        traditional: true,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        processData: false,
                        success: function (response) {
                            if (response.data) {
                                console.log(response.data);
                                $('.loader').hide();
                                $("#exampleModalCenter").modal('hide');
                                $('#save_button').prop('disabled', true);
                                $('#payOrderButtonFunction').prop('disabled', false);
                                $("#invoice").show();
                                $("#totalProducts").html('');
                                $("#totalProductsAfterDiscount").html('');
                                $("#discountPercentage").html('');
                                $("#order_id").val(0);
                                $("#order_online_id").val(0);
                                $('#totalProducts').append(response.data.totalProducts);
                                $('#totalProductsAfterDiscount').append(response.data.totalProductsAfterDiscount);
                                $('#discountPercentage').append(response.data.discountPercentage);
                                $('#totalOrder').append(response.data.totalOrder);
                                $('#order_id').val(response.data.order_id);
                                $('#order_online_id').val(response.data.order_id);


                                $('#payOrderButtonVisa').prop('disabled', true);
                                $('#payOrderFunctionmessage').show();
                                cartProducts = [];
                                const myJSON = JSON.stringify(cartProducts);
                                localStorage.setItem("admin_cart", myJSON);
                                $("#cartProductContainer").html('');
                                $("#cartProductContainer").append(
                                    '<tr id="nodata"><th scope="row" colspan="6" class="text-center">No Data </th> </tr>'
                                );
                                printOrder(response.data.order_id);
                                window.scrollTo({left: 0, top: document.body.scrollHeight, behavior: 'smooth'})
                            } else {
                                $('.loader').hide();
                            }
                        },
                        error: function (response) {
                            console.log(response)
                            alert('error');
                            $('.loader').hide();
                        }
                    });
                }

            }


            function printOrder(order_id) {
                let path = base_url + "/orderHeaders/print80c/" + order_id;
                $.ajax({
                    url: path,
                    type: 'GET',
                    cache: false,
                    traditional: true,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    processData: false,
                    success: function (response) {
                        var win = window.open('', '', 'left=300,top=0,width=1000,height=500,toolbar=0,scrollbars=0,status =0');
                        var content = "<html>";
                        content += "<body onload=\"window.print(); window.close();\">";
                        content += response;
                        content += "</body>";
                        content += "</html>";
                        win.document.write(content);
                        win.document.close();
                    },
                    error: function (response) {
                        console.log(response)
                        alert('error');
                    }
                });

            }

            function addNewOrder() {
                cartProducts = [];
                const myJSON = JSON.stringify(cartProducts);
                localStorage.setItem("admin_cart", myJSON);
                $("#nodata").show();
                $("#cartProductContainer").html('');
                location.reload();
            }
        </script>
    @endpush

@endsection

