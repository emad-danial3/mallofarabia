@extends('AdminPanel.layouts.main')
@section('content')

    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('products.index')}}">Products</a></li>

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
            <div class="card">

                <div class="card-header">


                        <form class="form-inline row" method="get" action="{{url('admin/products/change/barcode')}}">
                            <div class="form-group mx-sm-3 mb-2 col-md-3">
                                <label for="name" class="text-right mr-2">Product Name </label>
                                <input type="text" id="name" name="name" @if(isset($name) && $name !='' ) value="{{$name}}" @endif class="form-control" placeholder="Product Name">
                            </div>
                            <div class="form-group mx-sm-3 mb-2 col-md-3">
                                <label for="oracle_short_code" class="text-right mr-2">Item Code </label>
                                <input type="text" id="oracle_short_code" name="oracle_short_code" @if(isset($oracle_short_code) && $oracle_short_code !='' ) value="{{$oracle_short_code}}" @endif class="form-control" placeholder="Item Code" style="text-align: left">
                            </div>
                            <div class="form-group mx-sm-3 mb-2 col-md-3">
                                <label for="barcode" class="text-right mr-2">Barcode </label>
                                <input type="text" id="barcode" name="barcode" @if(isset($barcode) && $barcode !='' ) value="{{$barcode}}" @endif class="form-control" placeholder="BarCode" style="text-align: left">
                            </div>
                            <button type="submit" class="btn btn-primary mb-2 col-md-2">Search</button>
                        </form>


                </div>
            </div>

                <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">
                        <!-- /.card-header -->
                        <!-- form start -->

                        @if(isset($data))

                        @endif

                                        @if(isset($data))
                                            <table class="table table-striped" style="direction: ltr">
                                                <thead>
                                                <tr>
                                                    <th scope="col"><h3> Product ID</h3></th>
                                                    <th scope="col"><h3> Product Name</h3></th>
                                                    <th scope="col"><h3> Product Item</h3></th>
                                                    <th scope="col"><h3> Product Barcode</h3></th>
                                                    <th scope="col"><h3> Product Price</h3></th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                            <th scope="col"><h3> {{$data->id}}</h3></th>
                                            <th scope="col"><h3> {{$data->name_en}}</h3></th>
                                            <th scope="col"><h3> {{$data->oracle_short_code}}</h3></th>
                                            <th scope="col"><h3> {{$data->barcode}}</h3></th>
                                            <th scope="col"><h3> {{$data->price}} LE </h3> </th>
                                                </tbody>
                                            </table>
                                        @endif

                    </div>
                    <!-- /.card -->
                </div>
                <!--/.col (left) -->
                <!-- right column -->
                    @if(isset($data) && isset($data->id) && $data->id > 0)
                <div class="col-md-12">
                    <div class="card card-primary mr-5">
                        <input type="hidden" id="update_product_id" value="{{$data->id}}">
                        <div class="form-group mx-sm-3 mb-2 col-md-3 mt-4">
                                <label for="barcode" class="text-right mr-2">New Barcode </label>
                                <input type="text" id="newbarcode" name="newbarcode" @if(isset($data) && isset($data->barcode)) value="{{$data->barcode}}" @endif class="form-control" placeholder="Barcode" style="text-align: left">
                        </div>
                         <button id="updateBarcode" class="btn btn-primary mb-4 col-md-2 ml-4">Update</button>
                    </div>
                </div>
                @endif
                <!--/.col (right) -->
            </div>
            <!-- /.row -->
        </div><!-- /.container-fluid -->


    </section>
 @push('scripts')
        <script type="text/javascript">

              $(document).ready(function () {
   $("#updateBarcode").click(function () {
 var base_url            = window.location.origin;
                    console.log("updateBarcode Function");
                    let path     = base_url + "/admin/products/updateNewBarcode";
                    var update_product_id = $('#update_product_id').val();
                    var newbarcode = $('#newbarcode').val();
                    var ff       = {
                        "update_product_id": update_product_id,
                        "newbarcode": newbarcode,
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

                                 swal({
                                    text: "update Product ",
                                    title: "Successful",
                                    timer: 1500,
                                    icon: "success",
                                    buttons: false,
                                });

                                location.reload(true);
                            }
                        },
                        error: function (response) {
                            console.log(response)
                            alert('error');
                        }
                    });
                });
   });
        </script>

    @endpush
@endsection

