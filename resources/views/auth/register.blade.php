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
        }

        .log-in-box form input {
            border: 1px solid rgba(0, 0, 0, 0.4) !important;
            border-radius: 11px !important;
        }

    </style>
@endsection
@section('content')
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    <!-- log in section start -->
    <section class="log-in-section section-b-space">
        <div class="container-fluid-lg w-100">
            <div class="row">
                <div class="col-xxl-3">
                </div>
                <div class="col-xxl-5 col-xl-5 col-lg-6 col-sm-8 mx-auto">
                    <div class="log-in-box">
                        <div class="log-in-title">
                            <h3 class="text-center  theme-second-color">{{trans('website.Welcome to 4U Netting Hub',[],session()->get('locale'))}}</h3>
                            <h4 class="text-center">{{trans('website.Create New Account',[],session()->get('locale'))}}</h4>
                        </div>
@include('layoutsWep.componants.messages')
                        <div class="input-box">
                            <form class="row g-4" method="POST" action="{{url('registeruser') }}">

                                {{ csrf_field() }}
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating">
                                        <div class="form-floating theme-form-floating">
                                            <input type="text" class="form-control" id="fullname" name="name" value="{{ old('name') }}" required autofocus placeholder="{{trans('website.Full Name',[],session()->get('locale'))}}">
                                            <label for="fullname">{{trans('website.Full Name',[],session()->get('locale'))}}</label>
                                        </div>
                                        @if($errors->has('fullname'))
                                            <div class="alert alert-danger text-center" role="alert">
                                                {{ $errors->first('fullname') }}
                                            </div>
                                        @endif
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
                                            <input type="text" minlength="11" maxlength="11" class="form-control" id="phone" name="phone" value="{{ old('phone') }}" required autofocus placeholder="{{trans('website.Phone Number',[],session()->get('locale'))}}">
                                            <label for="phone">{{trans('website.Phone Number',[],session()->get('locale'))}}</label>
                                            @if($errors->has('phone'))
                                                <div class="alert alert-danger text-center" role="alert">
                                                    {{ $errors->first('phone') }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
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
                                <div class="col-6">
                                    <div class="form-floating theme-form-floating">
                                        <div class="form-floating theme-form-floating">
                                            <input type="text" class="form-control" id="address" name="address" value="{{ old('address') }}" required autofocus placeholder="{{trans('website.Address',[],session()->get('locale'))}}">
                                            <label for="address">{{trans('website.Address',[],session()->get('locale'))}}</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-check">
                                                <div class="row">

                                                            <div class="col-md-11 row">
                                                                <div class="col-md-3"> <h5 class="pt-1">{{trans('website.Gender',[],session()->get('locale'))}}</h5></div>
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

                                                    {{--                                                    <div class="col-md-6">--}}
                                                    {{--                                                          <div class="row">--}}
                                                    {{--                                                                <div class="col-md-12">--}}
                                                    {{--                                                                    <h4>Invited by this member (option)</h4>--}}
                                                    {{--                                                                    <br>--}}
                                                    {{--                                                                </div>--}}
                                                    {{--                                                                <div class="col-md-12">--}}
                                                    {{--                                                                    <input type="number" class="form-control" id="parent_membership_id" name="parent_membership_id" value="{{ old('parent_membership_id') }}" placeholder="Membership Id">--}}
                                                    {{--                                                                </div>--}}
                                                    {{--                                                            </div>--}}
                                                    {{--                                                    </div>--}}
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="forgot-box">
                                        <div class="form-check ps-0 m-0 remember-box">
                                            <input class="checkbox_animated check-box" type="checkbox"
                                                   id="flexCheckDefault">
                                            <label class="form-check-label" for="flexCheckDefault">
                                               {{trans('website.I agree with',[],session()->get('locale'))}}
                                                <span>{{trans('website.Terms and Privacy',[],session()->get('locale'))}}</span></label>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-animation w-100 background-dark-mint" type="submit"> {{trans('website.Sign Up',[],session()->get('locale'))}}
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

{{--                        <div class="sign-up-box">--}}
{{--                            <h4>Already have an account?</h4>--}}
{{--                            <a class="btn theme-bg-color mt-3 text-white" class="btn theme-bg-color mt-3 text-white" href="{{ url('login') }}">Log--}}
{{--                                In</a>--}}
{{--                        </div>--}}
                    </div>
                </div>
                <div class="col-xxl-3">
                </div>
            </div>
        </div>
    </section>
    <!-- log in section end -->
@endsection
