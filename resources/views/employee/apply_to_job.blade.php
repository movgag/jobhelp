@extends('layout')

@section('content')

    @if ( !empty(session('message')) )
        <div class="t_a_center alert alert-@if( !empty(session('type')) ){{ session('type') }}@else{{'warning'}}@endif">
            <strong>@if( !empty(session('type')) ){{ ucfirst(session('type')) }}@else{{'Warning'}}@endif!</strong> {!! session('message') !!}
        </div>
    @endif

    <div class="breadcrumb-banner-area pt-94 pb-85 bg-3 bg-opacity-dark-blue-90">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-text">
                        <h2 class="text-center text-white uppercase mb-17">
                            <a href="{{ route('single.job',['id'=>$data['job']->id]) }}" class="job_title_a">
                                {{ $data['job']->title }}
                            </a>
                        </h2>
                        <div class="breadcrumb-bar">
                            <ul class=" text-center m-0">
                                <li class="text-white uppercase ml-15 mr-15">Apply to job</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End of Breadcrumb Banner Area-->
    <!--Start of Single Job Post Area-->
    <div class="single-job-post-area pt-10 mb-100">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <form action="{{ url('/employee/apply-job/'.$data['job']->id) }}" method="post" enctype="multipart/form-data">
                        {{ csrf_field() }}
                        <div class="single-job-content">
                            <div class="title uppercase mt-45 mb-38"><span class="lg">Apply Form</span></div>
                            <div class="single-job-form">
                                <div class="single-info mb-14 fix">
                                    <label class="uppercase pull-left m-0">apply letter</label>
                                    <div class="desc fix">
                                        @php ($apply_letter = old('apply_letter')? old('apply_letter'): '')
                                        <textarea name="apply_letter" class="fix small textarea apply_textarea" cols="30" rows="10" placeholder="Please enter Your letter(max 1200 simbols)">{{$apply_letter}}</textarea>
                                        <p class="help-block val_error">@if(count($errors)>0 && $errors->has('apply_letter')) {{ $errors->first('apply_letter') }} @endif</p>
                                    </div>
                                </div>
                                <div class="single-info mb-14">
                                    <label class="uppercase pull-left m-0">minimum salary</label>
                                    <div class="form-box fix">
                                        @php ($excepted_salary = old('excepted_salary')? old('excepted_salary'): '')
                                        <input type="text" name="excepted_salary" placeholder="Please enter excepted salary" value="{{$excepted_salary}}">
                                        <p class="help-block val_error">@if(count($errors)>0 && $errors->has('excepted_salary')) {{ $errors->first('excepted_salary') }} @endif</p>
                                    </div>
                                </div>
                                <div class="single-info mb-14">
                                    <label class="uppercase pull-left m-0">attach cv (pdf)</label>
                                    <div class="form-box fix">
                                        <input type="file" name="uploaded_cv"  value="">
                                        <p class="help-block val_error">@if(count($errors)>0 && $errors->has('uploaded_cv')) {{ $errors->first('uploaded_cv') }} @endif</p>
                                    </div>
                                </div>
                                <div class="ml-160 mt-42">
                                    <button onclick="history.go(-1);return false;" type="button" class="button button-medium-box apply_btn mr-20">Back</button>
                                    <button type="submit" class="button button-medium-box apply_btn">Apply</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection