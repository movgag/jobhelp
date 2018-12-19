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
            <a href="{{ url('/employee/add-portfolio') }}" class="btn btn-success add_btn"><i class="fa fa-plus"></i> Add Portfolio</a>
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
                    @if($data['portfolios'] && count($data['portfolios']) > 0)
                        <table width="100%" class="table table-striped table-bordered table-hover" id="dataTables-example">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data['portfolios'] as $p=>$portfolio)
                                <tr class="odd gradeX {{--even gradeC odd gradeA even gradeA --}}">
                                    <td>{{ $portfolio->id }}</td>
                                    <td>{{ $portfolio->title }}</td>
                                    <td>{{ substr($portfolio->description,0,70).' ...' }}</td>
                                    <td class="center">
                                        <a title="Edit" href="{{ url('/employee/edit-portfolio/'.$portfolio->id) }}" class="btn btn-primary"><i class="fa fa-edit"></i></a>
                                        <a title="Delete" data-id="{{$portfolio->id}}" data-toggle="modal" data-target="#myModal" class="btn btn-danger delete_portfolio_btn"><i class="fa fa-close"></i></a>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <span>You don't have portfolios yet...</span>
                        <!-- /.table-responsive -->
                    @endif
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
                <form id="delete_portfolio_form" method="post" action="{{ url('/employee/delete-portfolio') }}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                       You are going to delete Your portfolio!
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="portfolio_id" value="">
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
        $("a.delete_portfolio_btn").click(function () {
            var val = $(this).data('id');
            $("#delete_portfolio_form input[name='portfolio_id']").val('');
            $("#delete_portfolio_form input[name='portfolio_id']").val(val);
        });
    </script>

@endsection