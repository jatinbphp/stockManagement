{!! Form::hidden('redirects_to', URL::previous()) !!}
<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('supplier_id') ? ' has-error' : '' }}">
            <label class="control-label" for="email">Supplier :<span class="text-red">*</span></label>
            {!! Form::select('supplier_id', empty($supplier) ? [] : $supplier, null, ['class' => 'form-control', 'placeholder' => 'Select Supplier', 'id' => 'supplier_id']) !!}
            @if ($errors->has('supplier_id'))
                <span class="text-danger">
                    <strong>{{ $errors->first('supplier_id') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('brand_id') ? ' has-error' : '' }}">
            <label class="control-label" for="brand_id">Brand :<span class="text-red">*</span></label>
            {!! Form::select('brand_id', empty($brand) ? [] : $brand, null, ['class' => 'form-control', 'placeholder' => 'Select Brand', 'id' => 'brand_id']) !!}
            @if ($errors->has('brand_id'))
                <span class="text-danger">
                    <strong>{{ $errors->first('brand_id') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('practice_id') ? ' has-error' : '' }}">
            <label class="control-label" for="practice_id">Practice :<span class="text-red">*</span></label>
            {!! Form::select('practice_id', empty($practice) ? [] : $practice, null, ['class' => 'form-control', 'placeholder' => 'Select Practice', 'id' => 'practice_id']) !!}
            @if ($errors->has('practice_id'))
                <span class="text-danger">
                    <strong>{{ $errors->first('practice_id') }}</strong>
                </span>
            @endif
        </div>
    </div>
   <div class="col-md-6">
        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
            <label class="col-md-12 control-label" for="image">Order Copy:<span class="text-red">*</span></label>
            <div class="col-md-12">
                <div class="fileError">
                {!! Form::file('order_copy', ['class' => '', 'id' => 'order_copy', 'accept' => '.pdf, .doc, .docx', 'onChange' => 'AjaxUploadFile(this)']) !!}
                </div>
                <div class= {{ request()->is('*edit') ? "mt-2" : "d-none" }}>
                    <a target="blank" href="{{ isset($stockOrder['order_copy']) ? url($stockOrder['order_copy']) : "#" }}" download>
                        <i class="fas fa-download"></i> Download
                    </a>
                </div>
                {{-- <img id="DisplayImage" @if(!empty($stockOrder['order_copy'])) src="{{ url($stockOrder['order_copy'])}}" style="margin-top: 1%; padding-bottom:5px; display: block;" @else src="" style="padding-bottom:5px; display: none;" @endif width="150"> --}}
                @if ($errors->has('order_copy'))
                    <span class="text-danger">
                        <strong>{{ $errors->first('order_copy') }}</strong>
                    </span>
                @endif
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('instructions') ? ' has-error' : '' }}">
            <label class="control-label" for="instructions">Instructions : <span class="text-red">*</span></label>
            {!! Form::textarea('instructions', null, ['class' => 'form-control', 'placeholder' => 'Enter instructions', 'rows' => 2, 'id' => 'instructions']) !!}
            @if ($errors->has('instructions'))
                <span class="text-danger">
                    <strong>{{ $errors->first('instructions') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            <label class="col-md-12 control-label" for="status">Status :<span class="text-red">*</span></label>
            <div class="col-md-12">
                @foreach (\App\Models\Brand::$status as $key => $value)
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
