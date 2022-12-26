@extends('layouts.admin.template')
@section('maincontent')
    <div class="main-content content-large">
        <div class="wraper-content">
            <div class="row">
                <div class="col-sm-12 page-info">
                    <h2>{{trans('content.perishables')}}</h2>
                    <div>
                        <a href="">{{trans('content.home')}}</a> -
                        <a href="">{{trans('content.perishables')}}</a> -
                        <span>{{trans('content.editPerishable')}}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-data">
                    @if (\Illuminate\Support\Facades\Session::has('error'))
                        <button class="error btn btn-outline-danger btn-lg">{{\Illuminate\Support\Facades\Session::get('error')}}</button>
                    @endif
                    <form class="" name="edit-perishable" action="{{route('perishables.update', $perishable->id)}}" method="POST" enctype="multipart/form-data">
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
                                            <option value="{{$branch->id}}" @if($perishable->branch_id == $branch->id) selected @endif>{{$branch->name}}</option>
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
                                    <select name="store" class="store form-select">
                                        <optgroup label="{{trans('content.enterStore')}}"></optgroup>
                                        <option value="" disabled selected class="disabled-option"></option>
                                        @foreach($stores as $store)
                                            <option value="{{$store->id}}" @if($perishable->store_id == $store->id) selected @endif>{{$store->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('store')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="store_quantity">
                                <div class="add-sec">
                                    <button class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></button>
                                    <h2 class="d-inline-block">{{trans('content.perishables_quantities')}}</h2>
                                </div>
                                @foreach($perishable_details as $_item)
                                    <div class="sec">
                                        <h6>{{trans('content.perishable')}}</h6>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>{{trans('content.item')}}</label>
                                                    <select name="store_quantity[0][item]" class="item form-select">
                                                        <optgroup label="{{trans('content.enterItem')}}"></optgroup>
                                                        <option selected disabled></option>
                                                        @foreach($items as $item)
                                                            <option value="{{$item->id}}" @if($item->id == $_item->item_id) selected @endif>{{$item->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('store_quantity.0.item')
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>{{trans('content.unit')}}</label>
                                                    <select name="store_quantity[0][unit]" class="form-select">
                                                        <optgroup label="{{trans('content.enterUnit')}}"></optgroup>
                                                        <option selected disabled></option>
                                                        @foreach($units as $unit)
                                                            <option value="{{$unit->id}}" @if($unit->id == $_item->unit->id) selected @endif>{{$unit->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('store_quantity.0.unit')
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>{{trans('content.itemQuantity')}}</label>
                                                    <input type="number" name="store_quantity[0][quantity]" value="{{@$_item->quantity}}" class="form-control" placeholder="{{trans('content.enterItemQuantity')}}" min="0">
                                                    @error('store_quantity.0.quantity')
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


@section('ajaxscript')
    <script>
        $(".branch").change(function () {
            $(".store option").not(".disabled-option").remove();
            $branch_id = $(this).val();
            $url = '{{route('prices_offers.get_branch_stores', ':id')}}';
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
        $(".store").change(function () {
            $(".item option").not(".disabled-option").remove();
            $store_id = $(this).val();
            $url = '{{route('prices_offers.get_store_items', ':id')}}';
            $url = $url.replace(":id", $store_id);
            $.ajax({
                method: 'POST',
                url: $url,
                data: {_token: "{{csrf_token()}}", id: $store_id},
                success: function (response) {
                    for(let i = 0; i < response.data.length; i++)
                    {
                        $(".item").append("<option value=" + response.data[i]['item_id'] + ">" + response.data[i]['item_name'] + "</option>");
                    }
                },
                error: function (resErr) {
                }
            });
        });
    </script>
@stop
@section('script')
    <script>
        let store_quantity_index = 1;
        $('.add-sec button').click(function (e) {
            e.preventDefault();
            let sec =
                "<div class='sec'>\
                    <h6>{{trans('content.perishable')}}</h6>\
                    <button class='close'><i class='fas fa-times'></i></button>\
                    <div class='row'>\
                        <div class='col-md-4'>\
                            <div class='form-group'>\
                                <label>{{trans('content.item')}}</label>\
                                <select name='store_quantity[" + store_quantity_index + "][item]' class='item form-select'>\
                                    <optgroup label='{{trans('content.enterItem')}}'></optgroup>\
                                    \<option disabled selected></option>\
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
                                    \<option disabled selected></option>\
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
                                @error('store_quantity.0.quantity')
                    <small class='text-danger'>{{$message}}</small>\
                                @enderror
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
@section('select2script')
    <script>
        // using select2 jquery plugin
        $("select").select2({
            dir: "{{\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocaleDirection()}}"
        });
    </script>
@stop
