@extends('layout')

@section('content')
<!--Breadcrumb Banner Area Start-->
<div class="breadcrumb-banner-area pt-94 pb-85 bg-3 bg-opacity-dark-blue-90">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="breadcrumb-text">
                    <h2 class="text-center text-white uppercase mb-17">Contact</h2>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End of Breadcrumb Banner Area-->
<!--Start of Map and Contact Form Area-->
<div class="map-conact-form-area fix">
    <!--Start of Google Map-->
    <div class="google-map-area">
        <!--  Map Section -->
        <div id="contacts" class="map-area">
            <div id="googleMap" style="width:100%;height:485px;filter: grayscale(100%);-webkit-filter: grayscale(100%);"></div>
        </div>
    </div>
    <!--End of Google Map-->
    <!--Start of Contact Form And info-->
    <div class="contact-form-and-info">
        <div class="contact-form white-bg fix pr-125 pl-125 pt-40 pb-35">
            <form id="contact-form">
                {{ csrf_field() }}
                <div class="col-5 pr-6 mb-15">
                    <label for="name" class="block ml-20">Name</label>
                    <input type="text" name="name" id="guest_name" class="pl-20" placeholder="Please enter your name">
                    <span class="name val_error"></span>
                </div>
                <div class="col-5 pl-6 mb-15">
                    <label for="email" class="block ml-20">Email</label>
                    <input type="text" name="email" id="guest_email" class="pl-20" placeholder="Please enter your email">
                    <span class="email val_error"></span>
                </div>
                <div class="col-10">
                    <label for="message" class="block ml-20">Message</label>
                    <textarea name="message" id="guest_message" cols="30" rows="10" placeholder="Please enter your message" class="mb-10"></textarea>
                    <span class="message val_error"></span>
                </div>
                <div class="col-10 fix">
                    <button type="submit" class="button submit-btn">
                        SUBMIT
                        <i class="fa fa-spinner fa-spin contact_spinner" style="display: none;"></i>
                    </button>
                </div>
                <p class="form-messege"></p>
            </form>
        </div>
        <div class="contact-info text-center fix pt-120 pb-115">
            <div class="single-contact-info">
                <div class="single-contact-icon">
                    <i class="zmdi zmdi-email"></i>
                </div>
                <div class="single-contact-text mt-18">
                    <span class="block">info@example.com</span>
                    <span class="block">info@example.com</span>
                </div>
            </div>
            <div class="single-contact-info">
                <div class="single-contact-icon">
                    <i class="zmdi zmdi-phone"></i>
                </div>
                <div class="single-contact-text mt-18">
                    <span class="block">+012 345 678 102 </span>
                    <span class="block">+013 345 628 112 </span>
                </div>
            </div>
            <div class="single-contact-info">
                <div class="single-contact-icon">
                    <i class="zmdi zmdi-pin"></i>
                </div>
                <div class="single-contact-text mt-18">
                    <span class="block">House 09, Road 32, Mohammadpur,</span>
                    <span class="block">Dhaka-1200, UK</span>
                </div>
            </div>
        </div>
    </div>
    <!--End of Contact Form ANd info-->
</div>
<!--End of Map and Contact Form-->
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDSLSFRa0DyBj9VGzT7GM6SFbSMcG0YNBM"></script>
<script type="text/javascript" src="https://www.google.com/jsapi"></script>
<script>
    function initialize() {
        var mapOptions = {
            zoom: 15,
            scrollwheel: false,
            center: new google.maps.LatLng(40.199138, 44.4773496)
        };

        var map = new google.maps.Map(document.getElementById('googleMap'),
            mapOptions);


        var marker = new google.maps.Marker({
            position: map.getCenter(),
            animation:google.maps.Animation.BOUNCE,
            icon: '{{asset('/')}}images/map-marker.png',
            map: map
        });

    }

    google.maps.event.addDomListener(window, 'load', initialize);
</script>
@endsection