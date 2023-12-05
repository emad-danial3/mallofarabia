@extends('AdminPanel.layouts.main')
@section('content')


    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}">Home</a></li>
                        <li class="breadcrumb-item"><a href="{{route('users.index')}}">Users</a></li>
                        <li class="breadcrumb-item active">{{isset($user)?'Edit / '.$user->full_name :'ADD'}}</li>
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
                        <form  action="{{(isset($user))?route('users.update',$user):route('users.store')}}" method="post" enctype="multipart/form-data">
                            @include('AdminPanel.layouts.messages')
                            @csrf
                            {{isset($user)?method_field('PUT'):''}}
                            <div class="card-body">
                                <div class="form-group">
                                    <label for="name">full_name</label>
                                    <input type="text" name="full_name" class="form-control"
                                           placeholder="Enter Name" value="@if(old('full_name')){{old('full_name')}}@elseif(isset($user->full_name)){{$user->full_name}}@endif" required>
                                </div>

                                <div class="form-group">
                                    <label for="name">Email</label>
                                    <input type="text" name="email" class="form-control"
                                           placeholder="Enter Email" value="@if(old('email')){{old('email')}}@elseif(isset($user->email)){{$user->email}}@endif" required>
                                </div>
                                
                              

                                <div class="form-group">
                                    <label for="phone">Phone</label>
                                    <input type="number" name="phone" id="materialRegisterFormPassword"  class="form-control" aria-describedby="materialRegisterFormPasswordHelpBlock" name="mob1" required oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" onKeyDown="if(this.value.length==11 && event.keyCode!=8) return false;"   value="@if(old('phone')){{old('phone')}}@elseif(isset($user->phone)){{$user->phone}}@endif" >
                                </div>

                                <div class="form-group">
                                    <label for="password">Password <span style="color: red"> ( Write if you want to change it ) </span> </label>
                                    <input type="password" placeholder="Password" class="form-control"  minlength="6" maxlength="8"  name="password"  >
                                </div>

                                <div class="form-group">
                                    <label for="front_id_image">Front ID Image</label>
                                    <input type="file" class="form-control" name="front_id_image"  @if(!isset($user))required @endif>
                                </div>

                                <div class="form-group">
                                    <label for="back_id_image">Back ID Image</label>
                                    <input type="file" class="form-control" name="back_id_image" @if(!isset($user))required @endif>
                                    <br>
                                    @if(isset($user->front_id_image))
                                        <img src="{{$user->front_id_image}}" width="250" height="250">
                                    @endif
                                    @if(isset($user->back_id_image))
                                        <img src="{{url($user->back_id_image)}}" width="250" height="250">
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
