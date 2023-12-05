@extends('AdminPanel.layouts.main')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}">Home</a></li>
                        <li class="breadcrumb-item active"><a href="{{route('productsCategories.mainCategory')}}">Main Categories</a></li>
                    </ol>
                </div>
                <div class="col-sm-6">

                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    @include('AdminPanel.layouts.messages')
    <div class="card">

        <!-- /.card-header -->
        <div class="card-body">
            @if(count($childs) > 0)
                <table id="areasTable"  class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name EN</th>
                        <th>Name Ar</th>
                        <th>Level</th>
                        <th>Control</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($childs as $row)
                        <tr>
                            <td>{{$row->id}}</td>
                            <td >{{$row->name_en}}</td>
                            <td >{{$row->name_ar}}</td>
                            <td >{{$row->level}}</td>
                            <td>
                                <a class="btn btn-dark" href="{{route('productsCategories.subCategoryEdit',$row)}}">Edit</a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Name EN</th>
                        <th>Name AR</th>
                        <th>Level</th>
                        <th>Control</th>
                    </tr>
                    </tfoot>
                </table>

            @else
                <h1 class="text-center">NO DATA</h1>
            @endif
        </div>
        <!-- /.card-body -->
    </div>
@endsection
