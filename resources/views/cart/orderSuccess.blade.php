@extends('layouts.app')
@section('content')


    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain breadscrumb-order">
                        <div class="order-box">
                            <div class="order-contain">
                                <h2 class="theme-color">

             <img src="../assets/images/images/checkdone.png" width="200" class="blur-up lazyload"
                                                 alt="">
                                    {{trans('website.Order Saved Success Pay Order',[],session()->get('locale'))}}
                                     @if($order && $order['order_header'] && $order['order_header']['wallet_status'] =='cash')
                                      {{trans('website.On Deliver',[],session()->get('locale'))}}
                                    @endif
                                </h2>
                                <h5 class="text-content">{{trans('website.Order Saved Success Pay Order',[],session()->get('locale'))}}
                                    @if($order && $order['order_header'] && $order['order_header']['wallet_status'] =='cash')
                                      {{trans('website.On Deliver',[],session()->get('locale'))}}
                                    @else
                                        {{trans('website.Now',[],session()->get('locale'))}}
                                    @endif
                                    </h5>
                                <h2>{{trans('website.Order ID',[],session()->get('locale'))}}: {{$id}}</h2>
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
                             @if($order && $order['order_header'] && $order['order_header']['wallet_status'] =='only_fawry' &&  $order['order_header']['payment_status'] =='PENDING')
                                        <form class="row g-4" method="POST" action="{{url('payWithfawry') }}">
                                            @csrf
                                            <input type="hidden" name="order_id" value="{{$order['order_header']->id}}">
                                            <input type="hidden" name="type" value="web">
                                            <div class="col-12">
                                                <button class="btn  background-dark-mint w-100 justify-content-center text-white" type="submit">
                                                    Pay Now
                                                </button>
                                            </div>
                                        </form>
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
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Cart Section End -->

@endsection
