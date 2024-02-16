@extends('admin.layouts.app')
@section('content')
<div class="content-wrapper" style="min-height: 946px;">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{$menu}}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{route('stock-orders.index')}}">{{$menu}}</a></li>
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">
        @include ('admin.error')
        <div class="row">
            <div class="col-md-12">
                @if($stockOrder->status!='completed')
                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Receive {{$menu}}</h3>
                    </div>
                    {!! Form::open(['url' => route('stock-orders.receive-documents'), 'id' => 'stockOrdersForm', 'class' => 'form-horizontal','files'=>true]) !!}
                        <div class="card-body">
                            {!! Form::hidden('redirects_to', URL::previous()) !!}
                            {!! Form::hidden('stock_order_id', $stockOrder->id, []) !!}
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('inv_number') ? ' has-error' : '' }}">
                                        <label class="control-label" for="inv_number">Invoice Number : <span class="text-red">*</span></label>
                                        {!! Form::text('inv_number', null, ['class' => 'form-control', 'placeholder' => 'Enter Invoice Number', 'id' => 'inv_number']) !!}
                                        @if ($errors->has('inv_number'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('inv_number') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('grv_number') ? ' has-error' : '' }}">
                                        <label class="control-label" for="grv_number">GRV Number : <span class="text-red">*</span></label>
                                        {!! Form::text('grv_number', null, ['class' => 'form-control', 'placeholder' => 'Enter GRV Number', 'id' => 'grv_number']) !!}
                                        @if ($errors->has('grv_number'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('grv_number') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group{{ $errors->has('notes') ? ' has-error' : '' }}">
                                        <label class="control-label" for="notes">Additional Notes :</label>
                                        {!! Form::textarea('notes', null, ['class' => 'form-control', 'placeholder' => 'Enter notes', 'rows' => 2, 'id' => 'notes']) !!}
                                        @if ($errors->has('notes'))
                                            <span class="text-danger">
                                                <strong>{{ $errors->first('notes') }}</strong>
                                            </span>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12 mb-2">
                                                    <p class="h5">Upload Documents</p>
                                                </div>
                                            </div>

                                            <div class="row product-attribute" id="documents_1">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-11">
                                                            <div class="form-control form-group{{ $errors->has('documents') ? ' has-error' : '' }}">
                                                                {!! Form::file("documents[1]", null) !!}

                                                                @if ($errors->has('documents'))
                                                                    <span class="text-danger">
                                                                        <strong>{{ $errors->first('documents') }}</strong>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                        <div class="col-md-1">
                                                            <button type="button" class="btn btn-info" id="optionBtn"><i class="fa fa-plus"></i></button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div id="extraOption"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('stock-orders.index') }}" class="btn btn-default">Back</a>
                            <button class="btn btn-info float-right" type="submit">Save</button>
                        </div>
                    {!! Form::close() !!}
                </div>
                @endif

                <div class="card card-info">
                    <div class="card-header">
                        <h3 class="card-title">Uploaded Documents</h3>
                    </div>
                    <div class="card-body table-responsive">
                        <input type="hidden" id="route_name" value="{{ route('stock-orders.index_receive_stock_order') }}">
                        <input type="hidden" id="stock_order_id" value="{{$stockOrder->id}}">
                        <table id="receiveStockOrderTable" class="table table-bordered table-striped datatable-dynamic">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Invoice Number</th>
                                    <th>GRV Number</th>
                                    <th>Notes</th>
                                    <th>Created Date</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<div id="view-documents-list" class="modal fade" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Documents</h4>
                <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            <div class="modal-body">
                <div class="col-md-12">
                    <table class="table table-bordered datatable-dynamic">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Updated By</th>
                                <th>Updated Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody class="view-documents-list-view">
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endsection
@section('jquery')
<script type="text/javascript">
var optionName = 1;

