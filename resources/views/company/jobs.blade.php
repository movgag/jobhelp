@extends('company.layout.main_layout')

@section('content')
    @if ( !empty(session('message')) )
        <div class="t_a_center alert alert-@if( !empty(session('type')) ){{ session('type') }}@else{{'warning'}}@endif">
            <strong>@if( !empty(session('type')) ){{ ucfirst(session('type')) }}@else{{'Warning'}}@endif!</strong> {!! session('message') !!}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ $data['title'] or 'Jobs' }}</h1>
            <a href="{{ url('/company/add-job') }}" class="btn btn-success add_btn"><i class="fa fa-plus"></i> Add Job</a>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                {{--<div class="panel-heading">
                    DataTables Advanced Tables
                </div>--}}
                <!-- /.panel-heading -->
                <div class="panel-body">
                    @if($data['jobs'] && count($data['jobs']) > 0)
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Salary</th>
                            <th>Closing Date</th>
                            <th>Applicants</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($data['jobs'] as $k=>$job)
                                @php($applicants_count = $job->employees ? count($job->employees) : 0)

                                @php($applications = $job->application_letters->filter( function ($app){
                                     return !$app->viewed;
                                 }))
                                @php($new_count_for_current_job = isset($applications) ? $applications->count() : 0)

                                <tr class="odd gradeX no_decoration <?= $new_count_for_current_job ? 'green' : ''  ?> {{--even gradeC odd gradeA even gradeA --}}">
                                    <td>{{ $job->id }}</td>
                                    <td><a href="{{ route('single.job',['id'=>$job->id]) }}" target="_blank">{{ $job->title }}</a></td>
                                    <td>{{ number_format($job->salary) }}</td>
                                    <td >{{ \Carbon\Carbon::parse($job->closing_date)->format('Y-m-d') }}</td>
                                    <td class="center">Count: <a href="{{url('/company/applicants/'.$job->id)}}">
                                            <button type="button">{{ $applicants_count }}</button>
                                        </a> , New:
                                        <a href="{{url('/company/applicants/'.$job->id)}}">
                                            <button type="button">{{$new_count_for_current_job}}</button>
                                        </a>
                                    </td>
                                    <td class="center"><?= ($job->status == 1) ? 'Active' : 'Passive' ?></td>
                                    <td class="center">
                                        <a href="{{ url('/company/edit-job/'.$job->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- /.table-responsive -->
                    @else
                        <span>You don't have jobs yet...</span>
                    @endif
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
@endsection