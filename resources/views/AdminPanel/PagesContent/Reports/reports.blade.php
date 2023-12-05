@extends('AdminPanel.layouts.main')
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('generalReports.reports')}}">Report Product
                                Sales</a></li>
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
            <form method="get" action="{{route('generalReports.reports')}}">
                <div class="row">
                    <div class="col-md-1 row ">
                        <div class="form-group col-12">
                            <input type="text" name="name" class="form-control" id="name" @if(app('request')->input('name'))value="{{app('request')->input('name')}}" @endif placeholder="ID">
                        </div>
                    </div>
                    <div class="col-md-3 row ">
                        <div class="form-group col-12">
                            <input type="text" name="product_name" class="form-control" id="product_name" @if(app('request')->input('product_name'))value="{{app('request')->input('product_name')}}" @endif placeholder=" Product Name">
                        </div>
                    </div>
                    <div class="col-md-2 row ">
                        <div class="form-group col-12">
                            <input type="text" name="product_code" class="form-control" id="product_code" @if(app('request')->input('product_code'))value="{{app('request')->input('product_code')}}" @endif placeholder=" Product Code">
                        </div>
                    </div>
                    <div class="form-group  mb-2 col-md-2">
                        <input type="text" id="date_from" name="date_from" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'" @if(isset($date_from) && $date_from !='' ) value="{{$date_from}}" @endif class="form-control" placeholder="Date From" required>
                    </div>
                    <div class="form-group  mb-2 col-md-2">
                        <input type="text" id="date_to" name="date_to" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'" @if(isset($date_to) && $date_to !='' ) value="{{$date_to}}" @endif class="form-control" placeholder="Date To" required>
                    </div>
                    <div class="form-group col-2">
                        <button type="submit" class="btn btn-success form-control"><i class="fa fa-search"></i> Search
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <div class="card-body card-body pt-0 pb-0">
            <form method="post" action="{{route('generalReports.export')}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="form-group col-4">
                        <input type="text" name="start_date" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'" class="form-control" required placeholder="Start Date">
                    </div>
                    <div class="form-group col-4">
                        <input type="text" name="end_date" onfocus="(this.type='date')" onblur="if(!this.value)this.type='text'" class="form-control" required placeholder="End Date">
                    </div>


                    <div class="form-group col-4">
                        <input type="hidden" name="payment_status" id="payment_status">
                        <button type="submit" class="btn btn-primary form-control"><i class="fa fa-file"></i> Export
                            Sheet
                        </button>
                    </div>
                </div>
            </form>
        </div>

        <!-- /.card-header -->
        <div class="card-body" style="overflow-x:scroll">
            @if(count($productsReport) > 0)
                <table id="orderHeadersTable" style="width: 100%" class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        {{--                        <th> <input type="checkbox" id="select-all"></th>--}}
                        <th>Product ID</th>
                        <th>Product Code</th>
                        <th>Product Name</th>
                        <th>Total Quantity</th>
                        <th>Total Sales</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($productsReport as $row)
                        <tr>
                            {{--                            <td><input type="checkbox" name="checkbox[]" value="{{$row->id}}"/></td>--}}
                            <td>{{$row->product_id}}</td>
                            <td>{{$row->oracle_short_code}}</td>
                            <td>{{$row->name_en}}</td>
                            <td>{{$row->total_quantity}}</td>
                            <td>{{ number_format( floatval($row->total_sales), 2, '.', ',')}}</td>
                            <td>{{$row->created_at}}</td>
                        </tr>
                    @endforeach
                    </tbody>

                </table>
                <div class="pagination justify-content-center mt-2">

                    @if (isset($productsReport) && $productsReport->lastPage() > 1)
                        <ul class="pagination align-items-center">
                        @php
                            $interval = isset($interval) ? abs(intval($interval)) : 3 ;
                            $from = $productsReport->currentPage() - $interval;
                            if($from < 1){
                              $from = 1;
                            }

                            $to = $productsReport->currentPage() + $interval;
                            if($to > $productsReport->lastPage()){
                              $to = $productsReport->lastPage();
                            }
                        @endphp
                        <!-- first/previous -->
                            @if($productsReport->currentPage() > 1)
                                <li class="page-item">
                                    <a href="{{ $productsReport->url(1)."&date_from=".app('request')->input('date_from')."&date_to=".app('request')->input('date_to')}}" aria-label="First" class="page-link">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a href="{{ $productsReport->url($productsReport->currentPage() - 1)."&date_from=".app('request')->input('date_from')."&date_to=".app('request')->input('date_to') }}" aria-label="Previous" class="page-link">
                                        <span aria-hidden="true">&lsaquo;</span>
                                    </a>
                                </li>
                            @endif
                        <!-- links -->
                            @for($i = $from; $i <= $to; $i++)
                                @php
                                    $isCurrentPage = $productsReport->currentPage() == $i;
                                @endphp
                                <li class="page-item {{ $isCurrentPage ? 'active' : '' }}" style="padding: 5px">
                                    <a class="page-link" href="{{ !$isCurrentPage ? $productsReport->url($i)."&date_from=".app('request')->input('date_from')."&date_to=".app('request')->input('date_to') : '' }}">
                                        {{ $i }}
                                    </a>
                                </li>
                            @endfor
                        <!-- next/last -->
                            @if($productsReport->currentPage() < $productsReport->lastPage())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $productsReport->url($productsReport->currentPage() + 1)."&date_from=".app('request')->input('date_from')."&date_to=".app('request')->input('date_to') }}" aria-label="Next">
                                        <span aria-hidden="true">&rsaquo;</span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="{{ $productsReport->url($productsReport->lastpage())."&date_from=".app('request')->input('date_from')."&date_to=".app('request')->input('date_to') }}" aria-label="Last">
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

            $('#select-all').click(function () {
                var checked = this.checked;
                $('input[type="checkbox"]').each(function () {
                    this.checked = checked;
                });
            })

            $(document).ready(function () {
                var type = urlParamfun('type');
                console.log(type);
            });

        </script>
    @endpush
@endsection
