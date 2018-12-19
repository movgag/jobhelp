@extends('layout')

@section('content')
    <!--Breadcrumb Banner Area Start-->
    <div class="breadcrumb-banner-area pt-94 pb-85 bg-3 bg-opacity-dark-blue-90">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-text">
                        <h2 class="text-center text-white uppercase mb-17">{{$data['employee_name'].' '.$data['employee_last_name']}}</h2>
                        <div class="breadcrumb-bar">
                            <ul class="text-center m-0">
                                <li class="text-white uppercase ml-15 mr-15">Resume</li>
                            </ul>
                        </div>
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
                    <form id="single_resume">
                        <div class="single-job-content">
                            <div class="title uppercase pt-50 pb-38"><span class="lg">Profile</span></div>
                            <div class="single-job-form">
                                <div class="single-info pb-14">
                                    <label for="f_name" class="uppercase pull-left m-0">First Name</label>
                                    <div class="form-box fix">
                                        <input id="f_name" disabled  value="{{$data['employee_name']}}">
                                    </div>
                                </div>
                                <div class="single-info">
                                    <label for="l_name" class="uppercase pull-left m-0">last name</label>
                                    <div class="form-box fix">
                                        <input id="l_name" disabled value="{{$data['employee_last_name']}}">
                                    </div>
                                </div>
                            </div>
                            <div class="title uppercase mt-45 mb-38"><span class="medium">Contact Information</span></div>
                            <div class="single-job-form">
                                <div class="single-info mb-14">
                                    <label for="country" class="uppercase pull-left m-0">country</label>
                                    <div class="form-box fix">
                                        <input id="country" disabled value="{{$data['resume']->country}}" >
                                    </div>
                                </div>
                                <div class="single-info mb-14">
                                    <label for="city" class="uppercase pull-left m-0">city</label>
                                    <div class="form-box fix">
                                        <input id="city" disabled value="{{$data['resume']->city}}">
                                    </div>
                                </div>
                                <div class="single-info mb-14">
                                    <label for="address" class="uppercase pull-left m-0">address</label>
                                    <div class="form-box fix">
                                        <input id="address" disabled value="{{$data['resume']->address}}">
                                    </div>
                                </div>
                                <div class="single-info mb-14">
                                    <label for="phone" class="uppercase pull-left m-0">phone</label>
                                    <div class="form-box fix">
                                        <input id="phone" disabled value="{{$data['resume']->phone}}">
                                    </div>
                                </div>
                                <div class="single-info mb-14">
                                    <label for="email" class="uppercase pull-left m-0">email</label>
                                    <div class="form-box fix">
                                        <input id="email" disabled value="{{$data['resume']->email}}">
                                    </div>
                                </div>
                                <div class="single-info mb-14">
                                    <label for="website" class="uppercase pull-left m-0">website</label>
                                    <div class="form-box fix">
                                        <input id="website" disabled value="{{$data['resume']->web_site}}">
                                    </div>
                                </div>
                            </div>
                            <div class="title uppercase mt-45 mb-38"><span class="lg">Biography</span></div>
                            <div class="single-job-form">
                                <div class="single-info mb-14 fix">
                                    <label class="uppercase pull-left m-0">description</label>

                                    <div class="desc fix">
                                        <textarea disabled class="textarea apply_textarea  small" cols="30" rows="10">{{$data['resume']->self_description}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="title uppercase mt-45 mb-38"><span class="lg">Education</span></div>
                            <div class="single-job-form">
                                <div class="single-info mb-14">
                                    <label for="school_name" class="uppercase pull-left m-0">university name</label>
                                    <div class="form-box fix">
                                        <input id="school_name" disabled value="{{$data['resume']->university_name}}" >
                                    </div>
                                </div>
                                <div class="single-info mb-14">
                                    <label for="school_name" class="uppercase pull-left m-0">degree</label>
                                    <div class="form-box fix">
                                        <input id="degree" disabled value="{{$data['resume']->degree}}" >
                                    </div>
                                </div>
                                <div class="single-info mb-14 fix">
                                    <label class="uppercase pull-left m-0">description</label>
                                    <div class="desc fix">
                                        <textarea disabled class="apply_textarea small textarea" cols="30" rows="10" >{{$data['resume']->education_description}}</textarea>
                                    </div>
                                </div>
                            </div>
                            <div class="title uppercase mt-45 mb-38"><span class="lg">Experience</span></div>
                            <div class="single-job-form">
                                <div class="single-info pb-14">
                                    <label for="title" class="uppercase pull-left m-0">Job Title</label>
                                    <div class="form-box fix">
                                        <input id="title" disabled value="{{$data['resume']->job_title}}" >
                                    </div>
                                </div>
                                <div class="single-info mb-14">
                                    <label for="date_from" class="uppercase pull-left m-0">date from</label>
                                    <div class="form-box fix">
                                        <input id="date_from" disabled value="{{$data['resume']->date_from}}">
                                    </div>
                                </div>
                                <div class="single-info mb-14">
                                    <label for="date_to" class="uppercase pull-left m-0">date to</label>
                                    <div class="form-box fix">
                                        <input id="date_to" disabled value="{{$data['resume']->date_to}}">
                                    </div>
                                </div>
                                <div class="single-info mb-14 fix">
                                    <label class="uppercase pull-left m-0">description </label>
                                    <div class="desc fix">
                                        <textarea name="textarea" class="apply_textarea small textarea" cols="30" rows="10">{{$data['resume']->job_description}}</textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--End of Single Job Post Area-->

@endsection