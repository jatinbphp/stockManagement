{!! Form::hidden('redirects_to', URL::previous()) !!}

<div class="row">
    <div class="col-md-6">
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
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('manager_name') ? ' has-error' : '' }}">
            <label class="control-label" for="manager_name">Manager Name :<span class="text-red">*</span></label>
            {!! Form::text('manager_name', null, ['class' => 'form-control', 'placeholder' => 'Enter Manager Name', 'id' => 'manager_name']) !!}
            @if ($errors->has('manager_name'))
                <span class="text-danger">
                    <strong>{{ $errors->first('manager_name') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
            <label class="control-label" for="email">Email :<span class="text-red">*</span></label>
            {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Enter Email', 'id' => 'email']) !!}
            @if ($errors->has('email'))
                <span class="text-danger">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('telephone') ? ' has-error' : '' }}">
            <label class="control-label" for="telephone">Telephone :<span class="text-red">*</span></label>
            {!! Form::number('telephone', null, ['class' => 'form-control', 'placeholder' => 'Enter Telephone', 'id' => 'telephone']) !!}
            @if ($errors->has('telephone'))
                <span class="text-danger">
                    <strong>{{ $errors->first('telephone') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="form-group{{ $errors->has('address') ? ' has-error' : '' }}">
            <label class="control-label" for="address">Address :</label>
            {!! Form::textarea('address', null, ['class' => 'form-control', 'placeholder' => 'Enter Address', 'rows' => 1, 'id' => 'address']) !!}
            @if ($errors->has('address'))
                <span class="text-danger">
                    <strong>{{ $errors->first('address') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
            <label class="control-label" for="image">Image :</label>
            <div class="">
                <div class="fileError">
                    {!! Form::file('image', ['class' => '', 'id'=> 'image','accept'=>'image/*', 'onChange'=>'AjaxUploadImage(this)']) !!}
                </div>

                @if(!empty($practice['image']) && file_exists($practice['image']))
                    <img src="{{asset($practice['image'])}}" alt="Practice Image" style="border: 1px solid #ccc;margin-top: 5px;" width="150" id="DisplayImage">
                @else
                    <img src=" {{url('assets/admin/dist/img/no-image.png')}}" alt="Practice Image" style="border: 1px solid #ccc;margin-top: 5px;padding: 20px;" width="150" id="DisplayImage">
                @endif
                
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
                @foreach (\App\Models\Practice::$status as $key => $value)
                    @php $checked = !isset($practice) && $key == 'active'?'checked':''; @endphp
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
