<ul class="nav nav-tabs" id="myTabs">
    <li class="nav-item">
        <a class="nav-link active" id="tab1" data-toggle="tab" href="#content1">General Information</a>
    </li>

    <li class="nav-item">
        <a class="nav-link @if(!isset($users)) disabled @endif" id="tab2" data-toggle="tab" href="#content2">Addresses</a>
    </li>
</ul>

{!! Form::hidden('redirects_to', URL::previous()) !!}
<div class="tab-content mt-2">
    <div class="row tab-pane fade show active" id="content1">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card mb-4">
                <div class="card-body">
                    
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label class="control-label" for="name">Name :<span class="text-red">*</span></label>
                                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter Name', 'id' => 'name']) !!}
                                @if ($errors->has('name'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                                <label class="control-label" for="email">Email :<span class="text-red">*</span></label>
                                {!! Form::text('email', null, ['class' => 'form-control', 'placeholder' => 'Enter Email', 'id' => 'email']) !!}
                                @if ($errors->has('email'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('phone') ? ' has-error' : '' }}">
                                <label class="control-label" for="phone">Phone :<span class="text-red">*</span></label>
                                {!! Form::text('phone', null, ['class' => 'form-control', 'placeholder' => 'Enter Phone', 'id' => 'phone']) !!}
                                @if ($errors->has('phone'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('phone') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label class="control-label" for="password">Password :@if (empty($customers))<span class="text-red">*</span>@endif</label>
                                {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Enter Password', 'id' => 'password']) !!}
                                @if ($errors->has('password'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                                <label class="control-label" for="password">Confirm Password :@if (empty($customers))<span class="text-red">*</span>@endif</label>
                                {!! Form::password('password_confirmation', ['class' => 'form-control', 'placeholder' => 'Confirm password', 'id' => 'password-confirm']) !!}
                                @if ($errors->has('password_confirmation'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('password_confirmation') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
                                <label class="col-md-12 control-label" for="image">Image<span class="text-red">*</span></label>
                                <div class="col-md-12">
                                    <div class="fileError">
                                        {!! Form::file('image', ['class' => '', 'id'=> 'image','accept'=>'image/*', 'onChange'=>'AjaxUploadImage(this)']) !!}
                                    </div>
                                    <img id="DisplayImage" @if(!empty($users['image'])) src="{{ url($users['image'])}}" style="margin-top: 1%; padding-bottom:5px; display: block;" @else src="" style="padding-bottom:5px; display: none;" @endif width="150">
                                    @if ($errors->has('image'))
                                        <span class="text-danger">
                                        <strong>{{ $errors->first('image') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                <label class="col-md-12 control-label" for="status">Status :<span class="text-red">*</span></label>
                                <div class="col-md-12">
                                    @foreach (\App\Models\User::$status as $key => $value)
                                            @php $checked = !isset($users) && $key == 'active'?'checked':''; @endphp
                                        <label>
                                            {!! Form::radio('status', $key, null, ['class' => 'flat-red',$checked]) !!} <span style="margin-right: 10px">{{ $value }}</span>
                                        </label>
                                    @endforeach
                                    <br class="statusError">
                                    @if ($errors->has('status'))
                                        <span class="text-danger" id="statusError">
                                            <strong>{{ $errors->first('status') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </div>

        @php
        $addressesCounter = 1;
        @endphp
        <div class="row tab-pane fade" id="content2">
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12 mb-2">
                            <p class="h5">Add Addresses
                                <button type="button" class="btn btn-info" id="addressBtn" style="float: right;"><i class="fa fa-plus"></i> Add New</button>
                                </p>
                            </div>
                        </div>
                        @if(count($user_addresses)>0)
                            @foreach ($user_addresses as $key => $address) 
                                <div class="card user-addresses" id="address_{{ $address->id }}">
                                    <div class="row p-2">
                                        <div class="col-md-12">
                                            <div class="row">
                                                <div class="col-md-11">
                                                    <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                                        <label class="control-label" for="title">Title :<span class="text-red">*</span></label>
                                                        {!! Form::text("addresses[old][$address->id][title]", $address->title, ['class' => 'form-control', 'placeholder' => 'Enter Title', 'id' => 'title']) !!}
                                                        @if ($errors->has('title'))
                                                            <span class="text-danger">
                                                                <strong>{{ $errors->first('title') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="col-md-1">
                                                    <button type="button" class="btn btn-danger deleteExp" onClick="removeAddressRow({{$address->id}}, 0)" style="margin-top: 30px;"><i class="fa fa-trash"></i></button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                                <label class="control-label" for="first_name">First Name :<span class="text-red">*</span></label>
                                                {!! Form::text("addresses[old][$address->id][first_name]", $address->first_name, ['class' => 'form-control', 'placeholder' => 'Enter First Name', 'id' => 'first_name']) !!}
                                                @if ($errors->has('first_name'))
                                                    <span class="text-danger">
                                                        <strong>{{ $errors->first('first_name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                                <label class="control-label" for="last_name">Last Name :<span class="text-red">*</span></label>
                                                {!! Form::text("addresses[old][$address->id][last_name]", $address->last_name, ['class' => 'form-control', 'placeholder' => 'Enter Last Name', 'id' => 'last_name']) !!}
                                                @if ($errors->has('last_name'))
                                                    <span class="text-danger">
                                                        <strong>{{ $errors->first('last_name') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group{{ $errors->has('company') ? ' has-error' : '' }}">
                                                <label class="control-label" for="company">Company :</label>
                                                {!! Form::text("addresses[old][$address->id][company]", $address->company, ['class' => 'form-control', 'placeholder' => 'Enter Company', 'id' => 'company']) !!}
                                                @if ($errors->has('company'))
                                                    <span class="text-danger">
                                                        <strong>{{ $errors->first('company') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group{{ $errors->has('mobile_phone') ? ' has-error' : '' }}">
                                                <label class="control-label" for="mobile_phone">Mobile No :<span class="text-red">*</span></label>
                                                {!! Form::text("addresses[old][$address->id][mobile_phone]", $address->mobile_phone, ['class' => 'form-control', 'placeholder' => 'Enter Mobile No', 'id' => 'mobile_phone']) !!}
                                                @if ($errors->has('mobile_phone'))
                                                    <span class="text-danger">
                                                        <strong>{{ $errors->first('mobile_phone') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group{{ $errors->has('address_line1') ? ' has-error' : '' }}">
                                                <label class="control-label" for="address_line1">Address :<span class="text-red">*</span></label>
                                                {!! Form::textarea("addresses[old][$address->id][address_line1]", $address->address_line1, ['class' => 'form-control', 'placeholder' => 'Enter Address', 'id' => 'address_line1', 'rows' => '2']) !!}
                                                @if ($errors->has('address_line1'))
                                                    <span class="text-danger">
                                                        <strong>{{ $errors->first('address_line1') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group{{ $errors->has('address_line2') ? ' has-error' : '' }}">
                                                <label class="control-label" for="address_line2">Address (Line 2) :</label>
                                                {!! Form::textarea("addresses[old][$address->id][address_line2]", $address->address_line2, ['class' => 'form-control', 'placeholder' => 'Enter Address Line 2', 'id' => 'address_line2', 'rows' => '2']) !!}
                                                @if ($errors->has('address_line2'))
                                                    <span class="text-danger">
                                                        <strong>{{ $errors->first('address_line2') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group{{ $errors->has('pincode') ? ' has-error' : '' }}">
                                                <label class="control-label" for="pincode">Pincode :<span class="text-red">*</span></label>
                                                {!! Form::text("addresses[old][$address->id][pincode]", $address->pincode, ['class' => 'form-control', 'placeholder' => 'Enter Pincode', 'id' => 'pincode']) !!}
                                                @if ($errors->has('pincode'))
                                                    <span class="text-danger">
                                                        <strong>{{ $errors->first('pincode') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                                <label class="control-label" for="city">City :<span class="text-red">*</span></label>
                                                {!! Form::text("addresses[old][$address->id][city]", $address->city, ['class' => 'form-control', 'placeholder' => 'Enter City', 'id' => 'city']) !!}
                                                @if ($errors->has('city'))
                                                    <span class="text-danger">
                                                        <strong>{{ $errors->first('city') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                                                <label class="control-label" for="state">State :<span class="text-red">*</span></label>
                                                {!! Form::text("addresses[old][$address->id][state]", $address->state, ['class' => 'form-control', 'placeholder' => 'Enter State', 'id' => 'state']) !!}
                                                @if ($errors->has('state'))
                                                    <span class="text-danger">
                                                        <strong>{{ $errors->first('state') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                                                <label class="control-label" for="country">Country :<span class="text-red">*</span></label>
                                                {!! Form::text("addresses[old][$address->id][country]", 'United Kingdom', ['class' => 'form-control', 'placeholder' => 'Enter Country', 'id' => 'country', 'readonly']) !!}
                                                @if ($errors->has('country'))
                                                    <span class="text-danger">
                                                        <strong>{{ $errors->first('country') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                        <div class="col-md-12">
                                            <div class="form-group{{ $errors->has('additional_information') ? ' has-error' : '' }}">
                                                <label class="control-label" for="additional_information">Additional information :</label>
                                                {!! Form::textarea("addresses[old][$address->id][additional_information]", $address->additional_information, ['class' => 'form-control', 'placeholder' => 'Enter Additional information', 'id' => 'additional_information', 'rows' => '2']) !!}
                                                @if ($errors->has('additional_information'))
                                                    <span class="text-danger">
                                                        <strong>{{ $errors->first('additional_information') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                @php
                                $addressesCounter = $address->id;
                                @endphp
                            @endforeach
                        @else
                            <div class="card user-addresses" id="address_1">
                                <div class="row p-2">
                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('title') ? ' has-error' : '' }}">
                                            <label class="control-label" for="title">Title :<span class="text-red">*</span></label>
                                            {!! Form::text('addresses[new][1][title]', null, ['class' => 'form-control', 'placeholder' => 'Enter Title', 'id' => 'title']) !!}
                                            @if ($errors->has('title'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('title') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group{{ $errors->has('first_name') ? ' has-error' : '' }}">
                                            <label class="control-label" for="first_name">First Name :<span class="text-red">*</span></label>
                                            {!! Form::text('addresses[new][1][first_name]', null, ['class' => 'form-control', 'placeholder' => 'Enter First Name', 'id' => 'first_name']) !!}
                                            @if ($errors->has('first_name'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('first_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group{{ $errors->has('last_name') ? ' has-error' : '' }}">
                                            <label class="control-label" for="last_name">Last Name :<span class="text-red">*</span></label>
                                            {!! Form::text('addresses[new][1][last_name]', null, ['class' => 'form-control', 'placeholder' => 'Enter Last Name', 'id' => 'last_name']) !!}
                                            @if ($errors->has('last_name'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('last_name') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group{{ $errors->has('company') ? ' has-error' : '' }}">
                                            <label class="control-label" for="company">Company :</label>
                                            {!! Form::text('addresses[new][1][company]', null, ['class' => 'form-control', 'placeholder' => 'Enter Company', 'id' => 'company']) !!}
                                            @if ($errors->has('company'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('company') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group{{ $errors->has('mobile_phone') ? ' has-error' : '' }}">
                                            <label class="control-label" for="mobile_phone">Mobile No :<span class="text-red">*</span></label>
                                            {!! Form::text('addresses[new][1][mobile_phone]', null, ['class' => 'form-control', 'placeholder' => 'Enter Mobile No', 'id' => 'mobile_phone']) !!}
                                            @if ($errors->has('mobile_phone'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('mobile_phone') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('address_line1') ? ' has-error' : '' }}">
                                            <label class="control-label" for="address_line1">Address :<span class="text-red">*</span></label>
                                            {!! Form::textarea('addresses[new][1][address_line1]', null, ['class' => 'form-control', 'placeholder' => 'Enter Address', 'id' => 'address_line1', 'rows' => '2']) !!}
                                            @if ($errors->has('address_line1'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('address_line1') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('address_line2') ? ' has-error' : '' }}">
                                            <label class="control-label" for="address_line2">Address (Line 2) :</label>
                                            {!! Form::textarea('addresses[new][1][address_line2]', null, ['class' => 'form-control', 'placeholder' => 'Enter Address Line 2', 'id' => 'address_line2', 'rows' => '2']) !!}
                                            @if ($errors->has('address_line2'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('address_line2') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group{{ $errors->has('pincode') ? ' has-error' : '' }}">
                                            <label class="control-label" for="pincode">Pincode :<span class="text-red">*</span></label>
                                            {!! Form::text('addresses[new][1][pincode]', null, ['class' => 'form-control', 'placeholder' => 'Enter Pincode', 'id' => 'pincode']) !!}
                                            @if ($errors->has('pincode'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('pincode') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group{{ $errors->has('city') ? ' has-error' : '' }}">
                                            <label class="control-label" for="city">City :<span class="text-red">*</span></label>
                                            {!! Form::text('addresses[new][1][city]', null, ['class' => 'form-control', 'placeholder' => 'Enter City', 'id' => 'city']) !!}
                                            @if ($errors->has('city'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('city') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group{{ $errors->has('state') ? ' has-error' : '' }}">
                                            <label class="control-label" for="state">State :<span class="text-red">*</span></label>
                                            {!! Form::text('addresses[new][1][state]', null, ['class' => 'form-control', 'placeholder' => 'Enter State', 'id' => 'state']) !!}
                                            @if ($errors->has('state'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('state') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group{{ $errors->has('country') ? ' has-error' : '' }}">
                                            <label class="control-label" for="country">Country :<span class="text-red">*</span></label>
                                            {!! Form::text('addresses[new][1][country]', 'United Kingdom', ['class' => 'form-control', 'placeholder' => 'Enter Country', 'id' => 'country', 'readonly']) !!}
                                            @if ($errors->has('country'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('country') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('additional_information') ? ' has-error' : '' }}">
                                            <label class="control-label" for="additional_information">Additional information :</label>
                                            {!! Form::textarea('addresses[new][1][additional_information]', null, ['class' => 'form-control', 'placeholder' => 'Enter Additional information', 'id' => 'additional_information', 'rows' => '2']) !!}
                                            @if ($errors->has('additional_information'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('additional_information') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                        <div id="extraAddress"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@section('jquery')
<script type="text/javascript">
var addressCounter = {{$addressesCounter}};

$('#addressBtn').on('click', function(){
    addressCounter = addressCounter + 1;

    var exAddressContent = '<div class="card user-addresses" id="address_'+addressCounter+'">'+
            '<div class="row p-2">'+
                
                '<div class="col-md-12">'+
                    '<div class="row">'+
                        '<div class="col-md-11">'+
                            '<div class="form-group">'+
                                '<label class="control-label" for="title">Title :<span class="text-red">*</span></label>'+
                                '<input type="text" name="addresses[new]['+addressCounter+'][title]" class="form-control" required- placeholder="Enter Title">'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-1">'+
                            '<button type="button" class="btn btn-danger deleteExp" onClick="removeAddressRow('+addressCounter+', 0)" style="margin-top: 30px;"><i class="fa fa-trash"></i></button>'+
                        '</div>'+
                    '</div>'+
                '</div>'+

                '<div class="col-md-3">'+
                    '<div class="form-group">'+
                        '<label class="control-label" for="first_name">First Name :<span class="text-red">*</span></label>'+
                        '<input type="text" name="addresses[new]['+addressCounter+'][first_name]" class="form-control" required- placeholder="Enter First Name">'+
                    '</div>'+
                '</div>'+

                '<div class="col-md-3">'+
                    '<div class="form-group">'+
                        '<label class="control-label" for="last_name">Last Name :<span class="text-red">*</span></label>'+
                        '<input type="text" name="addresses[new]['+addressCounter+'][last_name]" class="form-control" required- placeholder="Enter Last Name">'+
                    '</div>'+
                '</div>'+

                '<div class="col-md-3">'+
                    '<div class="form-group">'+
                        '<label class="control-label" for="company">Company :<span class="text-red">*</span></label>'+
                        '<input type="text" name="addresses[new]['+addressCounter+'][company]" class="form-control" required- placeholder="Enter Company">'+
                    '</div>'+
                '</div>'+
                    
                '<div class="col-md-3">'+
                    '<div class="form-group">'+
                        '<label class="control-label" for="mobile_phone">Mobile No :<span class="text-red">*</span></label>'+
                        '<input type="text" name="addresses[new]['+addressCounter+'][mobile_phone]" class="form-control" required- placeholder="Enter Mobile No">'+
                    '</div>'+
                '</div>'+

                '<div class="col-md-6">'+
                    '<div class="form-group">'+
                        '<label class="control-label" for="address_line1">Address :<span class="text-red">*</span></label>'+
                        '<textarea name="addresses[new]['+addressCounter+'][address_line1]" class="form-control" required- placeholder="Enter Address" rows="2"></textarea>'+
                    '</div>'+
                '</div>'+
                       
                '<div class="col-md-6">'+
                    '<div class="form-group">'+
                        '<label class="control-label" for="address_line2">Address (Line 2) :</label>'+
                        '<textarea name="addresses[new]['+addressCounter+'][address_line2]" class="form-control" required- placeholder="Enter Address Line 2" rows="2"></textarea>'+
                    '</div>'+
                '</div>'+

                '<div class="col-md-3">'+
                    '<div class="form-group">'+
                        '<label class="control-label" for="pincode">Pincode :<span class="text-red">*</span></label>'+
                        '<input type="text" name="addresses[new]['+addressCounter+'][pincode]" class="form-control" required- placeholder="Enter Pincode">'+
                    '</div>'+
                '</div>'+

                '<div class="col-md-3">'+
                    '<div class="form-group">'+
                        '<label class="control-label" for="city">City :<span class="text-red">*</span></label>'+
                        '<input type="text" name="addresses[new]['+addressCounter+'][city]" class="form-control" required- placeholder="Enter City">'+
                    '</div>'+
                '</div>'+

                '<div class="col-md-3">'+
                    '<div class="form-group">'+
                        '<label class="control-label" for="state">State :<span class="text-red">*</span></label>'+
                        '<input type="text" name="addresses[new]['+addressCounter+'][state]" class="form-control" required- placeholder="Enter State">'+
                    '</div>'+
                '</div>'+

                '<div class="col-md-3">'+
                    '<div class="form-group">'+
                        '<label class="control-label" for="country">Country :<span class="text-red">*</span></label>'+
                        '<input type="text" name="addresses[new]['+addressCounter+'][country]" class="form-control" required- placeholder="Enter Country" value="United Kingdom" readonly>'+
                    '</div>'+
                '</div>'+

                '<div class="col-md-12">'+
                    '<div class="form-group">'+
                        '<label class="control-label" for="additional_information">Additional information :</label>'+
                        '<textarea name="addresses[new]['+addressCounter+'][additional_information]" class="form-control" required- placeholder="Enter Additional information" rows="2"></textarea>'+
                    '</div>'+
                '</div>'+
            '</div>'+
        '</div>';
    $('#extraAddress').append(exAddressContent);
});


function removeAddressRow(divId, type){
    const removeRowAlert = createAddressAlert("Are you sure?", "Do want to delete this row", "warning");
    swal(removeRowAlert, function(isConfirm) {
        if (isConfirm) {
            var flag =  deleteRow(divId, type);
            if(flag){
                swal.close();
            }
        } else{
             swal("Cancelled", "Your data safe!", "error");
        }
    });
}

//remove the row
function deleteRow(divId, type){
    $('#address_'+divId).remove();
    if ($(".user-addresses").length == 0) {
        $('#addressBtn').click();
    }
    return 1;  
}

function createAddressAlert(title, text, type) {
    return {
        title: title,
        text: text,
        type: type,
        showCancelButton: true,
        confirmButtonColor: '#DD6B55',
        confirmButtonText: 'Yes, Delete',
        cancelButtonText: "No, cancel",
        closeOnConfirm: false,
        closeOnCancel: false
    };
}

var i = 2;
$(".imgAdd").click(function(){

    var html = '<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12" id="imgBox_'+i+'">'+
                    '<div class="boxImage imgUp">'+
                        '<div class="loader-contetn loader'+i+'"><div class="loader-01"></div></div>';
                        '<div class="imagePreview">'+
                            '<div class="text-right" style="position: absolute;">'+
                                '<button class="btn btn-danger deleteProdcutImage" data-id="'+i+'"><i class="fa fa-trash" aria-hidden="true"></i></button>'+
                            '</div>'+
                        '</div>'+
                        '<label class="btn btn-primary"> Upload<input type="file" id="file-'+i+'" class="uploadFile img" name="file[]" value="Upload Photo" style="width: 0px; height: 0px; overflow: hidden;" data-overwrite-initial="false" data-min-file-count="1" />'+
                        '</label>'+
                    '</div>'+
                '</div>';

    $(this).closest(".row").find('.imgAdd').before(html);

    i++;
});

$(document).on("click", ".deleteProdcutImage" , function() {
    var id = $(this).data('id');
    $(document).find('#imgBox_'+id).remove(); 
});

$(function() {
    $(document).on("change",".uploadFile", function(){
        var uploadFile = $(this);
        var files = !!this.files ? this.files : [];
        if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
 
        if (/^image/.test( files[0].type)){ // only image file
            var reader = new FileReader(); // instance of the FileReader
            reader.readAsDataURL(files[0]); // read the local file
 
            reader.onloadend = function(){ // set image data as background of div
                //alert(uploadFile.closest(".upimage").find('.imagePreview').length);
                uploadFile.closest(".imgUp").find('.imagePreview').css("background-image", "url("+this.result+")");
            }
        }
    });
});

function readURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            $('#imagePreview').css('background-image', 'url('+e.target.result +')');
            $('#imagePreview').hide();
            $('#imagePreview').fadeIn(650);
        }
        reader.readAsDataURL(input.files[0]);
    }
}

function removeAdditionalProductImg(img_name, image_id, product_id){
    swal({
            title: "Are you sure?",
            text: "You want to delete this image",
            type: "warning",
            showCancelButton: true,
            confirmButtonColor: '#DD6B55',
            confirmButtonText: 'Yes, Delete',
            cancelButtonText: "No, cancel",
            closeOnConfirm: false,
            closeOnCancel: false
        },
    function(isConfirm) {
        if (isConfirm) {
            $.ajax({
                url: "{{route('products.removeimage')}}",
                type: "POST",
                data: {
                    _token: '{{csrf_token()}}',
                    'id': image_id,
                    'product_id': product_id,
                    'img_name': img_name,
                 },
                success: function(data){                        
                    swal("Deleted", "Your image successfully deleted!", "success");
                }
            });
        } else {
            swal("Cancelled", "Your data safe!", "error");
        }
    });
}
</script>
@endsection