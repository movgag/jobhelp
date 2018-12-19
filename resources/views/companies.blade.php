@extends('layout')

@section('content')
    <!--Breadcrumb Banner Area Start-->
    <div class="breadcrumb-banner-area pt-150 bg-3 bg-opacity-black-60">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-text">
                        <h2 class="text-center text-white uppercase mb-17">Companies</h2>
                    </div>
                    <form action="{{ route('comp') }}" method="get">
                        <div class="form-container fix bg-opacity-blue-85 mt-125">
                            <div class="box-select">
                                <div class="select {{--small--}}large">
                                    <select name="region">
                                        <option value="">All Regions</option>
                                        @if($data['regions'])
                                            @foreach($data['regions'] as $region)
                                                <option value="{{$region->id}}" <?= ($data['active_region'] == $region->id) ? 'selected' : '' ?> >{{ $region->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="select {{--medium--}}large">
                                    <select name="category">
                                        <option value="">All Categories</option>
                                        @if($data['categories'])
                                            @foreach($data['categories'] as $category)
                                                <option value="{{$category->id}}" <?= ($data['active_category'] == $category->id) ? 'selected' : '' ?> >{{ $category->name }}</option>
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
    <!--Start of Candidates Area-->
    <div class="candidates-area ptb-120">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="section-title text-center ">
                        <h2 class="uppercase"><?= isset($data['from_search']) ? 'Search results' : 'Companies' ?></h2>
                        <div class="separator mt-35 mb-77">
                            <span><img src="images/icons/1.png" alt=""></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="job-post-container fix mb-70">
                        @if($data['companies'])
                            @foreach($data['companies'] as $company)
                                @php($region_name = isset($company->region()->first()->name) ? $company->region()->first()->name : 'no region')
                                <div class="single-job-post fix">
                                    <div class="job-title col-3 pl-30">
                                            <span class="pull-left block mtb-17">
                                                @php($company_logo = $company->image ? $company->image : 'no_logo.png')
                                                <a href="{{ route('single.company',['id'=>$company->id]) }}"><img width="72px" height="72px" src="images/company-logo/{{$company_logo}}" alt=""></a>
                                            </span>
                                        <div class="fix pl-30 mt-29">
                                            <h5 class="mb-5">{{ $company->company_name }}</h5>
                                            <h5><a href="#">{{ $company->title }}</a></h5>
                                        </div>
                                    </div>
                                    <div class="address col-3 pl-100">
                                        <span class="mtb-30 block">{{$region_name}},<br>
                                            {{ $company->address ? $company->address : 'no address' }}</span>
                                    </div>
                                    <div class="keyword col-4 pl-20 pt-39">
                                        <a href="#">{{ $company->email }}</a> <?= $company->web_site ? ' , ' : '' ?>
                                        <a href="#">{{ $company->web_site }}</a>
                                    </div>
                                </div>
                            @endforeach
                                {{ isset($data['from_search']) ? $data['companies']->appends(Request::except('page'))->links() : '' }}
                        @endif
                    </div>
                    <div class="text-center">
                        <a href="{{ route('all.companies') }}" class="button large-button">Browse all companies</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- End of Candidates Area -->

@endsection