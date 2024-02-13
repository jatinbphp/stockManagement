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
</div>

<div class="row">
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
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('account_number') ? ' has-error' : '' }}">
            <label class="control-label" for="account_number">Account Number :<span class="text-red">*</span></label>
            {!! Form::text('account_number', null, ['class' => 'form-control', 'placeholder' => 'Enter Account Number', 'id' => 'account_number']) !!}
            @if ($errors->has('account_number'))
                <span class="text-danger">
                    <strong>{{ $errors->first('account_number') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            <label class="col-md-12 control-label" for="status">Status :<span class="text-red">*</span></label>
            <div class="col-md-12">
                @foreach (\App\Models\Supplier::$status as $key => $value)
                    @php $checked = !isset($supplier) && $key == 'active'?'checked':''; @endphp
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
