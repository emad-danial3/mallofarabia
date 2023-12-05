@extends('layouts.app')
@section('style')
    <style>
        .js-copytextarea {
            width: 100%;
            height: 29px;
            border-radius: 5px;
            background-color: rgb(231, 231, 231);
            color: rgb(68, 68, 68);
            font-size: 20px;
            resize: none;
            text-align: center;
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

        #chartStatusBar * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        .status-bar {
            width: 80%;
            display: flex;
            gap: 34px;
            align-items: center;
            justify-content: space-between;
            margin: 50px auto 0 auto;
            padding-bottom: 40px;
        }

        .status-bar .status {
            position: relative;
            width: 100%;
            height: 70px;
            border-top: 1px solid black;
        }

        .status-bar .status.disabled {
            opacity: .4;
        }

        .status-bar .status .leftCorner {
            position: absolute;
            top: -16px;
            left: -40px;
            display: flex;
            align-items: center;
            flex-direction: column;
        }

        .status-bar .status .rightCorner {
            position: absolute;
            top: -16px;
            right: -40px;
            display: flex;
            align-items: center;
            flex-direction: column;
        }

        @media (max-width: 768px) {
            .status-bar {
                width: 60%;
            }
        }

        .main-image img {
            border-radius: 30px;
            height: 450px !important;
            max-width: 100%;
        }

        .mainsliderhomepage .slick-prev {
            right: 100%;
            top: 45%
        }

        .mainsliderhomepage .slick-next {
            right: -40px;
            top: 45%
        }

        .mainsliderhomepage .slick-next, .slick-prev {
            background-color: #1997B7 !important;
            color: white !important;
            border-radius: 15px !important;
        }

        .mainsliderhomepage .slick-next::before, .slick-prev::before {
            color: white !important;
            opacity: 1 !important;
        }

        .mainsliderhomepage div a {
            width: 97% !important;
            height: 150px !important;
            background-color: white;
            border-radius: 15px !important;
            margin: auto
        }


    </style>
@endsection
@section('content')




    <!-- Banner Section Start -->
    <section class="banner-section  pt-0">
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="banner-contain-3 pb-3   hover-effect">
                        {{--                        <img src="../assets/images/veg-3/banner/3.png" class="img-fluid bg-img" alt="">--}}
                        <div class="banner-detail p-center text-dark position-relative text-center p-0">
                            <div>
                                <h2 class="my-3 text-dark-mint">Our digital brochure  </h2>
                                <h3 class="fw-300 ">
                                    sign up to get the E-brochure every month
                                    <a href="{{url('subscribers')}}">For Free
                                        <i class="fa-solid fa-hand-pointer"></i></a>

                                </h3>

{{--                                <button class="btn background-dark-mint mt-sm-4 btn-md mx-auto text-white fw-bold"--}}
{{--                                >--}}
{{--                                    <a href="{{url('/'.$digitalBrochure->file)}}" target="_blank" class="text-white">--}}
{{--                                        Read now--}}
{{--                                    </a>--}}

{{--                                </button>--}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Banner Section End -->


    {{--      <div class="col-xl-12 col-12 text-center">--}}
    {{--                    <div class="social-link">--}}
    {{--                        <ul>--}}
    {{--                            <li>--}}
    {{--                                <a href="{{url('/'.$digitalBrochure->file)}}" download="digitalBrochure.pdf">--}}
    {{--                                    <i class="fa-solid fa-download fa-2x mr-5"></i></a>--}}
    {{--                            </li>--}}
    {{--                            <li>--}}

    {{--                                &nbsp; &nbsp;--}}
    {{--                            </li>--}}
    {{--                            <li>--}}
    {{--                                <a href="javascript:void(0)" target="_blank" data-bs-target="#view" data-bs-toggle="modal">--}}
    {{--                                    <i class="fa fa-share-alt fa-2x mr-5"></i>--}}
    {{--                                </a>--}}
    {{--                            </li>--}}
    {{--                            <li>--}}

    {{--                                &nbsp; &nbsp;--}}
    {{--                            </li>--}}
    {{--                            <li>--}}
    {{--                                <a href="{{url('/'.$digitalBrochure->file)}}" target="_blank">--}}
    {{--                                    <i class="fa fa-eye fa-2x mr-5"></i>--}}
    {{--                                </a>--}}
    {{--                            </li>--}}
    {{--                        </ul>--}}
    {{--                    </div>--}}
    {{--                </div>--}}



    <!-- Fresh Vegetable Section Start -->
{{--    <section class="fresh-vegetable-section pt-0">--}}
{{--        <div class="container-fluid-lg ">--}}
{{--            <div class="row gx-xl-5 gy-xl-0 g-3 ratio_148_1">--}}
{{--                <div class="col-xl-12 col-12">--}}
{{--                    <div class="row g-sm-4 g-2 mb-3">--}}
{{--                        <div class="col-1">--}}

{{--                        </div>--}}
{{--                        <div class="col-10">--}}
{{--                            <div class="main-image">--}}
{{--                                <img src="{{url('/'.$digitalBrochure->image)}}"--}}
{{--                                     class="" alt="">--}}
{{--                            </div>--}}
{{--                        </div>--}}
{{--                        <div class="col-1">--}}

{{--                        </div>--}}
{{--                    </div>--}}

{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </section>--}}
    <!-- Fresh Vegetable Section End -->



    <!-- Team Section Start -->
    <section class=" text-center p-0">
        <div class="container-fluid text-center">
            <div class="row pt-4 pb-2">
                <div class="col-12 banner-contain-3" style="display: flex; justify-content: center ;align-items: center">
                    <div class=" text-center ">
{{--                        <h2 class=" text-dark-mint mb-4 textleft">{{trans('website.Cover',[],session()->get('locale'))}}</h2>--}}
{{--                        <br>--}}
                    </div>
                </div>

                <div class="col-1"></div>
                <div class="col-10">
                    <div class="row justify-content-center">
    <iframe src="{{url('/'.$digitalBrochure->file)}}" width="50%" height="600">
            This browser does not support PDFs. Please download the PDF to view it: <a href="{{url('/'.$digitalBrochure->file)}}">Download PDF</a>
    </iframe>
