@extends('layouts.admin.template')
@section('maincontent')
    <div class="main-content content-large">
        <div class="wraper-content">
            <div class="row">
                <div class="col-sm-12 page-info">
                    <h2>{{trans('content.roles')}}</h2>
                    <div>
                        <a href="">{{trans('content.home')}}</a> -
                        <a href="">{{trans('content.roles')}}</a> -
                        <span>{{trans('content.addGroup')}}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-data">
                    @if (\Illuminate\Support\Facades\Session::has('error'))
                        <button class="error btn btn-outline-danger btn-lg">{{\Illuminate\Support\Facades\Session::get('error')}}</button>
                    @endif
                    <form class="" name="add-group" action="{{route('roles.store')}}" method="POST" enctype="application/x-www-form-urlencoded">
                        @csrf
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
                                                    <label>{{trans('content.groupdisplayname_'.$lang->abbr)}}</label>
                                                    <input type="text" name="role[display_name][{{$lang->abbr}}]" class="form-control" placeholder="{{trans('content.enterGroupDisplayName')}}">
                                                    @error('role.display_name.' . $lang->abbr)
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{trans('content.groupdescription_'.$lang->abbr)}}</label>
                                                    <input type="text" name="role[description][{{$lang->abbr}}]" class="form-control" placeholder="{{trans('content.enterGroupDescription')}}">
                                                    @error('role.description.' . $lang->abbr)
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.groupname')}}</label>
                                    <input type="text" name="name" class="form-control" placeholder="{{trans('content.enterGroupName')}}">
                                    @error('name')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <h5>{{trans('content.permissions')}}</h5>
                                    @foreach($permissions as $permission)
                                        <div class="form-check">
                                            <input class="form-check-input" type="checkbox" name="permission[]" value="{{$permission->id}}" id="check{{$permission->id}}">
                                            <label class="form-check-label" for="check{{$permission->id}}">
                                                {{$permission->display_name}}
                                            </label>
                                        </div>
                                    @endforeach
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
