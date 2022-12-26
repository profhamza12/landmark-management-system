@extends('admin.layouts.layout')
@section('content')
<section class="content">
    <div class="content-header d-flex">
        <h4 class="details">
            <span><a href="">{{__('admin.dashboard')}}</a> / {{__('admin.languages')}}</a></span>
        </h4>
    </div>
    @if(Session::has('success'))
    <div class="alert alert-success w-100 text-center">{{Session::get('success')}}</div>
    @endif
    @if(Session::has('error'))
    <div class="alert alert-danger w-100 text-center">{{Session::get('error')}}</div>
    @endif
    <div class="container-fluid cards">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="card">
                    <div class="card-header">
                        <i class="fa-solid fa-list"></i><span>{{__('admin.languages')}}</span>
                    </div>
                    <div class="card-body table-holder">
                        {{ $dataTable->table() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
@section('datatable')
{{ $dataTable->scripts() }}
@endsection()