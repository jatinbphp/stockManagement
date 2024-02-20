@extends('admin.layouts.app')
@section('content')
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
            @include ('admin.error')
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            {!! Form::open(['url' => null, 'id' => 'stock-orders-filter-Form', 'class' => 'form-horizontal','files'=>true]) !!}
                                @include ('admin.stock-order.filter')
                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="card card-info card-outline">
                        <div class="card-header">
                            <div class="row">
                                <div class="col-md-12">
                                    <a href="{{ route('stock-orders.create') }}" class="btn btn-info float-right">Add New</a>
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

    <div id="status-histories-list" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Status Histories</h4>
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
</script>
@endsection