$('#optionBtn').on('click', function(){
    optionName = optionName + 1;

    var exOptionContent = '<div class="row product-attribute" id="documents_'+optionName+'">'+
                '<div class="col-md-12">'+
                    '<div class="row">'+
                        '<div class="col-md-11">'+
                            '<div class="form-control form-group">'+
                                '<input type="file" name="documents['+optionName+']">'+
                            '</div>'+
                        '</div>'+
                        '<div class="col-md-1">'+
                            '<button type="button" class="btn btn-danger deleteExp" onClick="removeOptionRow('+optionName+', 0)"><i class="fa fa-trash"></i></button>'+
                        '</div>'+
                    '</div>'+
                '</div>'+
        '</div>';
    $('#extraOption').append(exOptionContent);
});

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
    $('#documents_'+divId).remove();
    if ($(".product-attribute").length == 0) {
        $('#optionBtn').click();
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

$(document).ready(function(){
    //Receive Stock Order Table
    var receive_stock_orders_table = $('#receiveStockOrderTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [ 100, 200, 300, 400, 500, ],
        ajax: {
            url: $("#route_name").val(),
            data: function (d) {
                d.stock_order_id = $("#stock_order_id").val();
            }
        },
        columns: [
            {
                data: 'id', width: '10%', name: 'id',
                render: function(data, type, row) {
                    return '#' + data; // Prepend '#' to the 'id' data
                }
            },
            {data: 'inv_number', name: 'inv_number'},
            {data: 'grv_number', name: 'grv_number'},
            {data: 'notes', name: 'notes'},
            {data: 'created_at', "width": "20%", name: 'created_at'},
            {data: 'action', "width": "20%", orderable: false},
        ],
        "order": [[0, "DESC"]]
    });

    function reloadStockOrdersTable() {
        receive_stock_orders_table.ajax.reload(null, false);
    }

    //Delete Record
    $('.datatable-dynamic tbody').on('click', '.deleteStockOrderDocumentRecord', function (event) {
        event.preventDefault();
        var id = $(this).attr("data-id");
        var type = $(this).attr("data-type");

        if(type=='receive_stock_order'){
            var msg = "You want to delete this record & documents?"
        } else {
            var msg = "You want to delete this document?"
        }

        swal({
            title: "Are you sure?",
            text: msg,
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

                var url = "{{ route('stock-orders.receive_stock_order_and_documents', [':stock_order_id', ':type']) }}";
                url = url.replace(':stock_order_id', id).replace(':type', type);

                $.ajax({
                    url: url,
                    type: "GET",
                    headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
                    success: function(data){
                        if(type=='receive_stock_order'){
                            reloadStockOrdersTable();
                        } else {
                            $("#view-documents-list").modal("hide");
                        }
                        swal("Deleted", "Your data successfully deleted!", "success");
                    }
                });
            } else {
                swal("Cancelled", "Your data safe!", "error");
            }
        });
    });

    $('.datatable-dynamic tbody').on('click', '.view-documents', function (event) {
        event.preventDefault();
        var url = $(this).attr('data-url');
        var id = $(this).attr("data-id");

        $.ajax({
            method: "GET",
            url: url,
            dataType: "json",
            headers: { 'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content') },
            success: function(response) {
                if (response.status) {
                    var html = "";
                    $.each(response.data, function(k, v) {

                        var formattedCreatedAt = moment(v.created_at).format('YYYY-MM-DD HH:mm:ss');

                        html += `<tr>
                                    <td>#${k+1} </td>
                                    <td> ${v.user.name} </td>
                                    <td> ${formattedCreatedAt} </td>
                                    <td>
                                        <a class="btn btn-sm btn-info" href="${v.document_path}" download><i class="fa fa-download" aria-hidden="true"></i></a>
                                        <button class="btn btn-sm btn-danger deleteStockOrderDocumentRecord" data-id="${v.id}" type="button" data-type="receive_stock_order_document"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>`;
                    });
                    $("#view-documents-list").find(".view-documents-list-view").html(html);
                    $("#view-documents-list").modal("show");
                }
            }
        });
    });
});
</script>
@endsection