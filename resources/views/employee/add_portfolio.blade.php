@extends('employee.layout.main_layout')

@section('content')

    @if ( !empty(session('message')) )
        <div class="t_a_center alert alert-@if( !empty(session('type')) ){{ session('type') }}@else{{'warning'}}@endif">
            <strong>@if( !empty(session('type')) ){{ ucfirst(session('type')) }}@else{{'Warning'}}@endif!</strong> {!! session('message') !!}
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ $data['title'] or 'Add Portfolio' }}</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">

                <div class="panel-body">
                    <div class="row">
                        <form method="post" action="{{ url('/employee/add-portfolio') }}" role="form" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Title: </label>
                                    @php ($title = old('title')? old('title'): '')
                                    <input name="title" class="form-control" placeholder="Website for business"
                                           value="{{$title}}">
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('title')) {{ $errors->first('title') }} @endif</p>
                                </div>
                                <div class="form-group">
                                    <label>Description (max 1200 symbols): </label>
                                    @php ($description = old('description')? old('description'): '')
                                    <textarea name="description" placeholder="The website focuses on website design, lead generation, and digital marketing for IT and high-tech companies. We build websites, mobile apps, and manage marketing to help IT enterprises & communication service providers with demand generation and best practice websites." class="form-control"
                                              rows="8">{{$description}}</textarea>
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('description')) {{ $errors->first('description') }} @endif</p>
                                </div>
                                <label for="portfolio_image" class="drag_input_label">Choose image: </label>
                                <div class="form-group drag_form_group">
                                    <input type="file" name="image" class="drag_image" id="portfolio_image">
                                    <p class="drag">Drag your files here or click in this area.</p>
                                </div>
                                <p class="help-block error">@if(count($errors)>0 && $errors->has('image')) {{ $errors->first('image') }} @endif</p>
                            </div>

                            <div class="custom_buttons_div">
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
    <script>
        $(document).ready(function(){
            $('form input[type="file"]').change(function () {
                $('form p.drag').text(this.files.length + " file selected");
            });
        });
    </script>
@endsection