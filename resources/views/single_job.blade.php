@extends('layout')

@section('content')
    @if ( !empty(session('message')) )
        <div class="t_a_center alert alert-@if( !empty(session('type')) ){{ session('type') }}@else{{'warning'}}@endif">
            <strong>@if( !empty(session('type')) ){{ ucfirst(session('type')) }}@else{{'Warning'}}@endif!</strong> {!! session('message') !!}
        </div>
    @endif
    <!--Breadcrumb Banner Area Start-->
    <div class="breadcrumb-banner-area pt-94 pb-85 bg-3 bg-opacity-dark-blue-90">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-text">
                        <h2 class="text-center text-white uppercase mb-17">Job Details</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End of Breadcrumb Banner Area-->
    <!--Start of Single Job Post Area-->
    <div class="single-job-post-area pt-70 mb-120">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <form action="#">
                        <div class="single-job-content">
                            <div class="area-title text-center">
                                <h2 class="pt-10 pb-10">{{ $data['job']->title }}</h2>
                            </div>
                            <div class="title uppercase pt-70 pb-26"><span>job description</span></div>
                            <div class="single-job-form">
                                <p>{{ $data['job']->description }}</p>
                            </div>
                            <div class="title uppercase mt-20 mb-15"><span class="medium">closing date</span></div>
                            <div class="single-job-form">
                                <div class="single-info mb-14">
                                    <span class="mark-icon block pl-27">{{ \Carbon\Carbon::parse($data['job']->closing_date)->format('Y-m-d') }}</span>
                                </div>
                            </div>
                            <div class="title uppercase mt-20 mb-15"><span class="medium">salary</span></div>
                            <div class="single-job-form">
                                <div class="single-info mb-14">
                                    <span class="mark-icon block pl-27">{{ number_format($data['job']->salary).' AMD' }}</span>
                                </div>
                            </div>

                            @if($data['job']->skills && count($data['job']->skills) > 0)
                                <div class="title uppercase mt-20 mb-15"><span class="medium">skills</span></div>
                                <div class="single-job-form">
                                    <div class="single-info mb-14">
                                        @foreach($data['job']->skills as $skill)
                                            <span class="mark-icon block pl-27">{{ ucfirst($skill->name) }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <div class="title uppercase mt-20 mb-15"><span>more info</span></div>
                            <div class="single-job-form">
                                <div class="single-info mb-14">
                                    <span class="mark-icon block pl-27">{{ isset($data['job']->region()->first()->name) ? $data['job']->region()->first()->name : '' }}</span>
                                    <span class="mark-icon block pl-27">{{ $data['job']->place }}</span>
                                    <span class="mark-icon block pl-27">{{ isset($data['job']->company()->first()->company_name) ? $data['job']->company()->first()->company_name : '' }}</span>
                                    <span class="mark-icon block pl-27">{{ isset($data['job']->category()->first()->name) ? $data['job']->category()->first()->name : '' }}</span>
                                    <span class="mark-icon block pl-27">{{ isset($data['job']->type()->first()->name) ? $data['job']->type()->first()->name : '' }}</span>

                                </div>
                            </div>
                            @if(isset($data['letter']) && $data['letter'])
                                <div class="title uppercase mt-20 mb-15"><span>Your application</span></div>
                                <div class="single-job-form employee_app_details">
                                    <div class="single-info mb-14">
                                        <span class="mark-icon block pl-27"><span class="employee_detail">Excepted salary:&nbsp; </span>{{ number_format($data['letter']->excepted_salary).' AMD' }}</span>
                                        <span class="mark-icon block pl-27"> <span class="employee_detail">Letter:</span></span>
                                        <p>{{ $data['letter']->apply_letter }}</p>
                                        @if($data['letter']->uploaded_cv)
                                            <span class="mark-icon block pl-27"><span class="employee_detail">Attached CV:&nbsp; </span><button data-id="{{$data['letter']->id}}" title="Download" type="button" class="btn btn-primary download_pdf"><i class="fa fa-download"></i></button></span>
                                        @endif
                                        <span class="mark-icon block pl-27"><span class="employee_detail">Apply status:&nbsp; </span>{{ $data['letter']->status}}</span>
                                    </div>
                                </div>
                            @endif

                            <div class="mt-38">
                                <a href="#" onclick="history.go(-1);return false;" class="button button-large-box lg-btn mr-20 redirect_back">back</a>
                                <a href="{{ url('/employee/apply-job/'.$data['job']->id) }}" class="button button-large-box lg-btn">Apply</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @if(isset($data['letter']) && $data['letter'] && $data['letter']->uploaded_cv)
        <form action="{{ url('/employee/download-cv') }}" method="post" id="download_cv_form_for_employee">
            {{csrf_field()}}
            <input type="hidden" name="application_id" value="">
        </form>
    @endif
    <!--End of Single Job Post Area-->
    <script>
        $(document).on('click','.employee_app_details .download_pdf',function () {
            var id = $(this).data('id');

            $("#download_cv_form_for_employee input[name='application_id']").val('');
            $("#download_cv_form_for_employee input[name='application_id']").val(id);
            $("#download_cv_form_for_employee").submit();
        });
    </script>
@endsection