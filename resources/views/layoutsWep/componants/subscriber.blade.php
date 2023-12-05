<!-- Newsletter Section Start -->
<section class="newsletter-section-2 section-b-space">
     <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <div class="container-fluid-lg">
        <div class="row">
            <div class="col-12">
                <div class="newsletter-box hover-effect">
                    <img src="../assets/images/logo/123456789.png" class="img-fluid bg-img" alt="">
                    <div class="row">
                        <div class="col-xxl-8 col-xl-7">
                            <div class="newsletter-detail p-center-left text-white">
                                <div>
                                    <h2>Subscribe to the e-Brochure</h2>
                                    <h4>Join our subscribers list to get the latest e-Brochure, updates and special
                                        offers
                                        delivered directly in your inbox.</h4>

                                    <div class="col-sm-10 col-12">
                                        <div class="newsletter-form">
                                            <input type="email" class="form-control" id="subscriberEmail"
                                                   placeholder="Enter your email">
                                            <button type="submit" class="btn bg-white theme-color btn-md fw-500
                                                        submit-button" id="subscriberEmailButton">Subscribe
                                            </button>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>

                        <div class="col-xxl-4 col-xl-5 d-xl-block d-none">
                            <div class="shape-box">
                                <img src="../assets/images/logo/email.png" alt="" class="img-fluid image-1" width="200" height="200">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Newsletter Section End -->
@section('java_script')
    <script>
        $(document).ready(function () {
            $("#subscriberEmailButton").click(function () {
                var email = $('#subscriberEmail').val();

                if (email && email != '' && email > '') {
                    var object = {
                        "email": email,
                    }
                    $.ajax({
                        url: "{{url('/addSubscriberEmail')}}",
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
                             $('#subscriberEmail').val('');
                                swal({
                                    text: "Subscriber Added Successful",
                                    title: "Successful",
                                    timer: 1000,
                                    icon: "success",
                                    buttons: false,
                                });
                            }
                        },
                        error: function (error) {
                            console.log(error.responseJSON.message)
                            alert('Error '+ error.responseJSON.message);
                        }
                    });

                }
            });
        });
    </script>
@endsection


