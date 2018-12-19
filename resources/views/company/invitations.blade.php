@extends('company.layout.main_layout')

@section('content')
    @if ( !empty(session('message')) )
        <div class="t_a_center alert alert-@if( !empty(session('type')) ){{ session('type') }}@else{{'warning'}}@endif">
            <strong>@if( !empty(session('type')) ){{ ucfirst(session('type')) }}@else{{'Warning'}}@endif!</strong> {!! session('message') !!}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ $data['title'] or 'Invitations' }}</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
            {{--<div class="panel-heading">
                DataTables Advanced Tables
            </div>--}}
            <!-- /.panel-heading -->
                <div class="panel-body">
                    @if($data['invitations'] && count($data['invitations']) > 0)
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Employee</th>
                                <th>Job</th>
                                <th>Letter</th>
                                <th>Date</th>
                                <th>Canceled</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data['invitations'] as $k=>$invitation)
                                @php($invite_counts = 0)
                                <tr class="odd gradeX {{--even gradeC odd gradeA even gradeA --}}">
                                    <td>{{ $invitation->id }}</td>
                                    <td><a href="{{ route('single.candidate',['id'=>$invitation->employee()->first()->id]) }}">{{ $invitation->employee()->first()->name.' '.$invitation->employee()->first()->last_name }}</a></td>
                                    <td><a href="{{ route('single.job',['id'=>$invitation->job()->first()->id]) }}">{{ $invitation->job()->first()->title }}</a></td>
                                    <td class="center"><?= $invitation->invitation_letter ? ( strlen($invitation->invitation_letter) < 20 ? $invitation->invitation_letter : substr($invitation->invitation_letter,0,20).'...' ) : 'not provided' ?></td>
                                    <td >{{ \Carbon\Carbon::parse($invitation->created_at)->format('Y-m-d') }}</td>
                                    <td class="center"><?= ($invitation->canceled == 1) ? 'Yes' : 'No' ?></td>
                                    <td class="center">
                                        <a href="{{ url('/company/edit-invitation/'.$invitation->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        <!-- /.table-responsive -->
                    @else
                        <span>You don't have invitations yet... <a title="Candidates" href="{{ route('candidates') }}">Click here to start</a> </span>
                    @endif
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
@endsection