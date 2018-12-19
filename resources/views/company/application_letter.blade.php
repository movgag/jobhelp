@extends('company.layout.main_layout')

@section('content')

    @if ( !empty(session('message')) )
        <div class="t_a_center alert alert-@if( !empty(session('type')) ){{ session('type') }}@else{{'warning'}}@endif">
            <strong>@if( !empty(session('type')) ){{ ucfirst(session('type')) }}@else{{'Warning'}}@endif!</strong> {!! session('message') !!}
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ $data['title'] or 'Add Job' }}</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">

                <div class="panel-body">
                    <div class="row">
                        <form role="form" id="show_application_form">
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Excepted Salary: </label>
                                    <input class="form-control" disabled value="{{$data['letter']->excepted_salary}}">
                                </div>
                                <div class="form-group">
                                    <label>Letter: </label>
                                    <textarea disabled class="form-control" rows="8">{{$data['letter']->apply_letter}}</textarea>
                                </div>
                                @if($data['letter']->uploaded_cv)
                                    <div class="form-group">
                                        <label>Download attached CV: </label><br>
                                        <button type="button" data-id="{{$data['letter']->id}}" class=" btn btn-primary download_pdf">Download</button>
                                    </div>
                                @endif
                                <div class="form-group">
                                    <label>Status: </label>
                                    <input class="form-control" disabled value="{{ucfirst($data['letter']->status)}}">
                                </div>
                            </div>

                            <div class="custom_buttons_div">
                                <button type="button" onclick="history.go(-1)" class="btn btn-default">Back</button>
                                <button type="button" class="btn btn-default accept_btn" data-val = 'accepted' data-toggle="modal" data-target="#myModal">Accept</button>
                                <button type="button" class="btn btn-default decline_btn" data-val = 'declined' data-toggle="modal" data-target="#myModal" >Decline</button>
                            </div>
                        </form>
                        @if($data['letter']->uploaded_cv)
                            <form action="{{ url('/company/download-cv') }}" method="post" id="download_cv_form">
                                {{csrf_field()}}
                                <input type="hidden" name="application_id" value="">
                            </form>
                        @endif

                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>


    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel"><b>Are You sure?</b></h4>
                </div>
                <form id="accept_or_decline_form" method="post" action="{{ url('/company/application-letter/'.$data['letter']->employee_id.'/'.$data['letter']->job_id) }}">
                    {{ csrf_field() }}
                <div class="modal-body">
                    <label for="#decision">Decision letter (not mandatory)</label>
                    <textarea name="decision" id="decision" class="form-control" cols="30" rows="6" placeholder="This letter will be email to employee"></textarea>
                </div>
                <div class="modal-footer">
                        <input type="hidden" name="val" value="">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Yes</button>
                </div>
                </form>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <script>
        $("#show_application_form button").click(function () {
            var val = $(this).data('val');

            $("#decision").val('');

            $("#accept_or_decline_form input[name='val']").val('');
            $("#accept_or_decline_form input[name='val']").val(val);
            //$("#accept_or_decline_form").submit();

        });

        $("#show_application_form .download_pdf").click(function () {
            var id = $(this).data('id');
            $("#download_cv_form input[name='application_id']").val('');
            $("#download_cv_form input[name='application_id']").val(id);
            $("#download_cv_form").submit();
        });
    </script>

@endsection