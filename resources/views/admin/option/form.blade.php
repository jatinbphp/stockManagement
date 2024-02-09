{!! Form::hidden('redirects_to', URL::previous()) !!}
<div class="row">

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('type') ? ' has-error' : '' }}">
            <label class="control-label" for="type">Select Option Type :<span class="text-red">*</span></label>
            {!! Form::select("type", \App\Models\Options::$option_types, null, ["class" => "form-control"]) !!}
            @if ($errors->has('type'))
                <span class="text-danger">
                    <strong>{{ $errors->first('type') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
            <label class="control-label" for="name">Option Name :<span class="text-red">*</span></label>
            {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => 'Enter Option Name', 'id' => 'name']) !!}
            @if ($errors->has('name'))
                <span class="text-danger">
                    <strong>{{ $errors->first('name') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            <label class="control-label" for="status">Status :<span class="text-red">*</span></label>
            <div class="col-md-12">
                @foreach (\App\Models\Options::$status as $key => $value)
                        @php $checked = !isset($option) && $key == 'active'?'checked':''; @endphp
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
<hr>
@if(!empty($option->option_values))
    @foreach ($option->option_values as $key => $option_value)
        <div class="row" id="option_values_{{ $option_value->id }}">
            <div class="col-md-6">
                <div class="form-group{{ $errors->has('option_values') ? ' has-error' : '' }}">
                    @if($key==0)
                    <label class="control-label" for="option_values">Option Values :<span class="text-red">*</span></label>
                    @endif
                    {!! Form::text("option_values[$option_value->id]", $option_value->value, ['class' => 'form-control','required']) !!}
                    @if ($errors->has('option_values'))
                        <span class="text-danger">
                            <strong>{{ $errors->first('option_values') }}</strong>
                        </span>
                    @endif
                </div>
            </div>

            <div class="col-md-1">
                @if($key==0)
                    <button type="button" class="btn btn-info" id="optionVBtn" style="margin-top: 30px;"><i class="fa fa-plus"></i> </button>
                @else
                    <button type="button" class="btn btn-danger deleteExp" onClick="removeRow({{ $option_value->id }}, {{ $option->id }})"><i class="fa fa-trash"></i></button>
                @endif
            </div>
        </div>
        @php
        $optionValues = $option_value->id;
        @endphp
    @endforeach
@else
    <div class="row" id="option_values_1">
        <div class="col-md-6">
            <div class="form-group{{ $errors->has('option_values') ? ' has-error' : '' }}">
                <label class="control-label" for="option_values">Option Values :<span class="text-red">*</span></label>
                {!! Form::text("option_values[]", null, ['class' => 'form-control','required']) !!}
                @if ($errors->has('option_values'))
                    <span class="text-danger">
                        <strong>{{ $errors->first('option_values') }}</strong>
                    </span>
                @endif
            </div>
        </div>

        <div class="col-md-1">
            <button type="button" class="btn btn-info" id="optionVBtn" style="margin-top: 30px;"><i class="fa fa-plus"></i> </button>
        </div>
    </div>
    @php
    $optionValues = 1;
    @endphp
@endif
<div id="extraOption"></div>

@section('jquery')
<script type="text/javascript">
var optionValues = {{$optionValues}};

$('#optionVBtn').on('click', function(){
    optionValues = optionValues + 1;

    var exOptionContent = '<div class="row" id="option_values_'+optionValues+'">'+
        '<div class="col-md-6">'+
            '<div class="form-group">'+
                '<input type="text" name="option_values[]" class="form-control" required>'+
            '</div>'+
        '</div>'+
        '<div class="col-md-1">'+
            '<button type="button" class="btn btn-danger deleteExp" onClick="removeRow('+optionValues+', 0)"><i class="fa fa-trash"></i></button>'+
        '</div>'+
        '</div>';
    $('#extraOption').append(exOptionContent);
});

function removeRow(divId, optionId){
    const removeRowAlert = createOptionAlert("Are you sure?", "Do want to delete this row", "warning");
    swal(removeRowAlert, function(isConfirm) {
        if (isConfirm) {

            if(optionId!=0){
                $.ajax({
                    url: "{{route('options.removeoptionvalues')}}",
                    type: "POST",
                    data: {
                        _token: '{{csrf_token()}}',
                        'id': divId,
                        'option_id': optionId,
                     },
                    success: function(data){                        
                        deleteSafe(divId);
                        swal.close();
                    }
                });
            } else {
                deleteSafe(divId);
                swal.close();
            }
        } else{
             swal("Cancelled", "Your data safe!", "error");
        }
    });
}

//remove the row
function deleteSafe(divId){
    $('#option_values_'+divId).remove();
}

function createOptionAlert(title, text, type) {
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
</script>
@endsection