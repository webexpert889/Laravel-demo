@extends('layouts.master')

@section('title')
Home
@endsection

@section('custom-css')
<style>
    .ladda-overcss{
        color: #fff;
        background-color: #007bff !important;
        border-color: #007bff !important;
        padding: 0.375rem 0.75rem !important;
        font-size: 1rem !important;
    }
    .m_btn{
        padding-bottom: 20px;
    }
    .modal-header .close{
        font-size: 28px;
    }
    .owl-item .champion-description{
        visibility: hidden;
    }
    .owl-item.active .champion-description{
        visibility: visible;
    }
</style>
@endsection

@section('content')

<!-- Banner section -->
<section class="hero-banner">
    @include('flash-message')
    <div class="container-fluid">
        <div class="owl-carousel banner-carousel owl-theme">

            @if ($banners->count() > 0)
                @foreach ($banners as $banner)
                    <div class="owl-slide" style="background: url({{asset('storage/'.$banner->image)}})">
                        <div class="owl--text">
                            <div class="container">
                                <div class="row">
                                    <div class="text-center col-sm-12">
                                        <div class="banner-content">
                                            <h1 class="mb-0">{{$banner->title}}</h1>
                                            <p> {{$banner->description}}</p>
                                            {{-- <a href="javascript:void(0)" class="btn common-primary-btn">Read More</a> --}}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach

            @else
                <div class="owl-slide">
                    <div class="owl--text">
                        <div class="container">
                            <div class="row">
                                <div class="text-center col-sm-12">
                                    <div class="banner-content">
                                        <h1>Welcome to LSAN Golf</h1>
                                        <p> A Social Golf Experience</p>
                                        {{-- <a href="javascript:void(0)" class="btn common-primary-btn">Read More</a> --}}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
</section>
<!-- Banner section End-->
<!-- About us section Start -->
@if ($about_us->count() > 0)
    <section class="about-us">
        <div class="container-fluid">
            <div class="row">
                <div class="payments_table_wrapper col-sm-6 order-sm-2">
                   <div class="abt_det"> <img src="{{asset($about_us->image)}}" alt="{{ $about_us->title }}" class="img-fluid abt_img"></div>
                </div>
                <div class="mb-3 col-sm-6 col-md-6 col-lg-6">
                    <div class="about-content">
                        <div class="about_heading "><h2 class="max_1">{{$about_us->title}}</h2></div>
                        <div class="mb-2 about_content"><p>{!! limitString($about_us->text,400) !!}</p>
                        </div>
                        <a href="{{route('about.us')}}" class="btn common-primary-btn read-more {{strlen($about_us->text) < 400?'d-none':''}}" href="#">
                        Read More</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
<!-- About us section End -->
@endif

{{-- subscribers section --}}
<section class="contact-section contact-notification">
    <div class="container">
        <div class="row">
            <div class="col-lg-10">
                <h2>Get the upcoming tournaments notification</h2>
            </div>
            <div class="col-lg-2 mt-2">
                <div class="text-center">
                    <button type="button" class="btn common-primary-btn-outline bg-white" data-toggle="modal" data-target="#addSubscriberModal">Click Here</button>
                </div>
            </div>
        </div>
    </div>
</section>

<div class="modal fade" id="addSubscriberModal" tabindex="-1" role="dialog" aria-labelledby="addSubscriberModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="subscribe-form" method="post" id="subscribe_form">
                <div class="modal-header">
                    <h5 class="modal-title" id="addSubscriberModalLabel">Subscribe to Newsletter</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <select name="state" id="state" class="form-control" required style="background-color: transparent;">
                            <option value="">Select State</option>
                            @foreach(get_states() as $state)
                                <option value="{{ $state }}" style="color: #000;">{{ $state }}</option>
                            @endforeach
                        </select>
                        <i class="las la-angle-down"></i>
                        <label id="state-error" class="error invalid-feedback" style="display: none;" for="state"></label>

                    </div>
                    <div class="form-group">
                        <input type="email" class="form-control" id="subscribe_email" name="subscribe_email" placeholder="Enter Email" required style="background-color: transparent;">
                        <label id="subscribe_email-error" class="error invalid-feedback" style="display: none;" for="subscribe_email"></label>
                    </div>
                </div>
                <div class="modal-footer m_btn">
                    <button type="button" class="btn common-primary-btn-outline" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn common-primary-btn" id="subscribe_btn" data-style="zoom-in">Subscribe</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Tour section End -->
