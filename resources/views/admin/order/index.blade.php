@extends('admin.layouts.app')

@section('content')
<div class="content-wrapper">
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>{{ $menu }}</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                        <li class="breadcrumb-item active">{{ $menu }}</li>
                    </ol>
                </div>
            </div>
        </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
        <div class="row">
            <div class="col-12">
                <div class="card card-info card-outline">
                    <div class="card-header">
                        <!-- <h3 class="card-title">Order Listing</h3> -->
                        <div class="row">
                            <div class="col-md-12">
                                <a href="{{ route('orders.create') }}" class="btn btn-info float-right"><i class="fa fa-plus pr-1"></i> Add New</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                         <input type="hidden" id="route_name" value="{{ route('orders.index')}}">
                        <table id="ordersTable" class="table table-bordered table-striped datatable-dynamic">
                            <thead>
                                <tr>
                                    <th>Order ID</th>
                                    <th>User Name</th>
                                    <th>User Email</th>
                                    <th>Total Amount</th>
                                    <th style="width: 10%;">Status</th>
                                    <th style="width: 10%;">Action</th>
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
@endsection
@section('jquery')
<script>
    $(document).ready(function() {
        $('#ordersTable tbody').on('change', '.orderStatus', function (event) {
            event.preventDefault();
            var orderId = $(this).attr('data-id');
            var status = $(this).val();
            swal({
                title: "Are you sure?",
                text: "To update status of this order",
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: '#17a2b8',
                confirmButtonText: 'Yes, Sure',
                cancelButtonText: "No, cancel",
                closeOnConfirm: false,
                closeOnCancel: false
            },
            function(isConfirm) {
                if (isConfirm) {
                    $.ajax({
                        url: "{{ route('orders.update', ':orderId') }}".replace(':orderId', orderId),
                        type: "post",
                        data: {'_method': 'put', 'status': status, '_token': $('meta[name=_token]').attr('content') },
                        success: function(data){
                            if(data.status == 1){
                                swal("Success", "Order status is updated", "success");
                            } else {
                                swal("Error", "Something is wrong!", "error");
                            }
                        }
                    });
                } else {
                    swal("Cancelled", "Your data is safe!", "error");
                }
            });
        }); 
    });
</script>

@endsection
