@extends('layouts.app')

@section('content')


    <!-- Breadcrumb Section Start -->
    <section class="breadscrumb-section pt-0">
         <meta name="csrf-token" content="{{ csrf_token() }}"/>
        <div class="container-fluid-lg">
            <div class="row">
                <div class="col-12">
                    <div class="breadscrumb-contain">
                        <h2>Contact Us</h2>
                        <nav>
                            <ol class="breadcrumb mb-0">
                                <li class="breadcrumb-item">
                                    <a href="/">
                                        <i class="fa-solid fa-house"></i>
                                    </a>
                                </li>
                                <li class="breadcrumb-item active" aria-current="page">Contact Us</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Breadcrumb Section End -->

    <!-- Contact Box Section Start -->
    <section class="contact-box-section">
        <div class="container-fluid-lg">
            <div class="row g-lg-5 g-3">
                <div class="col-lg-6">
                    <div class="left-sidebar-box">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="contact-image">
                                    <img src="../assets/images/inner-page/contact-us.png"
                                         class="img-fluid blur-up lazyloaded" alt="">
                                </div>
                            </div>
                            <div class="col-xl-12">
                                <div class="contact-title">
                                    <h3>Get In Touch</h3>
                                </div>

                                <div class="contact-detail">
                                    <div class="row g-4">
                                        <div class="col-xxl-6 col-lg-12 col-sm-6">
                                            <div class="contact-detail-box">
                                                <div class="contact-icon">
                                                    <i class="fa-solid fa-phone"></i>
                                                </div>
                                                <div class="contact-detail-title">
                                                    <h4>Phone</h4>
                                                </div>

                                                <div class="contact-detail-contain">
                                                    <p>(+2) 01222436850 </p>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-xxl-6 col-lg-12 col-sm-6">
                                            <div class="contact-detail-box">
                                                <div class="contact-icon">
                                                    <i class="fa-solid fa-envelope"></i>
                                                </div>
                                                <div class="contact-detail-title">
                                                    <h4>Email</h4>
                                                </div>

                                                <div class="contact-detail-contain">
                                                    <a href="mailto:support@4unettinghub.com"><h5>
                                                            support@4unettinghub.com</h5></a>
                                                </div>
                                            </div>
                                        </div>

                                                                                <div class="col-xxl-6 col-lg-12 col-sm-6">
                                                                                    <div class="contact-detail-box">
                                                                                        <div class="contact-icon">
                                                                                            <i class="fa fa-whatsapp"></i>
                                                                                        </div>
                                                                                        <div class="contact-detail-title">
                                                                                            <h4>Whatsapp</h4>
                                                                                        </div>

                                                                                        <div class="contact-detail-contain">
                                                                                            <p>(+2)1222436850</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-xxl-6 col-lg-12 col-sm-6">
                                                                                    <div class="contact-detail-box">
                                                                                        <div class="contact-icon">
                                                                                            <i class="fa fa-facebook"></i>
                                                                                        </div>
                                                                                        <div class="contact-detail-title">
                                                                                            <h4>Facebook</h4>
                                                                                        </div>

                                                                                        <div class="contact-detail-contain">
                                                                                            <p>4UNettingHub</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                        <div class="col-xxl-6 col-lg-12 col-sm-6">
                                                                                    <div class="contact-detail-box">
                                                                                        <div class="contact-icon">
                                                                                            <i class="fa fa-instagram"></i>
                                                                                        </div>
                                                                                        <div class="contact-detail-title">
                                                                                            <h4>Instagram</h4>
                                                                                        </div>

                                                                                        <div class="contact-detail-contain">
                                                                                            <p>nettinghub</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                                                                <div class="col-xxl-6 col-lg-12 col-sm-6">
                                                                                    <div class="contact-detail-box">
                                                                                        <div class="contact-icon">
                                                                                           <i class="fa-brands fa-tiktok"></i>
                                                                                        </div>
                                                                                        <div class="contact-detail-title">
                                                                                            <h4>Tiktok</h4>
                                                                                        </div>

                                                                                        <div class="contact-detail-contain">
                                                                                            <p>4UNettingHub</p>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="title d-xxl-none d-block">
                        <h2>Contact Us</h2>
                    </div>
                    <div class="right-sidebar-box">
                        <div class="row">
                            <div class="col-xxl-6 col-lg-12 col-sm-6">
                                <div class="mb-md-4 mb-3 custom-form">
                                    <label for="first_name" class="form-label">First Name</label>
                                    <div class="custom-input">
                                        <input type="text" class="form-control" id="first_name"
                                               placeholder="Enter First Name">
                                        <i class="fa-solid fa-user"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xxl-6 col-lg-12 col-sm-6">
                                <div class="mb-md-4 mb-3 custom-form">
                                    <label for="last_name" class="form-label">Last Name</label>
                                    <div class="custom-input">
                                        <input type="text" class="form-control" id="last_name"
                                               placeholder="Enter Last Name">
                                        <i class="fa fa-user-secret"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xxl-6 col-lg-12 col-sm-6">
                                <div class="mb-md-4 mb-3 custom-form">
                                    <label for="email" class="form-label">Email Address</label>
                                    <div class="custom-input">
                                        <input type="email" class="form-control" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,4}$"  id="email"
                                               placeholder="Enter Email Address">
                                        <i class="fa-solid fa-envelope"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xxl-6 col-lg-12 col-sm-6">
                                <div class="mb-md-4 mb-3 custom-form">
                                    <label for="phone" class="form-label">Phone Number</label>
                                    <div class="custom-input">
                                        <input type="tel" class="form-control" id="phone"
                                               placeholder="Enter Your Phone Number" maxlength="11" oninput="javascript: if (this.value.length > this.maxLength) this.value =
                                            this.value.slice(0, this.maxLength);">
                                        <i class="fa-solid fa-mobile-screen-button"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-xxl-12 col-lg-12 col-sm-12">
                                <div class="mb-md-4 mb-3 custom-form">
                                    <label for="subject" class="form-label">Subject</label>
                                    <div class="custom-input">
                                        <input type="text" class="form-control" id="subject"
                                               placeholder="Enter Subject">
                                        <i class="fa-solid fa-pen"></i>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12">
                                <div class="mb-md-4 mb-3 custom-form">
                                    <label for="message" class="form-label">Message</label>
                                     <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
                                    <div class="custom-textarea">
                                        <textarea class="form-control" id="message"
                                                  placeholder="Enter Your Message" rows="3"></textarea>
                                        <i class="fa-solid fa-message"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                         <div class="row mb-2" id="completeData" style="display: none">
                                        <div class="form-floating theme-form-floating">
                                            <div class="form-floating theme-form-floating">
                                                <div class="alert alert-danger" role="alert">
                                                    Complete Data
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                        <button class="btn btn-animation btn-md fw-bold mx-auto" id="sendMessageEmail">Send Message
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact Box Section End -->

    <!-- Map Section Start -->
    <section class="map-section">
        <div class="container-fluid p-0 mb-4">
            <div class="map-box">

                <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d863.4026656391499!2d31.246314632204854!3d30.04802569170738!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x145840bc2f9ba7e9%3A0x354a12c7e3d09c79!2sEVA%20Group%20Tower!5e0!3m2!1sar!2seg!4v1677754211411!5m2!1sar!2seg"
                        style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>

            </div>
        </div>
    </section>
    <!-- Map Section End -->


