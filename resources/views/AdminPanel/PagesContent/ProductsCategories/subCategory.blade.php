@extends('AdminPanel.layouts.main')
@section('content')


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('productsCategories.mainCategory')}}">Main Categories</a></li>
                        <li class="breadcrumb-item active">{{isset($category)?'Edit / '.$category->name_en :'ADD'}}</li>
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
                        <form  action="{{(isset($category))?route('productsCategories.update',$category):route('productsCategories.storeSubCategory')}}" method="post" enctype="multipart/form-data">
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
                                            @foreach($productsCategories as $productCategory)
                                                <option value="{{$productCategory->id}}"
                                                        @if(isset($category->parent->id)&& $category->parent->id==$productCategory->id)selected @endif>{{$productCategory->name_ar}}
                                                        <br> || {{$productCategory->name_en}}
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



{{--                                <div class="form-group">--}}
{{--                                    <label class="control-label col-md-12 col-sm-12 col-xs-12" for="name">--}}
{{--                                        Sub Category--}}
{{--                                    </label>--}}
{{--                                    <div class="col-md-12 col-sm-12 col-xs-12">--}}
{{--                                        <select id="level2" name='child_id'>--}}
{{--                                        </select>--}}
{{--                                    </div>--}}
{{--                                </div>--}}



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

    @push('scripts')
        <script>
            $('#parent_id').change(function(){
                $('#level2 option').remove();
              var  id = $(this).val();
                $.ajax({
                    type: "GET",
                    url: "{{route('getCteroires')}}",
                    data: {parent_id:id},
                    cache: false,
                    dataType:"json",
                    success: function(data){
                            $.each(data, function(k, v) {

                                    $('#level2').append("<option class='form-control col-md-12 col-xs-12'  value="+v['id']+">"+v['name_en']+"||"+v['level']+" </option>");

                            });
                    },
                    fail:function (Error) {
                        console.log(Error)
                    }
                });

            });
        </script>
    @endpush
@endsection
