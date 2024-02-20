<div class="row">
    <div class="col-md-4">
        <div class="form-group{{ $errors->has('practice_id') ? ' has-error' : '' }}">
            <label class="control-label" for="practice_id">Select Practice :<span class="text-red d-none">*</span></label>
            {!! Form::select("practice_id", $practice ?? [], null, ["class" => "form-control select2", 'placeholder' => '', "id" => "practice_id"]) !!}
            @if ($errors->has('practice_id'))
                <span class="text-danger">
                    <strong>{{ $errors->first('practice_id') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group{{ $errors->has('supplier_id') ? ' has-error' : '' }}">
            <label class="control-label" for="brand_id">Select Supplier :<span class="text-red d-none">*</span></label>
            {!! Form::select("supplier_id", $supplier ?? [], null, ["class" => "form-control select2", 'placeholder' => '', "id" => "supplier_id"]) !!}
            @if ($errors->has('supplier_id'))
                <span class="text-danger">
                    <strong>{{ $errors->first('supplier_id') }}</strong>
                </span>
            @endif
        </div>
    </div>

    <div class="col-md-4">
        <div class="form-group{{ $errors->has('brand_id') ? ' has-error' : '' }}">
            <label class="control-label" for="brand_id">Select Brand :<span class="text-red d-none">*</span></label>
            {!! Form::select("brand_id", $brand ?? [], null, ["class" => "form-control select2", 'placeholder' => '',"id" => "brand_id"]) !!}
            @if ($errors->has('brand_id'))
                <span class="text-danger">
                    <strong>{{ $errors->first('brand_id') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="form-group{{ $errors->has('daterange') ? ' has-error' : '' }}">
            <label class="control-label" for="daterange">Date range :<span class="text-red d-none">*</span></label>
            <input class="form-control" type="text" name="daterange" value="" />
            @if ($errors->has('daterange'))
                <span class="text-danger">
                    <strong>{{ $errors->first('daterange') }}</strong>
                </span>
            @endif
        </div>
    </div>
    <div class="col-md-4">
        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
            <label class="control-label" for="brand_id">Select Status :<span class="text-red d-none">*</span></label>
            {!! Form::select("status", $status ?? [], null, ["class" => "form-control select2", 'placeholder' => '', "id" => "status"]) !!}
            @if ($errors->has('status'))
                <span class="text-danger">
                    <strong>{{ $errors->first('status') }}</strong>
                </span>
            @endif
        </div>
    </div>
</div>

<div class="float-right">
    <button type="button" id="clear-filter" class="btn btn-danger" onclick="clearFilter()">Clear Filter</button>
    <button type="button" id="apply-filter" class="btn btn-success" onclick="applyFilter()">Apply Filter</button>
</div>

@section('jquery')
<script type="text/javascript">
    function applyFilter(){
        $.ajax({
            url: '{{ route("stock-orders.filter") }}',
            type: "POST",
            data: $('#stock-orders-filter-Form').serialize() + "&_token={{ csrf_token() }}",
            success: function(response) {
                var table = $('#stockOrderTable').DataTable();
                table.destroy();
                table.clear().draw();
                
                table = $('#stockOrderTable').DataTable({
                    processing: true,
                    pageLength: 100,
                    lengthMenu: [ 100, 200, 300, 400, 500, ],
                    data: response.data,
                    columns: [
                        {
                            data: 'id', width: '10%', name: 'id',
                            render: function(data, type, row) {
                                return '#' + data; // Prepend '#' to the 'id' data
                            }
                        },            
                        {data: 'supplier.full_name', name: 'supplier.full_name',
                            render: data => {
                                const [name, email] = data.split(' (');
                                return `${name}<br>${email.slice(0, -1)}`;
                            }
                        },
                        {data: 'brand.name', name: 'brand'},
                        {data: 'practice.full_name', name: 'practice.full_name',
                            render: data => {
                                const [name, email] = data.split(' (');
                                return `${name}<br>${email.slice(0, -1)}`;
                            }
                        },
                        {data: 'status', "width": "20%", name: 'status', orderable: false},
                        {data: 'created_at', "width": "20%", name: 'created_at'},
                        {data: 'action', "width": "25%", orderable: false},
                    ],
                    "order": [[0, "DESC"]]
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.error('AJAX Error:', textStatus, errorThrown);
            }
        });
    }


 
    function clearFilter(){
        $("#stock-orders-filter-Form :input").val('');
        $(".select2").val([]).trigger('change');
        $('#stockOrderTable').DataTable().ajax.reload();

    }
</script>
@endsection