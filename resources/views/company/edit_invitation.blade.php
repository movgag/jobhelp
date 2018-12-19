@extends('company.layout.main_layout')

@section('content')

    @if ( !empty(session('message')) )
        <div class="t_a_center alert alert-@if( !empty(session('type')) ){{ session('type') }}@else{{'warning'}}@endif">
            <strong>@if( !empty(session('type')) ){{ ucfirst(session('type')) }}@else{{'Warning'}}@endif!</strong> {!! session('message') !!}
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ $data['title'] or 'Edit Invitation' }}</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">

                <div class="panel-body">
                    <div class="row">
                        <form method="post" action="{{ url('/company/edit-invitation/'.$data['invitation']->id) }}" role="form">
                            {{ csrf_field() }}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Message: </label>
                                    @php ($message = old('message')? old('message'): ($data['invitation']->invitation_letter ? $data['invitation']->invitation_letter : '') )
                                    <textarea name="message" placeholder="Message" class="form-control"
                                              rows="8">{{$message}}</textarea>
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('message')) {{ $errors->first('message') }} @endif</p>
                                </div>
                                <div class="form-group">
                                    <label>Cancled: </label>
                                    @php ($canceled = old('canceled') != null ? old('canceled') : ($data['invitation']->canceled ? $data['invitation']->canceled : 0) )
                                    <select name="canceled" class="form-control">
                                        <option value="1" <?= ($canceled == 1) ? 'selected' : '' ?> >Yes</option>
                                        <option value="0" <?= ($canceled == 0) ? 'selected' : '' ?> >No</option>
                                    </select>
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('canceled')) {{ $errors->first('canceled') }} @endif</p>
                                </div>

                            </div>

                            <div class="custom_buttons_div">
                                <button type="submit" class="btn btn-default">Update</button>
                                <button type="reset" class="btn btn-default">Reset</button>
                            </div>
                        </form>
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