@endsection
@section('java_script')
    <script>
        $(document).ready(function () {
            $("#sendMessageEmail").click(function () {
                var email = $('#email').val();
                var first_name = $('#first_name').val();
                var last_name = $('#last_name').val();
                var phone = $('#phone').val();
                var subject = $('#subject').val();
                var message = $('textarea#message').val();
                const validateEmail = String(email).toLowerCase().match(/^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|.(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/);

                if (email > '' && validateEmail && message > '' && phone > '' && first_name > '' && subject > '' && message > '') {
                   $('#completeData').hide();
                    var object = {
                        "email": email,
                        "first_name": first_name,
                        "last_name": last_name,
                        "phone": phone,
                        "subject": subject,
                        "message": message,
                    }

                    $.ajax({
                        url: "{{url('/sendMessageEmail')}}",
                        type: 'POST',
                        cache: false,
                        data: JSON.stringify(object),
                        contentType: "application/json; charset=utf-8",
                        traditional: true,
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        },
                        processData: false,
                        success: function (response) {
                            if (response.data) {
                                $('#email').val('');
                                $('#first_name').val('');
                                $('#last_name').val('');
                                $('#phone').val('');
                                $('#subject').val('');
                                $('textarea#message').val('');
                                swal({
                                    text: "Email Added Successful",
                                    title: "Successful",
                                    timer: 1000,
                                    icon: "success",
                                    buttons: false,
                                });
                            }
                        },
                        error: function (error) {
                            console.log(error.responseJSON.message)
                            alert('Error ' + error.responseJSON.message);
                        }
                    });

                }else{
 $('#completeData').show();
                }
            });
        });
    </script>
@endsection
