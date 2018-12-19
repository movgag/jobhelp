@extends('layout')

@section('content')
    <!--Breadcrumb Banner Area Start-->
    <div class="breadcrumb-banner-area pt-150 bg-3 bg-opacity-black-60">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-text">
                        <h2 class="text-center text-white uppercase mb-17">Job Board</h2>
                    </div>
                    <form action="{{ route('board') }}" method="get">
                        <div class="form-container fix bg-opacity-blue-85 mt-125 search-block">
                            <div class="box-select">
                                <div class="select small {{--large--}}">
                                    <select name="type">
                                        <option value="">All Types</option>
                                        @if($data['types'])
                                            @foreach($data['types'] as $type)
                                                <option value="{{$type->id}}" <?= ($data['active_type'] == $type->id) ? 'selected' : '' ?> >{{ $type->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="select small">
                                    <select name="region">
                                        <option value="">All Regions</option>
                                        @if($data['regions'])
                                            @foreach($data['regions'] as $region)
                                                <option value="{{$region->id}}" <?= ($data['active_region'] == $region->id) ? 'selected' : '' ?> >{{ $region->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="select small {{--medium--}}">
                                    <select name="category">
                                        <option value="">All Categories</option>
                                        @if($data['categories'])
                                            @foreach($data['categories'] as $category)
                                                <option value="{{$category->id}}" <?= ($data['active_category'] == $category->id) ? 'selected' : '' ?> >{{ $category->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                                <div class="select small {{--medium--}}">
                                    <select name="skill">
                                        <option value="">All Skills</option>
                                        @if($data['skills'])
                                            @foreach($data['skills'] as $skill)
                                                <option value="{{$skill->id}}"  <?= ($data['active_skill'] == $skill->id) ? 'selected' : '' ?> >{{ ucfirst($skill->name) }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>

                            </div>
                            <button type="submit" class="button-dark pull-right">Search</button>
                        </div>
                    </form>
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
                        <h2 class="uppercase"><?= isset($data['from_search']) ? 'Search results' : 'Consumed Jobs' ?></h2>
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
                                @php($company_logo = isset($job->company()->first()->image) ? $job->company()->first()->image : 'no_logo.png')
                                @php($type_id = isset($job->type()->first()->id) ? $job->type()->first()->id : 0)
                                @php($type_name = isset($job->type()->first()->name) ? $job->type()->first()->name : 'no name')
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

                            {{ isset($data['from_search']) ? $data['jobs']->appends(Request::except('page'))->links() : '' }}
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