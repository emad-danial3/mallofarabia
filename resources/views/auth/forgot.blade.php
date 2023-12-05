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
        .log-in-section .log-in-box .log-in-title h4,.form-check-label {
            color: #979797;
        }
        .log-in-box {
            background-color: white !important;
            border: 1px solid #E9E9E9;
            box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.25);
            border-radius: 16px;
            padding-top:23px ;
        }
        .log-in-box form input {
            border: 1px solid rgba(0, 0, 0, 0.4)!important;
            border-radius: 11px!important;
        }

    </style>
@endsection
@section('content')
    <input type="hidden" name="_token" value="{{ csrf_token() }}">

    @include('layoutsWep.componants.messages')








    <!-- log in section start -->
    <section class="log-in-section background-image-2 section-b-space">
        <div class="container-fluid-lg w-100">
            <div class="row">
                <div class="col-xxl-3">
                </div>

                <div class="col-xxl-6 col-xl-6 col-lg-6 col-sm-6 mx-auto">
                    <div class="log-in-box">
                        <div class="log-in-title">
                            <h3 class="text-center theme-second-color">{{trans('website.Welcome to 4U Netting Hub',[],session()->get('locale'))}}</h3>
                            <h4 class="text-center">{{trans('website.Forgot your password',[],session()->get('locale'))}}  </h4>
                        </div>

                        <div class="input-box">
                            <form class="row g-4" method="POST" action="{{url('forgot') }}">
                                {{ csrf_field() }}
                                <div class="col-12">
                                    <div class="form-floating theme-form-floating log-in-form">
                                        <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" required autofocus placeholder="{{trans('website.Email Address',[],session()->get('locale'))}}">
                                        <label for="email">{{trans('website.Email Address',[],session()->get('locale'))}}</label>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <button class="btn btn-animation w-100 justify-content-center background-dark-mint" type="submit">
                                   {{trans('website.Reset Password',[],session()->get('locale'))}}
                                    </button>

                                </div>
                            </form>
                        </div>


                    </div>
                </div>
                <div class="col-xxl-3">
                </div>
            </div>
        </div>
    </section>
    <!-- log in section end -->
@endsection
