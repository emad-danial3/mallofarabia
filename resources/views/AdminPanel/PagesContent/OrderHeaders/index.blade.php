@extends('AdminPanel.layouts.main')
@section('content')
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
                        <li class="breadcrumb-item active"><a href="{{route('orderHeaders.index')}}">Orders</a></li>
                    </ol>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    @include('AdminPanel.layouts.messages')

    <div class="card">
        <div class="card-body">
             <div class="card-header" style="float: right">
            <h3 class="card-title">
                <form method="post" action="{{route('orderHeaders.importOrderSheet')}}" enctype="multipart/form-data">
                    @csrf
                    <input type="file"  name="file" required>
                    <button type="submit" class="btn btn-danger">Import Orders Paid & Delivry Sheet</button>
                </form>
            </h3>
        </div>
        </div>
        <div class="card-body">
            <form method="post" action="{{route('orderHeaders.ExportOrderHeadersSheet')}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-3">
                        <label class="col-form-label" for="start_date">Start Date</label>
                        <input type="date" name="start_date" class="form-control" required>
                    </div>
                    <div class="form-group col-3">
                        <label class="col-form-label " for="end_date">End Date</label>
                        <input type="date" name="end_date" class="form-control" required>
                    </div>
                    <div class="form-group col-3">
                        <label class="col-form-label" for="with"> With</label>
                        <select name="with" class="form-control">
                            <option value="user">User</option>
                            <option value="products">Products</option>
                        </select>
                    </div>

                    <div class="form-group col-3">
                        <input type="hidden" name="payment_status" id="payment_status">
                        <label class="col-form-label"> <i class="fa fa-file"></i> </label>
                        <button type="submit" class="btn btn-success form-control">Exports Orders Sheet</button>
                    </div>
                </div>
            </form>
            <form method="get" action="{{route('orderHeaders.index')}}">

                <div class="row">
                    <div class="form-group col-1">

                        <label>Payment Way</label>
                        <select name="wallet_status" class="form-control">
                            <option value="">Select Way</option>
                            <option value="cash" @if(app('request')->input('wallet_status') == 'cash')selected @endif>
                                Cash
                            </option>
                            <option value="only_fawry" @if(app('request')->input('wallet_status') == 'only_fawry')selected @endif>
                                Fawry
                            </option>
                            <option value="visa" @if(app('request')->input('wallet_status') == 'visa')selected @endif>
                                Visa
                            </option>

                        </select>

                    </div>
                    <div class="form-group col-1">
                        <label>Sent Oracle</label>
                        <select name="send_t_o" class="form-control">
                            <option value="">Select Status</option>
                            <option value="1" @if(app('request')->input('send_t_o') == '1')selected @endif>
                                Sent
                            </option>
                            <option value="0" @if(app('request')->input('send_t_o') == '0')selected @endif>
                                Not Sent Yet
                            </option>

                        </select>

                    </div>
                    <div class="col-md-3 row ">
                            <div class="form-group col-6">
                                <label class="col-form-label" for="name">Invoice Number</label>
                                <input type="text" name="name" class="form-control" id="name"  @if(app('request')->input('name'))value="{{app('request')->input('name')}}" @endif placeholder=" Invoice Number">
                            </div>
                            <div class="form-group col-6">
                                <label class="col-form-label" for="user_serial_number">User Serial Number</label>
                                <input type="text" name="user_serial_number" class="form-control" id="user_serial_number" @if(app('request')->input('user_serial_number'))value="{{app('request')->input('user_serial_number')}}" @endif placeholder="Serial Number">
                            </div>
                    </div>

                    <div class="col-3 row">
                        <div class="form-group col-6">
                            <label class="col-form-label" for="phone">User Phone</label>
                            <input type="text" name="phone" class="form-control" id="phone" @if(app('request')->input('phone'))value="{{app('request')->input('phone')}}" @endif placeholder="User phone">
                        </div>
                        <div class="form-group col-6">
                            <label class="col-form-label" for="user_name">User name</label>
                            <input type="text" name="user_name" class="form-control" id="user_name"  @if(app('request')->input('user_name'))value="{{app('request')->input('user_name')}}" @endif placeholder="User Name">
                        </div>
                    </div>
                    <div class="row col-3">
                        <div class="form-group col-6">
                            <label class="col-form-label" for="from_date">From Date</label>
                            <input type="date" name="from_date" id="from_date" @if(app('request')->input('from_date'))value="{{app('request')->input('from_date')}}" @endif class="form-control">
                        </div>
                        <div class="form-group col-6">
                            <label class="col-form-label"  for="to_date">To Date</label>
                            <input type="date" name="to_date"  @if(app('request')->input('to_date'))value="{{app('request')->input('to_date')}}" @endif id="to_date" class="form-control">
                        </div>
                    </div>
                    <div class="form-group col-1">
                        <label class="col-form-label"><i class="fa fa-search"></i></label>
                        <button type="submit" class="btn btn-info form-control">Search</button>
                    </div>
                </div>

            </form>
        </div>


        <div class="form-group">
            <label>Payment Status</label>
            <select name="type" class="form-control" id="orderType">
                <option value="">Select Type</option>
                <option value="" @if(app('request')->input('type') == '')selected @endif>All</option>
                <option value="PENDING" @if(app('request')->input('type') == 'PENDING')selected @endif>PENDING</option>
                <option value="PAID" @if(app('request')->input('type') == 'PAID')selected @endif>PAID</option>
                <option value="EXPIRED" @if(app('request')->input('type') == 'EXPIRED')selected @endif>EXPIRED</option>
                <option value="DELETED" @if(app('request')->input('type') == 'DELETED')selected @endif>DELETED</option>
                <option value="CANCELED" @if(app('request')->input('type') == 'CANCELED')selected @endif>CANCELED
                </option>
            </select>
        </div>

        <!-- /.card-header -->
        <div class="card-body" style="overflow-x:scroll">
            @if(count($orderHeaders) > 0)
                <table id="orderHeadersTable" style="width: 100%" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th><input type="checkbox" id="select-all"></th>
                        <th>Invoice Number</th>
                        <th>Payment Code</th>
                        <th>Total Order</th>
                        <th>Discount Amount</th>
                        <th>User Name</th>
                        <th>User Type</th>
                        <th>User Serial Number</th>
                        <th>User phone</th>
                        <th>payment_status</th>
                        <th>User email</th>
                        <th>User Address</th>
                        <th>User City</th>
                        <th>User Area</th>
                        <th>User NationalID</th>
                        <th>Shipping Amount</th>
                        <th>Order Status</th>
                        <th>Shipping Date</th>
                        <th>Delivery Date</th>
                        <th>wallet_status</th>
                        <th>Send to oracle</th>
                        <th>printed</th>

                        <th>View</th>
                        <th>Print</th>
                        {{--                        <th>Charge</th>--}}

                        <th>Cancel Order</th>
                        @if(Auth::guard('admin')->user()->id == 17)
                            <th>Refund</th>
                        @endif
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orderHeaders as $row)
                        <tr>
                            <td><input type="checkbox" name="checkbox[]" value="{{$row->id}}"/></td>
                            <td>{{$row->id}}</td>
                            <td>{{$row->payment_code}}</td>
                            <td>{{$row->total_order}}</td>
                            <td>{{$row->discount_amount}}</td>
                            <td>{{($row->user)?$row->user->full_name:''}}</td>
                            <td>{{($row->user)?$row->user->user_type:''}}</td>
                            <td>{{(isset($row->user))?$row->user->account_id:''}}</td>
                            <td>{{(isset($row->user))?$row->user->phone:''}}</td>
                            <td>{{$row->payment_status}}</td>
                            <td>{{(isset($row->user))?$row->user->email:''}}</td>
                            <td>{{(isset($row->address) &&isset($row->address->address))?$row->address->address:''}}</td>
                            <td>{{(isset($row->address) &&isset($row->address->city))?$row->address->city->name_en:''}}</td>
                            <td>{{(isset($row->address) &&isset($row->address->area))?$row->address->area->region_en:''}}</td>
                            <td>{{(isset($row->user))?$row->user->nationality_id :''}}</td>
                            <td>{{$row->shipping_amount}}</td>
                            <td>{{$row->order_status}}</td>
                            <td>{{$row->shipping_date}}</td>
                            <td>{{$row->delivery_date}}</td>
                            <td>{{$row->wallet_status}}</td>
                            <td>
                                {{(isset($row->send_t_o) && $row->send_t_o == '1')? "Yes" : 'NO'}}
                                @if((isset($row->send_t_o) && $row->send_t_o == '0'&& $row->wallet_status == 'cash'&& $row->payment_status == 'PENDING'))
                                    <form method="post" action="{{route('sendOrderToOracleNotSending')}}" enctype="multipart/form-data">
                                        @csrf
                                        <div class="row">
                                            <input type="hidden" name="order_id" class="form-control" value="{{$row->id}}">
                                            <div class="form-group col-12 mb-0">
                                                <button type="submit" class="btn btn-success form-control">
                                                    Send
                                                </button>
                                            </div>
                                        </div>
                                    </form>
                                @endif
                            </td>
                            <td>{{(isset($row->is_printed) && $row->is_printed == '1')? "Yes" : 'NO'}}
                                @if((isset($row->is_printed) && $row->is_printed == '1'))
                                    <button type="button" class="btn btn-info" data-toggle="modal" data-target="#examplePrintedModal" onclick="getAdminPrinteOrder({{$row->id}})">
                                        Show
                                    </button>
                                @endif

                            </td>

                            <td>
                                <a class="btn btn-primary" href="{{route('orderHeaders.view',$row)}}" target="_blank">View</a>
                            </td>
                            <td>
                                <a class="btn btn-success" href="{{route('orderHeaders.show',$row)}}" target="_blank">Print
                                    Invoice</a>
                            </td>
                            {{--                            <td>--}}

                            {{--                                <div class="dropdown">--}}
                            {{--                                    <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">--}}
                            {{--                                        charge Operation--}}
                            {{--                                    </button>--}}
                            {{--                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">--}}
                            {{--                                        <a class="dropdown-item" href="#">--}}

                            {{--                                            @if($row->payment_status== 'PAID' || ($row->wallet_status== 'cash' && $row->order_status != 'Cancelled' ))--}}
                            {{--                                                <button type="button" class="btn btn-primary form-control" data-toggle="modal" data-target="#exampleModalCenter" onclick="goToSpecificCharge('{{$row->id}}','{{($row->createdFor)?$row->createdFor->full_name:''}}','{{(isset($row->createdFor))?$row->createdFor->phone:''}}','{{(isset($row->createdFor))?$row->address:''}}')">--}}
                            {{--                                                    شحن--}}
                            {{--                                                </button>--}}
                            {{--                                            @endif--}}

                            {{--                                        </a>--}}
                            {{--                                        <a class="dropdown-item" href="#">--}}
                            {{--                                            @if($row->payment_status== 'PAID'&& $row->waybillNumber)--}}
                            {{--                                                <form method="post" action="{{route('orderHeaders.changeOrderChargeStatus')}}" enctype="multipart/form-data">--}}
                            {{--                                                    @csrf--}}
                            {{--                                                    <div class="row">--}}
                            {{--                                                        <input type="hidden" name="order_id" class="form-control" value="{{$row->id}}">--}}
                            {{--                                                        <div class="form-group col-12 mb-0">--}}
                            {{--                                                            <button type="submit" class="btn btn-success form-control">--}}
                            {{--                                                                تحديث--}}
                            {{--                                                            </button>--}}
                            {{--                                                        </div>--}}
                            {{--                                                    </div>--}}
                            {{--                                                </form>--}}
                            {{--                                            @endif--}}
                            {{--                                        </a>--}}
                            {{--                                        <a class="dropdown-item" href="#">--}}
                            {{--                                            @if($row->payment_status== 'PAID' && $row->waybillNumber)--}}

                            {{--                                                <button type="button" class="btn btn-info form-control" data-toggle="modal" data-target="#exampleModalCreatePickupRequest" onclick="goToSpecificPickup('{{$row->id}}')">--}}
                            {{--                                                    تحميل--}}
                            {{--                                                </button>--}}

                            {{--                                            @endif--}}
                            {{--                                        </a>--}}
                            {{--                                        <a class="dropdown-item" href="#">--}}
                            {{--                                            @if($row->payment_status== 'PAID'&& $row->waybillNumber)--}}
                            {{--                                                <button type="button" class="btn btn-danger form-control" data-toggle="modal" data-target="#exampleModalCancelRequest" onclick="goToSpecificCancel('{{$row->id}}','{{$row->waybillNumber}}')">--}}
                            {{--                                                    الغاء الشحن--}}
                            {{--                                                </button>--}}
                            {{--                                            @endif--}}
                            {{--                                        </a>--}}
                            {{--                                    </div>--}}
                            {{--                                </div>--}}


                            {{--                            </td>--}}
                            <td>
                                @if($row->wallet_status == 'cash' && $row->order_status != 'Cancelled')
                                    <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#exampleModalCancelOrderRequest" onclick="goToSpecificCancelOrder('{{$row->id}}')">
                                        الغاء الطلب
                                    </button>
                                @endif
                            </td>
                            @if(Auth::guard('admin')->user()->id == 17)
                                <td>
                                    <a class="btn btn-success" href="{{route('orderHeaders.edit',$row)}}" target="_blank">Refund
                                        Invoice</a>
                                </td>
                            @endif
                            <td>{{$row->created_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>
                    {{--                    <tfoot>--}}
                    {{--                    <tr>--}}
                    {{--                        <th> <input type="checkbox" id="select-all"></th>--}}
                    {{--                        <th>Invoice Number</th>--}}
                    {{--                        <th>payment_code</th>--}}
                    {{--                        <th>total_order</th>--}}
                    {{--                        <th>User Name</th>--}}
                    {{--                        <th>User Serial Number</th>--}}
                    {{--                        <th>order_type</th>--}}
                    {{--                        <th>shipping_amount</th>--}}
                    {{--                        <th>payment_status</th>--}}
                    {{--                        <th>order_status</th>--}}
                    {{--                        <th>shipping_date</th>--}}
                    {{--                        <th>delivery_date</th>--}}
                    {{--                        <th>wallet_status</th>--}}
                    {{--                        <th>wallet_used_amount</th>--}}
                    {{--                        <th>gift_category_id</th>--}}
                    {{--                        <th>Date</th>--}}
                    {{--                        <th>Control</th>--}}
                    {{--                    </tr>--}}
                    {{--                    </tfoot>--}}
                </table>
                <div class="pagination justify-content-center mt-2">

                    @if (isset($orderHeaders) && $orderHeaders->lastPage() > 1)
                        <ul class="pagination align-items-center">
                        @php
                            $interval = isset($interval) ? abs(intval($interval)) : 3 ;
                            $from = $orderHeaders->currentPage() - $interval;
                            if($from < 1){
                              $from = 1;
                            }

                            $to = $orderHeaders->currentPage() + $interval;
                            if($to > $orderHeaders->lastPage()){
                              $to = $orderHeaders->lastPage();
                            }
                        @endphp
                        <!-- first/previous -->
                            @if($orderHeaders->currentPage() > 1)
                                <li class="page-item">
                                    <a href="{{ $orderHeaders->url(1)."&type=".app('request')->input('type')}}" aria-label="First" class="page-link">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a href="{{ $orderHeaders->url($orderHeaders->currentPage() - 1)."&type=".app('request')->input('type') }}" aria-label="Previous" class="page-link">
                                        <span aria-hidden="true">&lsaquo;</span>
                                    </a>
                                </li>
                            @endif
                        <!-- links -->
                            @for($i = $from; $i <= $to; $i++)
                                @php
                                    $isCurrentPage = $orderHeaders->currentPage() == $i;
                                @endphp
                                <li class="page-item {{ $isCurrentPage ? 'active' : '' }}" style="padding: 5px">
                                    <a class="page-link" href="{{ !$isCurrentPage ? $orderHeaders->url($i)."&type=".app('request')->input('type') : '' }}">
                                        {{ $i }}
                                    </a>
                                </li>
                            @endfor
                        <!-- next/last -->
                            @if($orderHeaders->currentPage() < $orderHeaders->lastPage())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $orderHeaders->url($orderHeaders->currentPage() + 1)."&type=".app('request')->input('type') }}" aria-label="Next">
                                        <span aria-hidden="true">&rsaquo;</span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="{{ $orderHeaders->url($orderHeaders->lastpage())."&type=".app('request')->input('type') }}" aria-label="Last">
                                        <span aria-hidden="true">&raquo;</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    @endif
                </div>

            @else
                <h1 class="text-center">NO DATA</h1>
            @endif


        </div>
        <!-- /.card-body -->
    </div>


    <!-- Modal -->
    <div class="modal fade" id="examplePrintedModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Admin Printed</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Admin name</th>
                            <th scope="col">Date</th>

                        </tr>
                        </thead>
                        <tbody id="adminsprintedcontaier">
                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>


    <button onclick="window.scrollTo({ left: 0, top: document.body.scrollHeight, behavior: 'smooth' })" id="myBtn" title="Go to bottom">
        <i class="fa-sharp fa-solid fa-chevron-down"></i></button>
    <button onclick="window.scrollTo({ left: 0, top: 0, behavior: 'smooth' })" id="myBtn2" title="Go to bottom">
        <i class="fa-sharp fa-solid fa-chevron-up"></i></button>



    <!-- Modal for CreateWaybill -->
    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Order address</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('orderHeaders.ExportOrderCharge')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="category">City</label>
                                <select id="category" name="user_city" required class="form-control">
                                    <option value="">select City</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="subcategory">Area</label>
                                <select id="subcategory" name="user_area" class="form-control">
                                </select>
                            </div>
                        </div>

                        <div class="row">
                            <input type="hidden" name="order_id" id="order_id" class="form-control">
                            <input type="hidden" name="user_name" id="user_name_charge" class="form-control">
                            <input type="hidden" name="user_phone" id="user_phone" class="form-control">
                            {{--                            <input type="hidden" name="user_city" class="form-control" >--}}
                            <input type="hidden" name="user_address" id="user_address" class="form-control">
                            {{--                            <input type="hidden" name="user_area" class="form-control" >--}}
                            <div class="form-group col-12">
                                <button type="submit" class="btn btn-success form-control" onclick="$('#exampleModalCenter').modal('hide');">
                                    شحن
                                </button>
                            </div>
                        </div>
                    </form>


                </div>

            </div>
        </div>
    </div>



    <!-- Modal CreatePickupRequest -->
    <div class="modal fade" id="exampleModalCreatePickupRequest" tabindex="-1" role="dialog" aria-labelledby="exampleModalCreatePickupRequestTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Order Pickup</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('orderHeaders.CreatePickupRequest')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="form-group col-md-12">
                                <label for="categoryPickup">City</label>
                                <select id="categoryPickup" name="user_city" required class="form-control">
                                    <option value="">select City</option>
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="subcategoryPickup">Area</label>
                                <select id="subcategoryPickup" name="user_area" class="form-control">
                                </select>
                            </div>
                            <div class="form-group col-md-12">
                                <label for="user_area">Pickup Date</label>
                                <input class="form-control" type="date" id="pickupDate" name="pickupDate" placeholder="pickup Date" required>
                            </div>
                        </div>
                        <div class="row">
                            <input type="hidden" name="order_id" id="order_id_pickup" class="form-control">
                            <div class="form-group col-12">
                                <button type="submit" class="btn btn-success form-control" onclick="$('#exampleModalCreatePickupRequest').modal('hide');">
                                    تحميل
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create Cancel Request -->
    <div class="modal fade" id="exampleModalCancelRequest" tabindex="-1" role="dialog" aria-labelledby="exampleModalCancelRequestTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Order Cancel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('orderHeaders.cancelOrderCharge')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <h5 class="modal-title" id="exampleModalLongTitle">Do You want to Cancel Order</h5>
                            <br>
                            <br>
                            <input type="hidden" name="order_id" id="order_id_cancel" class="form-control">
                            <input type="hidden" name="waybillNumber" id="waybillNumber_cancel" class="form-control">
                            <div class="form-group col-12">
                                <button type="submit" class="btn btn-success form-control" onclick="$('#exampleModalCancelRequest').modal('hide');">
                                    Yes cancel
                                </button>
                            </div>
                        </div>


                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Create Cancel Order Request -->
    <div class="modal fade" id="exampleModalCancelOrderRequest" tabindex="-1" role="dialog" aria-labelledby="exampleModalCancelOrderRequestTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLongTitle">Order Cancel</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form method="post" action="{{route('orderHeaders.cancelOrderQuantity')}}" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <h5 class="modal-title col-md-12" id="exampleModalLongTitle">Do You want to Cancel Order And Return
                                Quantity ?</h5>

                            <div class="col-md-12 ">
                                 <input type="hidden" name="order_id" id="order_id_cancel_order" class="form-control">
                                     <label for="canceled_reason">Enter Reason</label>
                                     <textarea name="canceled_reason" id="canceled_reason" class="form-control" required></textarea>
                          <br>
                            </div>


                            <br>
                            <div class="form-group col-12">
                                <button type="submit" class="btn btn-success form-control" >
                                    Yes cancel
                                </button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script type="text/javascript">
            var base_url = window.location.origin;

            function urlParamfun(name) {
                var results = new RegExp('[\?&]' + name + '=([^&#]*)').exec(window.location.href);
                if (results == null) {
                    return null;
                }
                else {
                    return results[1] || 0;
                }
            }

            function getAdminPrinteOrder(order_id) {
                let path = base_url + "/admin/orderHeaders/getAdminPrinteOrder";
                console.log("path", path);
                $("#adminsprintedcontaier").html('');
                var dataObj = {
                    "order_id": order_id
                }

                $.ajax({
                    url: path,
                    type: 'POST',
                    cache: false,
                    data: JSON.stringify(dataObj),
                    contentType: "application/json; charset=utf-8",
                    traditional: true,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    processData: false,
                    success: function (response) {
                        if (response.data) {
                            if (response.status && response.status == 200) {
                                $("#adminsprintedcontaier").html('');
                                for (let ii = 0; ii < response.data.length; ii++) {
                                    let adobj = response.data[ii];
                                    if (adobj['admin']) {
                                        $("#adminsprintedcontaier").append(
                                            ' <tr> ' +
                                            ' <th scope="row">' + (ii + 1) + '</th> '
                                            + ' <th scope="row">' + adobj['admin']['name'] + '</td><td> ' + new Date(adobj['created_at']).toLocaleString() + ' </td></tr>'
                                        );
                                    }
                                }
                                console.log(response)
                            }
                            else {
                                console.log("error  error");
                                console.log(response);
                            }
                        }
                    },
                    error: function (response) {
                        console.log(response)
                        alert('error');
                    }
                });

            }

            $("#orderType").change(function () {

                $('.loader').show();
                $('#orderHeadersTable').hide();
                var newtype = $(this).val();

                let path = base_url + "/admin/orderHeaders/getAllOrdersWithType";
                console.log("path", path);

                var dataObj = {
                    "type": newtype
                }

                $.ajax({
                    url: path,
                    type: 'POST',
                    cache: false,
                    data: JSON.stringify(dataObj),
                    contentType: "application/json; charset=utf-8",
                    traditional: true,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    processData: false,
                    success: function (response) {
                        if (response.data) {
                            console.log(response);
                            if (response.status && response.status == 200) {
                                if (newtype == '') {
                                    window.location.href = "{{route('orderHeaders.index')}}"
                                }
                                window.location.href = "{{route('orderHeaders.index')}}?type=" + newtype;
                            }
                            else {
                                console.log("error  error");
                                console.log(response);
                            }
                            window.scrollTo({left: 0, top: document.body.scrollHeight, behavior: 'smooth'})
                        }
                    },
                    error: function (response) {
                        console.log(response)
                        alert('error');
                    }
                });

            });

            $('#select-all').click(function () {
                var checked = this.checked;
                $('input[type="checkbox"]').each(function () {
                    this.checked = checked;
                });
            })

            $(document).ready(function () {
                var type = urlParamfun('type');
                console.log(type);
                $("#payment_status").val(type);

                var allareasR2S = {
                    "ALSHARQIA": [
                        "10th of Ramdan City",
                        "Abu Hammad",
                        "Abu Kbeer",
                        "Al Hasiniya",
                        "Al Ibrahimiya",
                        "Al Salhiya Al Gedida",
                        "Al Sharqia",
                        "Awlad Saqr",
                        "Belbes",
                        "Darb Negm",
                        "Faqous",
                        "Hehya",
                        "Kafr Saqr",
                        "Mashtool Al Sooq",
                        "Meniya Alqamh",
                        "Zakazik"
                    ],
                    "ALEXANDRIA": [
                        "Abees",
                        "Abu Keer",
                        "Al Amriah",
                        "Al Bitash",
                        "Al Nahda Al Amria",
                        "Al Soyof",
                        "Alexandria",
                        "Asafra",
                        "Awaied-Ras Souda",
                        "Azarita",
                        "Bangar EL Sokar",
                        "Borg El Arab",
                        "City Center",
                        "El Borg El Kadem",
                        "El-Agamy",
                        "Glem",
                        "Kafer Abdou",
                        "Khorshid",
                        "Luran",
                        "Maamora",
                        "Mahtet El-Raml",
                        "Mandara",
                        "Manshia",
                        "Miami",
                        "Muntazah",
                        "Roshdy",
                        "San Stefano",
                        "Sedi Bisher",
                        "Sedi Gaber",
                        "Sedi Kreir",
                        "Smouha",
                        "Sporting",
                        "Stanly",
                        "Zezenya"
                    ],
                    "CAIRO": [
                        "Ain Shams",
                        "Al Azhar",
                        "Al Daher",
                        "Al Kalaa",
                        "Al Kasr Al Einy",
                        "Al Matareya",
                        "Al Moski",
                        "Al Rehab",
                        "Al Salam City",
                        "Al Zeitoun",
                        "Almaza",
                        "Amiria",
                        "Badr City",
                        "Cairo",
                        "Cornish Al Nile",
                        "Dar Al Salam",
                        "Down Town",
                        "El Herafieen",
                        "EL Marg",
                        "El Shorouk",
                        "El Tahrir",
                        "Ezbet El Nakhl",
                        "Fustat",
                        "Garden City",
                        "Gesr Al Suez",
                        "Ghamrah",
                        "Hadayek Al Qobah",
                        "Hadayek Al Zaiton",
                        "Hadayek Helwan",
                        "Hadayek Maadi",
                        "Heliopolis",
                        "Helmeya",
                        "Helmiet Elzaitoun",
                        "Helwan",
                        "Katamiah",
                        "Maadi",
                        "Maadi Degla",
                        "Madinty",
                        "Manial Al Rodah",
                        "Masaken Sheraton",
                        "Mirage City",
                        "Misr El Kadima",
                        "Mokattam",
                        "Nasr City",
                        "New Cairo",
                        "New El Marg",
                        "New Maadi",
                        "New Nozha",
                        "Ramsis",
                        "Rod El Farag",
                        "Sayeda Zeinab",
                        "Shubra",
                        "Zamalek"
                    ],
                    "GIZA": [
                        "6th of October",
                        "Agouza",
                        "Al Kom Al Ahmer",
                        "Al Moatamadia",
                        "Al Monib",
                        "Al Nobariah",
                        "Bolak Al Dakrour",
                        "Dokki",
                        "Faisal",
                        "Giza",
                        "Hadayeq El Ahram",
                        "Haram",
                        "Imbaba",
                        "Kit Kat",
                        "Manial",
                        "Mohandessin",
                        "Omraneya",
                        "Qism el Giza",
                        "Sakiat Mekki",
                        "Sheikh Zayed",
                        "Smart Village",
                        "Tirsa",
                        "Warraq"
                    ],
                    "ASYUT": [
                        "Abnoub",
                        "Abou Teag",
                        "Assuit Elgdeda",
                        "Asyut",
                        "Dayrout",
                        "El Badari",
                        "El Ghnayem",
                        "El Qusya",
                        "Elfath",
                        "Manflout",
                        "Sahel Selim",
                        "Serfa"
                    ],
                    "ALMENIYA": [
                        "Abo Korkas",
                        "Al Meniya",
                        "Bani Mazar",
                        "Dermwas",
                        "Eladwa",
                        "Malawi",
                        "Matai",
                        "Mghagha",
                        "Minya",
                        "Samaloot"
                    ],
                    "ISMAILIA": [
                        "Abo Sultan",
                        "Abu Swer",
                        "El Tal El Kebir",
                        "Elsalhia Elgdida",
                        "Fayed",
                        "Ismailia",
                        "Nfeesha",
                        "Qantara Gharb",
                        "Qantara Sharq",
                        "Srabioom"
                    ],
                    "ALBEHEIRA": [
                        "Abou Al Matamer",
                        "Abu Hummus",
                        "Al Beheira",
                        "Al Delengat",
                        "Al Mahmoudiyah",
                        "Al Rahmaniyah",
                        "Damanhour",
                        "Edfina",
                        "Edko",
                        "El Nubariyah",
                        "Etay Al Barud",
                        "Hosh Issa",
                        "Kafr El Dawwar",
                        "Kom Hamadah",
                        "Rashid",
                        "Shubrakhit",
                        "Wadi Al Natroun"
                    ],
                    "ASWAN": [
                        "Abu Simbel",
                        "Al Sad Al Aali",
                        "Aswan",
                        "Draw",
                        "Edfo",
                        "El Klabsha",
                        "Kom Ombo",
                        "Markaz Naser",
                        "Nasr Elnoba"
                    ],
                    "QENA": [
                        "Abu Tesht",
                        "Deshna",
                        "Farshoot",
                        "Naga Hamadi",
                        "Naqada",
                        "Qena",
                        "Qoos"
                    ],
                    "QALYUBIA": [
                        "Abu Zaabal",
                        "Al Khanka",
                        "Al Shareaa Al Gadid",
                        "Bahteem",
                        "Banha",
                        "El Kanater EL Khayrya",
                        "El Khsos",
                        "El Oboor",
                        "El Qalag",
                        "Kafr Shokr",
                        "Meet Nama",
                        "Mostorod",
                        "Om Bayoumi",
                        "Orabi",
                        "Qaha",
                        "Qalyoob",
                        "Qalyubia",
                        "Sheben Alkanater",
                        "Shoubra Alkhema",
                        "Tookh"
                    ],
                    "ALDAQAHLIYA": [
                        "Aga",
                        "Al Daqahliya",
                        "Al Mansoura",
                        "Belqas",
                        "Dekernes",
                        "El Sinblaween",
                        "Manzala",
                        "Meet Ghamr",
                        "Menit El Nasr",
                        "Nabroo",
                        "Shrbeen",
                        "Talkha"
                    ],
                    "BANISOUAIF": [
                        "Ahnaseaa",
                        "Bani Souaif",
                        "Bebaa",
                        "El Fashn",
                        "El Korimat",
                        "El Wastaa",
                        "Naser",
                        "New Bani Souaif",
                        "Smostaa"
                    ],
                    "SUEZ": [
                        "Ain Al Sukhna",
                        "Al Adabya",
                        "Al Suez",
                        "Ataka District",
                        "El Arbeen District",
                        "Elganaien District",
                        "Suez"
                    ],
                    "SOHAG": [
                        "Akhmem",
                        "Dar Elsalam",
                        "El Monshah",
                        "Elbalyna",
                        "Gerga",
                        "Ghena",
                        "Maragha",
                        "Saqatlah",
                        "Sohag",
                        "Tahta",
                        "Tema"
                    ],
                    "ALFAYOUM": [
                        "Al Fayoum",
                        "Atsa",
                        "Ebshoy",
                        "El Aagamen",
                        "Kofooer Elniel",
                        "Manshaa Abdalla",
                        "Manshaa Elgamal",
                        "New Fayoum",
                        "Sanhoor",
                        "Sersenaa",
                        "Sonores",
                        "Tameaa",
                        "Youssef Sadek"
                    ],
                    "ALGHARBIA": [
                        "Al Gharbia",
                        "Al Mahala Al Kobra",
                        "Alsanta",
                        "Basyoon",
                        "Kafr Alziat",
                        "Qotoor",
                        "Samanood",
                        "Tanta",
                        "Zefta"
                    ],
                    "ALMONUFIA": [
                        "Al Monufia",
                        "Ashmoon",
                        "Berket Al Sabei",
                        "Menoof",
                        "Quesna",
                        "Sadat City",
                        "Shebin El Koom",
                        "Shohada",
                        "Tala"
                    ],
                    "KAFRELSHEIKH": [
                        "Al Riadh",
                        "Balteem",
                        "Bela",
                        "Borollos",
                        "Desouq",
                        "Fooh",
                        "Hamool",
                        "Kafr El Sheikh",
                        "Metobas",
                        "Qeleen",
                        "Seedy Salem"
                    ],
                    "DAMIETTA": [
                        "Al Zarkah",
                        "Damietta",
                        "Fareskor",
                        "Kafr Saad",
                        "New Damietta",
                        "Ras El Bar"
                    ],
                    "LUXOR": [
                        "Armant Gharb",
                        "Armant Sharq",
                        "El Karnak",
                        "El Korna",
                        "Esnaa",
                        "Luxor"
                    ],
                    "MATROOH": [
                        "El Alamein",
                        "El Dabaa",
                        "Marsa Matrooh",
                        "Matrooh",
                        "Sidi Abdel Rahman"
                    ],
                    "REDSEA": [
                        "Gouna",
                        "Hurghada",
                        "Marsa Alam",
                        "Qouseir",
                        "Ras Ghareb",
                        "Red Sea",
                        "Safaga"
                    ],
                    "PORTSAID": [
                        "Port Fouad",
                        "Port Said",
                        "Zohoor District"
                    ]
                };

                for (let x in allareasR2S) {
                    let option = '<option class="' + x + '" value="' + x + '" > ' + x + '</option>';
                    $('#category').append(option);
                    $('#categoryPickup').append(option);
                    let optgroup = '<optgroup class="' + x + '"required>' +
                        '<option value="">select Area</option>';
                    for (let i = 0; i < allareasR2S[x].length; i++) {
                        optgroup += '<option value="' + allareasR2S[x][i] + '"> ' + allareasR2S[x][i] + '</option>';
                    }
                    optgroup += '</optgroup>';
                    $('#subcategory').append(optgroup);
                    $('#subcategoryPickup').append(optgroup);

                }


                $('#subcategory').find('optgroup').hide(); // initialize
                $('#subcategoryPickup').find('optgroup').hide(); // initialize
                $('#category').change(function () {
                    var $cat    = $(this).find('option:selected');
                    var $subCat = $('#subcategory').find('.' + $cat.attr('class'));
                    $('#subcategory').find('optgroup').not("'" + '.' + $cat.attr('class') + "'").hide(); // hide other optgroup
                    $subCat.show();
                    $subCat.find('option').first().attr('selected', 'selected');
                });
                $('#categoryPickup').change(function () {
                    var $cat    = $(this).find('option:selected');
                    var $subCat = $('#subcategoryPickup').find('.' + $cat.attr('class'));
                    $('#subcategoryPickup').find('optgroup').not("'" + '.' + $cat.attr('class') + "'").hide(); // hide other optgroup
                    $subCat.show();
                    $subCat.find('option').first().attr('selected', 'selected');
                });
            });

            $(function () {
                $("#example1").DataTable();
                $("#myBtn").css({
                    "position": "fixed",
                    "bottom": "20px",
                    "right": "30px",
                    "z-index": "99",
                    "border": "none",
                    "outline": "none",
                    "background-color": "#bbb",
                    "color": "white",
                    "cursor": "pointer",
                    "padding": "7px",
                    "font-size": "18px",
                    "width": "50px",
                    "height": "50px",
                    "border-radius": "50%",
                });
                $("#myBtn").hover(function () {
                    $(this).css("background-color", "#555");
                }, function () {
                    $(this).css("background-color", "#bbb");
                });

                $("#myBtn2").css({
                    "position": "fixed",
                    "bottom": "20px",
                    "right": "85px",
                    "z-index": "99",
                    "border": "none",
                    "outline": "none",
                    "background-color": "#bbb",
                    "color": "white",
                    "cursor": "pointer",
                    "padding": "7px",
                    "font-size": "18px",
                    "width": "50px",
                    "height": "50px",
                    "border-radius": "50%",
                });
                $("#myBtn2").hover(function () {
                    $(this).css("background-color", "#555");
                }, function () {
                    $(this).css("background-color", "#bbb");
                });
            });


            function goToSpecificCharge(order_id, user_name, user_phone, user_address) {
                $("#order_id").val(order_id);
                $("#user_name_charge").val(user_name);
                $("#user_phone").val(user_phone);
                $("#user_address").val(user_address);
            }

            function goToSpecificPickup(order_id) {
                $("#order_id_pickup").val(order_id);
            }

            function goToSpecificCancel(order_id, waybillNumber) {
                $("#order_id_cancel").val(order_id);
                $("#waybillNumber_cancel").val(waybillNumber);
            }

            function goToSpecificCancelOrder(order_id) {
                console.log(order_id)
                $("#order_id_cancel_order").val(order_id);
            }

        </script>
    @endpush
@endsection