</div>
                </div>
                 <div class="col-1"></div>
            </div>
        </div>
    </section>
    <!-- Team Section End -->





    <!-- Blog Section Start -->
    <section class="blog-section homecategories pb-4">
        <div class="container-fluid-lg text-center">

            <div class="slider-4-blog arrow-slider slick-height mainsliderhomepage">
                <!--<div>-->
                <!--    <div class=" blog-box ratio_45 border-0 mx-auto">-->
                <!--        <div class="blog-box-image mx-auto">-->
                <!--            <a href="{{url('/products?category_id='.$digitalBrochure->id)}}">-->
                <!--                <img src="{{url('/'.$digitalBrochure->image)}}" class="blur-up lazyload bg-img" alt="">-->
                <!--            </a>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
                <!--<div>-->
                <!--    <div class=" blog-box ratio_45 border-0 mx-auto">-->
                <!--        <div class="blog-box-image mx-auto">-->
                <!--            <a href="{{url('/products?category_id='.$digitalBrochure->id)}}">-->
                <!--                <img src="{{url('/'.$digitalBrochure->image)}}" class="blur-up lazyload bg-img" alt="">-->
                <!--            </a>-->
                <!--        </div>-->
                <!--    </div>-->
                <!--</div>-->
            </div>
        </div>
    </section>
    <!-- Blog Section End -->



    <!-- Quick View Modal Box Start -->
    <div class="modal fade theme-modal view-modal" id="view" tabindex="-1" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-l modal-fullscreen-sm-down">
            <div class="modal-content">
                <div class="modal-header p-0">
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row g-sm-4 g-2">
                        <div class="col-lg-12">
                            <div class="right-sidebar-modal">
                                <br>
                                <h4 class="title-name" id="productName">Share Digital Brochure
                                </h4>
                                <br>

                                <textarea readonly class="js-copytextarea">{{url('/'.$digitalBrochure->file)}}</textarea>
                                <div class="alert alert-success mb-0 p-2 text-center" role="alert">
                                    Copyed !
                                </div>

                            </div>
                        </div>

                        <button id="copyMembershipButton"
                                class="btn theme-bg-color view-button icon text-white fw-bold btn-md mt-1">
                            Copy
                        </button>

                        <p class="h5">Copy and go to &nbsp;
                            <a href="https://web.whatsapp.com/" target="_blank"><i class="fa-brands fa-whatsapp fa-2x theme-color"></i></a>
                            &nbsp; OR &nbsp;
                            <a href="https://www.messenger.com/" target="_blank"><i class="fa-brands fa-facebook-messenger fa-2x text-primary"></i></a>
                            &nbsp;
                            to paste</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Quick View Modal Box End -->

@endsection


@section('java_script')
    <script>
        var deleteAddress = '';
        $(document).ready(function () {

            $('.alert-success').hide();
            $("#copyMembershipButton").click(function () {
                var copyTextarea = document.querySelector('.js-copytextarea');
                copyTextarea.focus();
                copyTextarea.select();
                try {
                    var successful = document.execCommand('copy');
                    $('.alert-success').show();
                    setTimeout(function () {
                        hideModal('view')
                    }, 2000);
                } catch (err) {
                    console.log('Oops, unable to copy');
                }
            });
        });

        function hideModal(mm) {
            $('#' + mm).modal('hide');
        }
    </script>
@endsection

