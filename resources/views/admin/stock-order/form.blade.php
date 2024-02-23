{!! Form::hidden('redirects_to', URL::previous()) !!}
<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('supplier_id') ? ' has-error' : '' }}">
            <label for="supplier_id" class="control-label">Select Supplier :<span class="text-red">*</span></label>
            {!! Form::select('supplier_id', $supplier ?? [], null, ['class' => 'form-control', 'placeholder' => 'Please Select', 'id' => 'supplier_id']) !!}
            
            @if ($errors->has('supplier_id'))
                <span class="text-danger">
                    <strong>{{ $errors->first('supplier_id') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('brand_id') ? ' has-error' : '' }}">
            <label class="control-label" for="brand_id">Select Brand :<span class="text-red">*</span></label>
            {!! Form::select("brand_id", ['' => 'Please Select'], null, ["class" => "form-control select2", "id" => "brand_id"]) !!}
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
            <label class="control-label" for="practice_id">Select Practice :<span class="text-red">*</span></label>
            {!! Form::select('practice_id', $practice ?? [], null, ['class' => 'form-control', 'placeholder' => 'Please Select', 'id' => 'practice_id']) !!}
            @if ($errors->has('practice_id'))
                <span class="text-danger">
                    <strong>{{ $errors->first('practice_id') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('image') ? ' has-error' : '' }}">
            <label class="col-md-12 control-label" for="image">Order Copy:<span class="text-red">*</span> <small id="fileTypesLabel">Accepted file types: .pdf, .jpg, .docx, .png</small></label>
            <div class="col-md-12">
                <div class="fileError">
                    {!! Form::file('order_copy', ['class' => '', 'id' => 'order_copy', 'accept' => '.pdf, .jpg, .docx, .png', 'onChange' => 'AjaxUploadFile(this)']) !!}
                </div>
                <div class= {{ request()->is('*edit') ? "mt-2" : "d-none" }}>
                    <a target="blank" href="{{ isset($stockOrder['order_copy']) ? url($stockOrder['order_copy']) : 'javascript:void(0)' }}" download>
                        <i class="fas fa-download"></i> Download
                    </a>
                </div>
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
    <div class="col-md-12">
        <div class="form-group{{ $errors->has('instructions') ? ' has-error' : '' }}">
            <label class="control-label" for="instructions">Instructions : </label>
            {!! Form::textarea('instructions', null, ['class' => 'form-control', 'placeholder' => 'Enter instructions', 'rows' => 2, 'id' => 'instructions']) !!}            
        </div>
    </div>
</div>

@section('jquery')
<script type="text/javascript">
$(document).ready(function(){

    if($("#supplier_id").val()){
        setTimeout(function(){
            $('#supplier_id').val($("#supplier_id").val()).trigger('change');

            @if(isset($stockOrder->id))
                setTimeout(function() {
                    $('#brand_id').val({{ $stockOrder->brand_id}}).trigger('change');
                }, 500);
            @endif
        }, 500);
    }

    //get brands
    $('#supplier_id').change(function(){
        // Call your function here
        var supplier_id = $(this).val();
        if (supplier_id) {
            $.ajax({
                url: "{{ route('brands.by_supplier', ':supplierId') }}".replace(':supplierId', supplier_id),
                type: "GET",
                data: {
                    _token: '{{csrf_token()}}',
                    'supplier_id': supplier_id,
                 },
                success: function(data){                        
                    $('#brand_id').empty().append('<option value="">Please Select</option>');
                    $('#brand_id').select2('destroy').select2();
                    data.forEach(function(brand) {
                        $('#brand_id').append('<option value="' + brand.id + '">' + brand.name + '</option>');
                    });
                }
            });
        } else {
            $('#brand_id').empty().append('<option value="">Please Select</option>');
            $('#brand_id').select2('destroy').select2();
        }
    });
});
</script>
@endsection