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
                            <li class="breadcrumb-item"><a href="{{route('users.index')}}">{{$menu}}</a></li>
                            <li class="breadcrumb-item active">Edit</li>
                        </ol>
                    </div>
                </div>
            </div>
        </section>

        <section class="content">

            <div class="row">
                <div class="col-md-12">
                    <div class="card card-info">
                        <div class="card-header">
                            <h3 class="card-title">Edit {{$menu}}</h3>
                        </div>
                        {!! Form::model($content,['url' => route('content.update',['content'=>$content->id]),'method'=>'patch','id' => 'contentForm','class' => 'form-horizontal','files'=>true]) !!}
                        <div class="card-body">
                            @include ('admin.content.form')
                        </div>
                        <div class="card-footer">
                            <a href="{{ route('content.index') }}" class="btn btn-default">Back</a>
                            <button class="btn btn-info float-right" type="submit">Update</button>
                        </div>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

