@extends('AdminPanel.layouts.main')
@section('content')


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('areas.index')}}">Areas</a></li>
                        <li class="breadcrumb-item active">{{isset($area)?'Edit / '.$area->name_en :'ADD'}}</li>
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
                        <form  action="{{(isset($area))?route('areas.update',$area):route('areas.store')}}" method="post" enctype="multipart/form-data">
                            @include('AdminPanel.layouts.messages')
                            @csrf
                            {{isset($area)?method_field('PUT'):''}}

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name_en">Name EN</label>
                                    <input type="text" name="region_en" class="form-control"
                                           placeholder="Enter English Name" value="@if(old('region_en')){{old('region_en')}}@elseif(isset($area->region_en)){{$area->region_en}}@endif" required>
                                </div>

                                <div class="form-group">
                                    <label for="region_ar">Name Ar</label>
                                    <input type="text" name="region_ar" class="form-control"
                                           placeholder="Enter Arabic Name" value="@if(old('region_ar')){{old('region_ar')}}@elseif(isset($area->region_ar)){{$area->region_ar}}@endif" required>
                                </div>

                                <div class="form-group">
                                    <label for="governorate">Governorate</label>
                                    <input type="text" name="governorate" class="form-control"
                                           placeholder="Enter  Name" value="@if(old('governorate')){{old('governorate')}}@elseif(isset($area->governorate)){{$area->governorate}}@endif" required>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-12 col-sm-12 col-xs-12" for="name">
                                        City
                                    </label>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <select name="city_id" class="form-control col-md-12 col-xs-12">
                                            @foreach($cities as $city)
                                                <option value="{{$city->id}}"
                                                        @if(isset($area->city->id)&& $area->city->id==$city->id)selected @endif>{{$city->name_ar}}
                                                    <br>{{$city->name_en}}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
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
