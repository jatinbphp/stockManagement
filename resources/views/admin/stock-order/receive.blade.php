@extends('admin.layouts.app')
@section('content')
@php
$documentCounter = 1;
@endphp
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
              <li class="breadcrumb-item active">Add</li>
            </ol>
          </div>
        </div>
      </div>
    </section>

    {!! Form::hidden('stock_order_status', $stockOrder->status, []) !!}
    <section class="content">
      @include ('admin.common.error')
      <div class="row">
        <div class="col-md-12">
          @if($stockOrder->status!='completed')
          <div class="card card-info card-outline">
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
                    <label class="control-label" for="inv_number">Invoice Number : <span class="text-red"></span></label>
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
                    <label class="control-label" for="grv_number">GRV Number : <span class="text-red"></span></label>
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
                <div class="col-md-4">
                  <div class="form-group{{ $errors->has('stock_order_status') ? ' has-error' : '' }}">
                    <label class="control-label" for="stock_order_status">Stock Order Status :</label>
                    <select class="form-control" name="stock_order_status" id="stock_order_status">
                      @foreach($stock_order_status as $key => $statusName)
                      @php $selected = ($key == $stockOrder->status) ? 'selected' : ''; @endphp
                      <option {{$selected}} value="{{$key}}">{{$statusName}}</option>
                      @endforeach
                    </select>
                    @if ($errors->has('stock_order_status'))
                    <span class="text-danger">
                      <strong>{{ $errors->first('stock_order_status') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>                
                <div class="col-md-4">
                  <div class="form-group{{ $errors->has('courier_tracking_number') ? ' has-error' : '' }}">
                    <label class="control-label" for="courier_tracking_number">Courier & Tracking Number :</label>
                    {!! Form::text('courier_tracking_number', null, ['class' => 'form-control', 'placeholder' => 'Enter Courier & Tracking Number', 'id' => 'courier_tracking_number']) !!}
                    @if ($errors->has('courier_tracking_number'))
                    <span class="text-danger">
                      <strong>{{ $errors->first('courier_tracking_number') }}</strong>
                    </span>
                    @endif
                  </div>
                </div>
                <div class="col-md-4">
                  <label class="control-label" for="is_delivered">Stock Delivered :</label>
                  <label class="checkbox-label">
                    {!! Form::checkbox('is_delivered', null, null, ['class' => 'access-checkbox']) !!}
                    <span class="checkmark"></span>
                  </label>
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

                      <div class="row">

                        <div class="col-md-3 documents-upload mb-1" id="documents_1">

                          <div class="file-upload-box">
                            <h2>Upload File</h2>

                            {!! Form::file("documents[new][1]", ['class' => 'file-input', 'id' => 'fileInput_1']) !!}

                            <label for="fileInput_1" class="upload-label mb-0"><span class="btn btn-sm btn-info"><i class="fa fa-upload"></i> Choose File</span></label>
                          </div>
                        </div>

                        <div class="col-md-3" id="documentBtn">
                          <div class="file-upload-box">
                            <h2>Add File</h2>
                            <label class="upload-label mb-0">
                              <span class="btn btn-sm btn-info">
                                <i class="fa fa-plus"></i> Add New
                              </span>
                            </label>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer">
              @include('admin.common.footer-buttons', ['route' => 'stock-orders.index', 'type' => 'create'])
            </div>
            {!! Form::close() !!}
          </div>
          @else 
          <div class="card card-info card-outline">
            <div class="card-header">
              <h3 class="card-title">Receive {{$menu}}</h3>
            </div>
            {!! Form::model($stockOrder, ['route' => ['stock-orders.update_status'], 'method' => 'post', 'id' => 'stockOrdersForm', 'class' => 'form-horizontal', 'files' => true]) !!}

            <div class="card-body">
              {!! Form::hidden('redirects_to', URL::previous()) !!}
              {!! Form::hidden('id', $stockOrder->id, []) !!}

              <div class="row">
                <div class="col-md-12">
                  <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                    <label class="control-label" for="status">Stock Order Status :</label>
                    <select class="form-control" name="status" id="status">
                      @foreach($stock_order_status as $key => $statusName)
                      @php $selected = ($key == $stockOrder->status) ? 'selected' : ''; @endphp
                      <option {{$selected}} value="{{$key}}">{{$statusName}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
              </div>
            </div>
            <div class="card-footer">
              @include('admin.common.footer-buttons', ['route' => 'stock-orders.index', 'type' => 'create'])
            </div>
            {!! Form::close() !!}
          </div>
          @endif

          <div class="card card-info card-outline">
            <div class="card-header">
              <h3 class="card-title">Uploaded Documents</h3>
            </div>
            <div class="card-body table-responsive">
              <input type="hidden" id="route_name" value="{{ route('stock-orders.index_receive_stock_order') }}">
              <input type="hidden" id="stock_order_id" value="{{$stockOrder->id}}">
              @include ('admin.stock-order.receive-stock-order-table')
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <input type="hidden" id="documentCounter" value="{{$documentCounter}}">
  @include ('admin.stock-order.view-documents-list')
@endsection

@section('jquery')
<script type="text/javascript">
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
                {data: 'stock_order.courier_tracking_number', name: 'stock_order.courier_tracking_number'},
                {data: 'notes', name: 'notes'},
                {data: 'created_at', "width": "18%", name: 'created_at'},
                {data: 'action', "width": "15%", orderable: false},
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
  });
</script>
@endsection