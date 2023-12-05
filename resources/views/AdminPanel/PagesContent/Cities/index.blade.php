@extends('AdminPanel.layouts.main')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('cities.index')}}">Cities</a></li>
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

            <form method="get" action="{{route('cities.index')}}">
                <input type="text" id="searchtext" name="name">
                <button type="submit" class="btn btn-danger">Search</button>
            </form>
            <h3 class="card-title float-right">
                <a class="btn btn-warning" href="{{route('cities.create')}}">Create New City</a>
            </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @if(count($cities) > 0)
                <table id="areasTable"  class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name EN</th>
                        <th>Name Ar</th>
                        <th>Control</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($cities as $row)
                        <tr>
                            <td>{{$row->id}}</td>
                            <td width="150">{{$row->name_en}}</td>
                            <td width="150">{{$row->name_ar}}</td>
                            <td>
                                <a class="btn btn-dark" href="{{route('cities.edit',$row)}}">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Name EN</th>
                        <th>Name AR</th>
                        <th>Control</th>
                    </tr>
                    </tfoot>
                </table>
                <div class="pagination">

                    @if (isset($cities) && $cities->lastPage() > 1)
                        <ul class="pagination">
                        @php
                            $interval = isset($interval) ? abs(intval($interval)) : 3 ;
                            $from = $cities->currentPage() - $interval;
                            if($from < 1){
                              $from = 1;
                            }

                            $to = $cities->currentPage() + $interval;
                            if($to > $cities->lastPage()){
                              $to = $cities->lastPage();
                            }
                        @endphp
                        <!-- first/previous -->
                            @if($cities->currentPage() > 1)
                                <li>
                                    <a href="{{ $cities->url(1)."&name=".app('request')->input('name')}}" aria-label="First">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ $cities->url($cities->currentPage() - 1)."&name=".app('request')->input('name') }}" aria-label="Previous">
                                        <span aria-hidden="true">&lsaquo;</span>
                                    </a>
                                </li>
                            @endif
                        <!-- links -->
                            @for($i = $from; $i <= $to; $i++)
                                @php
                                    $isCurrentPage = $cities->currentPage() == $i;
                                @endphp
                                <li class="{{ $isCurrentPage ? 'active' : '' }}" style="padding: 5px">
                                    <a href="{{ !$isCurrentPage ? $cities->url($i)."&name=".app('request')->input('name') : '' }}">
                                        {{ $i }}
                                    </a>
                                </li>
                            @endfor
                        <!-- next/last -->
                            @if($cities->currentPage() < $cities->lastPage())
                                <li>
                                    <a href="{{ $cities->url($cities->currentPage() + 1)."&name=".app('request')->input('name') }}" aria-label="Next">
                                        <span aria-hidden="true">&rsaquo;</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ $cities->url($cities->lastpage())."&name=".app('request')->input('name') }}" aria-label="Last">
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
@endsection
