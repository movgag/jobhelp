<!--Footer Area Start-->
<div class="footer-three black-bg">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="footer-info-container text-center pt-50 pb-5">
                    <div class="footer-logo-three">
                        <a href="#"><img src="{{asset('/')}}/images/logo/footer-logo.png" alt=""></a>
                    </div>
                    <div class="footer-info">
                        <span><i class="fa fa-map-marker"></i>1st Floor New World Tower Miami</span>
                        <span><i class="fa fa-envelope"></i>info@example.com</span>
                        <span><i class="fa fa-phone"></i>(801) 2345 - 6789</span>
                    </div>
                    <nav id="footer-menu">
                        <ul class="main-menu text-right">
                            <li><a href="{{ route('board') }}">Job Board</a></li>
                            <li><a href="{{ route('candidates') }}">Candidates</a></li>
                            <li><a href="{{ route('terms') }}">Terms and Condition</a></li>
                            <li><a href="{{ route('privacy') }}">Privacy Policy</a></li>
                            <li><a href="{{ route('comp') }}">Companies</a></li>
                            <li><a href="{{ route('contact') }}">Contact</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="footer-container">
                    <div class="row">
                        <div class="col-md-6">
                            <span class="text-white block">&copy; <span>JOBHELP</span> 2017 .All right reserved. Created by <a
                                        href="http://paradigmalab.com/" class="text-white">ParadigmaLab</a></span>
                        </div>
                        <div class="col-md-6">
                            <div class="social-links-three">
                                <a href="#"><i class="fa fa-facebook"></i></a>
                                <a href="#"><i class="fa fa-google-plus"></i></a>
                                <a href="#"><i class="fa fa-twitter"></i></a>
                                <a href="#"><i class="fa fa-pinterest-p"></i></a>
                                <a href="#"><i class="fa fa-instagram"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End of Footer Area-->
<div id="quickview-login">
    <!-- Modal -->
    <div class="modal fade" id="productModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true"><i class="zmdi zmdi-close"></i></span></button>
                </div>
                <div class="modal-body">
                    <div class="form-pop-up-content ptb-60 pl-60 pr-60">
                        <ul class="nav nav-tabs">
                            <li class="active col-xs-6"><a data-toggle="tab" href="#login_employee">As a Employee</a></li>
                            <li class="col-xs-6"><a class="" data-toggle="tab" href="#login_company">As a Company</a></li>
                        </ul>
                        <div class="tab-content mt-25">
                        <div id="login_employee" class="tab-pane fade in active">
                            <form class="form-horizontal" role="form" {{--method="POST" action="{{ url('/employee/login') }}"--}} >
                                {{ csrf_field() }}

                                <div class="form-group">

                                    <div class="col-md-12">
                                        <input id="emp_email" type="email" class="form-control" name="email" value="{{ old('email') }}" autofocus>
                                        <span class="help-block emp_login_err">
                                            <strong></strong>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input id="emp_password" type="password" class="form-control" name="password">
                                    </div>
                                </div>
                                <div class="fix ptb-30">
                                    <label class="remember pull-left" style="cursor: pointer">
                                        <input class="p-0 pull-left" name="emp_remember" type="checkbox">
                                        Remember Me
                                    </label>
                                    <span class="pull-right"><a href="{{ url('/employee/password/reset') }}">Forget Password?</a></span>
                                </div>
                                <div class="text-center">
                                    <button type="button" class="text-uppercase login_employee_button">
                                        Sign In
                                        <i class="fa fa-spinner fa-spin employee_login_spinner" style="display: none;"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        <div id="login_company" class="tab-pane fade">
                            <form class="form-horizontal" role="form" {{--method="POST" action="{{ url('/company/login') }}"--}} >
                                {{ csrf_field() }}

                                <div class="form-group">

                                    <div class="col-md-12">
                                        <input id="comp_email" type="email" class="form-control" name="email_comp" value="{{ old('email') }}" autofocus>
                                        <span class="help-block comp_login_err">
                                            <strong></strong>
                                        </span>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-12">
                                        <input id="comp_password" type="password" class="form-control" name="password_comp">
                                    </div>
                                </div>
                                <div class="fix ptb-30">
                                    <label class="remember pull-left" style="cursor: pointer">
                                        <input class="p-0 pull-left"  name="comp_remember" type="checkbox">
                                        Remember Me
                                    </label>
                                    <span class="pull-right"><a href="{{ url('/company/password/reset') }}">Forget Password?</a></span>
                                </div>
                                <div class="text-center">
                                    <button type="button" class="text-uppercase login_company_button">
                                        Sign In
                                        <i class="fa fa-spinner fa-spin company_login_spinner" style="display: none;"></i>
                                    </button>
                                </div>
                            </form>
                        </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End of Login Form-->
