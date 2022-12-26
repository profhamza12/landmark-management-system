@extends('admin.layouts.layout')
@section('content')
<section class="content">
    <div class="content-header d-flex">
        <h4 class="details">
            <span><a href="">{{__('admin.dashboard')}}</a> / {{__('admin.add_lang')}}</a></span>
        </h4>
    </div>
    @if(Session::has('error'))
        <div class="alert alert-danger w-100 text-center">{{Session::get('error')}}</div>
    @endif    
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 col-md-12">
                <div class="tab">
                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="ar-tab" data-toggle="tab" data-tab="ar-pane" href="#home" role="tab" aria-controls="home" aria-selected="true">{{__('admin.add_lang_ar')}}</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="en-tab" data-toggle="tab" data-tab="en-pane" href="#home" role="tab" aria-controls="home" aria-selected="true">{{__('admin.add_lang_en')}}</a>
                        </li>
                    </ul>
                    <div class="tab-content" id="myTabContent">
                        <form action="{{route('languages.store')}}" method="post" enctype="">
                            @csrf
                            <div class="tab-pane" id="ar-pane" role="tabpanel">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">{{__('admin.lang_name_ar')}}</label>
                                        <input type="text" name="lang[name][ar]" class="form-control" placeholder="{{__('admin.lang_name')}}">
                                        @error('lang.name.ar')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="tab-pane hide" id="en-pane" role="tabpanel">
                                <div class="form-row">
                                    <div class="form-group col-md-6">
                                        <label for="inputEmail4">{{__('admin.lang_name_en')}}</label>
                                        <input type="text" name="lang[name][en]" class="form-control" placeholder="{{__('admin.lang_name')}}">
                                        @error('lang.name.en')
                                        <span class="text-danger">{{$message}}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <label>{{__('admin.lang_direction')}}</label>
                                    <select class="form-control" name="lang[direction]" multiple="multiple">
                                        <option value="ltr">{{__('admin.ltr')}}</option>
                                            ...
                                        <option value="rtl">{{__('admin.rtl')}}</option>
                                    </select>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>{{__('admin.lang_abbr')}}</label>
                                    <input type="text" name="lang[abbr]" class="form-control" placeholder="{{__('admin.lang_abbr')}}">
                                    @error('lang.abbr')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group">
                                    <div class="form-check">
                                    <input class="form-check-input" name="lang[active]" type="checkbox" id="gridCheck">
                                    <label class="form-check-label" for="gridCheck">
                                        {{__('admin.active')}}
                                    </label>
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">{{__('admin.add_btn')}}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection