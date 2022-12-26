@extends('layouts.admin.template')
@section('maincontent')
    <div class="main-content content-large">
        <div class="wraper-content">
            <div class="row">
                <div class="col-sm-12 page-info">
                    <h2>{{trans('content.company_branches')}}</h2>
                    <div>
                        <a href="">{{trans('content.home')}}</a> -
                        <a href="">{{trans('content.company_branches')}}</a> -
                        <span>{{trans('content.editBranch')}}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-data">
                    @if (\Illuminate\Support\Facades\Session::has('error'))
                        <button class="error btn btn-outline-danger btn-lg">{{\Illuminate\Support\Facades\Session::get('error')}}</button>
                    @endif
                    <form class="" name="edit-branch" action="{{route('branches.update', $branch->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
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
                                                        <label>{{trans('content.branchname_'.$lang->abbr)}}</label>
                                                        <input type="text" name="branch[name][{{$lang->abbr}}]" class="form-control" placeholder="{{trans('content.enterBranchName')}}" value="{{@$translations['name'][$lang->abbr]}}">
                                                        @error('branch.name.' . $lang->abbr)
                                                        <small class="text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{trans('content.branchaddress_'.$lang->abbr)}}</label>
                                                        <input type="text" name="branch[address][{{$lang->abbr}}]" class="form-control" placeholder="{{trans('content.enterBranchAddress')}}" value="{{@$translations['address'][$lang->abbr]}}">
                                                        @error('branch.address.' . $lang->abbr)
                                                        <small class="text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{trans('content.branchcountry_'.$lang->abbr)}}</label>
                                                        <input type="text" name="branch[country][{{$lang->abbr}}]" class="form-control" placeholder="{{trans('content.enterBranchCountry')}}" value="{{@$translations['country'][$lang->abbr]}}">
                                                        @error('branch.country.' . $lang->abbr)
                                                        <small class="text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{trans('content.branchgovernorate_'.$lang->abbr)}}</label>
                                                        <input type="text" name="branch[governorate][{{$lang->abbr}}]" class="form-control" placeholder="{{trans('content.enterBranchGovernorate')}}" value="{{@$translations['governorate'][$lang->abbr]}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{trans('content.branchposition_'.$lang->abbr)}}</label>
                                                        <input type="text" name="branch[position][{{$lang->abbr}}]" class="form-control" placeholder="{{trans('content.enterBranchPosition')}}" value="{{@$translations['position'][$lang->abbr]}}">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{trans('content.activity_'.$lang->abbr)}}</label>
                                                        <input type="text" name="branch[activity][{{$lang->abbr}}]" class="form-control" placeholder="{{trans('content.enterActivityName')}}" value="{{@$translations['activity'][$lang->abbr]}}">
                                                        @error('branch.activity.' . $lang->abbr)
                                                        <small class="text-danger">{{$message}}</small>
                                                        @enderror
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
                                    <label>{{trans('content.branchphone')}}</label>
                                    <input type="text" name="phone" class="form-control" placeholder="{{trans('content.enterBranchPhone')}}" value="{{@$branch->phone}}">
                                    @error('phone')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.branchemail')}}</label>
                                    <input type="text" name="email" class="form-control" placeholder="{{trans('content.enterBranchEmail')}}" value="{{@$branch->email}}">
                                    @error('email')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.branchweb')}}</label>
                                    <input type="text" name="website" class="form-control" placeholder="{{trans('content.enterBranchWeb')}}" value="{{@$branch->website}}">
                                    @error('website')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.finance_year')}}</label>
                                    <input type="text" name="finance_year" class="form-control" placeholder="{{trans('content.enterFinanceYear')}}" value="{{@$branch->finance_year}}">
                                    @error('finance_year')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
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
                                                <span>{{trans('content.chooseNewBranchPhoto')}}</span>
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
                                    <input type="checkbox" name="active" @if($branch->active == 1) checked @endif data-toggle="toggle" data-on="{{trans('content.enabled')}}" data-off="{{trans('content.disabled')}}" data-onstyle="success" data-offstyle="danger">
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
