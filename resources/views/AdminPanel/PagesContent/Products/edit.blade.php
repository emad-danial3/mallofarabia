@extends('AdminPanel.layouts.main')
@section('content')


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('products.index')}}">Products</a></li>
                        <li class="breadcrumb-item active">{{isset($product)?'Edit / '.$product->full_name :'ADD'}}</li>
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
                        <form action="{{(isset($product))?route('products.update',$product):route('products.store')}}"
                              method="post" enctype="multipart/form-data">
                            @include('AdminPanel.layouts.messages')
                            @csrf
                            {{isset($product)?method_field('PUT'):''}}

                            <input type="hidden" name="id" class="form-control"
                                   value="@if(old('id')){{old('id')}}@elseif(isset($product->id)){{$product->id}}@endif"
                                   required>

                            <div class="card-body">
                                @if(! isset($products))
                                    <div class="form-group">
                                        <label for="name">oracle Code</label>
                                        <div class="row">
                                            <input type="text" name="oracle_code" class="form-control col-md-4"
                                                   placeholder="Enter Name" id="oracle_code">
                                            <select id="short_code" name="item_code" class="form-select form-control  col-md-4">
                                            </select>
                                            <input type="text" placeholder="Search By code.." id="myInput"
                                                   onkeyup="filterFunction()" class="form-control col-md-4">
                                        </div>

                                    </div>
                                @endif
                                <div class="form-group">
                                    <label for="name">full_name</label>
                                    <input type="text" name="full_name" class="form-control"
                                           placeholder="Enter Name"
                                           value="@if(old('full_name')){{old('full_name')}}@elseif(isset($product->full_name)){{$product->full_name}}@endif"
                                           required>
                                </div>

                                <div class="form-group">
                                    <label for="name">name_ar</label>
                                    <input type="text" name="name_ar" class="form-control"
                                           placeholder="Enter Name"
                                           value="@if(old('name_ar')){{old('name_ar')}}@elseif(isset($product->name_ar)){{$product->name_ar}}@endif"
                                           required>
                                </div>

                                <div class="form-group">
                                    <label for="name">name_en</label>
                                    <input type="text" name="name_en" class="form-control"
                                           placeholder="Enter Name"
                                           value="@if(old('name_en')){{old('name_en')}}@elseif(isset($product->name_en)){{$product->name_en}}@endif"
                                           required>
                                </div>

                                <div class="row">


                                    <div class="form-group col-md-3">
                                        <label for="name">price</label>

                                        @if(auth()->user()->id == 17 || !isset($product))
                                            <input type="number" name="price" id="price" class="form-control" step="any"
                                                   placeholder="Enter Price"
                                                   value="@if(old('price')){{old('price')}}@elseif(isset($product->price)){{$product->price}}@endif"
                                                   required>
                                        @else
                                            <input type="hidden" name="price" id="price"
                                                   value="@if(old('price')){{old('price')}}@elseif(isset($product->price)){{$product->price}}@endif"
                                            >
                                            <p>@if(old('price')){{old('price')}}@elseif(isset($product->price)){{$product->price}}@endif</p>
                                        @endif
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label for="nu">tax</label>
                                        <input type="number" name="tax" id="tax" class="form-control" step="0.01"
                                               placeholder="Enter Tax"
                                               value="@if(old('tax')){{old('tax')}}@elseif(isset($product->tax)){{$product->tax}}@endif"
                                               required>
                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="name">Discount Rate</label>

                                        @if(auth()->user()->id == 17 || !isset($product))

                                            <input type="number" name="discount_rate" id="discount_rate"
                                                   class="form-control" step="0.01"
                                                   placeholder="Enter discount Rate"
                                                   value="@if(old('discount_rate')){{old('discount_rate')}}@elseif(isset($product->discount_rate)){{$product->discount_rate}}@endif"
                                                   required>
                                        @else
                                            <input type="hidden" name="discount_rate" id="discount_rate"
                                                   value="@if(old('discount_rate')){{old('discount_rate')}}@elseif(isset($product->discount_rate)){{$product->discount_rate}}@endif"
                                            >
                                            <p>@if(old('discount_rate')){{old('discount_rate')}}@elseif(isset($product->discount_rate)){{$product->discount_rate}}@endif</p>
                                        @endif

                                    </div>
                                    <div class="form-group col-md-3">
                                        <label for="name">Old Price</label>
                                        <input type="number" name="old_price" id="old_price"
                                               class="form-control" step="0.01"
                                               placeholder="Old Price"
                                               value="@if(old('old_price')){{old('old_price')}}@elseif(isset($product->old_price)){{$product->old_price}}@endif"
                                               required>
                                    </div>


                                </div>


                                <div class="form-group">
                                    <input type="hidden" name="price_after_discount" id="price_after_discount"
                                           class="form-control"
                                           placeholder="Enter Name"
                                           value="@if(old('price_after_discount')){{old('price_after_discount')}}@elseif(isset($product->price_after_discount)){{$product->price_after_discount}}@endif"
                                           required>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="name">quantity</label>
                                        <input type="number" name="quantity" class="form-control"
                                               placeholder="Enter Name"
                                               value="@if(old('quantity')){{old('quantity')}}@elseif(isset($product->quantity)){{$product->quantity}}@endif"
                                               required>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="name">weight</label>
                                        <input type="number" name="weight" class="form-control" step="0.01"
                                               step="0.01" placeholder="Enter Name"
                                               value="@if(old('weight')){{old('weight')}}@elseif(isset($product->weight)){{$product->weight}}@endif"
                                               required>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="name">Barcode</label>
                                    <input type="text" name="barcode" id="barcode" class="form-control"
                                           placeholder="Enter barcode"
                                           value="@if(old('barcode')){{old('barcode')}}@elseif(isset($product->barcode)){{$product->barcode}}@endif"
                                           required>
                                </div>
                                <div class="form-group">
                                    <label for="name">description_ar</label>
                                    <input type="text" name="description_ar" id="description_ar" class="form-control"
                                           placeholder="Enter Name"
                                           value="@if(old('description_ar')){{old('description_ar')}}@elseif(isset($product->description_ar)){{$product->description_ar}}@endif"
                                           required>
                                </div>


                                <div class="form-group">
                                    <label for="name">description_en</label>
                                    <input type="text" name="description_en" class="form-control"
                                           placeholder="Enter Name"
                                           value="@if(old('description_en')){{old('description_en')}}@elseif(isset($product->description_en)){{$product->description_en}}@endif"
                                           required>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label for="name">Stock status</label>
                                        <select class="form-control" name="stock_status" id="stock_status">
                                            <option
                                                @if(isset($product->stock_status) && $product->stock_status  == 'out stock') {{'selected'}}@endif value="out stock">
                                                out stock
                                            </option>
                                            <option
                                                @if(isset($product->stock_status) && $product->stock_status  == 'in stock') {{'selected'}}@endif value="in stock">
                                                in stock
                                            </option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="name">Visible Status on web</label>
                                        <select class="form-control" name="visible_status" id="visible_status">
                                            <option
                                                @if(isset($product->visible_status) && $product->visible_status  == '1') {{'selected'}}@endif value="1">
                                                Yes
                                            </option>
                                            <option
                                                @if(isset($product->visible_status) && $product->visible_status  == '0') {{'selected'}}@endif value="0">
                                                No
                                            </option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label for="oracle_short_code">oracle short code</label>
                                    <input type="text" name="oracle_short_code" id="oracle_short_code"
                                           class="form-control"
                                           placeholder="Enter Name"
                                           value="@if(old('oracle_short_code')){{old('oracle_short_code')}}@elseif(isset($product->oracle_short_code)){{$product->oracle_short_code}}@endif"
                                           required>
                                </div>

                                <div class="form-group">
                                    <label for="image">Product Image</label>
                                    <input type="file" class="form-control" name="image"
                                           @if(!isset($product))required @endif>
                                    <br>
                                    @if(isset($product->image))

                                        @if(strlen($product->image) > 35)
                                            <img src="{{$product->image}}" width="250" height="250">
                                        @else
                                            <img src="{{url($product->image)}}" width="250" height="250">
                                        @endif


                                    @endif
                                </div>

                                @if(isset($categories))
                                    <div class="form-group">
                                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="name">
                                            Category
                                        </label>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <select name="category_id" class="form-control col-md-12 col-xs-12">
                                                @foreach($categories as $category)
                                                    <option value="{{$category->id}}">
                                                        @if(isset($category->parent)&& isset($category->parent->name_en)){{$category->parent->name_en}} @endif
                                                        =>
                                                        {{$category->name_en}}
                                                        {{--                                                        <br> || {{$category->name_en}}--}}
                                                        {{--                                                        <br> || {{$category->level}}--}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif

                                @if(isset($companies))
                                    <div class="form-group">
                                        <label class="control-label col-md-12 col-sm-12 col-xs-12" for="name">
                                            Company For Invoice
                                        </label>
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <select name="flag" class="form-control col-md-12 col-xs-12">
                                                @foreach($companies as $company)
                                                    <option
                                                        @if(isset($product->flag) && $product->flag==$company->id){{'selected'}}@endif  value="{{$company->id}}">
                                                        {{$company->name_ar}}
                                                        <br> || {{$company->name_en}}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                @endif
                                <div class="row" style="border: 1px solid #e7e7e7;border-radius: 5px;">
                                    <h3 class="col-md-12">Product Forms Sizes & Colors</h3>
                                    <div class="col-md-12">
                                        <table class="table table-striped">
                                            <thead>
                                            <tr>
                                                <th scope="col">Option</th>
                                                <th scope="col">Value</th>
                                                <th scope="col">Quantity</th>
                                                <th scope="col">Price</th>
                                                <th scope="col">Action</th>
                                            </tr>
                                            </thead>
                                            <tbody id="productForms">

                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="row">
                                            <div class="col-md-2">
                                                <div class="form-group mb-2">
                                                    <label for="options" class="sr-only">Option</label>
                                                    <select class="form-control" id="options">
                                                        <option>Chose Option</option>
                                                        @foreach($options as $option)
                                                            <option value="{{$option->id}}" name="{{$option->name_en}}">
                                                                {{$option->name_en}}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="form-group mb-2">
                                                    <label for="option" class="sr-only">Option Value</label>
                                                    <select class="form-control " id="optionValues">

                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group mb-2">
                                                    <label for="optionQuantity" class="sr-only">Quantity</label>
                                                    <input type="number" min="0" class="form-control" id="optionQuantity" placeholder="Quantity">
                                                </div>
                                            </div>
                                            <div class="col-md-3">
                                                <div class="form-group mb-2">
                                                    <label for="optionPrice" class="sr-only">Price</label>
                                                    <input type="number" min="0" class="form-control" id="optionPrice" placeholder="Price">

                                                </div>
                                            </div>

                                            <div class="col-md-2">
                                                <button type="button" class="btn btn-primary" id="addFormButton">
                                                    Add Form
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Save Info</button>
                            </div>
                        </form>
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
        @if(isset($product))

            <x-products.product-category :productId="$product->id" :categories="$product->productCategory"
                                         :newCategories="$newCategories"></x-products.product-category>
        @endif

    </section>

    @push('scripts')
        <script type="text/javascript">
            $('#price').on('change', function () {
                var new_price = this.value - ((this.value * $('#discount_rate').val()) / 100)
                $('#price_after_discount').val(new_price);
            });

            $('#discount_rate').on('change', function () {

                var new_price = $('#price').val() - (($('#price').val() * this.value) / 100)
                $('#price_after_discount').val(new_price);
            });

            $('#options').on('change', function () {

                var optionSelected = $("option:selected", this);
                var valueSelected  = optionSelected.val();

                $.ajax({
                    type: "GET",
                    url: "{{route('getOptionValues')}}",
                    cache: false,
                    data: {id: valueSelected},
                    dataType: "json",
                    success: function (response) {
                        $('#optionValues').html('');
                        if (response.data.length > 0) {
                            for (let iii = 0; iii < response.data.length; iii++) {
                                let proObjff = response.data[iii];
                                let option   = '<option value="' + proObjff['id'] + '" name="' + proObjff['name_en'] + '">' + proObjff['name_en'] + '</option>';
                                $('#optionValues').append(option);
                            }
                        }
                    },
                    fail: function (Error) {
                        console.log(Error)
                    }
                });
            });


            $(document).ready(function () {
                // $('#oracle_code').focusout(function(){
                var item_code = $(this).val();
                $('#short_code option').remove();
                $.ajax({
                    type: "GET",
                    url: "{{route('getOracleProducts')}}",
                    cache: false,
                    data: {item_code: item_code},
                    dataType: "json",
                    success: function (data) {
                        // console.log(data);
                        $.each(data, function (k, v) {
                            $('#short_code').append("<option class='form-control col-md-12 col-xs-12'   value=" + v['id'] + " >" + v['item_code'] + " </option>");
                        });
                    },
                    fail: function (Error) {
                        console.log(Error)
                    }
                });

                $('#short_code').on('change', function (e) {
                    var optionSelected = $("option:selected", this);
                    var valueSelected  = optionSelected.val();
                    $.ajax({
                        type: "GET",
                        url: "{{route('getOracleProduct')}}",
                        cache: false,
                        data: {id: valueSelected},
                        dataType: "json",
                        success: function (data) {
                            $('#price').val(data['cust_price']);
                            $('#tax').val(data['percentage_rate']);
                            $('#description_ar').val(data['description']);
                            $('#oracle_short_code').val(data['item_code']);
                        },
                        fail: function (Error) {
                            console.log(Error)
                        }
                    });
                });

                // });

                $("#addFormButton").click(function () {

                    console.log("fdfdfd 11");
                    var option_id       = $('#options').val();
                    var option_value_id = $('#optionValues').val();
                    var option_quantity = $('#optionQuantity').val();
                    var option_price    = $('#optionPrice').val();
                    if (option_id > 0 && option_value_id > 0 && option_quantity > 0 && option_price > 0) {
                        var op_name         = $("#options option:selected");
                        var option_name     = op_name.attr('name');
                        var op_val          = $("#optionValues option:selected");
                        var option_val_name = op_val.attr('name');
                        $("#productForms").append(
                            '<tr><td> ' +
                            '  <input type="hidden" name="options[]" value="' + option_id + '"> <input type="hidden" name="optionValues[]" value="' + option_value_id + '"> <input type="hidden" name="optionQuantity[]" value="' + option_quantity + '"> <input type="hidden" name="optionPrice[]" value="' + option_price + '">'
                            + option_name + ' </td><td>' + option_val_name + '</td><td>' + option_quantity + '</td><td>' + option_price + '</td><td ><button type="button" onclick="this.parentElement.parentElement.style.display=`none`" style="border: 0px;color: red;">X</button></td></tr>'
                        );
                    }
                    $('#optionValues').html('');
                });

            });


            function filterFunction() {
                var input,
                    filter,
                    ul,
                    li,
                    a,
                    i;
                input  = document.getElementById("myInput");
                filter = input.value.toUpperCase();
                div    = document.getElementById("short_code");
                console.log(div)
                a = div.getElementsByTagName("option");
                console.log(a)
                for (i = 0; i < a.length; i++) {
                    txtValue = a[i].textContent || a[i].innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        a[i].style.display = "";
                    }
                    else {
                        a[i].style.display = "none";
                    }
                }
            }

        </script>
    @endpush
@endsection
