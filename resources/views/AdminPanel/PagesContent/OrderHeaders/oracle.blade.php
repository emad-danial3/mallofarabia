@extends('AdminPanel.layouts.main')
@section('content')

    <meta name="csrf-token" content="{{ csrf_token() }}"/>
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
            <div class="card">

                <div class="card-header">


                        <form class="form-inline row" method="get" action="{{url('admin/orderHeaders/change/getOracleNumberByOrderId')}}">
                            <div class="form-group mx-sm-3 mb-2 col-md-3">
                                <label for="date_from" class="text-right mr-2">Date From </label>
                                <input type="date" id="date_from" name="date_from" @if(isset($date_from) && $date_from !='' ) value="{{$date_from}}" @endif class="form-control" placeholder="Date From">
                            </div>
                            <div class="form-group mx-sm-3 mb-2 col-md-3">
                                <label for="date_to" class="text-right mr-2">Date To </label>
                                <input type="date" id="date_to" name="date_to" @if(isset($date_to) && $date_to !='' ) value="{{$date_to}}" @endif class="form-control" placeholder="Date To">
                            </div>
                            <div class="form-group mx-sm-3 mb-2 col-md-3">
                                <label for="name" class="text-right mr-2">Order Number </label>
                                <input type="text" id="name" name="name" @if(isset($name) && $name !='' ) value="{{$name}}" @endif class="form-control" placeholder="Order Number" style="text-align: left">
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

                                        @if(isset($orders) && count($orders) > 0)
                                            <table class="table table-striped" style="direction: ltr">
                                                <thead>
                                                <tr>
                                                    <th scope="col">#</th>
                                                    <th scope="col"><h3> Order Number</h3></th>
                                                    <th scope="col"><h3>Order Payment Status</h3></th>
                                                    <th scope="col"><h3>Oracle Numbers</h3></th>

                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($orders as $order)
                                                    <tr>
                                                        <th scope="row">{{$loop->iteration}}</th>
                                                        <td> <h4>{{$order->id}}</h4></td>
                                                        <td> <h4>{{$order->payment_status}}</h4></td>
                                                        <td>
                                                            @if(isset($order->order_lines))

                                                                @foreach($order->order_lines as $line)
                                                                    <h4>{{$line->oracle_num}}</h4>
                                                                @endforeach
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        @endif

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


    </section>

@endsection

