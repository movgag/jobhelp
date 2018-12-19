@extends('admin.layout.main_layout')

@section('content')

    @if ( !empty(session('message')) )
        <div class="t_a_center alert alert-@if( !empty(session('type')) ){{ session('type') }}@else{{'warning'}}@endif">
            <strong>@if( !empty(session('type')) ){{ ucfirst(session('type')) }}@else{{'Warning'}}@endif!</strong> {!! session('message') !!}
        </div>
    @endif

    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ $data['title'] or 'Categories' }}</h1>
            <a href="#" class="btn btn-success add_btn"><i class="fa fa-plus"></i> Add Category</a>
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
                    @if($data['categories'] && count($data['categories']) > 0)
                        <table width="100%" class="table table-striped table-bordered table-hover" id="categories-table">
                            <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($data['categories'] as $c=>$cat)
                                <tr class="odd gradeX {{--even gradeC odd gradeA even gradeA --}}">
                                    <td>{{ $cat->id }}</td>
                                    <td>{{ $cat->name }}</td>
                                    <td class="center">
                                        <a title="Edit" href="#" class="btn btn-primary"><i class="fa fa-edit"></i></a>

                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    @else
                        <span>You don't have added categories yet...</span>
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
                <form id="delete_portfolio_form" method="post" action="#">
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
        $(document).ready(function () {
            $('#categories-table').DataTable({
                responsive: true,
            });
        });
    </script>


@endsection