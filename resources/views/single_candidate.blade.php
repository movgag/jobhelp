@extends('layout')

@section('content')
    <style>
        #exampleModalLabel { border-bottom: 1px solid #e5e5e5; padding: 10px 0 10px 20px; font-family:"Helvetica Neue",Helvetica,Arial,sans-serif !important; color:#000 !important; font-size:18px; font-weight: 600;}
        .modal_close_btn { color: white;}
        .modal_close_btn:hover { color: white; }
        .no_top_border { border-top: none;}
        .modal_label {color: black; padding: 7px 7px 7px 0; font-weight: 500; cursor: pointer;}
        .custom_modal_body { padding: 10px;}
    </style>
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
                        <h2 class="text-center text-white uppercase mb-17">{{ $data['employee']->name.' '.$data['employee']->last_name }}</h2>
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
                                <div class="single-blog hover-effect mb-50">
                                    <div class="blog-image box-hover">
                                        <a href="#" class="block">
                                            @php($image_name = $data['employee']->image ? $data['employee']->image : 'no_image.png')
                                            <img src="{{ asset('/images/candidates/'.$image_name) }}" alt="">
                                        </a>
                                    </div>
                                </div>
                                <div class="tags-and-links fix pt-14 pb-12">
                                    <div class="related-tag pull-left">
                                        <span class="mr-10">Skills:</span>
                                        <ul class="tags">
                                            @if($data['employee']->skills)
                                                @foreach($data['employee']->skills as $s => $skill)
                                                    <li>{{ $skill->name }} <?= (count($data['employee']->skills) - 1) == $s ? '' : ',' ?> </li>
                                                @endforeach
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="single-sidebar-widget mb-48">
                        @php($region = isset($data['employee']->region()->first()->name) ? $data['employee']->region()->first()->name : 'no region')
                        @php($type = isset($data['employee']->type()->first()->name) ? $data['employee']->type()->first()->name : 'no type')
                        @php($category = isset($data['employee']->category()->first()->name) ? $data['employee']->category()->first()->name : 'no category')
                        <ul class="light-gray-bg pt-17 pb-15">
                            <li class="ptb-10 ml-30"><span class="employee_detail">Full name:</span ><span class="ml-9">{{ $data['employee']->name.' '.$data['employee']->last_name }}</span></li>
                            <li class="ptb-10 ml-30"><span class="employee_detail">Title:</span ><span class="ml-9">{{ $data['employee']->title }}</span></li>
                            <li class="ptb-10 ml-30"><span class="employee_detail">Birthday:</span ><span class="ml-9">{{ $data['employee']->date_of_birth }}</span></li>
                            <li class="ptb-10 ml-30"><span class="employee_detail">Email:</span ><span class="ml-9">{{ $data['employee']->email }}</span></li>
                            <li class="ptb-10 ml-30"><span class="employee_detail">Type:</span ><span class="ml-9">{{ $type }}</span></li>
                            <li class="ptb-10 ml-30"><span class="employee_detail">Category:</span ><span class="ml-9">{{ $category }}</span></li>
                            <li class="ptb-10 ml-30"><span class="employee_detail">Languages:</span>
                                @if($data['employee']->languages()->get())
                                    @foreach($data['employee']->languages()->get() as $l => $language)
                                        <span class="ml-2">{{ $language->name }} <?= (count($data['employee']->languages()->get()) - 1) == $l ? '' : ',' ?> </span>
                                    @endforeach
                                @endif
                            </li>
                            <li class="ptb-10 ml-30"><span class="employee_detail">Region:</span ><span class="ml-9">{{ $region }}</span></li>
                            <li class="ptb-10 ml-30"><span class="employee_detail">Address:</span ><span class="ml-9">{{ $data['employee']->address }}</span></li>
                            <li class="ptb-10 ml-30"><span class="employee_detail">Phone:</span ><span class="ml-9">{{ $data['employee']->phone }}</span></li>

                            <li class="ptb-10 ml-30"><span class="employee_detail">CV:</span ><a title="See resume" href="{{ url('/company/look-resume/'.$data['employee']->id) }}"><span class="ml-9"><i class="fa fa-eye"></i></span></a></li>

                            <li class="ptb-10 ml-30">
                                <span class="employee_detail">Send Invitation:</span >
                                <a @if(isset($data['auth_company'])) data-toggle="modal" data-target="#exampleModal" href="" @else href="{{ url('/company/home') }}" @endif title="Send Invitation">
                                    <span class="ml-9"><i class="fa fa-list"></i></span>
                                </a>
                            </li>

                        </ul>
                    </div>

                </div>
            </div>

            <div class="row pt-20">
                <div class="col-md-12">
                    <div class="blog-posts">
                        <div class="row">

                            @if($data['portfolios'] && count($data['portfolios'])>0)
                                @foreach($data['portfolios'] as $portfolio)
                                    <div class="col-md-6 col-xs-12">
                                        <div class="single-blog hover-effect mb-50">
                                            <div class="blog-image box-hover">
                                                <a href="{{ route('single.portfolio',['id'=>$portfolio->id]) }}" class="block">
                                                    <img class="portfolio_image" src="{{ asset('/images/emp-portfolios/'.$portfolio->image) }}" alt="">
                                                </a>
                                            </div>
                                            <div class="blog-text">
                                                <div class="blog-date pt-12">
                                                    <span class="text-large block text-white">{{ \Carbon\Carbon::parse($portfolio->created_at)->format('d') }}</span>
                                                    <span class="uppercase block text-white">{{ \Carbon\Carbon::parse($portfolio->created_at)->format('F') }}</span>
                                                </div>
                                                <div class="blog-post-info">
                                                    <span class="pl-10"><i class="zmdi zmdi-account pr-8"></i>{{ $data['employee']->name.' '.$data['employee']->last_name }}</span>
                                                    {{--<span class="pl-35"><i class="zmdi zmdi-favorite pr-8"></i>like</span>--}}
                                                    {{--<span class="pl-15"><i class="zmdi zmdi-comments pr-8"></i>comments</span>--}}
                                                </div>
                                                <h5 class="pt-28 mb-6"><a href="{{ route('single.portfolio',['id'=>$portfolio->id]) }}">{{$portfolio->title}}</a></h5>
                                                @php($portfolio_description = $portfolio->description ? ( strlen($portfolio->description) > 300 ? substr($portfolio->description,0,300).'...' : $portfolio->description  ) : '' )
                                                <p class="mb-21">{{$portfolio_description}}</p>
                                                <a href="{{ route('single.portfolio',['id'=>$portfolio->id]) }}" class="button large-button">Read More</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                <div class="col-md-6 col-xs-12">
                                    <div class="single-blog hover-effect mb-50 pt-13">
                                        <p>Employee has not added portfolio details yet ...</p>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>

                    @if($data['portfolios'] && count($data['portfolios']) > 0)
                        <div class="pagination-content text-center block">
                            {{ $data['portfolios']->links('custom_pagination') }}
                        </div>
                    @endif

                </div>
                {{--<div class="col-md-4">--}}
                    {{--<div class="social-links pull-right ">--}}
                        {{--<span>Share:</span>--}}
                        {{--<a href="#"><i class="zmdi zmdi-facebook"></i></a>--}}
                        {{--<a href="#"><i class="zmdi zmdi-twitter"></i></a>--}}
                        {{--<a href="#"><i class="zmdi zmdi-google-old"></i></a>--}}
                        {{--<a href="#"><i class="zmdi zmdi-instagram"></i></a>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>
        </div>
    </div>
    <!--End of Blog Area-->

    @if(isset($data['auth_company']))
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Invitation letter</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form action="{{ url('/company/send-invitation') }}" method="post">
                        {{ csrf_field() }}
                        <input type="hidden" name="employee_id" value="{{$data['employee']->id}}">
                        <div class="modal-body custom_modal_body">
                            <label for="job_id" class="modal_label">Select Job</label>
                            <select name="job_id" id="job_id" class="form-control">
                                <option value="">Select Job</option>
                                @if($data['jobs'] && count($data['jobs']) > 0)
                                    @foreach($data['jobs'] as $job)
                                        <option value="{{ $job->id }}" <?= in_array($job->id,$data['invited_job_ids']) ? 'disabled style="background-color:#D7DADD;" title="Is already invited"' : '' ?> >{{ $job->title }}</option>
                                    @endforeach
                                @endif
                            </select>
                            <p class="help-block val_error">@if(count($errors)>0 && $errors->has('job_id')) {{ $errors->first('job_id') }} @endif</p>
                            <label for="text_message" class="modal_label">Message</label>
                            <textarea name="message" id="text_message" class="small textarea fix form-control" placeholder="Type message (not required,max 400 characters)" cols="30" rows="10"></textarea>
                            <p class="help-block val_error">@if(count($errors)>0 && $errors->has('message')) {{ $errors->first('message') }} @endif</p>
                        </div>
                        <div class="modal-footer no_top_border">
                            <button type="button" class="btn btn-secondary modal_close_btn" data-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Send</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endif
@endsection