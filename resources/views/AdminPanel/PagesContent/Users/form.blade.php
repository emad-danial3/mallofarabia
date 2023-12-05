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

                                <input type="hidden" name="parent_id" value="1">
                                <input type="hidden" name="stage" value="2">
                                <div class="form-group">
                                    <label for="name">Email</label>
                                    <input type="text" name="email" class="form-control"
                                           placeholder="Enter Email" value="@if(old('email')){{old('email')}}@elseif(isset($user->email)){{$user->email}}@endif" required>
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
                                <input type="hidden" name="notionality" value="egypt">
                                <!-- Default inline 1-->
                                <div class="form-check form-check-inline"style="text-align:center;">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="gender"
                                        id="inlineRadio1"
                                        value="male"
                                        required
                                    />
                                    <label class="form-check-label" for="inlineRadio1">{{ trans('auth.attributes.male')}}</label>
                                </div>
                                <!-- Default inline 2-->

                                <div class="form-check form-check-inline" style="text-align:center;">
                                    <input
                                        class="form-check-input"
                                        type="radio"
                                        name="gender"
                                        id="inlineRadio2"
                                        value="female"
                                        required
                                    />
                                    <label class="form-check-label" for="inlineRadio2">{{ trans('auth.attributes.female')}}</label>
                                </div>

                                <div class="md-form">
                                    <label for="materialRegisterFormPassword"><i class="far fa-calendar-alt"></i> {{ trans('auth.attributes.birthday')}}</label>
                                    <input type="date" id="materialbirthday" class="form-control" aria-describedby="materialRegisterFormPasswordHelpBlock" name="birthday" required  value="" >


                                </div>

                                <div class="md-form">
                                    <label for="materialRegisterFormAddress"><i class="far fa-address-card"></i> {{ trans('auth.attributes.address')}}</label>
                                    <input type="text" id="materialaddress" class="form-control" aria-describedby="materialRegisterFormAddressHelpBlock" name="address" requiredn value=""  >


                                </div>
                                <div class="md-form"  style=" padding:1rem;">
                                    <select  id="city-dropdown" class="form-select" aria-label="Default select example" class="form-control" aria-describedby="materialRegisterFormcityHelpBlock" name="city" required>
                                        <option value="" selected>{{ trans('auth.attributes.city')}}</option>

                                        @foreach ($cities as $city)

                                            <option value="{{$city->id}}">
                                                {{$city->name_en}}
                                            </option>
                                        @endforeach

                                    </select>

                                </div>

                                <div class="md-form"style=" padding:1rem;">
                                    <select id="regions-dropdown" class="form-select" aria-label="Default select example" class="form-select" aria-label="Default select example"  class="form-control" aria-describedby="materialRegisterFormareaHelpBlock" name="area"    required>

                                        <option value="">{{ trans('auth.attributes.select_city_first')}}</option>


                                    </select>


                                </div>

                                <div class="md-form">
                                    <label for="materialRegisterFormbuilding"><i class="far fa-building"></i>{{ trans('auth.attributes.building_number')}}</label>

                                    <input type="number" id="materialRegisterFormbuilding" class="form-control" aria-describedby="materialRegisterFormbuildingHelpBlock" name="building_number" required value="">

                                </div>
                                <div class="md-form">
                                    <label for="materialRegisterFormfloor"><i class="far fa-building"></i>{{ trans('auth.attributes.floor_number')}}</label>
                                    <input type="number" id="materialRegisterFormfloor" class="form-control" aria-describedby="materialRegisterFormfloorHelpBlock" name="floor_number" required value="">


                                </div>
                                <div class="md-form">
                                    <label for="materialRegisterFormApartment"><i class="far fa-building"></i>{{ trans('auth.attributes.apartment_number')}}</label>
                                    <input type="number" id="materialRegisterFormApartment" class="form-control" aria-describedby="materialRegisterFormApartmentHelpBlock" name="apartment_number" required  value="">


                                </div>

                                <div class="md-form">
                                    <label for="materialRegisterFormLandmark"><i class="fas fa-landmark"></i> {{ trans('auth.attributes.landmark')}}</label>
                                    <input type="text" id="materialRegisterFormLandmark" class="form-control" aria-describedby="materialRegisterFormLandmarkHelpBlock" name="landmark" required value="">


                                </div>
                                <div class="md-form">
                                    <label for="materialRegisterFormPassword"><i class="fas fa-mobile-alt"></i> {{ trans('auth.attributes.mobile')}} </label>
                                    <input type="number" name="phone" id="materialRegisterFormPassword"  class="form-control{{ $errors->has('mob1') ? ' is-invalid' : '' }}" aria-describedby="materialRegisterFormPasswordHelpBlock" name="mob1" required oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" onKeyDown="if(this.value.length==11 && event.keyCode!=8) return false;"   value="" >
                                    @if ($errors->has('mob1'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('mob1') }}</strong>
                                    </span>
                                    @endif
                                </div>


                                <div class="md-form">
                                    <label for="materialRegisterFormPassword"><i class="fas fa-phone-alt"></i> {{ trans('auth.attributes.telephone')}}</label>
                                    <input type="number" id="materialRegisterFormPassword"  class="form-control" aria-describedby="materialRegisterFormPasswordHelpBlock"  name="telephone"  oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" onKeyDown="if(this.value.length==11 && event.keyCode!=8) return false;"  value="{{ old('tel') }}">

                                </div>
                                <div class="md-form" style="position:relative;">
                                    <label for="materialRegisterFormPassword"><i class="fas fa-lock"></i> {{ trans('auth.attributes.password')}}</label>
                                    <div style="
    display: flex;
    flex-flow: row-reverse;
