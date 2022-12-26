@extends('layouts.admin.template')
@section('maincontent')
    <div class="main-content content-large">
        <div class="wraper-content">
            <div class="row">
                <div class="col-sm-12 page-info">
                    <h2>{{trans('content.vendors')}}</h2>
                    <div>
                        <a href="">{{trans('content.home')}}</a> -
                        <a href="">{{trans('content.vendors')}}</a> -
                        <span>{{trans('content.editVendor')}}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-data">
                    @if (\Illuminate\Support\Facades\Session::has('error'))
                        <button class="error btn btn-outline-danger btn-lg">{{\Illuminate\Support\Facades\Session::get('error')}}</button>
                    @endif
                    <form class="" name="edit-vendor" action="{{route('vendors.update', $vendor->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
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
                                                    <label>{{trans('content.vendorname_'.$lang->abbr)}}</label>
                                                    <input type="text" name="vendor[name][{{$lang->abbr}}]" class="form-control" placeholder="{{trans('content.enterVendorName')}}" value="{{@$translations['name'][$lang->abbr]}}">
                                                    @error('vendor.name.' . $lang->abbr)
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{trans('content.vendoraddress_'.$lang->abbr)}}</label>
                                                    <input type="text" name="vendor[address][{{$lang->abbr}}]" class="form-control" placeholder="{{trans('content.enterVendorAddress')}}" value="{{@$translations['address'][$lang->abbr]}}">
                                                    @error('vendor.address.' . $lang->abbr)
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{trans('content.vendorGovernorate_'.$lang->abbr)}}</label>
                                                    <input type="text" name="vendor[governorate][{{$lang->abbr}}]" class="form-control" placeholder="{{trans('content.enterVendorGovernorate')}}" value="{{@$translations['governorate'][$lang->abbr]}}">
                                                    @error('vendor.governorate.' . $lang->abbr)
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{trans('content.vendorPosition_'.$lang->abbr)}}</label>
                                                    <input type="text" name="vendor[position][{{$lang->abbr}}]" class="form-control" placeholder="{{trans('content.enterVendorPosition')}}" value="{{@$translations['position'][$lang->abbr]}}">
                                                    @error('vendor.position.' . $lang->abbr)
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
                                    <label>{{trans('content.vendoremail')}}</label>
                                    <input type="text" name="email" class="form-control" placeholder="{{trans('content.enterVendorEmail')}}" value="{{@$vendor->email}}">
                                    @error('email')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.vendorpassword')}}</label>
                                    <input type="password" name="password" class="form-control" placeholder="{{trans('content.enterVendorPassword')}}">
                                    @error('password')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.vendorphone')}}</label>
                                    <input type="text" name="phone" class="form-control" placeholder="{{trans('content.enterVendorPhone')}}" value="{{@$vendor->phone}}">
                                    @error('phone')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.creditor_amount')}}</label>
                                    <input type="number" name="creditor_amount" class="form-control" value="{{@$vendor->creditor_amount}}">
                                    @error('creditor_amount')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.debtor_amount')}}</label>
                                    <input type="number" name="debtor_amount" class="form-control" value="{{@$vendor->debtor_amount}}">
                                    @error('debtor_amount')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.InvoiceType')}}</label>
                                    <select name="invoice_type" class="form-select">
                                        <optgroup label="{{trans('content.enterInvoiceType')}}"></optgroup>
                                        <option disabled selected></option>
                                        @foreach($invoice_types as $invoice_type)
                                            <option value="{{$invoice_type->id}}" @if($vendor->invoice_type == $invoice_type->id) selected @endif>{{$invoice_type->display_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.vendorgender')}}</label>
                                    <select name="gender" class="form-select">
                                        <optgroup label="{{trans('content.enterVendorGender')}}"></optgroup>
                                        <option value="1" @if($vendor->gender == 1) selected @endif>{{trans('content.male')}}</option>
                                        <option value="0" @if($vendor->gender == 0) selected @endif>{{trans('content.female')}}</option>
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
                                                <span>{{trans('content.chooseNewVendorPhoto')}}</span>
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
                                    <input type="checkbox" name="active" @if($vendor->name) checked @endif data-toggle="toggle" data-on="{{trans('content.enabled')}}" data-off="{{trans('content.disabled')}}" data-onstyle="success" data-offstyle="danger">
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
