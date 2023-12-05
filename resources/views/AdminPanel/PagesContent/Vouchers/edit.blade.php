@extends('AdminPanel.layouts.main')
@section('content')


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('vouchers.index')}}">Vouchers</a></li>
                        <li class="breadcrumb-item active">{{isset($voucher)?'Edit / '.$voucher->name :'ADD'}}</li>
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
                        <form  action="{{(isset($voucher))?route('vouchers.update',$voucher):route('vouchers.store')}}" method="post" enctype="multipart/form-data">
                            @include('AdminPanel.layouts.messages')
                            @csrf
                            {{isset($voucher)?method_field('PUT'):''}}

                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" name="name" class="form-control"
                                           placeholder="Enter Voucher Name" value="@if(old('name')){{old('name')}}@elseif(isset($voucher->name)){{$voucher->name}}@endif" required>
                                </div>

                                <div class="form-group">
                                    <label for="code">Code</label>
                                    <input type="text" name="code" class="form-control"
                                           placeholder="Enter Code" value="@if(old('code')){{old('code')}}@elseif(isset($voucher->code)){{$voucher->code}}@endif" required>
                                </div>
                                <div class="form-group">
                                    <label for="description">description</label>
                                    <textarea type="text" name="description" class="form-control"
                                           placeholder="Enter description" value="@if(old('description')){{old('description')}}@elseif(isset($voucher->description)){{$voucher->description}}@endif" required>
                                    </textarea>
                                </div>
                                <input type="hidden" name="voucher_type_id" value="1">
                                <input type="hidden" name="discount_type" value="Percent">

                                <div class="form-group">
                                    <label for="max_uses">max uses for all</label>
                                    <input type="number" name="max_uses" class="form-control"
                                           placeholder="Enter max_uses number" value="@if(old('max_uses')){{old('max_uses')}}@elseif(isset($voucher->max_uses)){{$voucher->max_uses}}@endif" required>
                                </div>
                                <div class="form-group">
                                    <label for="max_uses_user">max uses per user</label>
                                    <input type="number" name="max_uses_user" class="form-control"
                                           placeholder="Enter max_uses_user number" value="@if(old('max_uses_user')){{old('max_uses_user')}}@elseif(isset($voucher->max_uses_user)){{$voucher->max_uses_user}}@endif" required>
                                </div>
                                <div class="form-group">
                                    <label for="discount_amount">discount amount</label>
                                    <input type="number" name="discount_amount" class="form-control"
                                           placeholder="Enter discount_amount number" value="@if(old('discount_amount')){{old('discount_amount')}}@elseif(isset($voucher->discount_amount)){{$voucher->discount_amount}}@endif" required>
                                </div>
                                <div class="form-group">
                                    <label for="starts_at">starts at</label>
                                    <input type="date" name="starts_at" class="form-control"
                                           placeholder="Enter starts_at number" value="@if(old('starts_at')){{old('starts_at')}}@elseif(isset($voucher->starts_at)){{$voucher->starts_at}}@endif" >
                                </div>
                                <div class="form-group">
                                    <label for="expires_at">expires at</label>
                                    <input type="date" name="expires_at" class="form-control"
                                           placeholder="Enter expires_at number" value="@if(old('expires_at')){{old('expires_at')}}@elseif(isset($voucher->expires_at)){{$voucher->expires_at}}@endif" >
                                </div>
                                <div class="form-group">
                                    <label for="url">Image</label>
                                    <input type="file" class="form-control" name="image" @if(!isset($voucher))required @endif>
                                    <br>
                                    @if(isset($voucher->image))
                                        <img src="{{url($voucher->image)}}" width="250" height="250">
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="control-label col-md-12 col-sm-12 col-xs-12" for="name">
                                        Available
                                    </label>
                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                        <select name="is_available" class="form-control col-md-12 col-xs-12">
                                            <option value="1"
                                                    @if(isset($voucher->is_available)&& $voucher->is_available==1)selected @endif>Available
                                            </option>
                                            <option value="0"
                                                    @if(isset($voucher->is_available)&& $voucher->is_available==0)selected @endif> Not Available
                                            </option>
                                        </select>
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
