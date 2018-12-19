@extends('employee.layout.main_layout')

@section('content')

    @if ( !empty(session('message')) )
        <div class="t_a_center alert alert-@if( !empty(session('type')) ){{ session('type') }}@else{{'warning'}}@endif">
            <strong>@if( !empty(session('type')) ){{ ucfirst(session('type')) }}@else{{'Warning'}}@endif!</strong> {!! session('message') !!}
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ $data['title'] or 'Edit Application' }}</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">

                <div class="panel-body">
                    <div class="row">
                        <form action="{{ url('/employee/edit-application/'.$data['letter']->id) }}" role="form" id="show_application_form" method="post">
                            {{ csrf_field() }}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Excepted Salary: </label>
                                    @php ($excepted_salary = old('excepted_salary')? old('excepted_salary'): $data['letter']->excepted_salary)
                                    <input class="form-control" name="excepted_salary" value="{{$excepted_salary}}">
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('excepted_salary')) {{ $errors->first('excepted_salary') }} @endif</p>
                                </div>
                                <div class="form-group">
                                    <label>Letter: </label>
                                    @php ($apply_letter = old('apply_letter')? old('apply_letter'): $data['letter']->apply_letter)
                                    <textarea name="apply_letter" class="form-control" rows="8">{{$apply_letter}}</textarea>
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('apply_letter')) {{ $errors->first('apply_letter') }} @endif</p>
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
                                <button onclick="history.go(-1);return false;" type="button" class="btn btn-default">Back</button>
                                <button type="submit" class="btn btn-default">Update</button>
                            </div>
                        </form>
                        @if($data['letter']->uploaded_cv)
                            <form action="{{ url('/employee/download-cv') }}" method="post" id="download_cv_form">
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


    <script>

        $("#show_application_form .download_pdf").click(function () {
            var id = $(this).data('id');
            $("#download_cv_form input[name='application_id']").val('');
            $("#download_cv_form input[name='application_id']").val(id);
            $("#download_cv_form").submit();
        });
    </script>

@endsection