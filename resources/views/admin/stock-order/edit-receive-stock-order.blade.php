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
                        <li class="breadcrumb-item active">Edit</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    {!! Form::hidden('stock_order_status', $receiveStockOrder->stock_order->status, []) !!}
    <section class="content">
        @include ('admin.common.error')
        <div class="row">
            <div class="col-md-12">
                @if($receiveStockOrder->stock_order->status!='completed')
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Edit Receive {{$menu}}</h3>
                        </div>
                        {!! Form::open(['url' => route('stock-orders.edit-receive-documents'), 'id' => 'stockOrdersForm', 'class' => 'form-horizontal','files'=>true]) !!}
                            <div class="card-body">
                                {!! Form::hidden('redirects_to', URL::previous()) !!}
                                {!! Form::hidden('stock_order_id', $receiveStockOrder->stock_order->id, []) !!}
                                {!! Form::hidden('stock_order_receive_id', $receiveStockOrder->id, []) !!}
                                <div class="row">

                                    <div class="col-md-6">
                                        <div class="form-group{{ $errors->has('inv_number') ? ' has-error' : '' }}">
                                            <label class="control-label" for="inv_number">Invoice Number : <span class="text-red"></span></label>
                                            {!! Form::text('inv_number', $receiveStockOrder->inv_number, ['class' => 'form-control', 'placeholder' => 'Enter Invoice Number', 'id' => 'inv_number']) !!}
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
                                            {!! Form::text('grv_number', $receiveStockOrder->grv_number, ['class' => 'form-control', 'placeholder' => 'Enter GRV Number', 'id' => 'grv_number']) !!}
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
                                            {!! Form::textarea('notes', $receiveStockOrder->notes, ['class' => 'form-control', 'placeholder' => 'Enter notes', 'rows' => 2, 'id' => 'notes']) !!}
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
                                                    @php $selected = ($key == $receiveStockOrder->stock_order->status) ? 'selected' : ''; @endphp
                                                    <option {{$selected}} value="{{$key}}">{{$statusName}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group{{ $errors->has('courier_tracking_number') ? ' has-error' : '' }}">
                                            <label class="control-label" for="courier_tracking_number">Courier & Tracking Number :</label>

                                            @php 
                                              $courier = null; 
                                              
                                              if(isset($receiveStockOrder['stock_order']) && !empty($receiveStockOrder['stock_order']['courier_tracking_number'])){
                                                $courier = $receiveStockOrder['stock_order']['courier_tracking_number'];
                                              }                                                
                                            @endphp

                                            {!! Form::text('courier_tracking_number', $courier, ['class' => 'form-control', 'placeholder' => 'Enter Courier & Tracking Number', 'id' => 'courier_tracking_number']) !!}
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
                                            @php 
                                              $checked = ''; 
                                              $disabled = ''; 
                                              if(isset($receiveStockOrder['stock_order']) && !empty($receiveStockOrder['stock_order']['is_delivered']) && $receiveStockOrder['stock_order']['is_delivered'] == 1){
                                                $checked = 'checked';
                                                $disabled = 'disabled';
                                              }                                                
                                            @endphp
                                            {!! Form::checkbox('is_delivered', null, $checked, [$disabled, 'class' => 'access-checkbox']) !!}
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
                                                    @if(count($receiveStockOrder->stock_order_receive_documents)>0)
                                                        @foreach ($receiveStockOrder->stock_order_receive_documents as $key => $document) 

                                                            <div class="col-md-3 documents-upload mb-1" id="documents_{{ $document->id }}">

                                                                <div class="file-upload-box">
                                                                    <h2>Download File</h2>
                                                                    <a download href="{{asset($document->document_name)}}" class="btn btn-info text-center btn-sm">
                                                                        <i class="fa fa-download"></i> Download
                                                                    </a>

                                                                    {!! Form::hidden("documents[old][$document->id]", $document->document_name) !!}

                                                                    <button type="button" class="btn btn-sm btn-danger deleteExp" onClick="removeDocument({{$document->id}}, 0)">
                                                                        <i class="fa fa-trash"></i> Delete
                                                                    </button>
                                                                </div>
                                                            </div>
                                                            @php
                                                            $documentCounter = $document->id;
                                                            @endphp
                                                        @endforeach
                                                    @else
                                                        <div class="col-md-3 documents-upload mb-1" id="documents_1">

                                                            <div class="file-upload-box">
                                                                <h2>Upload File</h2>

                                                                {!! Form::file("documents[new][1]", ['class' => 'file-input', 'id' => 'fileInput_1']) !!}

                                                                <label for="fileInput_1" class="upload-label mb-0"><span class="btn btn-sm btn-info"><i class="fa fa-upload"></i> Choose File</span></label>
                                                            </div>
                                                        </div>
                                                    @endif
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
                                <a href="{{ url('admin/stock-orders/'.$receiveStockOrder->stock_order->id.'/receive') }}" class="btn btn-sm btn-default"><i class="fa fa-arrow-left pr-1"></i> Back</a>
                                <button class="btn btn-sm btn-info float-right" type="submit"><i class="fa fa-edit pr-1"></i> Update</button>
                            </div>
                        {!! Form::close() !!}
                    </div>
                @else
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <h3 class="card-title">Receive {{$menu}}</h3>
                        </div>
                        {!! Form::model($receiveStockOrder->stock_order, ['route' => ['stock-orders.update_status'], 'method' => 'post', 'id' => 'stockOrdersForm', 'class' => 'form-horizontal', 'files' => true]) !!}

                            <div class="card-body">
                                {!! Form::hidden('redirects_to', URL::previous()) !!}
                                {!! Form::hidden('id', $receiveStockOrder->stock_order->id, []) !!}
                               
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                            <label class="control-label" for="status">Stock Order Status :</label>
                                            <select class="form-control" name="status" id="status">
                                                @foreach($stock_order_status as $key => $statusName)
                                                    @php $selected = (key == $receiveStockOrder->stock_order->status) ? 'selected' : ''; @endphp
                                                    <option {{$selected}} value="{{$key}}">{{$statusName}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-footer">
                                <a href="{{ route('stock-orders.index') }}" class="btn btn-sm btn-default"><i class="fa fa-arrow-left pr-1"></i> Back</a>
                                <button class="btn btn-sm btn-info float-right" type="submit"><i class="fa fa-edit pr-1"></i> Update</button>
                            </div>
                        {!! Form::close() !!}
                    </div>
                @endif

                <input type="hidden" id="route_name" value="{{ route('stock-orders.index_receive_stock_order') }}">
                <input type="hidden" id="stock_order_id" value="{{$receiveStockOrder->stock_order->id}}">
            </div>
        </div>
    </section>
</div>
<input type="hidden" id="documentCounter" value="{{$documentCounter}}">
@endsection