@extends('AdminPanel.layouts.main')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('areas.index')}}">Areas</a></li>
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

            <form method="get" action="{{route('areas.index')}}">
                <input type="text" id="searchtext" name="name">
                <button type="submit" class="btn btn-danger">Search</button>
            </form>
            <h3 class="card-title float-right">
                <a class="btn btn-warning" href="{{route('areas.create')}}">Create New Area</a>
            </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @if(count($areas) > 0)
                <table id="areasTable"  class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name EN</th>
                        <th>Name Ar</th>
                        <th>City Name</th>
                        <th>Governorate Name</th>
                        <th>Control</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($areas as $row)
                        <tr>
                            <td>{{$row->id}}</td>
                            <td width="150">{{$row->region_en}}</td>
                            <td width="150">{{$row->region_ar}}</td>
                            <td width="150">{{$row->city->name_en}} / {{$row->city->name_ar}}</td>
                            <td colspan="1">{{$row->governorate}}</td>
                            <td>
                                <a class="btn btn-dark" href="{{route('areas.edit',$row)}}">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Name EN</th>
                        <th>Name Ar</th>
                        <th>City Name</th>
                        <th>Governorate Name</th>
                        <th>Control</th>
                    </tr>
                    </tfoot>
                </table>
                <div class="pagination">

                    @if (isset($areas) && $areas->lastPage() > 1)
                        <ul class="pagination">
                        @php
                            $interval = isset($interval) ? abs(intval($interval)) : 3 ;
                            $from = $areas->currentPage() - $interval;
                            if($from < 1){
                              $from = 1;
                            }

                            $to = $areas->currentPage() + $interval;
                            if($to > $areas->lastPage()){
                              $to = $areas->lastPage();
                            }
                        @endphp
                        <!-- first/previous -->
                            @if($areas->currentPage() > 1)
                                <li>
                                    <a href="{{ $areas->url(1)."&name=".app('request')->input('name')}}" aria-label="First">
                                        <span aria-hidden="true">&laquo;</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ $areas->url($areas->currentPage() - 1)."&name=".app('request')->input('name') }}" aria-label="Previous">
                                        <span aria-hidden="true">&lsaquo;</span>
                                    </a>
                                </li>
                            @endif
                        <!-- links -->
                            @for($i = $from; $i <= $to; $i++)
                                @php
                                    $isCurrentPage = $areas->currentPage() == $i;
                                @endphp
                                <li class="{{ $isCurrentPage ? 'active' : '' }}" style="padding: 5px">
                                    <a href="{{ !$isCurrentPage ? $areas->url($i)."&name=".app('request')->input('name') : '' }}">
                                        {{ $i }}
                                    </a>
                                </li>
                            @endfor
                        <!-- next/last -->
                            @if($areas->currentPage() < $areas->lastPage())
                                <li>
                                    <a href="{{ $areas->url($areas->currentPage() + 1)."&name=".app('request')->input('name') }}" aria-label="Next">
                                        <span aria-hidden="true">&rsaquo;</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="{{ $areas->url($areas->lastpage())."&name=".app('request')->input('name') }}" aria-label="Last">
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
