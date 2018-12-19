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
                    {{-- filter form is commented here--}}
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
                        <h2 class="uppercase"><?= isset($data['from_search']) ? 'Search results' : 'All Candidates' ?></h2>
                        <div class="separator mt-35 mb-77">
                            <span><img src="images/icons/1.png" alt=""></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="job-post-container fix mb-70">
                        @if($data['employees'])
                            @foreach($data['employees'] as $employee)
                                @php($region_name = isset($employee->region()->first()->name) ? $employee->region()->first()->name : 'no region')

                                <div class="single-job-post fix">
                                    <div class="job-title col-3 pl-30">
                                            <span class="pull-left block mtb-17">
                                                @php($employee_image = $employee->image ? $employee->image : 'no_image.png')
                                                <a href="{{ route('single.candidate',['id'=>$employee->id]) }}"><img
                                                            width="72px" height="72px"
                                                            src="{{ asset('/images/candidates/'.$employee_image) }}"
                                                            alt=""></a>
                                            </span>
                                        <div class="fix pl-30 mt-29">
                                            <h4 class="mb-5">{{ $employee->name.' '.$employee->last_name }}</h4>
                                            <h5><a href="#">{{ $employee->title ? $employee->title : 'no title' }}</a>
                                            </h5>
                                        </div>
                                    </div>
                                    <div class="address col-3 pl-100">
                                <span class="mtb-30 block">{{$region_name}},<br>
                                    {{ $employee->address ? $employee->address : 'no address' }}</span>
                                    </div>
                                    <div class="keyword col-4 pl-20 pt-39">
                                        @if($employee->skills)
                                            @foreach($employee->skills as $skill)
                                                @php($skill_name = (isset($skill->name) && $skill->name) ? $skill->name : 'undefined' )
                                                <a href="#" class="button mr-10">{{ $skill_name }}</a>
                                            @endforeach
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                            {{ $data['employees']->links() }}
                        @endif
                    </div>

                </div>
            </div>
        </div>
    </div>
    <!-- End of Candidates Area -->

@endsection