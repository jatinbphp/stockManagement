@extends('admin.layouts.app')
@section('content')
@section('style')
<style type="text/css">
#receiveStockOrderTable .btn {display: none;}
.view-documents {display: block !important;}
.deleteStockOrderDocumentRecord {display: none;}
</style>
@endsection
    <div class="content-wrapper">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>{{$menu}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('admin.dashboard')}}">Home</a></li>
                            <li class="breadcrumb-item active">{{$menu}}</li>
                        </ol>
                    </div>
                </div>
            </div><!-- /.container-fluid -->
        </section>

        <!-- Main content -->
        <section class="content">
            @include ('admin.common.error')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            {!! Form::open(['url' => null, 'id' => 'filter-Form', 'class' => 'form-horizontal','files'=>true]) !!}
                                @include('admin.stock-order.filter', ['type' => 'stock-orders'])
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Manage {{$menu}}</h3>
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{ route('stock-orders.create') }}" class="btn btn-sm btn-info float-right">Add New</a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <input type="hidden" id="order_update" value="{{ route('stock-orders.update_status')}}">
                            <input type="hidden" id="add_history" value="{{ route('stock-orders.add_history')}}">
                            <input type="hidden" id="route_name" value="{{ route('stock-orders.index') }}">
                            <table id="stockOrderTable" class="table table-bordered table-striped datatable-dynamic">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Supplier Information</th>
                                        <th>Brand</th>
                                        <th>Practice Information</th>
                                        <th>Status</th>
                                        <th>Date Created</th>
                                        <th>Date Received</th>
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

    <div id="status-histories-list" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Status History</h4>
                    <button type="button" class="close" data-dismiss="modal">×</button>
                </div>
                <div class="modal-body">
                    <div class="col-md-12">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Status</th>
                                    <!-- <th>Notes</th> -->
                                    <th>Updated By</th>
                                    <th>Updated Date</th>
                                </tr>
                            </thead>
                            <tbody class="status-histories-list-view">
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
    @include ('admin.stock-order.view-documents-list')
@endsection
@section('jquery')
<script type="text/javascript">
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

$('#commonModal').on('click', '.view-documents', function (event) {

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
                                <td>#${k+1}</td>
                                <td>${v.user.name}</td>
                                <td>${formattedCreatedAt}</td>
                                <td>`;

                    // Conditionally include the download button
                    if (v.document_path) {
                        html += `<a class="btn btn-sm btn-warning mr-1" href="${v.document_path}" download><i class="fa fa-download" aria-hidden="true"></i></a>`;
                    }

                    // Conditionally include the delete button based on stock order status
                    if ($('[name="stock_order_status"]').val() != 'completed') {
                        html += `<button class="btn btn-sm btn-danger deleteStockOrderDocumentRecord" data-id="${v.id}" type="button" data-type="receive_stock_order_document"><i class="fa fa-trash"></i></button>`;
                    }

                    html += `</td></tr>`;

                });
                $("#view-documents-list").find(".view-documents-list-view").html(html);
                $("#view-documents-list").modal("show");
            }
        }
    });
});

var receive_stock_orders_table;

function reloadStockOrdersTable() {

    // Destroy the existing DataTable, if it exists
    if ($.fn.DataTable.isDataTable('#receiveStockOrderTable')) {
        receive_stock_orders_table.destroy();
    }

    receive_stock_orders_table = $('#receiveStockOrderTable').DataTable({
        processing: true,
        serverSide: true,
        pageLength: 100,
        lengthMenu: [ 100, 200, 300, 400, 500, ],
        ajax: {
            url: $("#receive_route_name").val(),
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
            {data: 'created_at', "width": "18%", name: 'created_at'},
            {data: 'action', "width": "15%", orderable: false},
        ],
        "order": [[0, "DESC"]]
    });
}
</script>
@endsection