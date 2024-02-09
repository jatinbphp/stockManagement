@extends('admin.layouts.app')
@section('content')
    <div class="content-wrapper" style="min-height: 946px;">
        <section class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1>Import {{$menu}}</h1>
                    </div>
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="{{route('products.index')}}">{{$menu}}</a></li>
                            <li class="breadcrumb-item active">Add</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">
            @include ('admin.error')
            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title w-100">
                                Import {{$menu}}

                                <a href="{{ url('uploads/productImport.csv') }}" class="float-right" download><i class="fa fa-download"></i> Download Sample File</a>
                            </h3>
                        </div>
                        {!! Form::open(['url' => route('products.import.product.store'), 'id' => 'productsImportForm', 'class' => 'form-horizontal','files'=>true]) !!}
                        <div class="card-body">
                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group{{ $errors->has('file') ? ' has-error' : '' }}">
                                        <label class="col-md-12 control-label" for="file">Upload CSV File<span class="text-red">*</span></label>
                                        <div class="col-md-12">
                                            <div class="fileError">
                                                {!! Form::file('file', ['class' => '', 'id'=> 'file', 'accept' => 'text/csv']) !!}
                                            </div>
                                            @if ($errors->has('file'))
                                                <span class="text-danger">
                                                    <strong>{{ $errors->first('file') }}</strong>
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                        <div class="card-footer">
                            <a href="{{ route('products.index') }}" class="btn btn-default">Back</a>
                            <button class="btn btn-info float-right" type="submit">Import</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
