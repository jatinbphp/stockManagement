@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                @include ('admin.common.error')

                <div class="row">
                    @if(in_array('users', getAccessRights()))
                        <div class="col-12 col-sm-6 col-md-3 mt-2">
                            <div class="info-box">
                                <span class="info-box-icon bg-info elevation-1">
                                    <i class="fas fa-users">
                                    </i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Stock Clerk</span>
                                    <span class="info-box-number">{{$total_stock_clerk}}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-12 col-sm-6 col-md-3 mt-2">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-danger elevation-1">
                                    <i class="fas fa-boxes">
                                    </i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Accountant</span>
                                    <span class="info-box-number">{{$total_accountant}}</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(in_array('suppliers', getAccessRights()))
                        <div class="col-12 col-sm-6 col-md-3 mt-2">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-success elevation-1">
                                    <i class="fas fa-truck">
                                    </i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Suppliers</span>
                                    <span class="info-box-number">{{$total_suppliers}}</span>
                                </div>
                            </div>
                        </div>
                    @endif

                    @if(in_array('stock-orders', getAccessRights()))
                        <div class="col-12 col-sm-6 col-md-3 mt-2">
                            <div class="info-box mb-3">
                                <span class="info-box-icon bg-warning elevation-1">
                                    <i class="fas fa-folder">
                                    </i>
                                </span>
                                <div class="info-box-content">
                                    <span class="info-box-text">Total Stock Orders</span>
                                    <span class="info-box-number">{{$total_stock_orders}}</span>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                @if(in_array('stock-orders', getAccessRights()))
                    <div class="row">
                        <div class="col-12">
                            <div class="card card-info card-outline">
                                <div class="card-header">
                                    <h3 class="card-title">Latest Stock Orders</h3>
                                </div>
                                <div class="card-body table-responsive">
                                    <input type="hidden" id="route_name" value="{{ route('stock-orders.index_dashboard') }}">
                                    <table id="dashboardStockOrderTable" class="table table-bordered table-striped datatable-dynamic">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Supplier Information</th>
                                                <th>Brand</th>
                                                <th>Practice Information</th>
                                                <th>Status</th>
                                                <th>Stock Displayed</th>
                                                <th>Date Created</th>
                                                <th>Date Received</th>
                                                <th>Date Displayed</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </section>
    </div>
@endsection