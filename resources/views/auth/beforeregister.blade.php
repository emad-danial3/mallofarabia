@extends('layouts.app')

@section('style')
    <style>
        .client-section .clint-contain:hover h2 {
            opacity: 1;
        }

        .client-section .clint-contain h2 {
            opacity: .7;
        }

        .client-section {
            background-image: url(../assets/images/background/loginbg.png);
            background-repeat: no-repeat;
            height: 100%;
            background-position: center;
            background-size: cover;
        }

        .before-register {
            height: auto;
            background-color: white;
            border: 1px solid #E9E9E9;
            box-shadow: 0px 0px 2px rgba(0, 0, 0, 0.25);
            border-radius: 16px;
        }

        .before-register h4, .buttons-content div {
            color: rgba(0, 0, 0, 0.5);
        }

        .buttons-header {
            height: 60px;
            background: #F5F5F5;
            border-radius: 22px;
        }

        .buttons-header .active {
            background: #FFFFFF;
            box-shadow: 0px 2px 2px rgba(0, 0, 0, 0.05);
            border-radius: 20px;
            height: 100%;

            display: flex;
            justify-content: center;
            align-items: center;
            opacity: 1;
        }

        .buttons-header .notactive {
            opacity: .5;
        }

        .buttons-header div:hover {
            cursor: pointer;
        }

    </style>
@endsection
@section('content')
    <!-- Client Section Start -->
    <section class="client-section section-lg-space">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-3">

                </div>
                <div class="col-6 before-register p-5">
                    <h2 class="text-center theme-second-color">{{trans('website.Join us as',[],session()->get('locale'))}}</h2>
                    <h4 class="text-center mt-2 mb-3">{{trans('website.To increase your income',[],session()->get('locale'))}}</h4>

                    <div class="buttons-header row justify-content-center align-items-center p-2">
                        <div id="customer-header" class="col-6 text-center text-dark-mint notactive h5" onclick="changeUserType('customer')">
                          {{trans('website.Register as customer',[],session()->get('locale'))}}
                        </div>
                        <div id="member-header" class="col-6 text-center text-dark-mint active h5" onclick="changeUserType('member')">
                          {{trans('website.Register as member',[],session()->get('locale'))}}
                        </div>
                    </div>
                    <div class="buttons-content p-4">
                        <div id="customer-content" class="customer  d-none text-center">
                            <h4 class="w-50">{{trans('website.To make one order',[],session()->get('locale'))}}  </h4>
                       <br>
                        </div>
                        <div id="member-content" class="member  text-center">
                            <h4 class="w-75">{{trans('website.Become a one of our family',[],session()->get('locale'))}}  </h4>
                        </div>

                        <a id="customer-btn" class="btn btn-animation background-dark-mint w-100 justify-content-center d-none mt-3" href="{{url('registeruser')}}">{{trans('website.Sign Up As Customer',[],session()->get('locale'))}}</a>
                        <a id="member-btn" class="btn  btn-animation background-dark-mint w-100 justify-content-center mt-3" href="{{url('joinus')}}">{{trans('website.Sign Up As Member',[],session()->get('locale'))}}</a>

                    </div>

                </div>
                <div class="col-3">

                </div>
            </div>
        </div>
    </section>
    <!-- Client Section End -->
@endsection
@section('java_script')
    <script>
        function changeUserType(type) {
            console.log("sdsdsdsd");
            if (type == 'member') {
                $("#member-header").removeClass('notactive')
                $("#customer-header").removeClass('active')
                $("#member-header").addClass('active')
                $("#customer-header").addClass('notactive')
                $("#member-btn").removeClass('d-none')
                $("#customer-btn").addClass('d-none')
                $("#member-content").removeClass('d-none')
                $("#customer-content").addClass('d-none')
            }
            else {
                $("#customer-header").removeClass('notactive')
                $("#member-header").removeClass('active')
                $("#customer-header").addClass('active')
                $("#member-header").addClass('notactive')
                $("#customer-btn").removeClass('d-none')
                $("#member-btn").addClass('d-none')
                $("#customer-content").removeClass('d-none')
                $("#member-content").addClass('d-none')
            }
        }
    </script>
@endsection
