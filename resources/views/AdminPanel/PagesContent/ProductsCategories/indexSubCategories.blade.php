@extends('AdminPanel.layouts.main')
@section('content')

    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}">Home</a></li>

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
                <a class="btn btn-warning" href="{{route('productsCategories.storeSubCategory')}}">Create New Sub Category</a>
            </h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @if(count($productsCategories) > 0)
                <table id="areasTable"  class="table table-bordered table-striped">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name EN</th>
                        <th>Name Ar</th>
                        <th>level</th>
                        <th>Parent</th>
                        <th>Status</th>
                        <th>Control</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($productsCategories as $row)
                        <tr>
                            <td>{{$row->id}}</td>
                            <td width="150">{{$row->name_en}}</td>
                            <td width="150">{{$row->name_ar}}</td>
                            <td width="150">{{$row->level}}</td>
                            <td width="150">{{$row->parent->name_en}}</td>
                            <td width="150">{{($row->is_available==0)?'Out Stock':'In Stock'}}</td>
                            <td>
                                <a class="btn btn-dark" href="{{route('productsCategories.subCategoryEdit',$row)}}">Edit</a>
                                <a class="btn btn-danger my-2" href="{{route('productsCategories.delete',$row)}}">Delete</a>
                                <form action="{{route('categoryChangeStatus',$row->id)}}" method="post" enctype="multipart/form-data">
                                    @csrf
                                    @if($row->is_available == 0)
                                        <input type="hidden" name="is_available" value=1>
                                        <button class="btn btn-success" >In Stock</button>
                                    @elseif($row->is_available == 1)
                                        <input type="hidden" name="is_available" value=0>
                                        <button  class="btn btn-danger" >Out Stock</button>
                                    @endif
                                </form>

                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                    <tfoot>
                    <tr>
                        <th>#</th>
                        <th>Name EN</th>
                        <th>Name AR</th>
                        <th>level</th>
                        <th>Parent</th>
                        <th>Status</th>
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