<!--Start of Registration Form-->
<div id="quickview-register">
    <!-- Modal -->
    <div class="modal fade" id="regtModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                aria-hidden="true"><i class="zmdi zmdi-close"></i></span></button>
                </div>
                <div class="modal-body">
                    <div class="form-pop-up-content ptb-60 pl-60 pr-60">
                        <ul class="nav nav-tabs">
                            <li class="active col-xs-6"><a data-toggle="tab" href="#reg_employee">As a Employee</a></li>
                            <li class="col-xs-6"><a class="" data-toggle="tab" href="#reg_company">As a Company</a></li>
                        </ul>

                        <div class="tab-content mt-25">
                            <div id="reg_employee" class="tab-pane fade in active">
                                <form class="form-horizontal" role="form" {{--method="POST" action="{{ url('/employee/register') }}"--}} id="employee_reg_form">
                                    {{ csrf_field() }}
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input class="form-control name_input " id="name" type="text" placeholder="Enter name"  name="name" autocomplete="off" value="" autofocus>
                                            <span class="help-block">
                                                    <strong class="name"></strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input class="form-control last_name_input " id="last_name_employee" type="text" placeholder="Enter last name"  name="last_name" autocomplete="off" value="">
                                            <span class="help-block">
                                                    <strong class="last_name"></strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input class="form-control email_input " id="email" type="email" placeholder="Enter email address"  name="email" value="" autocomplete="off" >
                                            <span class="help-block">
                                                <strong class="email"></strong>
                                            </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input class="form-control phone_input " id="phone_number_employee" type="text" placeholder="Enter phone number: ex. 37410123456"  name="phone" autocomplete="off"  value="" >
                                                <span class="help-block">
                                                    <strong class="phone"></strong>
                                                </span>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input class="form-control employee_password_input" id="password" type="password" placeholder="Enter password"  name="employee_password" autocomplete="off" >
                                                <span class="help-block">
                                                    <strong class="employee_password"></strong>
                                                </span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <div class="col-md-12">
                                            <input class="form-control retype_password_input " id="password-confirm" type="password" placeholder="Retype password"  name="retype_password" autocomplete="off" >
                                            <span class="help-block">
                                                <strong class="retype_password"></strong>
                                            </span>
                                        </div>
                                    </div>
                                    <span class="block conditions fix agree_span">
                                        <input type="checkbox" name="term_of" class="p-5 pull-left checkbox_term" style="cursor: pointer;" value="1">
                                        I agree with the <a href="{{ route('terms') }}">
                                            Terms of use</a> and <a href="{{ route('privacy') }}">
                                            Privacy policy</a>
                                    </span>
                                    <div class="text-center mt-15">
                                        <button type="submit" class="text-uppercase sign_up_employee" disabled="disabled">
                                            Sign Up
                                            <i class="fa fa-spinner fa-spin employee_spinner" style="display: none;"></i>
                                        </button>
                                    </div>
                                    <p class="employee_failed_span"></p>
                                </form>
                            </div>
                            <div id="reg_company" class="tab-pane fade">
                                <form class="form-horizontal" role="form" {{--method="post" action="{{ url('/company/register') }}"--}} id="company_regitration">
                                    {{ csrf_field() }}
                                        <div class="form-group">
                                            <div class="col-md-12">
                                                <input type="text" id="company_name" name="company_name"
                                                       placeholder="Enter company name" class="form-control company_name_input">
                                                <span class="help-block">
                                                    <strong class="company_name"></strong>
                                                </span>
                                            </div>
                                        </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                                <input type="text" id="contact_person_name" name="contact_person_name"
                                                       placeholder="Enter contact person name" class="form-control contact_person_name_input">
                                                <span class="help-block">
                                                    <strong class="contact_person_name"></strong>
                                                </span>
                                            </div>
                                        </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                                <input type="text" id="phone_number_company" name="phone_number_company"
                                                       placeholder="Enter phone number: ex. 37410123456"
                                                       class="form-control phone_number_company_input">
                                                <span class="help-block">
                                                    <strong class="phone_number_company"></strong>
                                                </span>
                                            </div>
                                        </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                                <input type="text" id="tax_number" name="tax_number"
                                                       placeholder="Enter tax number" class="form-control tax_number_input">
                                                <span class="help-block">
                                                    <strong class="tax_number"></strong>
                                                </span>
                                            </div>
                                        </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                                <input type="text" id="email2" name="email_company"
                                                       placeholder="Enter email address" class="form-control email_company_input">
                                                <span class="help-block">
                                                    <strong class="email_company"></strong>
                                                </span>
                                            </div>
                                        </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                                <input type="password" id="company_password" name="company_password"
                                                       placeholder="Enter your password" class="form-control company_password_input">
                                                <span class="help-block">
                                                    <strong class="company_password"></strong>
                                                </span>
                                            </div>
                                        </div>
                                    <div class="form-group">
                                        <div class="col-md-12">
                                                <input type="password" id="r_password_comp" name="retype_password_company"
                                                       placeholder="Retype your password" class="form-control retype_password_company_input">
                                                <span class="help-block">
                                                    <strong class="retype_password_company"></strong>
                                                </span>
                                            </div>
                                        </div>
                                        <span class="block conditions fix agree_span">
                                            <input type="checkbox" class="p-5 pull-left checkbox_terms_company" style="cursor: pointer;">
                                            I agree with the <a href="{{ route('terms') }}">
                                                Terms of use</a> and <a href="{{ route('privacy') }}">
                                                Privacy policy</a>
                                            </span>
                                        <div class="text-center mt-15">
                                            <button type="submit" class="text-uppercase sign_up_company" disabled="disabled">
                                                Sign Up
                                                <i class="fa fa-spinner fa-spin company_spinner" style="display: none;"></i>
                                            </button>
                                        </div>
                                        <p class="company_failed_span"></p>

                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End of Registration Form-->
