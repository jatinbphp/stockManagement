@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-3 col-6 mt-3">
                        <div class="small-box bg-info">
                            <div class="inner">
                                <h3>{{$users}}</h3>
                                <p>Total Users</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-users"></i>
                            </div>
                            <a href="{{route('users.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 mt-3">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>{{$suppliers}}</h3>
                                <p>Total Suppliers</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-truck"></i>
                            </div>
                            <a href="{{route('suppliers.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 mt-3">
                        <div class="small-box bg-warning">
                            <div class="inner">
                                <h3>{{$brands}}</h3>
                                <p>Total Brands</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-boxes"></i>
                            </div>
                            <a href="{{route('brands.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-6 mt-3">
                        <div class="small-box bg-danger">
                            <div class="inner">
                                <h3>{{$practices}}</h3>
                                <p>Total Practices</p>
                            </div>
                            <div class="icon">
                                <i class="fa fa-folder"></i>
                            </div>
                            <a href="{{route('practices.index')}}" class="small-box-footer">More info <i class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
@section('jquery')
<script>

</script>
@endsection
