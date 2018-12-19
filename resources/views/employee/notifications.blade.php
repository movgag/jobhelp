@extends('employee.layout.main_layout')

@section('content')
    @if ( !empty(session('message')) )
        <div class="t_a_center alert alert-@if( !empty(session('type')) ){{ session('type') }}@else{{'warning'}}@endif">
            <strong>@if( !empty(session('type')) ){{ ucfirst(session('type')) }}@else{{'Warning'}}@endif!</strong> {!! session('message') !!}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ $data['title'] or 'Notifications' }} - <span style="color:#5CB85C;">{{$data['results_count'] or 0}}</span></h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-body">
                    @if($data['results'] && count($data['results']) > 0)
                        <table width="100%" class="table table-striped table-bordered table-hover" id="notifications_table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Company</th>
                                <th>Job</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data['results'] as $k=>$res)
                                @php($ntf_url = '')
                                @php($ntf_text = '')
                                @if(isset($res->application_id))
                                    @php($ntf_url = url('/employee/remove-app-notification/'.$res->id))
                                    @php($ntf_text = 'Your aplication is '.$res->status.'!' )
                                @elseif(isset($res->invitation_id) && isset($res->canceled))
                                    @php($ntf_url = url('/employee/remove-inv-notification/'.$res->id))
                                    @if($res->canceled)
                                        @php($ntf_text = 'Your invitation is canceled!')
                                    @elseif($res->created_at == $res->updated_at)
                                        @php($ntf_text = 'You have new invitation!' )
                                    @else
                                        @php($ntf_text = 'Your invitation is activated!' )
                                    @endif
                                @endif

                                <tr class="odd gradeX {{--even gradeC odd gradeA even gradeA --}}">
                                    <td>{{ $res->id }}</td>
                                    <td>{{ $res->company()->first()->company_name }}</td>
                                    <td>{{ $res->job()->first()->title }}</td>
                                    <td class="center">{{$ntf_text}}</td>
                                    <td >{{ \Carbon\Carbon::parse($res->updated_at)->format('Y-m-d H:i:s') }}</td>
                                    <td class="center">
                                        <a href="{{$ntf_url}}" title="View More" class="btn btn-info"><i class="fa fa-eye"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <!-- /.table-responsive -->
                    @else
                        <span>You don't have notifications yet...</span>
                    @endif
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
@endsection