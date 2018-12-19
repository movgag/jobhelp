@extends('company.layout.main_layout')

@section('content')

    @if ( !empty(session('message')) )
        <div class="t_a_center alert alert-@if( !empty(session('type')) ){{ session('type') }}@else{{'warning'}}@endif">
            <strong>@if( !empty(session('type')) ){{ ucfirst(session('type')) }}@else{{'Warning'}}@endif!</strong> {!! session('message') !!}
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ $data['title'] or 'Edit Job' }}</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">

                <div class="panel-body">
                    <div class="row">
                        <form method="post" action="{{ url('/company/edit-job/'.$data['job']->id) }}" role="form">
                            {{ csrf_field() }}
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <label>Title: </label>
                                    @php ($title = old('title')? old('title'): ($data['job']->title ? $data['job']->title : '') )
                                    <input name="title" class="form-control" placeholder="Title"
                                           value="{{$title}}">
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('title')) {{ $errors->first('title') }} @endif</p>
                                </div>
                                <div class="form-group">
                                    <label>Place: </label>
                                    @php ($place = old('place')? old('place'): ($data['job']->place ? $data['job']->place : '') )
                                    <input name="place" class="form-control" placeholder="Place"
                                           value="{{$place}}">
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('place')) {{ $errors->first('place') }} @endif</p>
                                </div>
                                <div class="form-group">
                                    <label>Min Salary (AMD): </label>
                                    @php ($salary = old('salary')? old('salary'): ($data['job']->salary ? $data['job']->salary : '') )
                                    <input name="salary" class="form-control" placeholder="Salary"
                                           value="{{$salary}}">
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('salary')) {{ $errors->first('salary') }} @endif</p>
                                </div>

                                <div class="form-group">
                                    <label>Closing date: </label>
                                    @php ($closing_date = old('closing_date')? old('closing_date'): ($data['job']->closing_date ? \Carbon\Carbon::parse($data['job']->closing_date)->format('Y-m-d') : '') )
                                    <input class="form-control" id="date" name="closing_date" placeholder="YYY/MM/DD" type="text" value="{{$closing_date}}" />
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('closing_date')) {{ $errors->first('closing_date') }} @endif</p>
                                </div>
                                <div class="form-group">
                                    <label>Category: </label>
                                    @php ($category_id = old('category')? old('category'): ($data['job']->category_id ? $data['job']->category_id : 0) )
                                    <select name="category" class="form-control">
                                        @if($data['categories'])
                                            @foreach($data['categories'] as $category)
                                                <option value="{{ $category->id }}" <?= $category_id == $category->id ? 'selected' : '' ?> >{{ $category->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('category')) {{ $errors->first('category') }} @endif</p>
                                </div>
                                <div class="form-group">
                                    <label>Region: </label>
                                    @php ($region_id = old('region')? old('region'): ($data['job']->region_id ? $data['job']->region_id : 0) )
                                    <select name="region" class="form-control">
                                        @if($data['regions'])
                                            @foreach($data['regions'] as $region)
                                                <option value="{{ $region->id }}" <?= $region_id == $region->id ? 'selected' : '' ?> >{{ $region->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('region')) {{ $errors->first('region') }} @endif</p>
                                </div>
                                <div class="form-group">
                                    <label>Type: </label>
                                    @php ($type_id = old('type')? old('type'): ($data['job']->type_id ? $data['job']->type_id : 0) )
                                    <select name="type" class="form-control">
                                        @if($data['types'])
                                            @foreach($data['types'] as $type)
                                                <option value="{{ $type->id }}" <?= $type_id == $type->id ? 'selected' : '' ?> >{{ $type->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('type')) {{ $errors->first('type') }} @endif</p>
                                </div>



                                <div class="form-group">
                                    <label>Skills: </label>
                                    @php ($skill_ids = old('skills') ? old('skills') : ($data['job_skills'] ? $data['job_skills'] : array()) )
                                    <select name="skills[]" class="form-control job_skills" multiple>
                                        @if($data['skills'])
                                            @foreach($data['skills'] as $skill)
                                                <option value="{{ $skill->id }}" <?= in_array($skill->id,$skill_ids) ? 'selected' : '' ?> >{{ $skill->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('skills')) {{ $errors->first('skills') }} @endif</p>
                                </div>



                                <div class="form-group">
                                    <label>Description (max 2500 symbols): </label>
                                    @php ($description = old('description')? old('description'): ($data['job']->description ? $data['job']->description : '') )
                                    <textarea name="description" placeholder="Description" class="form-control"
                                              rows="8">{{$description}}</textarea>
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('description')) {{ $errors->first('description') }} @endif</p>
                                </div>
                                <div class="form-group">
                                    <label>Status: </label>
                                    @php ($status = old('status') != null ? old('status') : ($data['job']->status ? $data['job']->status : 0) )
                                    <select name="status" class="form-control">
                                        <option value="1" <?= ($status == 1) ? 'selected' : '' ?> >Active</option>
                                        <option value="0" <?= ($status == 0) ? 'selected' : '' ?> >Passive</option>
                                    </select>
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('status')) {{ $errors->first('status') }} @endif</p>
                                </div>

                            </div>

                            <div class="custom_buttons_div">
                                <button type="submit" class="btn btn-default">Update</button>
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

@endsection