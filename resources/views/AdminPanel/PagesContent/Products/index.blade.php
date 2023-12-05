@extends('AdminPanel.layouts.main')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('products.index')}}">Products</a></li>
                    </ol>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>
    @include('AdminPanel.layouts.messages')


    <div class="card">

        <div class="card-header" style="float: right">
            <h3 class="card-title float-right">
                <a class="btn btn-warning" href="{{route('products.create')}}">Create New Product</a>
            </h3>

            <h3 class="card-title">
                <form method="post" action="{{route('products.changeStatus')}}">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <select name="stock_status" id="stock_status" class="form-control">
                                <option value="out stock">out stock</option>
                                <option value="in stock">in stock</option>
                            </select>
                        </div>
                        <button type="button"  onclick="getselectedId()" class="btn btn-danger form-control">Change Selected</button>
                    </div>
                </form>
            </h3>
        </div>


        <div class="card-header" style="float: right">
            <h3 class="card-title">
                <button type="button"  onclick="getselectedIdForExport()" class="btn btn-dark">Export Selected</button>
            </h3>
            <h3 class="card-title">
                <button type="button"  onclick="getAddIdForExport()" class="btn btn-success mx-2">Export All</button>
            </h3>
        </div>

    </div>
    <div class="card">
        <div class="card-body">
            <form method="get" action="{{route('products.index')}}">
                    <div class="row">
                        <div class="col-md-3">
                                <input class="form-control" type="text" placeholder="name" id="searchtext" name="name">
                        </div>

                        <div class="col-md-3">
                                <input class="form-control" type="text" placeholder="oracle code" id="searchtext" name="item_code">
                        </div>
                        <div class="col-md-2">
                                <input class="form-control" type="text" placeholder="bar code" id="searchtext" name="barcode">
                        </div>

                        <div class="col-md-2">
                            <select class="form-control" id="searchtext" name="category_id">
                                <option value="">ALL</option>
                                @foreach(\App\Models\Category::whereNull('parent_id')->get() as $key=>$value)
                                    <option value="{{$value->id}}">{{$value->name_ar}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2">
                            <button type="submit" class="btn btn-info">Search</button>
                        </div>
                    </div>
                </form>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @if(count($products) > 0)
                <table id="productsTable"  class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th> <input type="checkbox" id="select-all"></th>
                        <th>Name EN</th>
                        <th>Name AR</th>
                        <th>Categories</th>
                        <th>price</th>
                        <th>Quantity</th>
                        <th>stock Status</th>
                        <th>oracle Code</th>
                        <th>bar Code</th>
                        <th>tax</th>

                        <th>Control</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $row)
                        <tr>
                            <td><input type="checkbox" name="checkbox[]" value="{{$row->id}}"/></td>
                            <td >{{$row->name_en}}</td>
                            <td >{{$row->name_ar}}</td>
                            <td >@foreach($row->productCategory as $productCategory)
                                    @if(isset($productCategory->category)&&$productCategory->category['parent_id']== null)
                                        {{$productCategory->category['name_en']}}
                                    @elseif(isset($productCategory->category))
                                        --{{$productCategory->category['name_en']}}

                                    @endif
                                    <br>@endforeach</td>
                            <td >{{$row->price}}</td>
                            <td >{{$row->quantity}}</td>
                            <td >{{$row->stock_status}}</td>
                            <td >{{$row->oracle_short_code}}</td>
                            <td >{{$row->barcode}}</td>
                            <td >{{$row->tax}}</td>

                            <td>
                                <a class="btn btn-dark" href="{{route('products.edit',$row)}}">Edit</a>
                              <br>
                              <br>
                              <br>
                                <a class="btn btn-success" href="{{route('products.show',$row)}}">View</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
{{--                    <tfoot>--}}
{{--                    <tr>--}}
{{--                        <th>#</th>--}}
{{--                        <th>Name EN</th>--}}
{{--                        <th>Name AR</th>--}}
{{--                        <th>price</th>--}}
{{--                        <th>stock Status</th>--}}
{{--                        <th>oracle Code</th>--}}
{{--                        <th>tax</th>--}}
{{--                        <th>discount Rate</th>--}}
{{--                        <th>price After Discount</th>--}}
{{--                        <th>Control</th>--}}
{{--                    </tr>--}}
{{--                    </tfoot>--}}
                </table>


             <div class="pagination justify-content-center mt-2">

                    @if (isset($products) && $products->lastPage() > 1)
                        <ul class="pagination align-items-center">
                        @php
                            $interval = isset($interval) ? abs(intval($interval)) : 3 ;
                            $from = $products->currentPage() - $interval;
                            if($from < 1){
                              $from = 1;
                            }

                            $to = $products->currentPage() + $interval;
                            if($to > $products->lastPage()){
                              $to = $products->lastPage();
                            }
                        @endphp
                        <!-- first/previous -->
                            @if($products->currentPage() > 1)
                                <li class="page-item">
                                    <a href="{{ $products->url(1)."&name=".app('request')->input('name')."&category_id".app('request')->input('category_id')}}" aria-label="First" class="page-link">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a href="{{ $products->url($products->currentPage() - 1)."&name=".app('request')->input('name')."&category_id".app('request')->input('category_id')}}" aria-label="Previous" class="page-link">
                                        <span aria-hidden="true">&lsaquo;</span>
                                    </a>
                                </li>
                            @endif
                        <!-- links -->
                            @for($i = $from; $i <= $to; $i++)
                                @php
                                    $isCurrentPage = $products->currentPage() == $i;
                                @endphp
                                <li class="page-item {{ $isCurrentPage ? 'active' : '' }}" style="padding: 5px">
                                    <a class="page-link" href="{{ !$isCurrentPage ? $products->url($i)."&name=".app('request')->input('name')."&category_id".app('request')->input('category_id') : '' }}">
                                        {{ $i }}
                                    </a>
                                </li>
                            @endfor
                        <!-- next/last -->
                            @if($products->currentPage() < $products->lastPage())
                                <li class="page-item">
                                    <a class="page-link" href="{{ $products->url($products->currentPage() + 1)."&name=".app('request')->input('name')."&category_id".app('request')->input('category_id')}}" aria-label="Next">
                                        <span aria-hidden="true">&rsaquo;</span>
                                    </a>
                                </li>
                                <li class="page-item">
                                    <a class="page-link" href="{{ $products->url($products->lastpage())."&name=".app('request')->input('name')."&category_id".app('request')->input('category_id')}}" aria-label="Last">
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

            function getselectedId()
            {
                var ids =[];
                var stock_status = $('#stock_status').val();
                $('input[type="checkbox"]').each(function() {
                        if (this.checked)
                        {
                            ids.push(this.value);
                        }
                });
                window.location.href = "{{route('products.changeStatus')}}?products_ids="+ids+"&stock_status="+stock_status;
            }

            function getselectedIdForExport()
            {
                var ids =[];
                $('input[type="checkbox"]').each(function() {
                    if (this.checked)
                    {
                        ids.push(this.value);
                    }
                });
                window.location.href = "{{route('products.ExportProductsSheet')}}?products_ids="+ids;

            }

            function getAddIdForExport()
            {

                window.location.href = "{{route('products.ExportProductsSheet')}}?products_ids=0";

            }
            $('#select-all').click(function() {
                var checked = this.checked;
                $('input[type="checkbox"]').each(function() {
                    this.checked = checked;
                });
            })

        </script>
    @endpush
@endsection
