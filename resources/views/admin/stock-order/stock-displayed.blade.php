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
                
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <h3 class="card-title">Receive {{$menu}}</h3>
                    </div>
                    {!! Form::model($stockOrder, ['route' => ['stock-orders.update_stock_displayed_status'], 'method' => 'post', 'id' => 'stockOrdersForm', 'class' => 'form-horizontal', 'files' => true]) !!}

                        <div class="card-body">
                            {!! Form::hidden('redirects_to', URL::previous()) !!}
                            {!! Form::hidden('id', $stockOrder->id, []) !!}
                           
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="form-group{{ $errors->has('status') ? ' has-error' : '' }}">
                                        <label class="control-label" for="status">Stock Order Status Part 1 :</label>
                                        <select class="form-control" name="status" id="status" readonly>
                                            @foreach($stock_order_status as $key => $statusName)
                                                @php $selected = ($key == $stockOrder->status) ? 'selected' : ''; @endphp
                                                <option {{$selected}} value="{{$key}}">{{$statusName}}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group{{ $errors->has('displayed_status') ? ' has-error' : '' }}">
                                        <label class="control-label" for="displayed_status">Stock Order Status Part 2:</label>
                                        <select class="form-control" name="displayed_status" id="displayed_status">
                                            <option value="">Please Select</option>
                                            @foreach($stock_displayed_status as $key => $statusName)
                                                @php $selected = ($key == $stockOrder->displayed_status) ? 'selected' : ''; @endphp
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
            </div>
        </div>
    </section>
</div>
@endsection

@section('jquery')
<script type="text/javascript">
</script>
@endsection