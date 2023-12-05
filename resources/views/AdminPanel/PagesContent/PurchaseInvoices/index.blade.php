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
                        <li class="breadcrumb-item active"><a href="{{route('purchaseInvoices.index')}}">Orders</a></li>
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
            <form method="get" action="{{route('purchaseInvoices.index')}}" enctype="multipart/form-data">
                @csrf
                <div class="row">
                    <div class="col-md-1 row ">
                        <div class="form-group col-12">
                            <label class="col-form-label" for="name">ID</label>
                            <input type="text" name="name" class="form-control" id="name" @if(app('request')->input('name'))value="{{app('request')->input('name')}}" @endif placeholder="ID">
                        </div>
                    </div>
                    <div class="col-md-3 row ">
                        <div class="form-group col-12">
                            <label class="col-form-label" for="product_name">Product Name</label>
                            <input type="text" name="product_name" class="form-control" id="product_name" @if(app('request')->input('product_name'))value="{{app('request')->input('product_name')}}" @endif placeholder=" Product Name">
                        </div>
                    </div>
                    <div class="col-md-2 row ">
                        <div class="form-group col-12">
                            <label class="col-form-label" for="product_code">Product Code</label>
                            <input type="text" name="product_code" class="form-control" id="product_code" @if(app('request')->input('product_code'))value="{{app('request')->input('product_code')}}" @endif placeholder=" Product Code">
                        </div>
                    </div>

                    <div class="row col-4">
                        <div class="form-group col-6">
                            <label class="col-form-label" for="from_date">From Date</label>
                            <input type="date" name="from_date" id="from_date" @if(app('request')->input('from_date'))value="{{app('request')->input('from_date')}}" @endif class="form-control">
                        </div>
                        <div class="form-group col-6">
                            <label class="col-form-label" for="to_date">To Date</label>
                            <input type="date" name="to_date" @if(app('request')->input('to_date'))value="{{app('request')->input('to_date')}}" @endif id="to_date" class="form-control">
                        </div>
                    </div>
                    <div class="form-group col-2">
                        <label class="col-form-label"><i class="fa fa-search"></i></label>
                        <button type="submit" class="btn btn-info form-control">Search</button>
                    </div>
                </div>
            </form>
        </div>

        <!-- /.card-header -->
        <div class="card-body" style="overflow-x:scroll">
            @if(count($purchaseInvoices) > 0)
                <table id="orderHeadersTable" style="width: 100%" class="table table-bordered table-striped">
                    <thead>
                    <tr>
{{--                        <th><input type="checkbox" id="select-all"></th>--}}
                        <th>ID</th>
                        <th>Product Name</th>
                        <th>Product code</th>
                        <th>Quantity</th>
                        <th>Price</th>
                        <th>Discount</th>
                        <th>Price after</th>
                        <th>Company</th>
                        <th>Date</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($purchaseInvoices as $row)
                        <tr>
{{--                            <td><input type="checkbox" name="checkbox[]" value="{{$row->id}}"/></td>--}}
                            <td>{{$row->id}}</td>
                            <td>{{$row->full_name?$row->full_name:''}}</td>
                            <td>{{$row->oracle_short_code}}</td>
                            <td>{{$row->quantity}}</td>
                            <td>{{$row->price}}</td>
                            <td>{{$row->discount_rate}}</td>
                            <td>{{$row->price_after_discount}}</td>
                            <td>{{$row->company?$row->company->name_ar:''}}</td>
                            <td>{{$row->created_at}}</td>

                        </tr>
                    @endforeach
                    </tbody>

                </table>
                <div class="pagination">

                    @if (isset($purchaseInvoices) && $purchaseInvoices->lastPage() > 1)
                        <ul class="pagination">
                        @php
                            $interval = isset($interval) ? abs(intval($interval)) : 3 ;
                            $from = $purchaseInvoices->currentPage() - $interval;
                            if($from < 1){
                              $from = 1;
                            }

                            $to = $purchaseInvoices->currentPage() + $interval;
                            if($to > $purchaseInvoices->lastPage()){
                              $to = $purchaseInvoices->lastPage();
                            }
                        @endphp
                        <!-- first/previous -->
                            @if($purchaseInvoices->currentPage() > 1)
                                <li>
                                    <a href="{{ $purchaseInvoices->url(1)."&type=".app('request')->input('type')}}" aria-label="First">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ $purchaseInvoices->url($purchaseInvoices->currentPage() - 1)."&type=".app('request')->input('type') }}" aria-label="Previous">
                                        <span aria-hidden="true">&lsaquo;</span>
                                    </a>
                                </li>
                            @endif
                        <!-- links -->
                            @for($i = $from; $i <= $to; $i++)
                                @php
                                    $isCurrentPage = $purchaseInvoices->currentPage() == $i;
                                @endphp
                                <li class="{{ $isCurrentPage ? 'active' : '' }}" style="padding: 5px">
                                    <a href="{{ !$isCurrentPage ? $purchaseInvoices->url($i)."&type=".app('request')->input('type') : '' }}">
                                        {{ $i }}
                                    </a>
                                </li>
                            @endfor
                        <!-- next/last -->
                            @if($purchaseInvoices->currentPage() < $purchaseInvoices->lastPage())
                                <li>
                                    <a href="{{ $purchaseInvoices->url($purchaseInvoices->currentPage() + 1)."&type=".app('request')->input('type') }}" aria-label="Next">
                                        <span aria-hidden="true">&rsaquo;</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ $purchaseInvoices->url($purchaseInvoices->lastpage())."&type=".app('request')->input('type') }}" aria-label="Last">
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
