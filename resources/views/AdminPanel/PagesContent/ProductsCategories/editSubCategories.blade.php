@extends('AdminPanel.layouts.main')
@section('content')


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('productsCategories.subCategory')}}"> Sub Categories</a></li>
                        <li class="breadcrumb-item active">Edit / {{$category->name_en}}</li>
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
            <div class="row">
                <!-- left column -->
                <div class="col-md-12">
                    <!-- jquery validation -->
                    <div class="card card-primary">

                        <!-- /.card-header -->
                        <!-- form start -->
                        <form  action="{{route('productsCategories.subCategoryUpdate',$category)}}" method="post" enctype="multipart/form-data">
                            @include('AdminPanel.layouts.messages')
                            @csrf
                            {{isset($category)?method_field('PUT'):''}}
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name_en">Name EN</label>
                                    <input type="text" name="name_en" class="form-control"
                                           placeholder="Enter English Name" value="@if(old('name_en')){{old('name_en')}}@elseif(isset($category->name_en)){{$category->name_en}}@endif" required>
                                </div>

                                <div class="form-group">
                                    <label for="name_ar">Name Ar</label>
                                    <input type="text" name="name_ar" class="form-control"
                                           placeholder="Enter Arabic Name" value="@if(old('name_ar')){{old('name_ar')}}@elseif(isset($category->name_ar)){{$category->name_ar}}@endif" required>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-12 col-sm-12 col-xs-12" for="name">
                                        Main Category
                                    </label>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <select name="parent_id"  id="parent_id" class="form-control col-md-12 col-xs-12" required>
                                            @foreach($parents as $productCategory)
                                                <option value="{{$productCategory->id}}"
                                                        @if(isset($category->parent->id)&& $category->parent->id==$productCategory->id)selected @endif>{{$productCategory->name_ar}}
                                                    <br>||{{$productCategory->name_en}} ||  {{$productCategory->level}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label for="image">Image</label>
                                    <input type="file" class="form-control" name="image" @if(!isset($category))required @endif>
                                    <br>
                                    @if(isset($category->image))
                                        <img src="{{url($category->image)}}" width="250" height="250">
                                    @endif
                                </div>

                            </div>
                            <!-- /.card-body -->
                            <div class="card-footer">
                                <button type="submit" class="btn btn-success">Save Info</button>
                            </div>
                        </form>
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
