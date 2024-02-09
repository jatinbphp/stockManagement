{!! Form::hidden('redirects_to', URL::previous()) !!}
<style type="text/css">
.dataTables_length, #orderProductTable_filter, .dataTables_info, .dataTables_paginate{display: none;}
</style>
<div class="row">
    <div class="col-md-6">
        <div class="form-group{{ $errors->has('user_id') ? ' has-error' : '' }}">
            <label class="control-label" for="user_id">Select User :<span class="text-red">*</span></label>
            <select id="user_id" name="user_id" class="form-control">
                <option value="">--Select User--</option>
                @foreach ($users as $key => $user)
                    @php $selected = isset($order) && $order->user_id == $user->id?'selected':''; @endphp
                    <option value="{{$user->id}}" {{$selected}}>{{$user->name}} ({{$user->email}})</option>
                @endforeach
            </select>
            @if ($errors->has('user_id'))
                <span class="text-danger">
                    <strong>{{ $errors->first('user_id') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
        <div class="card mb-4">
            <div class="card-body">
                <input type="hidden" id="route_name" value="{{ route('orders.index_product') }}">
                <table id="orderProductTable" class="table table-bordered table-striped datatable-dynamic">
                    <thead>
                        <tr>
                            <th>Product</th>
                            <th>SKU</th>
                            <th>Quantity</th>
                            <th>Unit Price</th>
                            <th>Total</th>
                            <!-- <th style="width: 10%;">Action</th> -->
                        </tr>
                    </thead>
                    <tbody>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th colspan="5">
                                <button type="button" class="btn btn-info" data-toggle="modal" data-target="#myModal" style="float: right;"><i class="fa fa-plus"></i></button>
                            </th>
                        </tr>
                    </tfoot>
                </table>                
            </div>
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group{{ $errors->has('delivey_method') ? ' has-error' : '' }}">
            <label class="control-label" for="delivey_method">Delivey Method :<span class="text-red">*</span></label>
            <select name="delivey_method" class="form-control" id="delivey_method">
                @foreach (\App\Models\Order::$allDeliveryMethod as $key => $value)
                    <option value="{{ $key }}" class="flat-red">{{ $value }}</option>
                @endforeach
            </select>
            @if ($errors->has('delivey_method'))
                <span class="text-danger">
                    <strong>{{ $errors->first('delivey_method') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group{{ $errors->has('notes') ? ' has-error' : '' }}">
            <label class="control-label" for="notes">Notes :<span class="text-red">*</span></label>
            {!! Form::textarea('notes', null, ['class' => 'form-control', 'placeholder' => 'Enter Notes', 'id' => 'notes', 'rows' => '2']) !!}
            @if ($errors->has('notes'))
                <span class="text-danger">
                    <strong>{{ $errors->first('notes') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>
@section('jquery')
<script type="text/javascript">
$(document).ready(function(){

    //Order Product Table 
    var orders_products_table = $('#orderProductTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [100, 200, 300, 400, 500],
        ajax: $("#route_name").val(),
        columns: [
            { data: 'product_name', name: 'product_name' },
            { data: 'sku', name: 'sku' },
            { data: 'quantity', name: 'quantity' },
            { data: 'unit_price', name: 'unit_price' },
            { data: 'total', name: 'total' },
            //{ data: 'action', name: 'action' },

        ]
    });

    $('#product_id').change(function(){
        // Call your function here
        var product_id = $(this).val();

        $.ajax({
            url: "{{route('products.getoptions')}}",
            type: "POST",
            data: {
                _token: '{{csrf_token()}}',
                'product_id': product_id,
             },
            success: function(data){                        
                $("#ajaxOption").html(data);
            }
        });
    });

    $(document).on("click", "#add_product", function(e) {
        e.preventDefault();
        var form = $(this).closest("form");

        $('.product_id').html('');
        $('.quantity').html('');
        $('.options_error').html('');

        // AJAX request
        $.ajax({
            url: form.attr("action"),
            type: 'POST',
            data: form.serialize(),
            success: function(response){
                orders_products_table.row('.selected').remove().draw(false);
                swal("Success", "Your product has been added to the order!", "success");
            },
            error: function(xhr, status, error){
                var errors = JSON.parse(xhr.responseText).errors;
                $.each(errors, function(key, value) {

                    if(key=='product_id' || key=='quantity'){
                        $('.'+key).html('<strong>' + value + '</strong>');
                    } else {
                        $('.options_error').html('<strong>All options field is required.</strong>');
                    }

                });
            }
        });
    });

});
</script>
@endsection