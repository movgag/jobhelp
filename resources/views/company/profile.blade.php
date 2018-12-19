@extends('company.layout.main_layout')

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
                        <form method="post" action="{{ url('/company/profile') }}" role="form" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Company name: </label>
                                    @php ($company_name = old('company_name')? old('company_name'): $data['company']->company_name)
                                    <input name="company_name" class="form-control" placeholder="Company name" value="{{$company_name}}">
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('company_name')) {{ $errors->first('company_name') }} @endif</p>
                                </div>
                                <div class="form-group">
                                    <label for="disabledSelect">Email: </label>
                                    <input class="form-control" id="disabledInput" type="text" value="{{$data['company']->email}}"
                                           placeholder="company@test.test" disabled>
                                </div>
                                <div class="form-group">
                                    <label>Contact person name: </label>
                                    @php ($contact_person_name = old('contact_person_name')? old('contact_person_name'): $data['company']->contact_person_name)
                                    <input name="contact_person_name" class="form-control"
                                           placeholder="Contact person name" value="{{$contact_person_name}}">
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('contact_person_name')) {{ $errors->first('contact_person_name') }} @endif</p>
                                </div>
                                <div class="form-group">
                                    <label>Contact person phone: </label>
                                    @php ($contact_person_phone = old('contact_person_phone')? old('contact_person_phone'): $data['company']->contact_person_phone)
                                    <input name="contact_person_phone" class="form-control"
                                           placeholder="Contact person phone" value="{{$contact_person_phone}}">
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('contact_person_phone')) {{ $errors->first('contact_person_phone') }} @endif</p>
                                </div>
                                <div class="form-group">
                                    <label>Tax number: </label>
                                    @php ($tax_number = old('tax_number')? old('tax_number'): $data['company']->tax_number)
                                    <input name="tax_number" class="form-control" placeholder="Tax number"
                                           value="{{$tax_number}}">
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('tax_number')) {{ $errors->first('tax_number') }} @endif</p>
                                </div>
                                <div class="form-group">
                                    <label>Title: </label>
                                    @php ($title = old('title')? old('title'): $data['company']->title)
                                    <input name="title" class="form-control" placeholder="Web development company"
                                           value="{{$title}}">
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('title')) {{ $errors->first('title') }} @endif</p>
                                </div>
                                <div class="form-group">
                                    <label>Existing logo: </label>
                                    @php($company_logo = $data['company']->image ? $data['company']->image : 'no_logo.png')
                                    <img width="100px" height="100px" src="{{ asset('/images/company-logo/'.$company_logo) }}" alt="">
                                    <input type="hidden" name="old_image" value="{{$data['company']->image}}">
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Address: </label>
                                    @php ($address = old('address')? old('address'): $data['company']->address)
                                    <input name="address" class="form-control" placeholder="Tigran Mets street 1"
                                           value="{{$address}}">
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('address')) {{ $errors->first('address') }} @endif</p>
                                </div>
                                <div class="form-group">
                                    <label>Room: </label>
                                    @php ($room = old('room')? old('room'): $data['company']->room)
                                    <input name="room" class="form-control" placeholder="No: 207"
                                           value="{{$room}}">
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('room')) {{ $errors->first('room') }} @endif</p>
                                </div>
                                <div class="form-group">
                                    <label>Website: </label>
                                    @php ($web_site = old('web_site')? old('web_site'): $data['company']->web_site)
                                    <input name="web_site" class="form-control" placeholder="http://mycompany.com"
                                           value="{{$web_site}}">
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('web_site')) {{ $errors->first('web_site') }} @endif</p>
                                </div>
                                <div class="form-group">
                                    <label>Category: </label>
                                    @php ($category_id = old('category')? old('category'): $data['company']->category_id)
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
                                    @php ($region_id = old('region')? old('region'): $data['company']->region_id)
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
                                    <label>Description (max 1200 symbols): </label>
                                    @php ($description = old('description')? old('description'): $data['company']->description)
                                    <textarea name="description" placeholder="Our company is a new company that will provide high quality technical and environmental engineering services to it's clients. Terra Engineering is scheduled to begin operations on July 16, 2005. Terra Engineering will be a partnership, owned and operated by Norm Johnson and Rupert Smith." class="form-control"
                                              rows="5">{{$description}}</textarea>
                                    <p class="help-block error">@if(count($errors)>0 && $errors->has('description')) {{ $errors->first('description') }} @endif</p>
                                </div>
                                <label for="profile_image" class="drag_input_label">Choose logo: </label>
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