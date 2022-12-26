@extends('layouts.admin.template')
@section('maincontent')
    <div class="main-content content-large">
        <div class="wraper-content">
            <div class="row">
                <div class="col-sm-12 page-info">
                    <h2>{{trans('content.employees')}}</h2>
                    <div>
                        <a href="">{{trans('content.home')}}</a> -
                        <a href="">{{trans('content.employees')}}</a> -
                        <span>{{trans('content.addEmployee')}}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-data">
                    @if (\Illuminate\Support\Facades\Session::has('error'))
                        <button class="error btn btn-outline-danger btn-lg">{{\Illuminate\Support\Facades\Session::get('error')}}</button>
                    @endif
                    <form class="" name="add-employee" action="{{route('employees.store')}}" method="POST" enctype="multipart/form-data">
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
                                                    <label>{{trans('content.employeename_'.$lang->abbr)}}</label>
                                                    <input type="text" name="employee[name][{{$lang->abbr}}]" class="form-control" placeholder="{{trans('content.enterEmployeeName')}}">
                                                    @error('employee.name.' . $lang->abbr)
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{trans('content.employeeaddress_'.$lang->abbr)}}</label>
                                                    <input type="text" name="employee[address][{{$lang->abbr}}]" class="form-control" placeholder="{{trans('content.enterEmployeeAddress')}}">
                                                    @error('employee.address.' . $lang->abbr)
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{trans('content.employeegovernorate_'.$lang->abbr)}}</label>
                                                    <input type="text" name="employee[governorate][{{$lang->abbr}}]" class="form-control" placeholder="{{trans('content.enterEmployeeGovernorate')}}">
                                                    @error('employee.governorate.' . $lang->abbr)
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{trans('content.employeeposition_'.$lang->abbr)}}</label>
                                                    <input type="text" name="employee[position][{{$lang->abbr}}]" class="form-control" placeholder="{{trans('content.enterEmployeePosition')}}">
                                                    @error('employee.position.' . $lang->abbr)
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{trans('content.qualification_'.$lang->abbr)}}</label>
                                                    <input type="text" name="employee[qualification][{{$lang->abbr}}]" class="form-control" placeholder="{{trans('content.enterQualification')}}">
                                                    @error('employee.qualification.' . $lang->abbr)
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
                                    <label>{{trans('content.employeephone')}}</label>
                                    <input type="text" name="phone" class="form-control" placeholder="{{trans('content.enterEmployeePhone')}}">
                                    @error('phone')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.salary')}}</label>
                                    <input type="number" name="salary" class="form-control" placeholder="{{trans('content.enterSalary')}}">
                                    @error('salary')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.employeetarget')}}</label>
                                    <input type="number" name="target" class="form-control" placeholder="{{trans('content.enterTarget')}}">
                                    @error('target')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.employeeCommission') . " (%) "}}</label>
                                    <input type="number" name="commission" class="form-control" placeholder="{{trans('content.enterCommission')}}">
                                    @error('commission')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.national_id')}}</label>
                                    <input type="number" name="national_id" class="form-control" placeholder="{{trans('content.enterNationalId')}}">
                                    @error('national_id')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.insurance_number')}}</label>
                                    <input type="number" name="insurance_number" class="form-control" placeholder="{{trans('content.enterInsuranceNumber')}}">
                                    @error('insurance_number')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.joined_date')}}</label>
                                    <input type="date" name="created_at" class="form-control">
                                    @error('created_at')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.date_of_birth')}}</label>
                                    <input type="date" name="date_of_birth" class="form-control">
                                    @error('date_of_birth')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.employeegender')}}</label>
                                    <select name="gender" class="form-select">
                                        <optgroup label="{{trans('content.enterEmployeeGender')}}"></optgroup>
                                        <option value="1">{{trans('content.male')}}</option>
                                        <option value="0">{{trans('content.female')}}</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.branch')}}</label>
                                    <select name="branch" class="form-select">
                                        <optgroup label="{{trans('content.enterBranch')}}"></optgroup>
                                        <option disabled selected></option>
                                        @foreach($branches as $branch)
                                            <option value="{{$branch->id}}">{{$branch->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('branch')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.group')}}</label>
                                    <select name="groups[]" class="form-select" multiple>
                                        <optgroup label="{{trans('content.enterGroup')}}"></optgroup>
                                        <option disabled></option>
                                        @foreach($groups as $group)
                                            <option value="{{$group->id}}">{{$group->display_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('groups')
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
