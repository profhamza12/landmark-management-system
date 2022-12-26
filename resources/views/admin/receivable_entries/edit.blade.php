@extends('layouts.admin.template')
@section('maincontent')
    <div class="main-content content-large">
        <div class="wraper-content">
            <div class="row">
                <div class="col-sm-12 page-info">
                    <h2>{{trans('content.receivable_entries')}}</h2>
                    <div>
                        <a href="">{{trans('content.home')}}</a> -
                        <a href="">{{trans('content.receivable_entries')}}</a> -
                        <span>{{trans('content.editReceivableEntry')}}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-data">
                    @if (\Illuminate\Support\Facades\Session::has('error'))
                        <button class="error btn btn-outline-danger btn-lg">{{\Illuminate\Support\Facades\Session::get('error')}}</button>
                    @endif
                    <form class="" name="edit-receivable-entry" action="{{route('receivable_entries.update', $receivable_entry->id)}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{trans('content.company_branch')}}</label>
                                    <select name="branch" class="branch form-select">
                                        <optgroup label="{{trans('content.enterBranch')}}"></optgroup>
                                        <option selected disabled class="disabled-option"></option>
                                        @foreach($branches as $branch)
                                            <option value="{{$branch->id}}" @if($branch->id == $receivable_entry->branch_id) selected @endif>{{$branch->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('branch')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{trans('content.store')}}</label>
                                    <select name="store" class="form-select">
                                        <optgroup label="{{trans('content.enterStore')}}"></optgroup>
                                        <option selected disabled class="disabled-option"></option>
                                        @foreach($stores as $store)
                                            <option value="{{$store->id}}" @if($store->id == $receivable_entry->store_id) selected @endif>{{$store->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('store')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{trans('content.vendor')}}</label>
                                    <select name="vendor" class="form-select">
                                        <optgroup label="{{trans('content.enterVendor')}}"></optgroup>
                                        <option selected disabled class="disabled-option"></option>
                                        @foreach($vendors as $vendor)
                                            <option value="{{$vendor->id}}" @if($vendor->id == $receivable_entry->vendor_id) selected @endif>{{$vendor->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('vendor')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="store_quantity">
                                <div class="add-sec">
                                    <button class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></button>
                                    <h2 class="d-inline-block">{{trans('content.receivable_entry_quantities')}}</h2>
                                </div>
                                @foreach($receivable_entry_details as $index => $_item)
                                    <div class="sec">
                                        <h6>{{trans('content.receivable_entry_quantity')}}</h6>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>{{trans('content.item')}}</label>
                                                    <select name="store_quantity[{{$index}}][item]" class="form-select">
                                                        <optgroup label="{{trans('content.enterItem')}}"></optgroup>
                                                        <option value="" disabled selected></option>
                                                        @foreach($items as $item)
                                                            <option value="{{$item->id}}" @if($item->id == $_item->item_id) selected @endif>{{$item->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('store_quantity.' . $index . '.item')
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>{{trans('content.unit')}}</label>
                                                    <select name="store_quantity[{{$index}}][unit]" class="form-select">
                                                        <optgroup label="{{trans('content.enterUnit')}}"></optgroup>
                                                        <option value="" disabled selected></option>
                                                        @foreach($units as $unit)
                                                            <option value="{{$unit->id}}" @if($unit->id == $_item->unit_id) selected @endif>{{$unit->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('store_quantity.' . $index . '.unit')
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>{{trans('content.itemQuantity')}}</label>
                                                    <input type="number" name="store_quantity[{{$index}}][quantity]" class="form-control" placeholder="{{trans('content.enterItemQuantity')}}" min="0" value="{{$_item->quantity}}">
                                                    @error('store_quantity.' . $index . '.quantity')
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
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
        let store_quantity_index = {{++$index}};
        $('.add-sec button').click(function (e) {
            e.preventDefault();
            let sec =
                "<div class='sec'>\
                    <h6>{{trans('content.receivable_entry_quantity')}}</h6>\
                    <button class='close'><i class='fas fa-times'></i></button>\
                    <div class='row'>\
                        <div class='col-md-4'>\
                            <div class='form-group'>\
                                <label>{{trans('content.item')}}</label>\
                                <select name='store_quantity[" + store_quantity_index + "][item]' class='form-select'>\
                                    <optgroup label='{{trans('content.enterItem')}}'></optgroup>\
                                    @foreach($items as $item)
                                    <option value='{{$item->id}}'>{{$item->name}}</option>\
                                    @endforeach
                                </select>\
                            </div>\
                        </div>\
                        <div class='col-md-4'>\
                            <div class='form-group'>\
                                <label>{{trans('content.unit')}}</label>\
                                <select name='store_quantity[" + store_quantity_index + "][unit]' class='form-select'>\
                                    <optgroup label='{{trans('content.enterUnit')}}'></optgroup>\
                                    @foreach($units as $unit)
                                    <option value='{{$unit->id}}'>{{$unit->name}}</option>\
                                    @endforeach
                                </select>\
                            </div>\
                        </div>\
                    <div class='col-md-4'>\
                        <div class='form-group'>\
                                <label>{{trans('content.itemQuantity')}}</label>\
                                <input type='number' name='store_quantity[" + store_quantity_index + "][quantity]' class='form-control' placeholder='{{trans('content.enterItemQuantity')}}' min='0'>\
                        </div>\
                    </div>\
                </div>\
        </div>";
            $(".store_quantity").append(sec);
            store_quantity_index++;
        });
        $("body").on("click", 'button.close',function (e) {
            e.preventDefault();
            $(this).parent().remove();
        });
    </script>
@stop

@section('ajaxscript')
    <script>
        $(".branch").change(function () {
            $(".store option").not(".disabled-option").remove();
            $branch_id = $(this).val();
            $url = '{{route('receivable_entries.get_branch_stores', ':id')}}';
            $url = $url.replace(":id", $branch_id);
            $.ajax({
                method: 'POST',
                url: $url,
                data: {_token: "{{csrf_token()}}", id: $branch_id},
                success: function (response) {
                    for(let i = 0; i < response.stores.length; i++)
                    {
                        $(".store").append("<option value=" + response.stores[i].id + ">" + response.stores[i].name[response.lang] + "</option>");
                    }
                },
                error: function (resErr) {
                }
            });
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
