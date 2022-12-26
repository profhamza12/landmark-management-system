@extends('layouts.admin.template')
@section('maincontent')
    <div class="main-content content-large">
        <div class="wraper-content">
            <div class="row">
                <div class="col-sm-12 page-info">
                    <h2>{{trans('content.transferQuantity')}}</h2>
                    <div>
                        <a href="">{{trans('content.home')}}</a> -
                        <a href="">{{trans('content.transferQuantity')}}</a> -
                        <span>{{trans('content.addTransQuantity')}}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-data">
                    @if (\Illuminate\Support\Facades\Session::has('error'))
                        <button class="error btn btn-outline-danger btn-lg">{{\Illuminate\Support\Facades\Session::get('error')}}</button>
                    @endif
                    <form class="" name="add-trans-quantity-op" action="{{route('trans_quantity.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{trans('content.company_branch')}}</label>
                                    <select name="branch" class="branch form-select">
                                        <optgroup label="{{trans('content.enterBranch')}}"></optgroup>
                                        <option selected disabled class="disabled-option"></option>
                                        @foreach($branches as $branch)
                                            <option value="{{$branch->id}}">{{$branch->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('branch')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{trans('content.src_store')}}</label>
                                    <select name="src_store" class="store form-select">
                                        <optgroup label="{{trans('content.enterStore')}}"></optgroup>
                                        <option disabled selected class="disabled-option"></option>
                                    </select>
                                    @error('src_store')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{trans('content.dest_store')}}</label>
                                    <select name="dest_store" class="store form-select">
                                        <optgroup label="{{trans('content.enterStore')}}"></optgroup>
                                        <option disabled selected class="disabled-option"></option>
                                    </select>
                                    @error('dest_store')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="store_quantity">
                                <div class="add-sec">
                                    <button class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></button>
                                    <h2 class="d-inline-block">{{trans('content.transferQuantity')}}</h2>
                                </div>
                                <div class="sec">
                                    <h6>{{trans('content.storeTransQuantity')}}</h6>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{trans('content.item')}}</label>
                                                <select name="store_quantity[0][item]" class="item form-select">
                                                    <optgroup label="{{trans('content.enterItem')}}"></optgroup>
                                                    <option selected disabled></option>
                                                    @foreach($items as $item)
                                                        <option value="{{$item->id}}">{{$item->name}}</option>
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
                                                        <option value="{{$unit->id}}">{{$unit->name}}</option>
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
                                                <input type="number" name="store_quantity[0][quantity]" class="form-control" placeholder="{{trans('content.enterItemQuantity')}}" min="0">
                                                @error('store_quantity.0.quantity')
                                                <small class="text-danger">{{$message}}</small>
                                                @enderror
                                            </div>
                                        </div>
                                    </div>
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
        let store_quantity_index = 1;
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
                                <select name='store_quantity[" + store_quantity_index + "][item]' class='item form-select'>\
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

@section('ajaxscript')
    <script>
        $(".branch").change(function () {
            $(".store option").not(".disabled-option").remove();
            $branch_id = $(this).val();
            $url = '{{route('trans_quantity.get_branch_stores', ':id')}}';
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
