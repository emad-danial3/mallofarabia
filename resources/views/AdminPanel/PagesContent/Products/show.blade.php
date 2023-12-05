@extends('AdminPanel.layouts.main')
@section('content')

    <div class="page-title">
        <div class="title_left">
            <h3><i class="fa fa-hospital-o"></i> <a href="{{route('adminDashboard')}}">Home</a> / View

            </h3>
        </div>
    </div>
    <div class="clearfix"></div>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-md-12 col-sm-12 col-xs-12">
                    @include('AdminPanel.layouts.messages')
                    <table class="table table-hover table-striped">
                        <tbody>
                        <tr>
                            <th>Full Name</th>
                            <td>{{$product->full_name}}</td>
                        </tr>

                        <tr>
                            <th>name en</th>
                            <td>{{$product->name_en}}</td>
                        </tr>

                        <tr>
                            <th>name ar</th>
                            <td>{{$product->name_ar}}</td>
                        </tr>

                        <tr>
                            <th>price</th>
                            <td>{{$product->price}}</td>
                        </tr>

                        <tr>
                            <th>price after discount</th>
                            <td>{{$product->price_after_discount}}</td>
                        </tr>


                        <tr>
                            <th>quantity</th>
                            <td>{{$product->quantity}}</td>
                        </tr>

                        <tr>
                            <th>description Ar</th>
                            <td>{{$product->description_ar}}</td>
                        </tr>

                        <tr>
                            <th>description EN</th>
                            <td>{{$product->description_en}}</td>
                        </tr>

                        <tr>
                            <th></th>
                            <td><img width="500" height="250" src="{{url($product->image)}}"></td>
                        </tr>

                        <tr>
                            <th>oracle code</th>
                            <td>{{$product->oracle_short_code}}</td>
                        </tr>

                        <tr>
                            <th>discount rate</th>
                            <td>{{$product->discount_rate}}</td>
                        </tr>

                        <tr>
                            <th>tax</th>
                            <td>{{$product->tax}}</td>
                        </tr>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
