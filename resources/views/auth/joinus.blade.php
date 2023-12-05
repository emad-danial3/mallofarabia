@extends('layouts.app')

@section('style')
    <style>

        .log-in-section::after {
            background-image: url(../assets/images/background/loginbg.png);
            background-repeat: no-repeat;
            height: 100%;
            background-position: center;
            background-size: cover;
        }

        .log-in-section .log-in-box .log-in-title h4, .form-check-label {
            color: #979797;
        }

        .log-in-box {
            background-color: white !important;
            border: 1px solid #E9E9E9;
            box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.25);
            border-radius: 16px;
            padding-top: 23px;
        }

        .log-in-box form input {
            border: 1px solid rgba(0, 0, 0, 0.4) !important;
            border-radius: 11px !important;
        }


        .identitycard {
            position: absolute;
            top: 0px;
            right: 0;
            left: 0;
            opacity: 0;
            width: 100%;
            cursor: pointer;
            height: 100%;
        }

        .uploaded {
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .g-4, .gy-4 {
            --bs-gutter-y: 0.7rem !important;
        }

        .theme-form-floating .form-control, .theme-form-floating .form-select {
            height: calc(40px);
        }

        #country_id, #city_id, #area_id {
            height: calc(43px);
        }

        .theme-form-floating label {
            font-size: calc(10px + 3 * (100vw - 320px) / 1600);
            padding-top: 9px;
            padding-bottom: 9px;
        }

        .gender label {
            padding-top: 0px;
        }

        .cardID img {
            width: 75%;
            height: 110px;
            margin: auto !important;
            background: #FFFFFF;
            border: 0.5px solid rgba(0, 0, 0, 0.5);
            border-radius: 15px;
        }
    </style>
