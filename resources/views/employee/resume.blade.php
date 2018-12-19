@extends('employee.layout.main_layout')

@section('content')

    @if ( !empty(session('message')) )
        <div class="t_a_center alert alert-@if( !empty(session('type')) ){{ session('type') }}@else{{'warning'}}@endif">
            <strong>@if( !empty(session('type')) ){{ ucfirst(session('type')) }}@else{{'Warning'}}@endif!</strong> {!! session('message') !!}
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ $data['title'] or 'Resume' }}</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">

                <div class="panel-body">
                    <div class="row">
                        <form method="post" action="{{ url('/employee/resume') }}" role="form" id="resume_form" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Country: </label>
                                    @php ($country = old('country') ? old('country') : ( ($data['resume'] && isset($data['resume']->country)) ? $data['resume']->country : '' ) )
                                    <input name="country" class="form-control" placeholder="Armenia" value="{{$country}}">
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('country')) {{ $errors->first('country') }} @endif</p>
                                </div>
                                <div class="form-group">
                                    <label>City: </label>
                                    @php ($city = old('city') ? old('city') : ( ($data['resume'] && isset($data['resume']->city)) ? $data['resume']->city : '' ) )
                                    <input name="city" class="form-control" placeholder="Yerevan" value="{{$city}}">
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('city')) {{ $errors->first('city') }} @endif</p>
                                </div>
                                <div class="form-group">
                                    <label>Address: </label>
                                    @php ($address = old('address') ? old('address') : ( ($data['resume'] && isset($data['resume']->address)) ? $data['resume']->address : '' ) )
                                    <input name="address" class="form-control" placeholder="Tigran Mets 1, ap. 1" value="{{$address}}">
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('address')) {{ $errors->first('address') }} @endif</p>
                                </div>
                                <div class="form-group">
                                    <label>Phone: </label>
                                    @php ($phone = old('phone') ? old('phone') : ( ($data['resume'] && isset($data['resume']->phone)) ? $data['resume']->phone : '' ) )
                                    <input name="phone" class="form-control" placeholder="098000000" value="{{$phone}}">
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('phone')) {{ $errors->first('phone') }} @endif</p>
                                </div>
                                <div class="form-group">
                                    <label>Email: </label>
                                    @php ($email = old('email') ? old('email') : ( ($data['resume'] && isset($data['resume']->email)) ? $data['resume']->email : '' ) )
                                    <input name="email" class="form-control" placeholder="myemail@gmail.com" value="{{$email}}">
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('email')) {{ $errors->first('email') }} @endif</p>
                                </div>
                                <div class="form-group">
                                    <label>Website: </label>
                                    @php ($web_site = old('web_site') ? old('web_site') : ( ($data['resume'] && isset($data['resume']->web_site)) ? $data['resume']->web_site : '' ) )
                                    <input name="web_site" class="form-control" placeholder="http://mywebsite.com" value="{{$web_site}}">
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('web_site')) {{ $errors->first('web_site') }} @endif</p>
                                </div>
                                <div class="form-group">
                                    <label>Existing image: </label>
                                    @php($resume_image = ($data['resume'] && isset($data['resume']->image) && $data['resume']->image) ? $data['resume']->image : 'no_image.png')
                                    <img width="100px" height="100px" src="{{ asset('/images/resume_images/'.$resume_image) }}" alt="">
                                    <input type="hidden" name="old_image" value="{{$resume_image}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>University name: </label>
                                    @php ($university_name = old('university_name') ? old('university_name') : ( ($data['resume'] && isset($data['resume']->university_name)) ? $data['resume']->university_name : '' ) )
                                    <input name="university_name" class="form-control" placeholder="ASUE" value="{{$university_name}}">
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('university_name')) {{ $errors->first('university_name') }} @endif</p>
                                </div>
                                <div class="form-group">
                                    <label>Degree: </label>
                                    @php ($degree = old('degree') ? old('degree') : ( ($data['resume'] && isset($data['resume']->degree)) ? $data['resume']->degree : '' ) )
                                    <select name="degree" id="" class="form-control">
                                        <option value="">Select Degree</option>
                                        <option value="bachelor" <?= $degree == 'bachelor' ? 'selected' : '' ?> >Bachelor</option>
                                        <option value="master" <?= $degree == 'master' ? 'selected' : '' ?>>Master</option>
                                        <option value="academic" <?= $degree == 'academic' ? 'selected' : '' ?> >Academic</option>
                                    </select>
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('degree')) {{ $errors->first('degree') }} @endif</p>
                                </div>
                                <div class="form-group">
                                    <label>Education description (max 2000 symbols): </label>
                                    @php ($education_description = old('education_description')? old('education_description'): ( ($data['resume'] && isset($data['resume']->education_description)) ? $data['resume']->education_description : '' ) )
                                    <textarea name="education_description" placeholder="BSc (Hons) in Computing and Business , A Level Information Technology (A) " class="form-control"
                                              rows="5">{{$education_description}}</textarea>
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('education_description')) {{ $errors->first('education_description') }} @endif</p>
                                </div>
                                <div class="form-group">
                                    <label>Self description (max 2000 symbols): </label>
                                    @php ($self_description = old('self_description')? old('self_description') : ( ($data['resume'] && isset($data['resume']->self_description)) ? $data['resume']->self_description : '' ) )
                                    <textarea name="self_description" placeholder="I am a responsible , trustworthy friend and reliable worker. For me, my work is worship. I am helpful to my friends as well as colleagues. In difficult times, I prefer to stay calm and resolve the problems." class="form-control"
                                              rows="5">{{$self_description}}</textarea>
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('self_description')) {{ $errors->first('self_description') }} @endif</p>
                                </div>
                                <label for="resume_image" class="drag_input_label">Choose image: </label>
                                <div class="form-group drag_form_group">
                                    <input type="file" name="image" class="drag_image" id="resume_image">
                                    <p class="drag">Drag your files here or click in this area.</p>
                                </div>
                                <p class="help-block error">@if(count($errors)>0 && $errors->has('image')) {{ $errors->first('image') }} @endif</p>
                            </div>

                            <div class="col-lg-12">
                                <button type="submit" class="btn btn-default">Save</button>
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

    @php($job_details = ($data['resume'] && isset($data['resume']->id)) ? $data['resume']->job_details : array())
        <div class="row" style="padding-bottom: 60px;">
            <div class="col-lg-12">

                <h2 class="page-header">Build Your Job Employment (max 5)<button type="button" data-toggle="modal" data-target="#myModal" class="btn btn-success add_btn_for_job_detail"><i class="fa fa-plus"></i> Add Job Detail</button></h2>

                <table class="table-bordered table-responsive table" id="job_details_table">
                    <tr>
                        <th>ID</th>
                        <th>Job Title</th>
                        <th>Date From</th>
                        <th>Date To</th>
                        <th>Actions</th>
                    </tr>
                    @if($job_details && count($job_details) > 0)
                        @php($job_details = $job_details->sortByDesc('created_at'));
                        @foreach($job_details as $job_detail)
                            <tr class="current_tr_{{$job_detail->id}}">
                                <td>{{ $job_detail->id }}</td>
                                <td class="job_title_td">{{ $job_detail->job_title }}</td>
                                <td class="date_from_td">{{ $job_detail->date_from }}</td>
                                <td class="date_to_td">{{ $job_detail->date_to }}</td>
                                <td>
                                    <button data-toggle="modal" data-target="#myEditModal" class="btn btn-primary edit_btn_for_job_detail edit_btn_{{$job_detail->id}} " data-id="{{$job_detail->id}}"><i class="fa fa-edit"></i></button>
                                    <button data-toggle="modal" data-target="#myDeleteModal" class="btn btn-danger delete_btn_for_job_detail" data-id="{{$job_detail->id}}"><i class="fa fa-close"></i></button>
                                </td>
                                <td class="job_description_td" style="display: none;">{{$job_detail->job_description}}</td>
                            </tr>
                        @endforeach
                    @endif
                </table>
            </div>
       </div>

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close_btn_for_job_detail" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myModalLabel">Job Detail</h4>
                </div>
                <div class="modal-body">
                    <form id="add_job_detail_form">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Job title: </label>
                            <input name="job_title" class="form-control job_title_input" placeholder="Full Stack developer" value="">
                            <p class="help-block error job_title"></p>
                        </div>
                        <div class="form-group">
                            <label>Job description (max 2000 symbols): </label>
                            <textarea name="job_description" placeholder="I have worked on position for full stack developer and have led a team of juniors ..." class="form-control job_description_input" rows="5"></textarea>
                            <p class="help-block error job_description"></p>
                        </div>
                        <div class="form-group">
                            <label>Date From: </label>
                            <input class="form-control date_from_input" id="date_from" name="date_from" placeholder="YYYY-MM-DD" type="text" value=""/>
                            <p class="help-block error date_from"></p>
                        </div>
                        <div class="form-group">
                            <label>Date To: </label>
                            <input class="form-control date_to_input" id="date_to" name="date_to" placeholder="YYYY-MM-DD" type="text" value=""/>
                            <p class="help-block error date_to"></p>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default close_btn_for_job_detail" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary add_job_detail">
                        Save changes <i class="fa fa-spinner fa-spin add_job_detail_spinner" style="display: none;"></i>
                    </button>
                    <p class="failed_span"></p>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


    <div class="modal fade" id="myEditModal" tabindex="-1" role="dialog" aria-labelledby="myEditModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close_btn_for_job_detail" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myEditModalLabel">Job Detail</h4>
                </div>
                <div class="modal-body">
                    <form id="edit_job_detail_form">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label>Job title: </label>
                            <input name="job_title" class="form-control job_title_input" placeholder="Full Stack developer" value="">
                            <p class="help-block error job_title"></p>
                        </div>
                        <div class="form-group">
                            <label>Job description (max 2000 symbols): </label>
                            <textarea name="job_description" placeholder="I have worked on position for full stack developer and have led a team of juniors ..." class="form-control job_description_input" rows="5"></textarea>
                            <p class="help-block error job_description"></p>
                        </div>
                        <div class="form-group">
                            <label>Date From: </label>
                            <input class="form-control date_from_input" id="date_from" name="date_from" placeholder="YYYY-MM-DD" type="text" value=""/>
                            <p class="help-block error date_from"></p>
                        </div>
                        <div class="form-group">
                            <label>Date To: </label>
                            <input class="form-control date_to_input" id="date_to" name="date_to" placeholder="YYYY-MM-DD" type="text" value=""/>
                            <p class="help-block error date_to"></p>
                        </div>
                        <input type="hidden" name="job_detail_id" value="">
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default close_btn_for_job_detail" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary edit_job_detail">
                        Save changes <i class="fa fa-spinner fa-spin edit_job_detail_spinner" style="display: none;"></i>
                    </button>
                    <p class="failed_span"></p>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>


    <div class="modal fade" id="myDeleteModal" tabindex="-1" role="dialog" aria-labelledby="myDeleteModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close close_btn_for_job_detail" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="myDeleteModalLabel">Are You sure ?</h4>
                </div>
                <div class="modal-body">
                    <form id="delete_job_detail_form">
                        {{ csrf_field() }}
                        <input type="hidden" name="job_detail_id" value="">
                        <p class="help-block error job_detail_id"></p>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default close_btn_for_job_detail" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary delete_job_detail">
                        Delete <i class="fa fa-spinner fa-spin delete_job_detail_spinner" style="display: none;"></i>
                    </button>
                    <p class="failed_span"></p>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <script>
        $(document).ready(function(){

            $('form input[type="file"]').change(function () {
                $('form p.drag').text(this.files.length + " file selected");
            });

        });
        // job details js logic ----------------start

        // submiting form -------------- start

        $(document).on('click','button.delete_job_detail',function () {

            var job_detail_id = $("form#delete_job_detail_form input[name='job_detail_id']");

            var _token = $("form#delete_job_detail_form input[name='_token']");

            var submit_btn = $(this);
            var spinner = $('#myDeleteModal .delete_job_detail_spinner');
            var failed_span = $('#myDeleteModal .failed_span');

            var arr = {};
            arr.job_detail_id = job_detail_id;

            $.ajax({
                url: "/employee/delete-job-detail",
                type:'POST',
                data: {_token:_token.val(), job_detail_id: job_detail_id.val()},
                beforeSend: function () {
                    failed_span.text('');
                    submit_btn.prop('disabled',true);
                    spinner.show();
                },
                success: function(data) {
                    failed_span.text('');

                    $("#job_details_table tr.current_tr_"+ data.id).remove();

                    submit_btn.prop('disabled',false);
                    spinner.hide();

                    $.each(arr, function (index, value) {
                        value.val('');
                        value.css('border-color','#ccc');
                        value.next('p').html('');
                    });

                    $("#myDeleteModal").modal('toggle');

                },
                error:function (response) {

                    failed_span.text('');

                    $.each(arr, function (index, value) {
                        value.next('p').html('');
                        value.css('border-color','#ccc');
                    });

                    $.each(response.responseJSON.errors, function (index, value) {
                        $('form#delete_job_detail_form' + ' ' + '.'+ index).text(value[0]);
                        $('form#delete_job_detail_form' + ' ' + '.'+ index+'_input').css('border-color','red');
                    });
                    if (response.responseJSON.error) {
                        failed_span.text(response.responseJSON.error);
                    }
                    submit_btn.prop('disabled',false);
                    spinner.hide();
                }
            });
        });

        $(document).on('click','button.add_job_detail',function () {

            var job_title = $("form#add_job_detail_form input[name='job_title']");
            var job_description = $("form#add_job_detail_form textarea[name='job_description']");
            var date_from = $("form#add_job_detail_form input[name='date_from']");
            var date_to = $("form#add_job_detail_form input[name='date_to']");

            var _token = $("form#add_job_detail_form input[name='_token']");

            var submit_btn = $(this);
            var spinner = $('#myModal .add_job_detail_spinner');
            var failed_span = $('#myModal .failed_span');

            var arr = {};
            arr.job_title = job_title;
            arr.job_description = job_description;
            arr.date_from = date_from;
            arr.date_to = date_to;

            $.ajax({
                url: "/employee/add-job-detail",
                type:'POST',
                data: {_token:_token.val(), job_title: job_title.val(), job_description: job_description.val(), date_from: date_from.val(), date_to: date_to.val()},
                beforeSend: function () {
                    failed_span.text('');
                    submit_btn.prop('disabled',true);
                    spinner.show();
                },
                success: function(data) {
                    failed_span.text('');

                    var html = '<tr class="current_tr_'+ data.id + '">' + '<td>'+data.id+'</td>' + '<td class="job_title_td">' + data.job_title + '</td>' + '<td class="date_from_td">' + data.date_from + '</td>' + '<td class="date_to_td">' + data.date_to + '</td>'
                        + '<td>' + '<button data-toggle="modal" data-target="#myEditModal" class="btn btn-primary edit_btn_for_job_detail edit_btn_' + data.id + '" data-id="' + data.id +'"><i class="fa fa-edit"></i></button>'
                        + ' ' + '<button class="btn btn-danger delete_btn_for_job_detail" data-toggle="modal" data-target="#myDeleteModal" data-id="' + data.id + '"><i class="fa fa-close"></i></button>'   + '</td>' + '<td class="job_description_td" style="display: none;">' + data.job_description + '</td>' + '</tr>';

                    $("#job_details_table tr:first-child").after(html);

                    submit_btn.prop('disabled',false);
                    spinner.hide();

                    $.each(arr, function (index, value) {
                        value.val('');
                        value.css('border-color','#ccc');
                        value.next('p').html('');
                    });

                    $("#myModal").modal('toggle');

                },
                error:function (response) {

                    failed_span.text('');

                    $.each(arr, function (index, value) {
                        value.next('p').html('');
                        value.css('border-color','#ccc');
                    });

                    $.each(response.responseJSON.errors, function (index, value) {
                        $('form#add_job_detail_form' + ' ' + '.'+ index).text(value[0]);
                        $('form#add_job_detail_form' + ' ' + '.'+ index+'_input').css('border-color','red');
                    });
                    if (response.responseJSON.error) {
                        failed_span.text(response.responseJSON.error);
                    }
                    submit_btn.prop('disabled',false);
                    spinner.hide();
                }
            });
        });

        $(document).on('click','button.edit_job_detail',function () {

            var job_title = $("form#edit_job_detail_form input[name='job_title']");
            var job_description = $("form#edit_job_detail_form textarea[name='job_description']");
            var date_from = $("form#edit_job_detail_form input[name='date_from']");
            var date_to = $("form#edit_job_detail_form input[name='date_to']");
            var job_detail_id = $("form#edit_job_detail_form input[name='job_detail_id']");

            var _token = $("form#edit_job_detail_form input[name='_token']");

            var submit_btn = $(this);
            var spinner = $('#myEditModal .edit_job_detail_spinner');
            var failed_span = $('#myEditModal .failed_span');

            var arr = {};
            arr.job_title = job_title;
            arr.job_description = job_description;
            arr.date_from = date_from;
            arr.date_to = date_to;

            $.ajax({
                url: "/employee/edit-job-detail",
                type:'POST',
                data: {_token:_token.val(), job_detail_id: job_detail_id.val(), job_title: job_title.val(), job_description: job_description.val(), date_from: date_from.val(), date_to: date_to.val()},
                beforeSend: function () {
                    failed_span.text('');
                    submit_btn.prop('disabled',true);
                    spinner.show();
                },
                success: function(data) {
                    failed_span.text('');

                    $('tr.current_tr_' + data.id).find('td.job_title_td').text(data.job_title);
                    $('tr.current_tr_' + data.id).find('td.date_from_td').text(data.date_from);
                    $('tr.current_tr_' + data.id).find('td.date_to_td').text(data.date_to);
                    $('tr.current_tr_' + data.id).find('td.job_description_td').text(data.job_description);

                    submit_btn.prop('disabled',false);
                    spinner.hide();

                    $.each(arr, function (index, value) {
                        value.val('');
                        value.next('p').html('');
                        value.css('border-color','#ccc');
                    });

                    $("#myEditModal").modal('toggle');
                },
                error:function (response) {

                    failed_span.text('');

                    $.each(arr, function (index, value) {
                        value.next('p').html('');
                        value.css('border-color','#ccc');
                    });

                    $.each(response.responseJSON.errors, function (index, value) {
                        $('form#edit_job_detail_form' + ' ' + '.'+ index).text(value[0]);
                        $('form#edit_job_detail_form' + ' ' + '.'+ index+'_input').css('border-color','red');
                    });
                    if (response.responseJSON.error) {
                        failed_span.text(response.responseJSON.error);
                    }
                    submit_btn.prop('disabled',false);
                    spinner.hide();
                }
            });
        });
        // submiting form -------------- end

        // modal fields clearing and seting values --- start
        $(document).on('click','button.edit_btn_for_job_detail',function () {
            var job_title = $("form#edit_job_detail_form input[name='job_title']");
            var job_description = $("form#edit_job_detail_form textarea[name='job_description']");
            var date_from = $("form#edit_job_detail_form input[name='date_from']");
            var date_to = $("form#edit_job_detail_form input[name='date_to']");
            var job_detail_id = $("form#edit_job_detail_form input[name='job_detail_id']");

            var arr = {};
            arr.job_title = job_title;
            arr.job_description = job_description;
            arr.date_from = date_from;
            arr.date_to = date_to;
            arr.job_detail_id = job_detail_id;

            $.each(arr, function (index, value) {
                value.val('');
                if(index != 'job_detail_id'){
                    value.css('border-color','#ccc');
                    value.next('p').html('');
                }

            });

            job_title.val($(this).parent('td').parent('tr').find('td.job_title_td').text());
            job_description.val($(this).parent('td').parent('tr').find('td.job_description_td').text());
            date_from.val($(this).parent('td').parent('tr').find('td.date_from_td').text());
            date_to.val($(this).parent('td').parent('tr').find('td.date_to_td').text());

            date_from.datepicker('setDate', $(this).parent('td').parent('tr').find('td.date_from_td').text());
            date_from.datepicker('update');

            date_to.datepicker('setDate', $(this).parent('td').parent('tr').find('td.date_to_td').text());
            date_to.datepicker('update');

            job_detail_id.val($(this).data('id'));
        });

        $(document).on('click','button.add_btn_for_job_detail',function () {
            $("form#add_job_detail_form input[name='job_title']").val('').css('border-color','#ccc').next('p').html('');
            $("form#add_job_detail_form textarea[name='job_description']").val('').css('border-color','#ccc').next('p').html('');
            $("form#add_job_detail_form input[name='date_from']").val('').css('border-color','#ccc').next('p').html('');
            $("form#add_job_detail_form input[name='date_to']").val('').css('border-color','#ccc').next('p').html('');
        });

        $(document).on('click','button.delete_btn_for_job_detail', function () {
            var job_detail_id = $(this).data('id');
            $("form#delete_job_detail_form input[name='job_detail_id']").val('');
            $("form#delete_job_detail_form input[name='job_detail_id']").val(job_detail_id);
        });


        $(document).on('click','#myEditModal button.close_btn_for_job_detail',function () {

            $("form#edit_job_detail_form input[name='job_title']").val('');
            $("form#edit_job_detail_form textarea[name='job_description']").val('');
            $("form#edit_job_detail_form input[name='date_from']").val('');
            $("form#edit_job_detail_form input[name='date_to']").val('');
            $("form#edit_job_detail_form input[name='job_detail_id']").val('');
        });

        $(document).on('click','#myModal button.close_btn_for_job_detail',function () {

            $("form#add_job_detail_form input[name='job_title']").val('').css('border-color','#ccc').next('p').html('');
            $("form#add_job_detail_form textarea[name='job_description']").val('').css('border-color','#ccc').next('p').html('');
            $("form#add_job_detail_form input[name='date_from']").val('').css('border-color','#ccc').next('p').html('');
            $("form#add_job_detail_form input[name='date_to']").val('').css('border-color','#ccc').next('p').html('');
            $('#myModal .failed_span');
        });

        $(document).on('click','#myDeleteModal button.close_btn_for_job_detail',function () {
            $("form#delete_job_detail_form input[name='job_detail_id']").val('');
        });
        // modal fields clearing and seting values --- start

        // job details js logic ----------------end

    </script>


@endsection