<ul class="nav nav-tabs" id="myTabs">
    <li class="nav-item">
        <a class="nav-link active" id="tab1" data-toggle="tab" href="#content1">General Information</a>
    </li>

    <li class="nav-item">
        <a class="nav-link @if(!isset($product)) disabled @endif" id="tab2" data-toggle="tab" href="#content2">Product Images</a>
    </li>

    <li class="nav-item">
        <a class="nav-link @if(!isset($product)) disabled @endif" id="tab3" data-toggle="tab" href="#content3">Options</a>
    </li>
</ul>
<style type="text/css">
.nav-tabs .active {color: #007bff !important;}
</style>

{!! Form::hidden('redirects_to', URL::previous()) !!}
<div class="tab-content mt-2">
    <div class="row tab-pane fade show active" id="content1">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card mb-4">
                <div class="card-body">

                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('category_id') ? ' has-error' : '' }}">
                                <label class="control-label" for="category_id">Select Category :<span class="text-red">*</span></label>

                                <select id="category_id" name="category_id" class="form-control">
                                    <option value="">--Select Category--</option>
                                    @foreach ($categories as $key => $val)
                                        @php $selected = isset($product) && $product->category_id == $val->id?'selected':''; @endphp
                                        <option value="{{$val->id}}" {{$selected}}>{{$val->categoryName}}</option>
                                    @endforeach
                                </select>

                                @if ($errors->has('category_id'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('category_id') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('product_name') ? ' has-error' : '' }}">
                                <label class="control-label" for="product_name">Product Name :<span class="text-red">*</span></label>
                                {!! Form::text('product_name', null, ['class' => 'form-control', 'placeholder' => 'Enter Product Name', 'id' => 'product_name']) !!}
                                @if ($errors->has('product_name'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('product_name') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group{{ $errors->has('sku') ? ' has-error' : '' }}">
                                <label class="control-label" for="sku">SKU :<span class="text-red">*</span></label>
                                {!! Form::text('sku', null, ['class' => 'form-control', 'placeholder' => 'Enter SKU', 'id' => 'sku']) !!}
                                @if ($errors->has('sku'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('sku') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label class="control-label" for="description">Description :<span class="text-red">*</span></label>
                                {!! Form::textarea('description', null, ['class' => 'form-control', 'placeholder' => 'Enter Description', 'id' => 'description', 'rows' => '4']) !!}
                                @if ($errors->has('description'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('price') ? ' has-error' : '' }}">
                                <label class="control-label" for="price">Price :<span class="text-red">*</span></label>
                                {!! Form::text('price', null, ['class' => 'form-control', 'placeholder' => 'Enter Price', 'id' => 'price']) !!}
                                @if ($errors->has('price'))
                                    <span class="text-danger">
                                        <strong>{{ $errors->first('price') }}</strong>
                                    </span>
                                @endif
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                <label class="col-md-12 control-label" for="status">Status :<span class="text-red">*</span></label>
                                <div class="col-md-12">
                                    @foreach (\App\Models\Products::$status as $key => $value)
                                            @php $checked = !isset($product) && $key == 'active'?'checked':''; @endphp
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

    <div class="row tab-pane fade" id="content2">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row additionalImageClass">
                        <div class="col-lg-12 mb-2">
                            <h5>Add Product Images</h5>
                        </div>

                        <?php 
                        if(!empty($product)){
                            if (!empty($product->product_images)) {
                                foreach ($product->product_images as $key => $value) { ?>
                                    <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                                        <div class="imagePreviewPlus">
                                            <div class="text-right">
                                                <button type="button" class="btn btn-danger removeImage" onclick="removeAdditionalProductImg('<?php echo $value['image']; ?>','<?php echo $value['id']; ?>','<?php echo $product->id; ?>');"><i class="fa fa-trash" aria-hidden="true"></i></button>
                                            </div>
                                            <img style="width: inherit; height: inherit;" @if(!empty($value['image'])) src="{{ url($value['image'])}}" @endif alt="">
                                        </div>
                                    </div>
                                <?php 
                                }
                            }
                        } ?>

                        <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12">
                            <div class="boxImage imgUp">
                                <div class="loader-contetn loader1">
                                    <div class="loader-01"> </div>
                                </div>
                                <div class="imagePreview"></div>
                                <label class="btn btn-primary">
                                    Upload<input type="file" name="file[]" class="uploadFile img" id="file-1" value="Upload Photo" style="width: 0px;height: 0px;overflow: hidden;" data-overwrite-initial="false" data-min-file-count="1">
                                </label>
                            </div>
                        </div>
                        <div class="col-lg-2 col-md-4 col-sm-6 col-xs-12 imgAdd">
                            <div class="imagePreviewPlus imgUp"><i class="fa fa-plus fa-4x"></i></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
    $optionValuesCounter = 1;
    @endphp

    <div class="row tab-pane fade" id="content3">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12 mb-2">
                        <p class="h5">Add Options
                            <button type="button" class="btn btn-info" id="optionBtn" style="float: right;"><i class="fa fa-plus"></i> Add Option</button>
                            </p>
                        </div>
                    </div>
                    @if(count($product_options)>0)
                        @foreach ($product_options as $key => $option) 
                        <div class="card product-attribute" id="options_{{ $option->id }}">
                                <div class="row p-2">
                                    <div class="col-md-4">
                                        <div class="row">
                                            <div class="col-md-10">
                                                <div class="form-group{{ $errors->has('options') ? ' has-error' : '' }}">
                                                    <label class="control-label" for="options">Option Name :<span class="text-red">*</span></label>
                                                    {!! Form::text("options[old][$option->id]", $option->option_name, ['class' => 'form-control','required-', 'placeholder' => "Enter Option Name"]) !!}
                                                    @if ($errors->has('options'))
                                                        <span class="text-danger">
                                                            <strong>{{ $errors->first('options') }}</strong>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>

                                            <div class="col-md-1">
                                                <button type="button" class="btn btn-danger deleteExp" onClick="removeOptionRow({{$option->id}}, 0)" style="margin-top: 30px;"><i class="fa fa-trash"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-8" id="extraValuesOption_{{ $option->id }}_{{ $option->id }}">

                                        @if(count($option->product_option_values)>0)
                                            @foreach ($option->product_option_values as $vkey => $option_value)
                                                @if($vkey==0)
                                                    <div class='row'>
                                                        <div class="col-md-5">
                                                            <label class="control-label" for="option_values">Option Values :<span class="text-red">*</span></label>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <label class="control-label" for="option_price">Option Values Price :<span class="text-red">*</span></label>
                                                        </div>
                                                    </div>
                                                @endif
                                                <div class="row" id="options_values_{{ $option_value->id }}">
                                                    <div class="col-md-5">
                                                        <div class="form-group{{ $errors->has('option_values') ? ' has-error' : '' }}">
                                                            {!! Form::text("option_values[old][$option->id][$option_value->id]", $option_value->option_value, ['class' => 'form-control','required-', 'placeholder' => "Enter Option Value"]) !!}
                                                            @if ($errors->has('option_values'))
                                                                <span class="text-danger">
                                                                    <strong>{{ $errors->first('option_values') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-md-5">
                                                        <div class="form-group{{ $errors->has('option_price') ? ' has-error' : '' }}">
                                                            {!! Form::text("option_price[old][$option->id][$option_value->id]", $option_value->option_price, ['class' => 'form-control','required-', 'placeholder' => "Enter Option Price"]) !!}
                                                            @if ($errors->has('option_price'))
                                                                <span class="text-danger">
                                                                    <strong>{{ $errors->first('option_price') }}</strong>
                                                                </span>
                                                            @endif
                                                        </div>
                                                    </div>

                                                    <div class="col-md-2">
                                                        <button type="button" class="btn btn-danger deleteExp" onClick="removeOptionRow({{ $option_value->id }}, 1)"><i class="fa fa-trash"></i></button>
                                                        @if($vkey==0)
                                                            <button type="button" class="btn btn-info add-option" onclick="optionValuesBtn({{ $option->id }}, {{ $option->id }})"><i class="fa fa-plus"></i> </button>
                                                        @endif
                                                    </div>
                                                </div>
                                                @php
                                                $optionValuesCounter = $option_value->id;
                                                @endphp
                                            @endforeach
                                            <!-- <div id="extraValuesOption_{{ $option->id }}_{{ $option->id }}"></div> -->
                                        @else 
                                            <div class="row" id="options_values_1">
                                                <div class='row'>
                                                        <div class="col-md-5">
                                                            <label class="control-label" for="option_values">Option Values :<span class="text-red">*</span></label>
                                                        </div>
                                                        <div class="col-md-5">
                                                            <label class="control-label" for="option_price">Option Values Price :<span class="text-red">*</span></label>
                                                        </div>
                                                    </div>
                                                <div class="col-md-5">
                                                    <div class="form-group{{ $errors->has('option_values') ? ' has-error' : '' }}">
                                                        {!! Form::text("option_values[new][$option->id][]", null, ['class' => 'form-control','required-', 'placeholder' => "Enter Option Value"]) !!}
                                                        @if ($errors->has('option_values'))
                                                            <span class="text-danger">
                                                                <strong>{{ $errors->first('option_values') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-md-5">
                                                    <div class="form-group{{ $errors->has('option_price') ? ' has-error' : '' }}">
                                                        {!! Form::text("option_price[new][$option->id][]", null, ['class' => 'form-control','required-', 'placeholder' => "Enter Option Price"]) !!}
                                                        @if ($errors->has('option_price'))
                                                            <span class="text-danger">
                                                                <strong>{{ $errors->first('option_price') }}</strong>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>

                                                <div class="col-md-2">
                                                    <button type="button" class="btn btn-danger deleteExp" onClick="removeOptionRow({{ $option->id }}, 1)"><i class="fa fa-trash"></i></button>
                                                    <button type="button" class="btn btn-info add-option" onclick="optionValuesBtn({{ $option->id }}, {{ $option->id }})"><i class="fa fa-plus"></i> </button>
                                                </div>
                                            </div>
                                            <!-- <div id="extraValuesOption_{{ $option->id }}_{{ $option->id }}"></div> -->
                                            @php
                                            $optionValuesCounter = $option->id;
                                            @endphp
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @else
                        <div class="card product-attribute" id="options_1">
                            <div class="row p-2">
                                <div class="col-md-4">
                                    <div class="row">
                                        <div class="col-md-10">
                                            <div class="form-group{{ $errors->has('options') ? ' has-error' : '' }}">
                                                <label class="control-label" for="options">Option Name :<span class="text-red">*</span></label>
                                                {!! Form::text("options[new][1]", null, ['class' => 'form-control','required-', 'placeholder' => "Enter Option Name"]) !!}
                                                @if ($errors->has('options'))
                                                    <span class="text-danger">
                                                        <strong>{{ $errors->first('options') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-8" id="extraValuesOption_1_1">
                                    <div class='row'>
                                        <div class="col-md-5">
                                            <label class="control-label" for="option_values">Option Values1s :<span class="text-red">*</span></label>
                                        </div>
                                        <div class="col-md-5">
                                            <label class="control-label" for="option_price">Option Values Price :<span class="text-red">*</span></label>
                                        </div>
                                    </div>
                                    <div class="row" id="options_values_1">
                                        <div class="col-md-5">
                                            <div class="form-group{{ $errors->has('option_values') ? ' has-error' : '' }}">
                                                {!! Form::text("option_values[new][1][]", null, ['class' => 'form-control','required-', 'placeholder' => "Enter Option Value"]) !!}
                                                @if ($errors->has('option_values'))
                                                    <span class="text-danger">
                                                        <strong>{{ $errors->first('option_values') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-5">
                                            <div class="form-group{{ $errors->has('option_price') ? ' has-error' : '' }}">
                                                {!! Form::text("option_price[new][1][]", null, ['class' => 'form-control','required-', 'placeholder' => "Enter Option Price"]) !!}
                                                @if ($errors->has('option_price'))
                                                    <span class="text-danger">
                                                        <strong>{{ $errors->first('option_price') }}</strong>
                                                    </span>
                                                @endif
                                            </div>
                                        </div>

                                        <div class="col-md-2">
                                            <button type="button" class="btn btn-danger deleteExp" onClick="removeOptionRow(1, 1)"><i class="fa fa-trash"></i></button>
                                            <button type="button" class="btn btn-info add-option" onclick="optionValuesBtn(1, 1)"><i class="fa fa-plus"></i> </button>
                                        </div>
                                    </div>
                                    <!-- <div id="extraValuesOption_1_1"></div> -->
                                </div>
                            </div>
                        </div>
                    @endif
                <div id="extraOption"></div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('jquery')
<script type="text/javascript">
var optionName = {{$optionValuesCounter}};

$('#optionBtn').on('click', function(){
    optionName = optionName + 1;

    var exOptionContent = '<div class="card product-attribute" id="options_'+optionName+'">'+
            '<div class="row p-2">'+
                '<div class="col-md-4">'+
                    '<div class="row">'+
                        '<div class="col-md-10">'+
                            '<label class="control-label" for="options">Option Name :<span class="text-red">*</span></label>'+
                            '<div class="form-group">'+
                                '<input type="text" name="options[new]['+optionName+']" class="form-control" required- placeholder="Enter Option Name">'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-1">'+
                            '<button type="button" class="btn btn-danger deleteExp" onClick="removeOptionRow('+optionName+', 0)" style="margin-top: 30px;"><i class="fa fa-trash"></i></button>'+
                        '</div>'+
                    '</div>'+
                '</div>'+

                '<div class="col-md-8" id="extraValuesOption_'+optionName+'_'+optionName+'">'+
                    '<div class="row">'+
                        '<div class="col-md-5">'+
                            '<label class="control-label" for="option_values">Option Values :<span class="text-red">*</span></label>'+
                        '</div>'+
                        '<div class="col-md-5">'+
                            '<label class="control-label" for="option_price">Option Values Price :<span class="text-red">*</span></label>'+
                        '</div>'+
                    '</div>'+
                    '<div class="row" id="options_values_'+optionName+'">'+
                        '<div class="col-md-5">'+
                            '<div class="form-group">'+
                                '<input type="text" name="option_values[new]['+optionName+'][]" class="form-control" required- placeholder="Enter Option Value">'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-5">'+
                            '<div class="form-group">'+
                                '<input type="text" name="option_price[new]['+optionName+'][]" class="form-control" required- placeholder="Enter Option Price">'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-2">'+
                            '<button type="button" class="btn btn-danger deleteExp mr-1" onClick="removeOptionRow('+optionName+', 1)"><i class="fa fa-trash"></i></button>'+
                            '<button type="button" class="btn btn-info add-option" onclick="optionValuesBtn('+optionName+', '+optionName+')"><i class="fa fa-plus"></i> </button>'+
                        '</div>'+                    
                    '</div>'+
                '</div>'+
            '</div>'+
        '</div>';
    $('#extraOption').append(exOptionContent);
});

function optionValuesBtn(option_value_number, option_number) {
    optionName = optionName + 1;

    var exOptionContent = '<div class="row" id="options_values_'+optionName+'">'+
                            '<div class="col-md-5">'+
                                '<div class="form-group">'+
                                    '<input type="text" name="option_values[new]['+option_value_number+'][]" class="form-control" required- placeholder="Enter Option Value">'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-md-5">'+
                                '<div class="form-group">'+
                                    '<input type="text" name="option_price[new]['+option_value_number+'][]" class="form-control" required- placeholder="Enter Option Price">'+
                                '</div>'+
                            '</div>'+
                            '<div class="col-md-2">'+
                                '<button type="button" class="btn btn-danger deleteExp mr-1" onClick="removeOptionRow('+optionName+', 1)"><i class="fa fa-trash"></i></button>'+
                            '</div>'+                    
                        '</div>';
    $('#extraValuesOption_'+option_value_number+'_'+option_number).append(exOptionContent);
}

function removeOptionRow(divId, type){
    const removeRowAlert = createOptionAlert("Are you sure?", "Do want to delete this row", "warning");
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
    if(type==1){
        console.log($('#options_values_'+divId).parent('div').children('div').length);
        if($('#options_values_'+divId).parent('div').children('div').length <= 2){
            swal("Error", "You cannot remove all option values. If you wish to remove them, you must delete the entire option.", "error");
            return 0;
        }
        var mainDiv = $('#options_values_'+divId);
        var divWithAddOptionClass = mainDiv.find('.add-option').closest('.row');
        if(divWithAddOptionClass.length > 0){
            var addButton = divWithAddOptionClass.find('.add-option');
            var secondDiv = mainDiv.next('.row');
            var colMd2Div = secondDiv.find('.col-md-2');
            addButton.detach();
            colMd2Div.append(addButton);
        }
        $('#options_values_'+divId).remove();
    } else {
        $('#options_'+divId).remove();
        if ($(".product-attribute").length == 0) {
            $('#optionBtn').click();
        }
    }
    return 1;  
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

var i = 2;
$(".imgAdd").click(function(){

    var html = '<div class="col-lg-2 col-md-4 col-sm-6 col-xs-12" id="imgBox_'+i+'">'+
                    '<div class="boxImage imgUp">'+
                        '<div class="loader-contetn loader'+i+'"><div class="loader-01"></div></div>'+
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