{!! Form::hidden('redirects_to', URL::previous()) !!}

<div class="row">
    <div class="col-md-12">
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label class="control-label" for="name">Name :<span class="text-red">*</span></label>
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter Name', 'id' => 'name', 'readonly']) !!}
            @if ($errors->has('name'))
                <span class="text-danger">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group{{ $errors->has('access_rights') ? ' has-error' : '' }}">
            <label class="col-md-12 control-label" for="access_rights">Access Rights :<span class="text-red">*</span></label>
            <div class="col-md-12 checkbox-list">
                @foreach (\App\Models\Role::$permission as $key => $value)

                    @php 
                    $checked = (isset($role) && !empty($role->access_rights) && in_array($key, json_decode($role->access_rights))) ? 'checked' : ''; 
                    @endphp

                    <div class="col-md-3">
                        <label class="checkbox-label">
                            {!! Form::checkbox('access_rights[]', $key, $checked, ['class' => 'access-checkbox']) !!}
                            <span class="checkmark"></span>
                            <span>{{ $value }}</span>
                        </label>
                    </div>

                @endforeach
                <br class="access_rightsError">
                @if ($errors->has('access_rights'))
                    <span class="text-danger" id="access_rightsError">
                        <strong>{{ $errors->first('access_rights') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>

</div>
{!! Form::hidden('status', 'active', ['class' => 'form-control', 'id' => 'status']) !!}