">

                                        <i class="fa fa-eye " style="cursor: pointer;margin: auto 10px;" id="eyeIcon2"  onclick="togglePassword('pass2','eyeIcon2')">
                                        </i>

                                        <input type="password"  minlength="6" maxlength="8" id="pass2" id="materialRegisterFormPassword" class="form-control" aria-describedby="materialRegisterFormPasswordHelpBlock"  name="password"    value="">
                                    </div></div>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" style="display: block !important;    position: inherit;
    margin: 4px;" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                                <div class="md-form" style="position: relative">
                                    <label for="materialRegisterFormPassword"><i class="fas fa-lock"></i> {{ trans('auth.attributes.password_confirmation')}}</label>
                                    <div style="
    display: flex;
    flex-flow: row-reverse;
">

                                        <i class="fa fa-eye " style="cursor: pointer;margin: auto 10px;" id="eyeIcon"  onclick="togglePassword('pass','eyeIcon')">
                                        </i>

                                        <input type="password" minlength="6" id="pass" maxlength="8" id="materialRegisterFormPassword" class="form-control" aria-describedby="materialRegisterFormPasswordHelpBlock"  name="password_confirmation"    value="">
                                    </div></div>
                                <div class="md-form">
                                    <label style="margin: 10px"></label>

                                    <select id="materialRegisterFormPassword" class="form-control" aria-describedby="materialRegisterFormPasswordHelpBlock" name="account_type" required>
                                        <option value="">Select Account Type</option>
                                        @foreach($types as $type)
                                        <option value="{{$type->id}}">{{$type->name_en}}</option>
                                            @endforeach
                                    </select>

                                </div>

                                <div class="md-form">
                                    <label for="materialRegisterFormPassword"><i class="far fa-id-card"></i>{{ trans('auth.attributes.id_number')}}</label>
                                    <input type="number" id="materialRegisterFormPassword" class="form-control {{ $errors->has('nationality_id') ? ' is-invalid' : '' }}" aria-describedby="materialRegisterFormPasswordHelpBlock" name="nationality_id" required  oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" onKeyDown="if(this.value.length==14 && event.keyCode!=8) return false;"   value="">
                                    @if ($errors->has('nationality_id'))
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $errors->first('nationality_id') }}</strong>
                                    </span>
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

        <script>
            $(document).ready(function() {
            $('#city-dropdown').on('change', function() {

                x=document.getElementById('city-dropdown');

                console.log(x)

                var city_id = this.value;
                //
                // if(!this.value)
                //     city_id=1
                $("#regions-dropdown").html('');
                $.ajax({
                    url:"{{url('get-regions')}}",
                    type: "POST",
                    data: {
                        city_id: city_id,
                        _token: '{{csrf_token()}}'
                    },
                    dataType : 'json',
                    success: function(result){
                        console.log(result)
                        $('#regions-dropdown').html('<option value="">Select Regions</option>');
                        $.each(result.regions,function(key,value){
                            $("#regions-dropdown").append('<option value="'+value.region_en+'">'+value.region_en+'</option>');
                        });
                    }
                });
            });

        });
            function disabledFunction(){
                document.getElementById("signUpPreBTN").disabled = true;
                document.getElementById("signUpPreBTN").value = "انتظر من فضلك ....";

            }
            function togglePassword(id,iconId) {
                let passwordInput = document.getElementById(id),
                    icon =  document.getElementById(iconId);

                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    icon.classList.add("fa-eye-slash");
                    //toggle.innerHTML = 'hide';
                } else {
                    passwordInput.type = 'password';
                    icon.classList.remove("fa-eye-slash");
                    //toggle.innerHTML = 'show';
                }
            }

        </script>
@push('custom-scripts')
    <script>



        $('#materialRegisterFormFirstName').bind('input', function(){
            $(this).val(function(_, v){
                return v.replace(/\s+/g, '');
            });
        });

        $('#materialRegisterFormMiddleName').bind('input', function(){
            $(this).val(function(_, v){
                return v.replace(/\s+/g, '');
            });
        });

        $('#materialRegisterFormLastName').bind('input', function(){
            $(this).val(function(_, v){
                return v.replace(/\s+/g, '');
            });
        });
        $(function(){
            $("#materialRegisterFormFirstName , #materialRegisterFormMiddleName , #materialRegisterFormLastName,#materialRegisterFormEmail").keypress(function(event){
                var ew = event.which;


                if(ew == 32)
                    return true;
                if(ew >= 48 && ew <= 57 )
                    return true;
                if(64 <= ew && ew <= 90)
                    return true;
                if(97 <= ew && ew <= 122)
                    return true;
                if(ew >= 32 && ew <= 47 )
                    return true;

                return false;
            });




        });




    </script>
@endpush


@push('custom-scripts')

@endpush
@endsection
