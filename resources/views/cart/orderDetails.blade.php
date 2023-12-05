@extends('layouts.app')
@section('style')
    <style>
        #chartStatusBar * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .status-bar {
            width: 80%;
            display: flex;
            gap: 34px;
            align-items: center;
            justify-content: space-between;
            margin: 50px auto 0 auto;
            padding-bottom: 40px;
        }

        .status-bar .status {
            position: relative;
            width: 100%;
            height: 70px;
            /*border-top: 1px solid black;*/
        }

        .status-bar .status.disabled {
            opacity: .4;
        }

    </style>
@endsection
@section('content')
    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain breadscrumb-order">
                        <div class="order-box">
                            <div class="order-contain">

                                <h2>{{trans('website.Order ID',[],session()->get('locale'))}}: {{$id}}</h2>
                                <br>
                                <h2 class="theme-color">
                                    Delivery status : {{$order['order_header']['order_status']}}
                                </h2>
                                <div class="col-md-12 mt-3">
                                    <div class="row">
                                        <div class="col-md-1"></div>
                                        <div class="col-md-11" id="chartStatusBar">

                                            <div class="status-bar">
                                                @if($order && count( $order['order_status'])>0)
                                                    @for($ii=0;$ii<count($order['order_status']);$ii++)
                                                        <div class="status {{$order['order_status'][$ii]['isComplete'] == true ||   $ii <  $order['order_header']->current_status_index ? '':'disabled'}} ">
                                                            <div class="leftCorner">
                                                                <div class="row">
                                                                    <div class="col-md-8">
                                                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/73/Flat_tick_icon.svg/1024px-Flat_tick_icon.svg.png" alt="checked" width="30px" height="30px">
                                                                        <p class="mt-2" >{{$order['order_status'][$ii]['name']}}</p>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        @if($ii <  $order['order_header']->max_status_index)
                                                                            <img  src="https://upload.wikimedia.org/wikipedia/commons/d/d2/Arrow-right-line.svg" alt="checked" width="30px" height="30px">
                                                                        @endif
                                                                    </div>
                                                                </div>

                                                            </div>


                                                        </div>
                                                    @endfor
                                                @endif


                                                {{--                                                <div class="status disabled">--}}
                                                {{--                                                    <div class="leftCorner">--}}
                                                {{--                                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/73/Flat_tick_icon.svg/1024px-Flat_tick_icon.svg.png" alt="checked" width="30px" height="30px">--}}
                                                {{--                                                        <p>Total Sales</p>--}}

                                                {{--                                                    </div>--}}
                                                {{--                                                </div>--}}
                                                {{--                                                <div class="status  disabled">--}}
                                                {{--                                                    <div class="leftCorner">--}}
                                                {{--                                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/73/Flat_tick_icon.svg/1024px-Flat_tick_icon.svg.png" alt="checked" width="30px" height="30px">--}}
                                                {{--                                                        <p>Next Sales</p>--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                </div>--}}
                                                {{--                                                <div class="status  disabled">--}}
                                                {{--                                                    <div class="leftCorner">--}}
                                                {{--                                                        <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/7/73/Flat_tick_icon.svg/1024px-Flat_tick_icon.svg.png" alt="checked" width="30px" height="30px">--}}
                                                {{--                                                        <p>Earning</p>--}}
                                                {{--                                                    </div>--}}
                                                {{--                                                </div>--}}
                                            </div>
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
    <!-- Breadcrumb Section End -->

    <!-- Cart Section Start -->
    <section class="cart-section section-b-space">
        <div class="container-fluid-lg">
            <div class="row g-sm-4 g-3">
                <div class="col-xxl-9 col-lg-8">
                    <div class="cart-table order-table order-table-2">
                        <div class="table-responsive">
                            <table class="table mb-0">
                                <tbody>
                                @if($order && count( $order['order_lines'])>0)
                                    @foreach($order['order_lines'] as $row)
                                        <tr>
                                            <td class="product-detail">
                                                <div class="product border-0">
                                                    <a href="{{url('product-details/'.$row->id)}}" class="product-image">
                                                        <img src="{{url($row->image)}}"
                                                             class="img-fluid blur-up lazyload" alt="" width="100" height="100">
                                                    </a>
                                                    <div class="product-detail">
                                                        <ul>
                                                            <li class="name">
                                                                <a href="3">{{$row->full_name}}</a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="price">
                                                <h4 class="table-title text-content"> {{trans('website.Price',[],session()->get('locale'))}}</h4>
                                                <h6 class="theme-color">{{$row->price}}</h6>
                                            </td>

                                            <td class="quantity">
                                                <h4 class="table-title text-content">{{trans('website.Quantity',[],session()->get('locale'))}}</h4>
                                                <h4 class="text-title">{{$row->quantity}}</h4>
                                            </td>

                                            <td class="subtotal">
                                                <h4 class="table-title text-content">{{trans('website.Total',[],session()->get('locale'))}}</h4>
                                                <h5>{{(float)$row->price * (float)$row->quantity}}  {{trans('website.LE',[],session()->get('locale'))}}</h5>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>
                        </div>
                        <br>
                        <div class="text-center mt-4">
                            @if($order['order_header']->can_cancel == '1')
                                <button class="btn theme-bg-color text-white  justify-content-center p-1 pr-2" data-bs-target="#exampleModalCancelOrderRequest" data-bs-toggle="modal" onclick="goToSpecificCancelOrder('{{$order['order_header']->id}}')">
                                    &nbsp; Cancel
                                </button>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="col-xxl-3 col-lg-4">
                    <div class="row g-4">
                        <div class="col-lg-12 col-sm-6">
                            <div class="summery-box">
                                <div class="summery-header">
                                    <h3>Price Details</h3>
                                    <h5 class="ms-auto theme-color">( {{count($order['order_lines'])}} Items )</h5>
                                </div>

                                <ul class="summery-contain">
                                    <li>
                                        <h4>Total Products </h4>
                                        <h4 class="price">{{$totalProducts}} LE</h4>
                                    </li>

                                    <li>
                                        <h4>Discount Amount</h4>
                                        <h4 class="price theme-color">{{$order['order_header']->discount_amount}}
                                            LE</h4>
                                    </li>
                                    <li>
                                        <h4>After Discount</h4>
                                        <h4 class="price theme-color">{{$afterDiscount}}
                                            LE</h4>
                                    </li>
                                    <li>
                                        <h4>Shipping Amount</h4>
                                        <h4 class="price theme-color">{!! $order['order_header']->shipping_amount >0 ?$order['order_header']->shipping_amount .' LE': '<del>50 LE</del>'  !!}
                                        </h4>
                                    </li>
                                    @if($giftPrice > 0)
                                        <li>
                                            <h4>Gift Price</h4>
                                            <h4 class="price theme-color">{{$giftPrice}}
                                                LE </h4>
                                        </li>
                                    @endif

                                </ul>

                                <ul class="summery-total">
                                    <li class="list-total">
                                        <h4>Total Order</h4>
                                        <h4 class="price">{{$totalOrder}} LE</h4>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-12 col-sm-6">
                            <div class="summery-box">
                                <div class="summery-header d-block">
                                    <h3>Shipping Address</h3>
                                </div>
                                @if($address)
                                    <ul class="summery-contain pb-0 border-bottom-0">
                                        <li class="d-block">
                                            <h6>{{$address->country_name}} - {{$address->city_name}}</h6>
                                            <h6 class="text-content"><span
                                                    class="text-title">Area :</span>
                                                {{$address->area_name}}</h6>
                                            <h6 class="text-content"><span
                                                    class="text-title">Address
                                                : </span>{{$address->address}}
                                            </h6>
                                            <h6 class="text-content mb-0"><span
                                                    class="text-title">Landmark
                                                :</span>
                                                {{$address->landmark}}</h6>
                                            <h6 class="text-content mb-0"><span
                                                    class="text-title">Floor Number
                                                 :</span>
                                                {{$address->floor_number}}</h6>
                                            <h6 class="text-content mb-0"><span
                                                    class="text-title">Apartment Number
                                            :</span>
                                                {{$address->apartment_number}}</h6>
                                        </li>
                                    </ul>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Cart Section End -->


    <!-- Quick View Modal Box Start -->
    <div class="modal fade theme-modal view-modal" id="exampleModalCancelOrderRequest" tabindex="-1" aria-labelledby="exampleModalLabel"
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
                                <h4 class="title-name" id="productName">Cancel Order</h4>
                            </div>
                        </div>

                    </div>
                    <div class="modal-body">
                        <form method="post" action="{{route('order.cancelMemberOrder')}}" enctype="multipart/form-data">
                            @csrf

                            <div class="row">
                                <h5 class="modal-title col-md-12" id="exampleModalLongTitle">Do You want to Cancel Order
                                    ?</h5>

                                <div class="col-md-12 ">
                                    <input type="hidden" name="order_id" id="order_id_cancel_order" class="form-control">
                                    <br>
                                    <label for="canceled_reason">Enter Reason</label>
                                    <textarea name="canceled_reason" id="canceled_reason" class="form-control" required></textarea>
                                    <br>
                                </div>


                                <br>
                                <div class="form-group col-12">
                                    <button type="submit" class="btn btn-success form-control">
                                        Yes cancel
                                    </button>
                                </div>
                            </div>

                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Quick View Modal Box End -->


@endsection

@section('java_script')
    <script>
        function goToSpecificCancelOrder(order_id) {
            console.log(order_id)
            $("#order_id_cancel_order").val(order_id);
        }
    </script>

@endsection
