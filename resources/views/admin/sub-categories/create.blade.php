@extends('layouts.admin.template')
@section('maincontent')
    <div class="main-content content-large">
        <div class="wraper-content">
            <div class="row">
                <div class="col-sm-12 page-info">
                    <h2>{{trans('content.subCategories')}}</h2>
                    <div>
                        <a href="">{{trans('content.home')}}</a> -
                        <a href="">{{trans('content.subCategories')}}</a> -
                        <span>{{trans('content.addSubCat')}}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-data">
                    @if (\Illuminate\Support\Facades\Session::has('error'))
                        <button class="error btn btn-outline-danger btn-lg">{{\Illuminate\Support\Facades\Session::get('error')}}</button>
                    @endif
                    <form class="" name="add-subCat" action="{{route('sub-categories.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @isset($languages)
                            <div class="row tap">
                                <div class="col-ms-12 tap-links">
                                    @foreach($languages as $index => $lang)
                                        <a href="" class="btn @if($index == 0) active-link @endif" data-id="{{$lang->abbr}}">{{trans('content.'.$lang->abbr)}}</a>
                                    @endforeach
                                </div>
                                <div class="col-sm-12 tap-content">
                                    @foreach($languages as $index => $lang)
                                        <div class="tap-box {{$lang->abbr}} @if($index == 0) active-content @endif">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{trans('content.subcatname_'.$lang->abbr)}}</label>
                                                        <input type="text" name="subcat[name][{{$lang->abbr}}]" class="form-control" placeholder="{{trans('content.enterSubCatName')}}">
                                                        @error('subcat.name.' . $lang->abbr)
                                                        <small class="text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{trans('content.subcatdescription_'.$lang->abbr)}}</label>
                                                        <input type="text" name="subcat[description][{{$lang->abbr}}]" class="form-control" placeholder="{{trans('content.enterSubCatDescription')}}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        @endisset
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.mainCategory')}}</label>
                                    <select name="mainCat" class="form-select">
                                        <optgroup label="{{trans('content.entermainCategory')}}"></optgroup>
                                        @foreach($mainCats as $mainCat)
                                            <option value="{{$mainCat->id}}">{{$mainCat->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.subCategory')}}</label>
                                    <select name="subCat" class="form-select">
                                        <optgroup label="{{trans('content.entersubCategory')}}"></optgroup>
                                        <option value="0">{{trans('content.notHaveSubCat')}}</option>
                                        @foreach($subCats as $subCat)
                                            <option value="{{$subCat->id}}">{{$subCat->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="custom-file-upload">
                                        <div class="main-file">
                                            <input type="file" class="form-control" name="photo">
                                        </div>
                                        <div class="custom-file">
                                            <div class="sec1">
                                                <span>{{trans('content.chooseSubCatPhoto')}}</span>
                                            </div>
                                            <div class="sec2">
                                                <span>{{trans('content.upload')}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @error('photo')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group status">
                                    <input type="hidden" name="active" value="off">
                                    <input type="checkbox" name="active" checked data-toggle="toggle" data-on="{{trans('content.enabled')}}" data-off="{{trans('content.disabled')}}" data-onstyle="success" data-offstyle="danger">
                                </div>
                            </div>
                        </div>

                        <div class="row hr">
                            <div class="form-group">
                                <hr />
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <button class="btn-back btn btn-info text-light">
                                        <i class="fas fa-backspace"></i>
                                        {{trans('content.back')}}
                                    </button>
                                    <button class="btn btn-primary">
                                        <i class="fas fa-check"></i>
                                        {{trans('content.save')}}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop
@section('select2script')
    <script>
        // using select2 jquery plugin
        $("select").select2({
            dir: "{{\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocaleDirection()}}"
        });
    </script>
@stop
