@extends('AdminPanel.layouts.main')
@section('content')


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('users.index')}}">Users</a></li>
                        <li class="breadcrumb-item active">{{isset($code)?'Edit / '.$code->full_name :'ADD'}}</li>
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
                        <form  action="{{(isset($code))?route('qrCodes.update',$code):route('qrCodes.store')}}" method="post" enctype="multipart/form-data">
                            @include('AdminPanel.layouts.messages')
                            @csrf
                            {{isset($code)?method_field('PUT'):''}}
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">Code</label>
                                    <input type="text" name="code" class="form-control"
                                           placeholder="Enter code" value="@if(old('code')){{old('code')}}@elseif(isset($code->code)){{$code->code}}@endif" required>
                                </div>
                                <div class="md-form">
                                    <label style="margin: 10px">Type</label>

                                    <select id="materialRegisterFormPassword" class="form-control"
                                            aria-describedby="materialRegisterFormPasswordHelpBlock" name="account_type" required>
                                        @foreach($types as $type)
                                            <option @if(isset($code) && $type->id == $code->account_type){{'selected'}}@endif
                                                    value="{{$type->id}}">{{$type->name_en}}</option>
                                        @endforeach
                                    </select>

                                </div>
                                <div class="md-form">
                                    <label > Start Date</label>
                                    <input type="date" value="@if(old('start_date')){{old('start_date')}}@endif"
                                      class="form-control"  name="start_date" required>

                                </div>
                                <div class="md-form">
                                    <label for="materialRegisterFormPassword"> End Date</label>
                                    <input required type="date" id="materialbirthday" value="@if(old('end_date')){{old('end_date')}}@elseif(isset($code->end_date)){{date($code->end_date)}}@endif" placeholder="@if(old('end_date')){{old('end_date')}}@elseif(isset($code->end_date)){{date($code->end_date)}}@endif" class="form-control"  name="end_date"  >

                                </div>
                                <div class="md-form">
                                <label for="materialRegisterFormPassword">availability </label>
                                <select id="materialRegisterFormPassword" class="form-control" aria-describedby="materialRegisterFormPasswordHelpBlock" name="is_available" required>
                                        <option @if(isset($code) && $code->is_available === 0){{'selected'}}@endif value="0"> not availabile</option>
                                        <option @if(isset($code) && $code->is_available === 1){{'selected'}}@endif value="1">availabile</option>
                                </select>
                                </div>
                            </div>
                                <!-- /.card-body -->
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
