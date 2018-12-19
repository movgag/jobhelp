@extends('company.layout.main_layout')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ $data['title'] or 'Applicants' }} for job: "<a href="#">{{$data['job_title']}}</a>"</h1>
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
                    @if($data['employees'] && count($data['employees']) > 0)
                    <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                        <thead>
                        <tr>
                            <th>ID</th>
                            <th>Full Name</th>
                            <th>Title</th>
                            <th>Email</th>
                            <th>Application</th>
                            <th>Employee</th>
                            <th>Status</th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($data['employees'] as $k=>$employee)

                                <tr class="odd gradeX {{--even gradeC odd gradeA even gradeA --}} <?= array_key_exists($employee->id,$data['employee_id_and_viewed']) ? 'green' : '' ?> ">
                                    <td>{{ $employee->id }}</td>
                                    <td>{{$employee->name.' '.$employee->last_name}}</td>
                                    <td>{{ $employee->title }}</td>
                                    <td>{{ $employee->email }}</td>
                                    <td>
                                        <a href="{{ url('/company/application-letter/'.$employee->id.'/'.$data['job_id']) }}" class="btn btn-info" >View</a>
                                    </td>
                                    <td class="center">
                                        <a href="{{ route('single.candidate',['id'=>$employee->id]) }}" target="_blank" class="btn btn-info" >View</a>
                                    </td>
                                    <td>
                                        <?= array_key_exists($employee->id,$data['employee_id_and_status']) ? ucfirst($data['employee_id_and_status'][$employee->id]) : ''  ?>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    <!-- /.table-responsive -->
                    @else
                        <span>There aren't applicants for this job...</span>
                    @endif

                    <button type="button" onclick="history.go(-1)" class="btn btn-default">Back</button>
                </div>
                <!-- /.panel-body -->
            </div>
            <!-- /.panel -->
        </div>
        <!-- /.col-lg-12 -->
    </div>
@endsection