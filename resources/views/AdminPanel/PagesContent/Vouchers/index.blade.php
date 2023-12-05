@extends('AdminPanel.layouts.main')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('vouchers.index')}}">vouchers</a></li>
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

            <h3 class="card-title float-right">
                <a class="btn btn-warning" href="{{route('vouchers.create')}}">Create New Voucher</a>
            </h3>
        </div>

        <!-- /.card-header -->
        <div class="card-body">
            @if(count($vouchers) > 0)
                <table id="areasTable"  class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>code</th>
                        <th>Name </th>
                        <th>description</th>
                        <th>image</th>
                        <th>uses</th>
                        <th>max_uses</th>
                        <th>max_uses_user</th>
                        <th>discount_amount	</th>
                        <th>discount_type	</th>
                        <th>starts_at	</th>
                        <th>expires_at	</th>
                        <th>Control</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($vouchers as $row)
                        <tr>
                            <td>{{$row->id}}</td>
                            <td width="150">{{$row->code}}</td>
                            <td width="150">{{$row->name}}</td>
                            <td width="150">{{$row->description}}</td>
                            <td><a href="{{url($row->image)}}" target="_blank">
                                    <img src="{{url($row->image)}}" width="350" height="200">
                                </a></td>
                            <td width="150">{{$row->uses}}</td>
                            <td width="150">{{$row->max_uses}}</td>
                            <td width="150">{{$row->max_uses_user}}</td>
                            <td width="150">{{$row->discount_amount}}</td>
                            <td width="150">{{$row->discount_type}}</td>
                            <td width="150">{{$row->starts_at}}</td>
                            <td width="150">{{$row->expires_at}}</td>

                    <td>
                    <a class="btn btn-dark" href="{{route('vouchers.edit',$row)}}">Edit</a>
{{--                    <form action="{{route("vouchers.destroy", $row)}}" method="post"--}}
{{--                          style="display:inline;">--}}
{{--                        @csrf--}}
{{--                        @method('delete')--}}
{{--                        <button type="button" id="btnDelete" class="btn btn-danger btn-delete">Delete--}}
{{--                        </button>--}}
{{--                    </form>--}}
                    </td>
                    </tr>
                    @endforeach
                    </tbody>

                    </table>

                    @else
                    <h1 class="text-center">NO DATA</h1>
                    @endif
                    </div>
                    <!-- /.card-body -->
                    </div>
                    @endsection
