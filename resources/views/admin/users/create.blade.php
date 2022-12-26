@extends('layouts.admin.template')
@section('maincontent')
    <div class="main-content content-large">
        <div class="wraper-content">
            <div class="row">
                <div class="col-sm-12 page-info">
                    <h2>{{trans('content.users')}}</h2>
                    <div>
                        <a href="">{{trans('content.home')}}</a> -
                        <a href="">{{trans('content.users')}}</a> -
                        <span>{{trans('content.addUser')}}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-data">
                    @if (\Illuminate\Support\Facades\Session::has('error'))
                        <button class="error btn btn-outline-danger btn-lg">{{\Illuminate\Support\Facades\Session::get('error')}}</button>
                    @endif
                    <form class="" name="add-user" action="{{route('users.store')}}" method="POST" enctype="multipart/form-data">
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
                                                    <label>{{trans('content.username_'.$lang->abbr)}}</label>
                                                    <input type="text" name="user[name][{{$lang->abbr}}]" class="form-control" placeholder="{{trans('content.enterUserName')}}">
                                                    @error('user.name.' . $lang->abbr)
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{trans('content.useraddress_'.$lang->abbr)}}</label>
                                                    <input type="text" name="user[address][{{$lang->abbr}}]" class="form-control" placeholder="{{trans('content.enterUserAddress')}}">
                                                    @error('user.address.' . $lang->abbr)
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
                                    <label>{{trans('content.useremail')}}</label>
                                    <input type="text" name="email" class="form-control" placeholder="{{trans('content.enterUserEmail')}}">
                                    @error('email')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.userpassword')}}</label>
                                    <input type="password" name="password" class="form-control" placeholder="{{trans('content.enterUserPassword')}}" autocomplete="off">
                                    @error('password')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.userphone')}}</label>
                                    <input type="text" name="phone" class="form-control" placeholder="{{trans('content.enterUserPhone')}}">
                                    @error('phone')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.usergroup')}}</label>
                                    <select name="roles[]" multiple class="form-select">
                                        <optgroup label="{{trans('content.enterUserGroup')}}"></optgroup>
                                        @foreach($roles as $role)
                                            <option value="{{$role->id}}">{{$role->display_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('roles')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.usergender')}}</label>
                                    <select name="gender" class="form-select">
                                        <optgroup label="{{trans('content.enterUserGender')}}"></optgroup>
                                        <option value="1">{{trans('content.male')}}</option>
                                        <option value="0">{{trans('content.female')}}</option>
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
                                                <span>{{trans('content.choosePhoto')}}</span>
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
                                <div class="form-group">
                                    <h5>{{trans('content.userpermission')}}</h5>
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
@section('select2script')
    <script>
        // using select2 jquery plugin
        $("select").select2({
            dir: "{{\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocaleDirection()}}"
        });
    </script>
@stop
