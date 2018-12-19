@extends('employee.layout.main_layout')

@section('content')

    @if ( !empty(session('message')) )
        <div class="t_a_center alert alert-@if( !empty(session('type')) ){{ session('type') }}@else{{'warning'}}@endif">
            <strong>@if( !empty(session('type')) ){{ ucfirst(session('type')) }}@else{{'Warning'}}@endif!</strong> {!! session('message') !!}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ $data['title'] or 'Applied Jobs' }}</h1>
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
                    @if($data['applications'] && count($data['applications']) > 0)
                    <table width="100%" class="table table-striped table-bordered table-hover table-responsive" id="dataTables-example">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Salary</th>
                            <th>Applied Date</th>
                            <th>Closing Date</th>
                            <th>Job Status</th>
                            <th>Apply Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($data['applications'] as $k=>$app)
                                @php($route_url = $app->application_notification()->first() && isset($app->application_notification()->first()->id) > 0 ? url('/employee/remove-app-notification/'.$app->application_notification()->first()->id) : route('single.job',['id'=>$app->job_id]) )
                                <tr class="odd gradeX <?= $route_url == route('single.job',['id'=>$app->job_id]) ? '' : 'green' ?> {{--even gradeC odd gradeA even gradeA --}}">
                                    <td>{{ $app->job_id }}</td>
                                    <td>{{ $app->job()->first()->title }}</td>
                                    <td>{{ number_format($app->job()->first()->salary) }}</td>
                                    <td>{{ substr($app->created_at,0,-8) }}</td>
                                    <td >{{ substr($app->job()->first()->closing_date,0,-8) }}</td>
                                    <td class="center"><?= ($app->job()->first()->status == 1) ? 'Active' : 'Passive' ?></td>
                                    <td class="center">{{ucfirst($app->status)}}</td>
                                    <td class="center">
                                        <a title="View more" href="{{$route_url}}" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                        <a title="Edit application" href="{{ url('/employee/edit-application/'.$app->id) }}" class="btn btn-success"><i class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                        <span>You don't have applied jobs yet...</span>
                    <!-- /.table-responsive -->
                    @endif
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>

@endsection