@if (isset($tours) && $tours->count() > 0)
    <section class="tour-section common-bg-light" id="choose_your_tour">
        <div class="container-fluid">
            <div class="row">
                <div class="text-center col-md-12">
                    <h1> Choose Your Tour </h1>
                </div>
            </div>
            <div class="mx-2 row mx-sm-5">
                <div class="owl-carousel choose-slider owl-theme">
                    @foreach ($tours as $tour)
                        <div class="item">
                            <div class="slider-content">
                                <div class="card">
                                    @if($tour->images()->count() > 0)
                                        @foreach ($tour->images as $key=>$image)
                                            @if($key == 0)
                                                <div class="tour-card-img">
                                                    <img src="{{ asset('storage/'.$image->image_path) }}" class="card-img-top img-fluid" alt="{{ $tour->name }}">
                                                </div>
                                            @endif
                                        @endforeach
                                    @endif
                                    <div class="card-body">
                                        <div class="card-body-content">
                                            <div class="card-body-heading">
                                                <h6 class="card-text">{{$tour->name}} </h6>
                                                <h5 class="card-title prices">{{$tour->price_range}}</h5>
                                            </div>
                                            <p>{!!$tour->description !!}</p>
                                        </div>
                                        <div class="common-card-button">
                                            <a class="btn common-primary-btn" href="{{route('home.tour.detail',$tour->id)}}">Enter Tour</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    <!-- Tour section End -->
@endif

<!-- Testimonials Start -->
@if($testimonials->count() > 0)

    <section class="testimonial-section common-bg-light">
        <div class="container-fluid">
            <div class="row">
                <div class="mb-3 text-center col-sm-12">
                    <h1>Testimonials</h1>
                </div>
            </div>
            <div class="owl-carousel testimonials-slider owl-theme">
                @foreach ($testimonials as $testimonial)
                    <div class="item">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="slider-img res_img">
                                    <div class="testimonials-bg" style="background-image: url('@if(isset($testimonial->image_path)) {{ asset('storage/'.$testimonial->image_path) }} @else {{ asset('assets/images/default_testimonial.jpg') }} @endif')">

                                    </div>
                                    @if(isset($testimonial->image_path))
                                        <img src="{{ asset('storage/'.$testimonial->image_path) }}" class="img-fluid" alt="{{ $testimonial->name }}">
                                    @else
                                        <img src="{{ asset('assets/images/default_testimonial.jpg') }}" class="img-fluid" alt="{{ $testimonial->name }}">
                                    @endif
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="text-center slider-content">
                                    <img src="{{ asset('assets/images/quota.png') }}" class="img-fluid" alt="{{ $testimonial->name }}">
                                    <p>
                                        {!!$testimonial->text!!}
                                    </p>
                                </div>
                                <div class="slider_head_name">
                                <h4>{{$testimonial->name}}</h4>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
@endif
<!-- Testimonials End -->
<!-- contact us Start -->
<section class="contact-section" id="contact_us_section">
    <div class="container">
        <div class="row">
            <div class="text-center col-sm-12">
                <h5>Just Shoot Them To Us, We'll Make Sure They Get Into The Hole.</h5>
                <h1 class="contact_head">Let Us Know Questions You Might Have.</h1>
            </div>
            <div class="col-md-7 ">
                <div class="left-side-content mr-lg-3 ">
                    <form class="row g-2" id="contact_us_form" method="POST">
                        <div class="my-4 col-sm-6 my-sm-0">
                            <div class="form-group">
                                <input type="text" name="contact_name" class="form-control" placeholder="Your Name" required>
                                <label id="contact_name-error" class="error invalid-feedback" style="display: none;" for="contact_name"></label>
                            </div>
                        </div>
                        <div class="col-sm-6">
                            <div class="form-group">
                                <input type="email" name="contact_email" class="form-control" placeholder="Your Email" required>
                                <label id="contact_email-error" class="error invalid-feedback" style="display: none;" for="contact_email"></label>
                            </div>
                        </div>
                        <div class="my-4 col-sm-12">
                            <div class="form-group custom-contact-are">
                                <textarea class="form-control" name="contact_message" rows="5" placeholder="Your Message" required></textarea>
                                <label id="contact_message-error" class="error invalid-feedback" style="display: none;" for="contact_message"></label>
                            </div>
                        </div>
                        <div class="text-right col-sm-12 m_btn">
                            <button type="submit" class="bg-white btn" id="contact_us_btn" data-style="zoom-in" >Submit</button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-5 col-md-5 mt-md-0">
                <div class="right-side-content">
                    <p>OR</p>
                    <ul class="mt-5 mt-md-0">
                        <li class="my-4 call_width">
                            <i class="las la-mobile"></i>
                            <ul>
                                <li>Give us a call</li>
                                <li><a href="tel:{{get_support_number()}}">{{get_support_number()}}</a></li>
                            </ul>
                        </li>
                        <li class="py-4">
                            <i class="las la-envelope"></i>
                            <ul>
                                <li>Send us an email </li>
                                <li><a href="mailto:{{get_support_email()}}">{{get_support_email()}}</a></li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- contact us end -->
@if($sponsor_images->count() > 0)
    <!-- Sponsors start -->
    <section class="sponsors-section">
        <div class="container">
            <div class="row">
                <div class="text-center col-sm-12">
                    <h5 class="mb-0">Thank You For Your Support</h5>
                    <h1>Our Sponsors</h1>
                </div>
            </div>

            <div class="owl-carousel partners-slider owl-theme row">
            @foreach ($sponsor_images as $image)
                <div class="item">
                    <div class="slider-img">
                        <img src="{{ asset('storage/'.$image->image_path) }}" class="img-fluid" alt="sponsors">
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </section>
    <!-- Sponsors end -->
