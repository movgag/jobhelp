@extends('layout')

@section('content')

<!--Background Area Start-->
@if ( !empty(session('verify_text')) )
    <div class="t_a_center alert alert-@if( !empty(session('type')) ){{ session('type') }}@else{{'warning'}}@endif">
        <strong>@if( !empty(session('type')) ){{ ucfirst(session('type')) }}@else{{'Warning'}}@endif!</strong> {!! session('verify_text') !!}
    </div>
@endif
@if ( !empty(session('message')) )
    <div class="t_a_center alert alert-@if( !empty(session('type')) ){{ session('type') }}@else{{'warning'}}@endif">
        <strong>@if( !empty(session('type')) ){{ ucfirst(session('type')) }}@else{{'Warning'}}@endif!</strong> {!! session('message') !!}
    </div>
@endif
<div class="background-area no-overlay">
    <img src="images/slider/2.jpg" alt=""/>
    <div class="banner-content static-text">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="text-content-wrapper full-width">
                        <div class="text-content text-center">
                            <h1 class="title1 text-center text-uppercase text-white mb-16">
                                <span class="tlt block color-blue" data-in-effect="rollIn" data-out-effect="fadeOutRight" >LOOKING FOR A JOB?</span>
                            </h1>

                            <div class="banner-readmore wow bounceInUp mt-35" data-wow-duration="2500ms" data-wow-delay=".1s">
                                <a class="slider-btn" href="{{ route('board') }}">Find a job</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End of Background Area-->
<!--Start of Job Post Area-->
<div class="job-post-area ptb-120">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="section-title text-center ">
                    <h2 class="uppercase">Recent Jobs</h2>
                    <div class="separator mt-35 mb-77">
                        <span><img src="images/icons/1.png" alt=""></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="job-post-container fix mb-70">

                    @if($data['jobs'])
                        @foreach($data['jobs'] as $j => $job)
                            @php($region_name = isset($job->region()->first()->name) ? $job->region()->first()->name : 'no region')
                            @php($company_address = isset($job->company()->first()->address) ? $job->company()->first()->address : 'no address')
                            @php($company_name = isset($job->company()->first()->company_name) ? $job->company()->first()->company_name : 'no name')
                            @php($type_id = isset($job->type()->first()->id) ? $job->type()->first()->id : 0)
                            @php($type_name = isset($job->type()->first()->name) ? $job->type()->first()->name : 'no name')
                            @php($company_logo = isset($job->company()->first()->image) ? $job->company()->first()->image : 'no_logo.png')
                            @php($company_id = isset($job->company()->first()->id) ? $job->company()->first()->id : 0)
                            <div class="single-job-post fix">
                                <div class="job-title col-4 pl-30">
                                            <span class="pull-left block mtb-17">
                                                <a href="{{ route('single.job',['id'=>$job->id]) }}"><img height="72px" width="72px" src="images/company-logo/{{$company_logo}}" alt=""></a>
                                            </span>
                                    <div class="fix pl-30 mt-29">
                                        <h5 class="mb-5">{{ $job->title }}</h5>
                                        <h6><a href="{{ route('single.company',['id'=>$company_id]) }}">{{$company_name}}</a></h6>
                                    </div>
                                </div>
                                <div class="address col-2 pl-50">
                                            <span class="mtb-30 block">{{$region_name}},<br>
                                                {{ $company_address }}</span>
                                </div>
                                <div class="address col-2 pl-50">
                                    <span class="mtb-30 block">Closing date: <br> {{substr($job->closing_date, 0, -8)}}</span>
                                </div>
                                <div class="time-payment col-2 pl-60 text-center pt-22">
                                    <span class="block mb-6">AMD {{number_format($job->salary)}} </span>
                                    @php($btn_class = $type_id == 1 ? 'button-red' : ( $type_id == 2 ? 'button-green' : '' ) )
                                    <a href="#" class="button {{ $btn_class }}">{{$type_name}}</a>
                                </div>
                            </div>
                        @endforeach
                    @endif

                </div>
                <div class="text-center">
                    <a href="{{ route('all.jobs') }}" class="button large-button">Browse all jobs</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End of Job Post Area -->
<!--Start of Fun Factor Area-->
<div class="fun-factor-area bg-1 text-center fix bg-opacity-blue-10 ptb-120">
    <div class="container">
        <div class="row">
            <div class="col-md-3 col-sm-3">
                <div class="single-fun-factor">
                    <h3 class="pb-15 mb-23">Jobs</h3>
                    <h1><span class="counter">{{ $data['jobs_count'] }}</span></h1>
                </div>
            </div>
            <div class="col-md-3 col-sm-3">
                <div class="single-fun-factor">
                    <h3 class="pb-15 mb-23">Members</h3>
                    <h1><span class="counter">{{ $data['employees_count'] }}</span></h1>
                </div>
            </div>
            <div class="col-md-3 col-sm-3">
                <div class="single-fun-factor">
                    <h3 class="pb-15 mb-23">Resume</h3>
                    <h1><span class="counter">{{ $data['resumes_count'] }}</span></h1>
                </div>
            </div>
            <div class="col-md-3 col-sm-3">
                <div class="single-fun-factor">
                    <h3 class="pb-15 mb-23">Company</h3>
                    <h1><span class="counter">{{ $data['companies_count'] }}</span></h1>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End of Fun Factor Area-->
<!--Start of Advertise Area-->
<div class="advertise-area ptb-120">
    <div class="container">
        <div class="row">
            <div class="col-lg-5 col-lg-offset-1 col-md-6 col-xs-12">
                <div class="fix video-post embed-responsive embed-responsive-16by9">
                    <iframe class="embed-responsive-item" src="https://www.youtube.com/embed/MLBKJUF7TwM"></iframe>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-xs-12">
                <div class="advertise-content pl-15">
                    <h3 class="uppercase pb-10 mb-20">Join Thousands of <br>
                        Companies That Rely on Jobify</h3>
                    <p class="pr-50">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomised words which don't look even slightly believable.available, but the majority have suffered alteration in some form,</p>
                    <a href="#" class="button large-button mt-9">Get Started</a>
                </div>
            </div>
        </div>
    </div>
</div>
<!--End of Advertise Area-->




@endsection