<!-- End of Footer area -->
</div>
<!--End of Bg White-->
</div>
<!--End of Main Wrapper Area-->




<!-- Bootstrap framework js
========================================================= -->
<script src="{{asset('/')}}/js/bootstrap.min.js"></script>

<!-- Owl Carousel js
========================================================= -->
<script src="{{asset('/')}}/js/owl.carousel.min.js"></script>

<!-- nivo slider js
========================================================= -->
<script src="{{asset('/')}}/lib/nivo-slider/js/jquery.nivo.slider.js" type="text/javascript"></script>
<script src="{{asset('/')}}/lib/nivo-slider/home.js" type="text/javascript"></script>

<!-- Js plugins included in this file
========================================================= -->
<script src="{{asset('/')}}/js/plugins.js"></script>

<!-- Video Player JS
========================================================= -->
<script src="{{asset('/')}}/js/jquery.mb.YTPlayer.js"></script>

<!-- AJax Mail JS
========================================================= -->
<script src="{{asset('/')}}/js/ajax-mail.js"></script>

<!-- Mail Chimp JS
========================================================= -->
<script src="{{asset('/')}}/js/jquery.ajaxchimp.min.js"></script>

<!-- Waypoint Js
========================================================= -->
<script src="{{asset('/')}}/js/waypoints.min.js"></script>

<!-- Main js file contents all jQuery plugins activation
========================================================= -->
<script src="{{asset('/')}}/js/main.js"></script>
<script src="{{asset('/')}}/js/Auth/register.js"></script>
<script src="{{asset('/')}}/js/Auth/login.js"></script>
<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

{{--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/css/select2.min.css">--}}
{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.4/js/select2.min.js"></script>--}}

<script>
    $(document).on('click','.general_logout', function (e) {
        e.preventDefault();
        $("form.logout_form").submit();
    });

//    $(".skills_select").select2({
//        placeholder: "Select Skills",
//        allowClear: true,
//        closeOnSelect: true,
//        width: 'resolve'
//    });

</script>

</body>

</html>