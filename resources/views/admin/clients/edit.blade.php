@extends('layouts.admin.template')
@section('maincontent')
    <div class="main-content content-large">
        <div class="wraper-content">
            <div class="row">
                <div class="col-sm-12 page-info">
                    <h2>{{trans('content.clients')}}</h2>
                    <div>
                        <a href="">{{trans('content.home')}}</a> -
                        <a href="">{{trans('content.clients')}}</a> -
                        <span>{{trans('content.editClient')}}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-data">
                    @if (\Illuminate\Support\Facades\Session::has('error'))
                        <button class="error btn btn-outline-danger btn-lg">{{\Illuminate\Support\Facades\Session::get('error')}}</button>
                    @endif
                    <form class="" name="edit-client" action="{{route('clients.update', $client->id)}}" method="POST" enctype="application/x-www-form-urlencoded">
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
                                                    <label>{{trans('content.clientname_'.$lang->abbr)}}</label>
                                                    <input type="text" name="client[name][{{$lang->abbr}}]" class="form-control" placeholder="{{trans('content.enterClientName')}}" value="{{@$translations['name'][$lang->abbr]}}">
                                                    @error('client.name.' . $lang->abbr)
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{trans('content.clientaddress_'.$lang->abbr)}}</label>
                                                    <input type="text" name="client[address][{{$lang->abbr}}]" class="form-control" placeholder="{{trans('content.enterClientAddress')}}" value="{{@$translations['address'][$lang->abbr]}}">
                                                    @error('client.address.' . $lang->abbr)
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{trans('content.clientGovernorate_'.$lang->abbr)}}</label>
                                                    <input type="text" name="client[governorate][{{$lang->abbr}}]" class="form-control" placeholder="{{trans('content.enterClientGovernorate')}}" value="{{@$translations['governorate'][$lang->abbr]}}">
                                                    @error('client.governorate.' . $lang->abbr)
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{trans('content.clientPosition_'.$lang->abbr)}}</label>
                                                    <input type="text" name="client[position][{{$lang->abbr}}]" class="form-control" placeholder="{{trans('content.enterClientPosition')}}" value="{{@$translations['position'][$lang->abbr]}}">
                                                    @error('client.position.' . $lang->abbr)
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
                                    <label>{{trans('content.clientemail')}}</label>
                                    <input type="text" name="email" class="form-control" placeholder="{{trans('content.enterClientEmail')}}" value="{{$client->email}}">
                                    @error('email')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.clientphone')}}</label>
                                    <input type="text" name="phone" class="form-control" placeholder="{{trans('content.enterClientPhone')}}" value="{{$client->phone}}">
                                    @error('phone')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.creditor_amount')}}</label>
                                    <input type="number" name="creditor_amount" class="creditor_amount form-control" value="{{@$client->creditor_amount}}">
                                    @error('creditor_amount')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.debtor_amount')}}</label>
                                    <input type="number" name="debtor_amount" class="debtor_amount form-control" value="{{@$client->debtor_amount}}">
                                    @error('debtor_amount')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.clientgroup')}}</label>
                                    <select name="group_id" class="form-select">
                                        <optgroup label="{{trans('content.enterClientGroup')}}"></optgroup>
                                        @foreach($groups as $group)
                                            <option value="{{$group->id}}" @if($client->group->id == $group->id) selected @endif>{{$group->display_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.InvoiceType')}}</label>
                                    <select name="invoice_type" class="invoice_type form-select">
                                        <optgroup label="{{trans('content.enterInvoiceType')}}"></optgroup>
                                        @foreach($invoice_types as $group)
                                            <option value="{{$group->id}}" data-name="{{$group->name}}" @if($client->invoice_type == $group->id) selected @endif>{{$group->display_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.credit_limit')}}</label>
                                    <input type="number" name="credit_limit" class="credit_limit form-control" value="{{@$client->credit_limit}}">
                                    @error('credit_limit')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.clientgender')}}</label>
                                    <select name="gender" class="form-select">
                                        <optgroup label="{{trans('content.enterClientGender')}}"></optgroup>
                                        <option value="1" @if($client->gender == 1) selected @endif>{{trans('content.male')}}</option>
                                        <option value="0" @if($client->gender == 0) selected @endif>{{trans('content.female')}}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group status">
                                    <input type="hidden" name="active" value="off">
                                    <input type="checkbox" name="active" @if($client->active == 1) checked @endif data-toggle="toggle" data-on="{{trans('content.enabled')}}" data-off="{{trans('content.disabled')}}" data-onstyle="success" data-offstyle="danger">
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
@section('script')
    <script>
        $(".invoice_type").change(function () {
            $invoice_type = $(this).find("option:selected").data("name");
            if ($invoice_type === "cash")
            {
                $(".credit_limit").attr("disabled", "disabled");
                $(".creditor_amount").attr("disabled", "disabled");
            }
            else
            {
                $(".credit_limit").removeAttr("disabled");
                $(".creditor_amount").removeAttr("disabled");
            }
        });
    </script>
@stop
@section('select2script')
    <script>
        // using select2 jquery plugin
        $("select").select2({
            dir: "{{\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocaleDirection()}}"
        });
    </script>
@stop