@endif

@endsection

@section('plugin-script')
    <script src="js/add-tour-location.js"></script>
@endsection

@section('page-script')
<script>
    $(document).ready(function () {

        var validator = $('#contact_us_form').validate({
            onkeyup: false,
            submitHandler:function(form,e)
            {
                var formData = new FormData(form);
                var l = Ladda.create(document.querySelector('#contact_us_btn'));
                $.ajax({
                    url: "{{ route('contact.us') }}",
                    type: 'POST',
                    data: formData,
                    dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        $('#contact_us_btn').removeClass('bg-white');
                        l.start();
                    },
                    success: function (response)
                    {
                        l.stop();
                        $('#contact_us_btn').addClass('bg-white');

                        if(!response.status)
                        {
                            if(response.type === "validation-error") {
                                $.each( response.message, function( key, value ) {
                                    key = key.replace('.','_');
                                    $('#'+key+'-error').show().html(value);
                                    $('#'+key+'-error').focus();

                                });
                            }
                            else {
                                $.toast({
                                    heading: 'Error',
                                    text: response.message,
                                    icon: 'error',
                                    position: 'top-right',
                                    hideAfter: 5000,
                                    loader: false,
                                });
                            }
                        }
                        else if(response.status)
                        {

                            $.toast({
                                heading: 'Success',
                                text: response.message,
                                icon: 'success',
                                position: 'top-right',
                                hideAfter: 5000,
                                loader: false,
                            });
                            $('#contact_us_form')[0].reset();

                        }
                    },
                     error: function (jqXHR, exception) {
                        l.stop();
                        $('#contact_us_btn').addClass('bg-white');
                        var msg = '';
                        if (jqXHR.status === 0) {
                            msg = 'Not connect.\n Verify Network.';
                        } else if (jqXHR.status == 404) {
                            msg = 'Requested page not found. [404]';
                        } else if (jqXHR.status == 500) {
                            msg = 'Internal Server Error [500].';
                        } else if (exception === 'parsererror') {
                            msg = 'Requested JSON parse failed.';
                        } else if (exception === 'timeout') {
                            msg = 'Time out error.';
                        } else if (exception === 'abort') {
                            msg = 'Ajax request aborted.';
                        } else {
                            msg = 'Uncaught Error.\n' + jqXHR.responseText;
                        }
                        $.toast({
                            heading: 'Error',
                            text: msg,
                            icon: 'error',
                            position: 'top-right',
                            hideAfter: 5000,
                            loader: false,
                        });
                    }
                });

            }
        });

        // subscribe to newsletter
        var validator2 = $('#subscribe_form').validate({

            onkeyup: false,
            submitHandler:function(form,e)
            {
                var formData = new FormData(form);
                var l = Ladda.create(document.querySelector('#subscribe_btn'));
                $.ajax({
                    url: "{{ route('subscribe.newsletter') }}",
                    type: 'POST',
                    data: formData,
                    dataType: "json",
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function () {
                        l.start();
                    },
                    success: function (response)
                    {
                        l.stop();

                        if(!response.status)
                        {
                            if(response.type === "validation-error") {
                                $.each( response.message, function( key, value ) {
                                    key = key.replace('.','_');
                                    $('#'+key+'-error').show().html(value);
                                    $('#'+key+'-error').focus();
                                });
                            }
                            else {
                                $.toast({
                                    heading: 'Error',
                                    text: response.message,
                                    icon: 'error',
                                    position: 'top-right',
                                    hideAfter: 5000,
                                    loader: false,
                                });
                            }
                        }
                        else if(response.status)
                        {
                            $.toast({
                                heading: 'Success',
                                text: response.message,
                                icon: 'success',
                                position: 'top-right',
                                hideAfter: 5000,
                                loader: false,
                            });
                            $('#subscribe_form')[0].reset();
                            $('#addSubscriberModal').modal('hide');
                        }
                    },
                    error: function (jqXHR, exception) {
                        l.stop();
                        var msg = '';
                        if (jqXHR.status === 0) {
                            msg = 'Not connect.\n Verify Network.';
                        } else if (jqXHR.status == 404) {
                            msg = 'Requested page not found. [404]';
                        } else if (jqXHR.status == 500) {
                            msg = 'Internal Server Error [500].';
                        } else if (exception === 'parsererror') {
                            msg = 'Requested JSON parse failed.';
                        } else if (exception === 'timeout') {
                            msg = 'Time out error.';
                        } else if (exception === 'abort') {
                            msg = 'Ajax request aborted.';
                        } else {
                            msg = 'Uncaught Error.\n' + jqXHR.responseText;
                        }
                        $.toast({
                            heading: 'Error',
                            text: msg,
                            icon: 'error',
                            position: 'top-right',
                            hideAfter: 5000,
                            loader: false,
                        });
                    }
                });
            }
        });

        $('#addSubscriberModal').on('hidden.bs.modal', function (e) {
            $('#subscribe_form')[0].reset();
            $('#subscribe_form .invalid-feedback').css('display','none');
            $('.form-control').removeClass('error');
        });
    });
</script>
@endsection

