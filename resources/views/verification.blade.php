@extends('layout')

@section('content')

    <style>
        .click_here, .click_here_2 { color: #14b1bb; text-decoration: none; cursor: pointer;}
        .click_here:hover { color: darkblue;}
        .click_here_2:hover { color: darkblue;}
    </style>
    <style>
        #exampleModalLabel { border-bottom: 1px solid #e5e5e5; padding: 10px 0 10px 20px; font-family:"Helvetica Neue",Helvetica,Arial,sans-serif !important; color:#000 !important; font-size:18px; font-weight: 600;}
        .modal_close_btn { color: white;}
        .modal_close_btn:hover { color: white; }
        .no_top_border { border-top: none;}
        .modal_label {color: black; padding: 7px 7px 7px 0; font-weight: 500; cursor: pointer;}
        .custom_modal_body { padding: 10px;}
    </style>

    @if ( !empty(session('message')) )
        <div class="alert alert-@if( !empty(session('typeV')) ){{ session('typeV') }}@else{{'warning'}}@endif">
            <strong>@if( !empty(session('typeV')) ){{ ucfirst(session('typeV')) }}@else{{'Warning'}}@endif!</strong> {!! session('message') !!}
        </div>
    @endif
    @if(count($errors)>0 && $errors->has('new_email'))
        <div class="alert alert-danger">
            <strong>{{ $errors->first('new_email') }}</strong>
        </div>
    @endif

    <div class="breadcrumb-banner-area pt-94 pb-85 bg-3 bg-opacity-dark-blue-90">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="breadcrumb-text">
                        <h2 class="text-center text-white uppercase mb-17">Verification</h2>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End of Breadcrumb Banner Area-->
    <!--Start of Account Area-->
    <div class="account-area pt-140 mb-120">
        <div class="container">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    @if ( !empty(session('verify_text')) )
                        <div role="alert" class="alert alert-{{ session('type') }}">
                            <p>{!! session('verify_text') !!}</p>
                            <p>{!! session('resend_text') !!} <span class="click_here">HERE</span> , or contact us!</p>
                            <p>If You want to change Your email address then click <span class="click_here_2" data-toggle="modal" data-target="#exampleModal">HERE</span> </p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @php($a_guard = (auth()->guard('company')->user() && isset(auth()->guard('company')->user()->id) && (int)auth()->guard('company')->user()->id > 0) ? 'company' :
    ( (auth()->guard('employee')->user() && isset(auth()->guard('employee')->user()->id) && (int)auth()->guard('employee')->user()->id > 0) ? 'employee' : '' ) )
    <form id="repeat_verification" action="{{ url('/'.$a_guard.'/send-repeat-mail') }}" method="post">
        {{ csrf_field() }}
    </form>

    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Change Email Address</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ url('/'.$a_guard.'/change-email-address') }}" method="post">
                    {{ csrf_field() }}
                    <input type="hidden" name="employee_id" value="">
                    <div class="modal-body custom_modal_body">
                        <label for="existing_email" class="modal_label">Existing Email Address</label>
                        <input id="existing_email" type="text" disabled value="{{ auth()->guard($a_guard)->user()->email }}" class="form-control">

                        <label for="new_email" class="modal_label">New Email Address</label>
                        <input id="new_email" name="new_email" type="email" required value="" class="form-control">
                    </div>

                    <div class="modal-footer no_top_border">
                        <button type="button" class="btn btn-secondary modal_close_btn" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--End of Account Area-->
    <script>
        $(document).on('click','span.click_here',function () {
           $("#repeat_verification").submit();
        });

    </script>
@endsection