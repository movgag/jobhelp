@extends('employee.layout.main_layout')

@section('content')

    @if ( !empty(session('message')) )
        <div class="t_a_center alert alert-@if( !empty(session('type')) ){{ session('type') }}@else{{'warning'}}@endif">
            <strong>@if( !empty(session('type')) ){{ ucfirst(session('type')) }}@else{{'Warning'}}@endif!</strong> {!! session('message') !!}
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ $data['title'] or 'Look Invitation' }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="form-group">
                                <label>Company: </label>
                                <input type="text" disabled class="form-control" value="{{$data['invitation']->company()->first()->company_name}}">
                            </div>
                            <div class="form-group">
                                <label>Email: </label>
                                <input type="text" disabled class="form-control" value="{{$data['invitation']->company()->first()->email}}">
                            </div>
                            <div class="form-group">
                                <label>Job Title: </label>
                                <input type="text" disabled class="form-control" value="{{$data['invitation']->job()->first()->title}}">
                            </div>
                            <div class="form-group">
                                <label>Message: </label>
                                @php ($message = $data['invitation']->invitation_letter ? $data['invitation']->invitation_letter : '' )
                                <textarea disabled placeholder="Message is missed" class="form-control"
                                          rows="8">{{$message}}</textarea>
                            </div>
                            <div class="form-group">
                                <label>Cancled: </label>
                                @php ($canceled = $data['invitation']->canceled ? $data['invitation']->canceled : 0 )
                                <select class="form-control" disabled>
                                    <option value="1" <?= ($canceled == 1) ? 'selected' : '' ?> >Yes</option>
                                    <option value="0" <?= ($canceled == 0) ? 'selected' : '' ?> >No</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Date: </label>
                                <input type="text" disabled class="form-control" value="{{\Carbon\Carbon::parse($data['invitation']->created_at)->format('d-F-Y')}}">
                            </div>

                        </div>

                        <div class="custom_buttons_div">
                            <button type="button" onclick="history.go(-1);return false;" class="btn btn-default">Back</button>
                        </div>
                    </div>
                    <!-- /.row (nested) -->
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>

@endsection