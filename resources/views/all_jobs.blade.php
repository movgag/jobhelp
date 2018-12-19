@extends('layout')

@section('content')
    <!--Breadcrumb Banner Area Start-->
    <div class="breadcrumb-banner-area pt-150 bg-3 bg-opacity-black-60">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-text">
                        <h2 class="text-center text-white uppercase mb-17"></h2>
                    </div>
                   {{--filter form part is commented here--}}
                </div>
            </div>
        </div>
    </div>
    <!--End of Breadcrumb Banner Area-->
    <!--Start of Job Post Area-->
    <div class="job-post-area ptb-120">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title text-center ">
                        <h2 class="uppercase"><?= isset($data['from_search']) ? 'Search results' : 'All Jobs' ?></h2>
                        <div class="separator mt-35 mb-77">
                            <span><img src="images/icons/1.png" alt=""></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="job-post-container fix">

                        @if($data['jobs'])
                            @foreach($data['jobs'] as $j => $job)
                                @php($region_name = isset($job->region()->first()->name) ? $job->region()->first()->name : 'no region')
                                @php($company_address = isset($job->company()->first()->address) ? $job->company()->first()->address : 'no address')
                                @php($company_name = isset($job->company()->first()->company_name) ? $job->company()->first()->company_name : 'no name')
                                @php($type_id = isset($job->type()->first()->id) ? $job->type()->first()->id : 0)
                                @php($type_name = isset($job->type()->first()->name) ? $job->type()->first()->name : 'no name')
                                @php($company_logo = isset($job->company()->first()->image) ? $job->company()->first()->image : 'no_logo.png')
                                <div class="single-job-post fix">
                                    <div class="job-title col-4 pl-30">
                                            <span class="pull-left block mtb-17">
                                                <a href="{{ route('single.job',['id'=>$job->id]) }}"><img height="72px" width="72px" src="images/company-logo/{{$company_logo}}" alt=""></a>
                                            </span>
                                        <div class="fix pl-30 mt-29">
                                            <h4 class="mb-5">{{ $job->title }}</h4>
                                            <h5><a href="#">{{$company_name}}</a></h5>
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
                                        @php($btn_class = $type_id == 1 ? 'button-red' : ( $type_id == 2 ? 'button-dark-blue' : '' ) )
                                        <a href="#" class="button {{ $btn_class }}">{{$type_name}}</a>
                                    </div>
                                </div>
                            @endforeach
                            {{ $data['jobs']->links() }}
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Job Post Area -->
    <!--Start of Job Post Area-->

    {{--<div class="job-post-area pb-120">--}}
    {{--<div class="container">--}}
    {{--<div class="row">--}}
    {{--<div class="col-md-12">--}}
    {{--<div class="section-title text-center ">--}}
    {{--<h2 class="uppercase">Featured Jobs</h2>--}}
    {{--<div class="separator mt-35 mb-77">--}}
    {{--<span><img src="images/icons/1.png" alt=""></span>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="row">--}}
    {{--<div class="col-md-12">--}}
    {{--<div class="job-post-container fix">--}}
    {{--<div class="single-job-post fix">--}}
    {{--<div class="job-title col-4 pl-30">--}}
    {{--<span class="pull-left block mtb-17">--}}
    {{--<a href="#"><img src="images/company-logo/1.png" alt=""></a>--}}
    {{--</span>--}}
    {{--<div class="fix pl-30 mt-29">--}}
    {{--<h4 class="mb-5">Graphic Designer</h4>--}}
    {{--<h5><a href="#">Devitems</a></h5>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="address col-4 pl-50">--}}
    {{--<span class="mtb-30 block">2020 Willshire Glen,<br>--}}
    {{--Alpharetta, GA-30009</span>--}}
    {{--</div>--}}
    {{--<div class="time-payment col-2 pl-60 text-center pt-22">--}}
    {{--<span class="block mb-6">€ 200.00</span>--}}
    {{--<a href="#" class="button button-red">Full Time</a>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="single-job-post fix">--}}
    {{--<div class="job-title col-4 pl-30">--}}
    {{--<span class="pull-left block mtb-17">--}}
    {{--<a href="#"><img src="images/company-logo/2.png" alt=""></a>--}}
    {{--</span>--}}
    {{--<div class="fix pl-30 mt-29">--}}
    {{--<h4 class="mb-5">Web Designer</h4>--}}
    {{--<h5><a href="#">Hastech</a></h5>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="address col-4 pl-50">--}}
    {{--<span class="mtb-30 block">2020 Willshire Glen,<br>--}}
    {{--Alpharetta, GA-30009</span>--}}
    {{--</div>--}}
    {{--<div class="time-payment col-2 pl-60 text-center pt-22">--}}
    {{--<span class="block mb-6">€ 450.00</span>--}}
    {{--<a href="#" class="button button-red">Full Time</a>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="single-job-post fix">--}}
    {{--<div class="job-title col-4 pl-30">--}}
    {{--<span class="pull-left block mtb-17">--}}
    {{--<a href="#"><img src="images/company-logo/3.png" alt=""></a>--}}
    {{--</span>--}}
    {{--<div class="fix pl-30 mt-29">--}}
    {{--<h4 class="mb-5">Print Designer</h4>--}}
    {{--<h5><a href="#">Bootexperts</a></h5>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--<div class="address col-4 pl-50">--}}
    {{--<span class="mtb-30 block">2020 Willshire Glen,<br>--}}
    {{--Alpharetta, GA-30009</span>--}}
    {{--</div>--}}
    {{--<div class="time-payment col-2 pl-60 text-center pt-22">--}}
    {{--<span class="block mb-6">€ 500.00</span>--}}
    {{--<a href="#" class="button">Part Time</a>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}
    {{--</div>--}}

    <!-- End of Job Post Area -->
@endsection