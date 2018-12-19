@extends('employee.layout.main_layout')

@section('content')

    @if ( !empty(session('message')) )
        <div class="t_a_center alert alert-@if( !empty(session('type')) ){{ session('type') }}@else{{'warning'}}@endif">
            <strong>@if( !empty(session('type')) ){{ ucfirst(session('type')) }}@else{{'Warning'}}@endif!</strong> {!! session('message') !!}
        </div>
    @endif
    <div class="row">
        <div class="col-lg-12">
            <h1 class="page-header">{{ $data['title'] or 'Profile' }}</h1>
        </div>
        <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">

                <div class="panel-body">
                    <div class="row">
                        <form method="post" action="{{ url('/employee/profile') }}" id="employee_profile_form" role="form" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="col-lg-6">

                                <div class="form-group">
                                    <label>Name: </label>
                                    @php ($name = old('name')? old('name'): $data['employee']->name)
                                    <input name="name" class="form-control" placeholder="Name" value="{{$name}}">
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('name')) {{ $errors->first('name') }} @endif</p>
                                </div>
                                <div class="form-group">
                                    <label>Last name: </label>
                                    @php ($last_name = old('last_name')? old('last_name'): $data['employee']->last_name)
                                    <input name="last_name" class="form-control" placeholder="Last name" value="{{$last_name}}">
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('last_name')) {{ $errors->first('last_name') }} @endif</p>
                                </div>

                                <div class="form-group">
                                    <label>Date of birth: </label>
                                    @php ($date_of_birth = old('date_of_birth')? old('date_of_birth'): $data['employee']->date_of_birth)
                                    <input class="form-control" id="date" name="date_of_birth" placeholder="YYYY-MM-DD" type="text" value="{{$date_of_birth}}"/>
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('date_of_birth')) {{ $errors->first('date_of_birth') }} @endif</p>
                                </div>
                                <div class="form-group">
                                    <label for="disabledSelect">Email: </label>
                                    <input class="form-control" id="disabledInput" type="text" value="{{$data['employee']->email}}"
                                           placeholder="company@test.test" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Title: </label>
                                    @php ($title = old('title')? old('title'): $data['employee']->title)
                                    <input name="title" class="form-control" placeholder="Full Stack developer"
                                           value="{{$title}}">
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('title')) {{ $errors->first('title') }} @endif</p>
                                </div>
                                <div class="form-group">
                                    <label>Skills: </label>
                                    @php ($skill_ids = old('skills') ? old('skills') : ($data['employee_skills'] ? $data['employee_skills'] : array()) )
                                    <select name="skills[]" class="form-control employee_skills" multiple>
                                        @if($data['skills'])
                                            @foreach($data['skills'] as $skill)
                                                <option value="{{ $skill->id }}" <?= in_array($skill->id,$skill_ids) ? 'selected' : '' ?> >{{ $skill->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('skills')) {{ $errors->first('skills') }} @endif</p>
                                </div>
                                <div class="form-group">
                                    <label>Languages: </label>
                                    @php ($language_ids = old('languages') ? old('languages') : ($data['employee_languages'] ? $data['employee_languages'] : array()) )
                                    <select name="languages[]" class="form-control employee_languages" multiple>
                                        @if($data['languages'])
                                            @foreach($data['languages'] as $language)
                                                <option value="{{ $language->id }}" <?= in_array($language->id,$language_ids) ? 'selected' : '' ?> >{{ $language->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('languages')) {{ $errors->first('languages') }} @endif</p>
                                </div>
                                <div class="form-group">
                                    <label>Existing image: </label>
                                    @php($employee_image = $data['employee']->image ? $data['employee']->image : 'no_image.png')
                                    <img width="100px" height="100px" src="{{ asset('/images/candidates/'.$employee_image) }}" alt="">
                                    <input type="hidden" name="old_image" value="{{$data['employee']->image}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Address: </label>
                                    @php ($address = old('address')? old('address'): $data['employee']->address)
                                    <input name="address" class="form-control" placeholder="Tigran Mets street 1, ap. 1"
                                           value="{{$address}}">
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('address')) {{ $errors->first('address') }} @endif</p>
                                </div>
                                <div class="form-group">
                                    <label>Phone: </label>
                                    @php ($phone = old('phone')? old('phone'): $data['employee']->phone)
                                    <input name="phone" class="form-control"
                                           placeholder="Contact person phone" value="{{$phone}}">
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('phone')) {{ $errors->first('phone') }} @endif</p>
                                </div>
                                <div class="form-group">
                                    <label>Category: </label>
                                    @php ($category_id = old('category')? old('category'): $data['employee']->category_id)
                                    <select name="category" class="form-control">
                                        <option value="">Select Category</option>
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
                                    @php ($region_id = old('region')? old('region'): $data['employee']->region_id)
                                    <select name="region" class="form-control">
                                        <option value="">Select Region</option>
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
                                    @php ($type_id = old('type')? old('type'): $data['employee']->type_id)
                                    <select name="type" class="form-control">
                                        <option value="">Select Type</option>
                                        @if($data['types'])
                                            @foreach($data['types'] as $type)
                                                <option value="{{ $type->id }}" <?= $type_id == $type->id ? 'selected' : '' ?> >{{ $type->name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('type')) {{ $errors->first('type') }} @endif</p>
                                </div>

                                <div class="form-group">
                                    <label>Description (max 1200 symbols): </label>
                                    @php ($description = old('description')? old('description'): $data['employee']->description)
                                    <textarea name="description" placeholder="I am a responsible , trustworthy friend and reliable worker. For me, my work is worship. I am helpful to my friends as well as colleagues. In difficult times, I prefer to stay calm and resolve the problems." class="form-control"
                                              rows="5">{{$description}}</textarea>
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('description')) {{ $errors->first('description') }} @endif</p>
                                </div>
                                <label for="profile_image" class="drag_input_label">Choose image: </label>
                                <div class="form-group drag_form_group">
                                    <input type="file" name="image" class="drag_image" id="profile_image">
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