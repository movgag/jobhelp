    <header id="sticky-header" class="header-area">
        <div class="container">
            <div class="row">
                <div class="col-md-3 col-xs-12">
                    <div class="logo"><a href="{{ route('home')  }}"><img src="{{asset('/')}}/images/logo/logo.png" alt="JobHelp"></a></div>
                </div>
                <div class="col-md-9 hidden-sm hidden-xs">
                    <div class="pull-right">
                        <nav id="primary-menu">
                            <ul class="main-menu text-right">
                                <li><a href="{{ route('board') }}" class="{{ (isset($data['nav_active']) && $data['nav_active'] == 'job_board') ? 'active' : ''  }}">Job Board</a></li>
                                <li><a href="{{ route('candidates') }}" class="{{ (isset($data['nav_active']) && $data['nav_active'] == 'candidates') ? 'active' : ''  }}">Candidates</a></li>
                                <li><a href="{{ route('comp') }}" class="{{ (isset($data['nav_active']) && $data['nav_active'] == 'companies') ? 'active' : ''  }}" >Companies</a></li>
                                <li><a href="{{ route('contact') }}" class="{{ (isset($data['nav_active']) && $data['nav_active'] == 'contact') ? 'active' : ''  }}" >Contact</a></li>
                            </ul>
                        </nav>
                        @if (!$auth_user_exists)
                        <div class="login-btn pt-42">
                            <a class="modal-view premly" href="#" data-toggle="modal" data-target="#regtModal" title="Registration"><i class="fas fa-user-plus"></i></a>
                        </div>
                        <div class="login-btn pt-42">
                            <a class="modal-view premly" href="#" data-toggle="modal" data-target="#productModal" title="Log in"><i class="fas fa-sign-in-alt"></i></a>
                        </div>
                        @else
                            @php($home_url = auth()->guard('company')->user() ? '/company/home' : (auth()->guard('employee')->user() ? '/employee/home' : (auth()->guard('admin')->user() ? '/admin/home' : '/')) )
                            <div class="login-btn pt-42">
                                <a class="premly" href="{{$home_url}}" title="Dashboard"><i class="fas fa-user-alt"></i></a>
                            </div>
                            <div class="login-btn pt-42">
                                <a class="premly general_logout" href="#" title="Log out"><i class="fas fa-sign-out-alt"></i></a>
                            </div>
                            <form action="/logout" method="post" class="logout_form">
                                {{ csrf_field() }}
                            </form>
                        @endif

                    </div>
                </div>
            </div>
        </div>
        <!-- Mobile Menu Area start -->
        <div class="mobile-menu-area">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12 col-md-12 col-sm-12">
                        <div class="mobile-menu">
                            <nav id="dropdown">
                                <ul>
                                    @if (!$auth_user_exists)
                                        <li><a  href="#" data-toggle="modal" data-target="#productModal">Login</a></li>
                                        <li><a  href="#" data-toggle="modal" data-target="#regtModal">Registration</a></li>
                                    @else
                                        <li><a class="" href="{{$home_url}}">Dashboard</a></li>
                                    @endif
                                    <li><a href="{{ url('/') }}">HOME</a>
                                        {{--<ul>--}}
                                            {{--<li><a href="index-2.html">Slider Style 1</a></li>--}}
                                            {{--<li><a href="index-3.html">Slider Style 2</a></li>--}}
                                            {{--<li><a href="index-4.html">Image Overlay Light</a></li>--}}
                                            {{--<li><a href="index-5.html">Image Overlay Dark</a></li>--}}
                                            {{--<li><a href="index-6.html">Background Image</a></li>--}}
                                            {{--<li><a href="index-7.html">Menu With Image 1</a></li>--}}
                                            {{--<li><a href="index-8.html">Menu With Image 2</a></li>--}}
                                            {{--<li><a href="index-9.html">Video Background</a></li>--}}
                                            {{--<li><a href="index-10.html">Fixed Background</a></li>--}}
                                            {{--<li><a href="index-11.html">Box Layout</a></li>--}}
                                        {{--</ul>--}}
                                    </li>
                                    <li><a href="{{ route('board') }}">Job Board</a>
                                        {{--<ul class="sub-menu">--}}
                                            {{--<li><a href="single-job-post.html">Single Job</a></li>--}}
                                            {{--<li><a href="job-details.html">Job Details</a></li>--}}
                                        {{--</ul>--}}
                                    </li>
                                    <li><a href="{{ route('candidates') }}">Candidates</a>
                                        {{--<ul class="sub-menu">--}}
                                            {{--<li><a href="#">Slider Style</a>--}}
                                                {{--<ul class="sub-menu">--}}
                                                    {{--<li><a href="slider-style-1.html">Slider Style 1</a></li>--}}
                                                    {{--<li><a href="slider-style-2.html">Slider Style 2</a></li>--}}
                                                    {{--<li><a href="background-image.html">Image Background</a></li>--}}
                                                    {{--<li><a href="video-background.html">Video Background</a></li>--}}
                                                    {{--<li><a href="fixed-image.html">Fixed Background</a></li>--}}
                                                    {{--<li><a href="text-animation-1.html">Text Animation 1</a></li>--}}
                                                    {{--<li><a href="text-animation-2.html">Text Animation 2</a></li>--}}
                                                    {{--<li><a href="text-animation-3.html">Text Animation 3</a></li>--}}
                                                {{--</ul>--}}
                                            {{--</li>--}}
                                            {{--<li><a href="#">Menu Style</a>--}}
                                                {{--<ul class="sub-menu">--}}
                                                    {{--<li><a href="menu-style-1.html">Default Menu</a></li>--}}
                                                    {{--<li><a href="menu-style-2.html">Menu With Top Bar</a></li>--}}
                                                    {{--<li><a href="menu-style-3.html">Menu Center</a></li>--}}
                                                    {{--<li><a href="menu-style-4.html">Menu Transparent</a></li>--}}
                                                    {{--<li><a href="menu-style-5.html">Menu White</a></li>--}}
                                                    {{--<li><a href="menu-style-6.html">Menu Border</a></li>--}}
                                                {{--</ul>--}}
                                            {{--</li>--}}
                                            {{--<li><a href="#">Page Title</a>--}}
                                                {{--<ul class="sub-menu">--}}
                                                    {{--<li><a href="breadcrumb-center.html">Title Center</a></li>--}}
                                                    {{--<li><a href="breadcrumb-left.html">Title Left</a></li>--}}
                                                    {{--<li><a href="breadcrumb-right.html">Title Right</a></li>--}}
                                                    {{--<li><a href="breadcrumb-dark.html">Title Dark</a></li>--}}
                                                    {{--<li><a href="breadcrumb-fixed.html">Title Fixed</a></li>--}}
                                                {{--</ul>--}}
                                            {{--</li>--}}
                                            {{--<li><a href="#">Footer Style</a>--}}
                                                {{--<ul class="sub-menu">--}}
                                                    {{--<li><a href="footer-style-1.html">Footer Style 1</a></li>--}}
                                                    {{--<li><a href="footer-style-2.html">Footer Style 2</a></li>--}}
                                                    {{--<li><a href="footer-style-3.html">Footer Style 3</a></li>--}}
                                                    {{--<li><a href="footer-style-4.html">Footer Style 4</a></li>--}}
                                                {{--</ul>--}}
                                            {{--</li>--}}
                                        {{--</ul>--}}
                                    </li>
                                    <li><a href="{{ route('comp') }}">Companies</a></li>

                                    <li><a href="{{ route('contact') }}">Contact</a></li>

                                    @if($auth_user_exists)
                                        <li>
                                            <a class="general_logout" href="#">Logout</a>

                                            <form action="/logout" method="post" class="logout_form">
                                                {{ csrf_field() }}
                                            </form>
                                        </li>
                                    @endif

                                    {{--<li><a href="#">Shortcode</a>--}}
                                    {{--<ul class="sub-menu">--}}
                                    {{--<li><a href="shortcode-job-posts.html">Job Posts</a></li>--}}
                                    {{--<li><a href="shortcode-candidates.html">Candidates </a></li>--}}
                                    {{--<li><a href="shortcode-advertise.html">Advertise</a></li>--}}
                                    {{--<li><a href="shortcode-blog.html">Blog</a></li>--}}
                                    {{--<li><a href="shortcode-testimonial.html">Testimonial </a></li>--}}
                                    {{--<li><a href="shortcode-contact-form.html">Contact Form</a></li>--}}
                                    {{--<li><a href="shortcode-map.html">Map</a></li>--}}
                                    {{--<li><a href="shortcode-fun-facts.html">Fun Facts</a></li>--}}
                                    {{--<li><a href="image-gallery.html">Image Gallery</a></li>--}}
                                    {{--<li><a href="video-gallery.html">Video Gallery</a></li>--}}
                                    {{--<li><a href="shortcode-address.html">Address</a></li>--}}
                                    {{--<li><a href="shortcode-alerts.html">Alerts</a></li>--}}
                                    {{--<li><a href="shortcode-button.html">Buttons</a></li>--}}
                                    {{--<li><a href="shortcode-breadcrumbs.html">Breadcrumbs </a></li>--}}
                                    {{--<li><a href="shortcode-pagination.html">Pagination </a></li>--}}
                                    {{--<li><a href="shortcode-progressbar.html">Progressbar </a></li>--}}
                                    {{--<li><a href="text-animation-1.html">Text Animation 1</a></li>--}}
                                    {{--<li><a href="text-animation-2.html">Text Animation 2</a></li>--}}
                                    {{--<li><a href="text-animation-3.html">Text Animation 3</a></li>--}}
                                    {{--</ul>--}}
                                    {{--</li>--}}
                                    {{--<li><a href="#">Page</a>--}}
                                    {{--<ul class="sub-menu">--}}
                                    {{--<li><a href="job-board.html">Job Board</a></li>--}}
                                    {{--<li><a href="single-job-post.html">Single Job</a></li>--}}
                                    {{--<li><a href="job-details.html">Job Details</a></li>--}}
                                    {{--<li><a href="candidates.html">Candidates</a></li>--}}
                                    {{--<li><a href="resume.html">Resume</a></li>--}}
                                    {{--<li><a href="blog.html">Blog Page</a></li>--}}
                                    {{--<li><a href="blog-details.html">Blog Details</a></li>--}}
                                    {{--<li><a href="login.html">Login Page</a></li>--}}
                                    {{--<li><a href="login-two.html">Login Page Two</a></li>--}}
                                    {{--<li><a href="contact.html">Contact</a></li>--}}
                                    {{--</ul>--}}
                                    {{--</li>--}}
                                    {{--<li><a href="blog.html">Blog</a>--}}
                                    {{--<ul class="sub-menu">--}}
                                    {{--<li><a href="blog-details.html">Blog Details</a></li>--}}
                                    {{--</ul>--}}
                                    {{--</li>--}}
                                </ul>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Mobile Menu Area end -->
    </header>
    <!-- End of Header Area -->