@endsection
@section('content')
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @include('layoutsWep.componants.messages')


    <!-- log in section start -->
    <section class="log-in-section section-b-space">
        <div class="container-fluid-lg w-100">
            <div class="row">
                <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-3"></div>

                <div class="col-xxl-8 col-xl-6 col-lg-6 col-md-6 mx-auto">
                    <div class="log-in-box">
                        <div class="log-in-title">
                            <h3 class="text-center theme-second-color">{{trans('website.Welcome to 4U Netting Hub',[],session()->get('locale'))}}</h3>
                            <h4 class="text-center">   {{trans('website.Create New Member Account',[],session()->get('locale'))}}  </h4>
                        </div>

                        <div class="input-box">
                            <form class="row g-4" method="POST" action="{{url('joinus') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="col-4">
                                    <div class="form-floating theme-form-floating">
                                        <div class="form-floating theme-form-floating">
                                            <input type="text" class="form-control" id="fname" name="fname" value="{{ old('fname') }}" required autofocus placeholder="{{trans('website.First Name',[],session()->get('locale'))}}">
                                            <label for="fname">{{trans('website.First Name',[],session()->get('locale'))}}</label>
                                            @if($errors->has('fname'))
                                                <div class="alert alert-danger text-center" role="alert">
                                                    {{ $errors->first('fname') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-floating theme-form-floating">
                                        <div class="form-floating theme-form-floating">
                                            <input type="text" class="form-control" id="mname" name="mname" value="{{ old('mname') }}" required autofocus placeholder="{{trans('website.Middle Name',[],session()->get('locale'))}}">
                                            <label for="mname">{{trans('website.Middle Name',[],session()->get('locale'))}}</label>
                                            @if($errors->has('mname'))
                                                <div class="alert alert-danger text-center" role="alert">
                                                    {{ $errors->first('mname') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="form-floating theme-form-floating">
                                        <div class="form-floating theme-form-floating">
                                            <input type="text" class="form-control" id="lname" name="lname" value="{{ old('lname') }}" required autofocus placeholder="{{trans('website.Last Name',[],session()->get('locale'))}}">
                                            <label for="lname">{{trans('website.Last Name',[],session()->get('locale'))}}</label>
                                            @if($errors->has('lname'))
                                                <div class="alert alert-danger text-center" role="alert">
                                                    {{ $errors->first('lname') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating theme-form-floating">
                                        <div class="form-floating theme-form-floating">
                                            <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="{{trans('website.Email Address',[],session()->get('locale'))}}">
                                            <label for="email">{{trans('website.Email Address',[],session()->get('locale'))}}</label>
                                            @if($errors->has('email'))
                                                <div class="alert alert-danger text-center" role="alert">
                                                    {{ $errors->first('email') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating">
                                        <div class="form-floating theme-form-floating">
                                            <input type="text" minlength="11" maxlength="11" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required autofocus placeholder="{{trans('website.Phone Number',[],session()->get('locale'))}}  {{trans('website.(11 digit)',[],session()->get('locale'))}}">
                                            <label for="phone">{{trans('website.Phone Number',[],session()->get('locale'))}}  {{trans('website.(11 digit)',[],session()->get('locale'))}}</label>
                                            @if($errors->has('phone'))
                                                <div class="alert alert-danger text-center" role="alert">
                                                    {{ $errors->first('phone') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating">
                                        <div class="form-floating theme-form-floating">
                                            <input type="password" class="form-control" id="password" name="password" required autofocus placeholder="{{trans('website.password',[],session()->get('locale'))}}">
                                            <label for="password">{{trans('website.password',[],session()->get('locale'))}}</label>
                                            @if($errors->has('password'))
                                                <div class="alert alert-danger text-center" role="alert">
                                                    {{ $errors->first('password') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating">
                                        <div class="form-floating theme-form-floating">
                                            <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required autofocus placeholder="{{trans('website.Address',[],session()->get('locale'))}}">
                                            <label for="address">{{trans('website.Address',[],session()->get('locale'))}}</label>
                                            @if($errors->has('address'))
                                                <div class="alert alert-danger text-center" role="alert">
                                                    {{ $errors->first('address') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating">
                                        <div class="form-floating theme-form-floating row">
                                            <div class="col-4">
                                                <select name="country_id" id="country_id" class="form-control">
                                                    @foreach($countries as $country)
                                                        <option value="{{$country->id}}"> {{$country->name_en}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <input type="hidden" id="old_city_id" value="{{ old('city_id')}}">
                                                <select name="city_id" id="city_id" class="form-control">
                                                    <option value="">{{trans('website.Choose City',[],session()->get('locale'))}}</option>
                                                    @foreach($cities as $city)
                                                        <option value="{{$city->id}}"> {{$city->name_en}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="col-4">
                                                <input type="hidden" id="old_area_id" value="{{ old('area_id') }}">
                                                <select name="area_id" id="area_id" class="form-control">
                                                    <option value="">{{trans('website.Choose Area',[],session()->get('locale'))}}</option>
                                                </select>
                                                @if($errors->has('area_id'))
                                                    <div class="alert alert-danger text-center" role="alert">
                                                        {{ $errors->first('area_id') }}
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-floating theme-form-floating">
                                        <div class="form-floating theme-form-floating">
                                            <input type="text" class="form-control" id="nationality_id" name="nationality_id" value="{{ old('nationality_id') }}" required autofocus placeholder="{{trans('website.Nationality Id (14 digit)',[],session()->get('locale'))}}" minlength="14" maxlength="14">
                                            <label for="nationality_id">{{trans('website.Nationality Id (14 digit)',[],session()->get('locale'))}}</label>
                                            @if($errors->has('nationality_id'))
                                                <div class="alert alert-danger text-center" role="alert">
                                                    {{ $errors->first('nationality_id') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating">
                                        <div class="form-floating theme-form-floating">
                                            <input type="number" class="form-control" id="parent_membership_id" name="parent_membership_id" @if(old('parent_membership_id')) value="{{old('parent_membership_id')}}" @elseif($membership)value="{{$membership}}" @endif placeholder="{{trans('website.Invited by (optional)',[],session()->get('locale'))}}">
                                            <label for="parent_membership_id">{{trans('website.Invited by (optional)',[],session()->get('locale'))}}</label>
                                            @if($errors->has('parent_membership_id'))
                                                <div class="alert alert-danger text-center" role="alert">
                                                    {{ $errors->first('parent_membership_id') }}
                                                </div>
                                            @endif
                                            @if($membership && $membershipName)
                                                <div class="col-md-12">
                                                    <h6>Invited
                                                        by<span class="theme-color"> ({{$membershipName}}) </span>
                                                    </h6>
                                                </div>
                                            @else
                                                <div class="col-md-12">
                                                    <h6>{{trans('website.Invited by (optional)',[],session()->get('locale'))}}</h6>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating theme-form-floating">
                                        <div class="form-floating theme-form-floating">
                                            <div class="cardID d-block">
                                                <div class="d-flex justify-content-center w-100">
                                                    <img class="card-img-top" src="{{asset('assets/images/identityfront.png')}}" alt="Card image" height="200">
                                                </div>

                                                <div class="card-body">
                                                    <button class="btn theme-bg-color text-white btn-md  fw-bold mx-auto" onclick="saveOrderButton()">
                                                        إدخل البطاقة من الامام
                                                    </button>
                                                    <input type="file" accept="image/*" class="identitycard" id="front_id_image" name="front_id_image" value="{{ old('front_id_image') }}">
                                                </div>
                                                <div class="text-center mb-2 d-none uploadefrontimage uploaded">
                                                    Uploaded &nbsp;
                                                    <i class="fa-solid fa-circle-check theme-color fa-2x"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-floating theme-form-floating">
                                        <div class="form-floating theme-form-floating">
                                            <div class="cardID d-block">
                                                <div class="d-flex justify-content-center w-100">
                                                    <img class="card-img-top" src="{{asset('assets/images/identityback.png')}}" alt="Card image" height="200">

                                                </div>
                                                <div class="card-body">
                                                    <button class="btn theme-bg-color text-white btn-md  fw-bold mx-auto" onclick="saveOrderButton()">
                                                        إدخل البطاقة من الخلف
                                                    </button>
                                                    <input type="file" accept="image/*" class="identitycard" id="back_id_image" name="back_id_image" value="{{ old('back_id_image') }}">

                                                </div>
                                                <div class="text-center mb-2 d-none uploadebackimage uploaded">
                                                    Uploaded &nbsp;
                                                    <i class="fa-solid fa-circle-check theme-color fa-2x"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="alert alert-danger text-center imagesattition d-none" role="alert">
                                        قم برفع الصور مرة اخري
                                    </div>
                                </div>


                                <div class="col-12">
                                    <div class="form-floating theme-form-floating">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-check">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="row gender">
                                                            <div class="col-md-3">
                                                                <h5>{{trans('website.Gender',[],session()->get('locale'))}}</h5>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input class="form-check-input" type="radio" name="gender" id="male" value="male" checked>
                                                                <label class="form-check-label" for="male">
                                                                    {{trans('website.Male',[],session()->get('locale'))}}
                                                                </label>
                                                            </div>
                                                            <div class="col-md-4">
                                                                <input class="form-check-input" type="radio" name="gender" id="female" value="female">
                                                                <label class="form-check-label" for="female">
                                                                    {{trans('website.Female',[],session()->get('locale'))}}
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="forgot-box">
                                        <div class="form-check ps-0 m-0 remember-box">
                                            <input class="checkbox_animated check-box" type="checkbox" required
                                                   id="flexCheckDefault">
                                            <label class="form-check-label" for="flexCheckDefault">I
                                                {{trans('website.I agree with',[],session()->get('locale'))}}
                                                <span>{{trans('website.Terms and Privacy',[],session()->get('locale'))}}</span></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12 d-flex justify-content-center">
                                    <button class="btn btn-animation w-75 justify-content-center background-dark-mint" type="submit">{{trans('website.Sign Up',[],session()->get('locale'))}}
                                    </button>
                                </div>
                            </form>
                        </div>

                        {{--                        <div class="other-log-in">--}}
                        {{--                            <h6>or</h6>--}}
                        {{--                        </div>--}}

                        {{--                        <div class="log-in-button">--}}
                        {{--                            <ul>--}}
                        {{--                                <li>--}}
                        {{--                                    <a href="https://accounts.google.com/signin/v2/identifier?flowName=GlifWebSignIn&flowEntry=ServiceLogin"--}}
                        {{--                                       class="btn google-button w-100">--}}
                        {{--                                        <img src="../assets/images/inner-page/google.png" class="blur-up lazyload"--}}
                        {{--                                             alt="">--}}
                        {{--                                        Sign up with Google--}}
                        {{--                                    </a>--}}
                        {{--                                </li>--}}
                        {{--                                <li>--}}
                        {{--                                    <a href="https://www.facebook.com/" class="btn google-button w-100">--}}
                        {{--                                        <img src="../assets/images/inner-page/facebook.png" class="blur-up lazyload"--}}
                        {{--                                             alt=""> Sign up with Facebook--}}
                        {{--                                    </a>--}}
                        {{--                                </li>--}}
                        {{--                            </ul>--}}
                        {{--                        </div>--}}

                        {{--                        <div class="other-log-in">--}}
                        {{--                            <h6></h6>--}}
                        {{--                        </div>--}}

                        {{--                        <div class="sign-up-box">--}}
                        {{--                            <h4>Already have an account?</h4>--}}
                        {{--                            <a class="btn theme-bg-color mt-3 text-white" href="{{ url('login') }}">Log In</a>--}}
                        {{--                        </div>--}}
                    </div>
                </div>
                <div class="col-xxl-2 col-xl-3 col-lg-3 col-md-3"></div>
            </div>
        </div>
    </section>
    <!-- log in section end -->

    <script type="text/javascript">
        $(document).ready(function () {
            var base_url    = window.location.origin;
            var old_city_id = $("#old_city_id").val();
            var old_area_id = $("#old_area_id").val();

            if (old_city_id > 0) {
                $("#city_id").val(old_city_id);
                $('.imagesattition').removeClass('d-none');
                let formData = new FormData();
                formData.append('city_id', old_city_id);
                let path = base_url + "/get-regions";
                console.log("path", path);
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    processData: false,
                    success: function (response) {
                        if (response) {
                            $("#area_id").html('');
                            $("#area_id").append(
                                '<option value="">Choose Area</option>'
                            );
                            if (response.regions.length > 0) {
                                for (let ii = 0; ii < response.regions.length; ii++) {
                                    let proObj = response.regions[ii];
                                    $("#area_id").append(
                                        '<option value="' + proObj['id'] + '">' + proObj['region_en'] + '</option>'
                                    );
                                }
                            }
                            $("#area_id").val(old_area_id);
                        }
                        else {
                            $("#area_id").html('');
                            $("#area_id").append(
                                '<option value="">Choose Area</option>'
                            );
                        }
                    },
                    error: function (response) {
                        console.log(response)
                        alert('error in choose');
                    }
                });
            }
            // $("select").select2();
            $("#back_id_image").change(function () {
                $('.uploadebackimage').removeClass('d-none');
            });
            $("#front_id_image").change(function () {
                $('.uploadefrontimage').removeClass('d-none');
            });

            $("#country_id").change(function () {

                var country_id = $("#country_id").val();
                let formData   = new FormData();
                formData.append('country_id', country_id);
                let path = base_url + "/get-cities";
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    processData: false,
                    success: function (response) {
                        if (response) {
                            $("#city_id").html('');
                            $("#city_id").append(
                                '<option value="">Choose City</option>'
                            );
                            if (response.cities.length > 0) {

                                for (let ii = 0; ii < response.cities.length; ii++) {
                                    let proObj = response.cities[ii];
                                    $("#city_id").append(
                                        '<option value="' + proObj['id'] + '">' + proObj['name_en'] + '</option>'
                                    );
                                }
                            }
                        }
                        else {
                            $("#city_id").html('');
                            $("#city_id").append(
                                '<option value="">Choose City</option>'
                            );
                        }
                    },
                    error: function (response) {
                        console.log(response)
                        alert('error in choose');
                    }
                });
            });

            $("#city_id").change(function () {
                var city_id  = $("#city_id").val();
                let formData = new FormData();
                formData.append('city_id', city_id);
                let path = base_url + "/get-regions";
                console.log("path", path);
                $.ajax({
                    url: path,
                    type: 'POST',
                    data: formData,
                    cache: false,
                    contentType: false,
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    processData: false,
                    success: function (response) {
                        if (response) {
                            $("#area_id").html('');
                            $("#area_id").append(
                                '<option value="">Choose Area</option>'
                            );
                            if (response.regions.length > 0) {
                                for (let ii = 0; ii < response.regions.length; ii++) {
                                    let proObj = response.regions[ii];
                                    $("#area_id").append(
                                        '<option value="' + proObj['id'] + '">' + proObj['region_en'] + '</option>'
                                    );
                                }
                            }
                        }
                        else {
                            $("#area_id").html('');
                            $("#area_id").append(
                                '<option value="">Choose Area</option>'
                            );
                        }
                    },
                    error: function (response) {
                        console.log(response)
                        alert('error in choose');
                    }
                });
            });


        });
    </script>

@endsection
