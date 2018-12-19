@extends('layout')

@section('content')
    <meta property="og:url"           content="{{url('/company/'.$data['company']->id)}}" />
    <meta property="og:type"          content="website" />
    <meta property="og:title"         content="JobHelp" />
    <meta property="og:description"   content="Find Job" />
    <meta property="og:image"         content="{{ asset('/images/company-logo/'.$data['company']->image) }}" />

    <style>
        .ui.facebook{cursor:pointer;}
    </style>
    <!--Breadcrumb Banner Area Start-->
    <div class="breadcrumb-banner-area pt-94 pb-85 bg-3 bg-opacity-dark-blue-90">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-text">
                        <h2 class="text-center text-white uppercase mb-17">{{ $data['company']->company_name }}</h2>
                        <div class="breadcrumb-bar">
                            <ul class="text-center m-0">
                                <li class="text-white uppercase ml-15 mr-15">Account</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End of Breadcrumb Banner Area-->
    <!--Start of Blog Area-->
    <div class="blog-area pt-60 pb-110">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <div class="blog-posts">
                        <div class="row">
                            <div class="col-md-8 col-xs-12">
                                <div class="single-blog hover-effect mb-10">
                                    <div class="blog-image box-hover">
                                        <a href="#" class="block">
                                            @php($image_name = $data['company']->image ? $data['company']->image : 'no_logo.png')
                                            <img src="{{ asset('/images/company-logo/'.$image_name) }}" alt="">
                                        </a>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="blog-text mb-25">
                                    <h5 class="pt-42 mb-14 l-text">Description</h5>
                                    <p class="mb-25">{{ $data['company']->description ? $data['company']->description : 'no description yet ...' }}</p>
                                </div>
                                <div class="social-links pull-left ">
                                    <span>Share:</span>

                                    <a class="ui facebook">
                                        <i class="zmdi zmdi-facebook"></i>
                                    </a>

                                    <a href="https://twitter.com/share" target="_blank"
                                       class="twitter-share-button"
                                       data-size="large"
                                       data-text="custom share text"
                                       data-url="https://dev.twitter.com/web/tweet-button"
                                       data-hashtags="example,demo"
                                       data-via="twitterdev"
                                       data-related="twitterapi,twitter">
                                        <i class="zmdi zmdi-twitter"></i>
                                    </a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="single-sidebar-widget mb-48">
                        @php($region = isset($data['company']->region()->first()->name) ? $data['company']->region()->first()->name : 'no region')
                        @php($category = isset($data['company']->category()->first()->name) ? $data['company']->category()->first()->name : 'no category')
                        @php($verifyed = $data['company']->verify ? 'check' : 'close')
                        @php($admin_verifyed = $data['company']->admin_verify ? 'check' : 'close')
                        @php($verify_status = $data['company']->verify ? 'Verified' : 'Unverified')
                        @php($admin_verify_status = $data['company']->admin_verify ? 'Verified' : 'Unverified')
                        <ul class="light-gray-bg pt-17 pb-15">
                            <li class="ptb-10 ml-30"><span class="employee_detail">Company Name:</span ><span class="ml-9">{{$data['company']->company_name}}</span></li>
                            <li class="ptb-10 ml-30"><span class="employee_detail">Title:</span ><span class="ml-9">{{$data['company']->title}}</span></li>
                            <li class="ptb-10 ml-30"><span class="employee_detail">Category:</span ><span class="ml-9">{{$category}}</span></li>
                            <li class="ptb-10 ml-30"><span class="employee_detail">Region:</span ><span class="ml-9">{{$region}}</span></li>
                            <li class="ptb-10 ml-30"><span class="employee_detail">Address:</span ><span class="ml-9">{{$data['company']->address}}</span></li>
                            <li class="ptb-10 ml-30"><span class="employee_detail">Website:</span ><span class="ml-9">{{$data['company']->web_site}}</span></li>
                            <li class="ptb-10 ml-30"><span class="employee_detail">Email:</span ><span class="ml-9">{{$data['company']->email}}</span></li>
                            <li class="ptb-10 ml-30"><span class="employee_detail">Tax number:</span ><span class="ml-9">{{$data['company']->tax_number}}</span></li>
                            <li class="ptb-10 ml-30"><span class="employee_detail">Email Verification: </span ><span class="ml-9"><i title="{{$verify_status}}" class="fa fa-{{$verifyed}}" style="cursor: pointer;"></i></span></li>
                            <li class="ptb-10 ml-30"><span class="employee_detail">Company Verification: </span ><span class="ml-9"><i title="{{$admin_verify_status}}" class="fa fa-{{$admin_verifyed}}" style="cursor: pointer;"></i></span></li>
                        </ul>
                    </div>
                    <div class="single-sidebar-widget mb-48">
                        <div class="sidebar-widget-title">
                            <h4 class="mb-23">Recent Jobs</h4>
                        </div>
                        @if($data['jobs'] && count($data['jobs']) > 0)
                            @foreach($data['jobs'] as $j=>$job)
                                <div class="recent-posts light-gray-bg">
                                    <div class="recent-post-item pl-30 ptb-20">
                                        <h5 class="mb-6"><a href="{{ route('single.job',['id'=>$job->id]) }}">{{ $job->title }}</a></h5>
                                        <span class="block"><i class="zmdi zmdi-calendar-check mr-10"></i>{{ \Carbon\Carbon::parse($job->created_at)->format('Y-m-d') }}</span>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <span>No jobs are found</span>
                        @endif
                    </div>
                </div>
            </div>

        </div>

        <script>
            $(".ui.facebook").click(function() {
                FB.ui({
                    method: 'share',
                    href: '{{url('/company/')}}',
                }, function(response){});
            })
        </script>
    <!--End of Blog Area-->

@endsection