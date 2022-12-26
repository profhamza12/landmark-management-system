@extends('layouts.admin.template')
@section('maincontent')
    <div class="main-content content-large">
        <div class="wraper-content">
            <div class="row">
                <div class="col-sm-12 page-info">
                    <h2>{{trans('content.items')}}</h2>
                    <div>
                        <a href="">{{trans('content.home')}}</a> -
                        <a href="">{{trans('content.items')}}</a> -
                        <span>{{trans('content.editItem')}}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-data">
                    @if (\Illuminate\Support\Facades\Session::has('error'))
                        <button class="error btn btn-outline-danger btn-lg">{{\Illuminate\Support\Facades\Session::get('error')}}</button>
                    @endif
                    <form class="" name="edit-item" action="{{route('items.update', $item->id)}}" method="POST" enctype="multipart/form-data">
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
                                                        <label>{{trans('content.itemname_'.$lang->abbr)}}</label>
                                                        <input type="text" name="item[name][{{$lang->abbr}}]" class="form-control" placeholder="{{trans('content.enterItemName')}}" value="{{@$translations['name'][$lang->abbr]}}">
                                                        @error('item.name.' . $lang->abbr)
                                                        <small class="text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{trans('content.itemdescription_'.$lang->abbr)}}</label>
                                                        <input type="text" name="item[description][{{$lang->abbr}}]" class="form-control" placeholder="{{trans('content.enterItemDescription')}}" value="{{@$translations['description'][$lang->abbr]}}">
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
                                    <select name="maincat_id" class="maincat form-select">
                                        <optgroup label="{{trans('content.entermainCategory')}}"></optgroup>
                                        <option disabled selected class="disabled-option"></option>
                                        @foreach($mainCats as $mainCat)
                                            <option value="{{$mainCat->id}}" @if($item->MainCategory->id == $mainCat->id) selected @endif>{{$mainCat->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('maincat_id')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.subCategory')}}</label>
                                    <select name="subcat_id" class="form-select">
                                        <optgroup label="{{trans('content.entersubCategory')}}"></optgroup>
                                        <option selected></option>
                                        @foreach($subCats as $subCat)
                                        <option value="{{$subCat->id}}"
                                        @if(!empty($item->SubCategory))
                                            @if($item->SubCategory->id == $subCat->id) selected @endif
                                        @endif
                                        >{{$subCat->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.itemMaxDiscountRate')}} ( % )</label>
                                    <input type="number" name="max_discount_rate" class="form-control" min="0" value="{{@$item->max_discount_rate}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.itemMaxQuantity')}}</label>
                                    <input type="number" name="max_quantity" class="form-control" min="0" value="{{@$item->max_quantity}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.itemMinQuantity')}}</label>
                                    <input type="number" name="min_quantity" class="form-control" min="0" value="{{@$item->min_quantity}}">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.coinname')}}</label>
                                    <select name="coin" class="form-select">
                                        <optgroup label="{{trans('content.enterCoinName')}}"></optgroup>
                                        <option selected disabled></option>
                                        @foreach($coins as $coin)
                                            <option value="{{$coin->id}}" @if($item->Coin->id == $coin->id) selected @endif>{{$coin->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('coin')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="item_prices">
                            <div class="add-price-sec">
                                <button class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></button>
                                <h2 class="d-inline-block">{{trans('content.unitsAndPrices')}}</h2>
                            </div>
                            @isset($item_unit_prices)
                                @foreach($item_unit_prices as $index => $_item)
                                    <div class="sec">
                                        <h6>{{trans('content.itemprice')}}</h6>
                                        <button class='close'><i class='fas fa-times'></i></button>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{trans('content.smallUnit')}}</label>
                                                    <select name="item_unit_price[{{$index}}][unit]" class="choose-unit form-select">
                                                        <optgroup label="{{trans('content.enterSmallUnit')}}"></optgroup>
                                                        <option selected disabled></option>
                                                        @foreach($units as $unit)
                                                            <option value="{{$unit->id}}" @if($unit->id == $_item->unit_id) selected @endif>{{$unit->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('item_unit_price.' . $index . '.unit')
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{trans('content.count')}}</label>
                                                    <input type="number" name="item_unit_price[{{$index}}][count]" @if($_item->unit_item_count == 1) readonly @endif class="count form-control" placeholder="{{trans('content.enterCount')}}" min="0" value="{{@$_item->unit_item_count}}">
                                                    @error('item_unit_price.' . $index . '.count')
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{trans('content.itempurchaseprice')}}</label>
                                                    <input type="number" name="item_unit_price[{{$index}}][purchasing_price]" class="purchase form-control" placeholder="{{trans('content.enterItemPurchasePrice')}}" min="0" value="{{@$_item->purchasing_price}}">
                                                    @error('item_unit_price.' . $index . '.purchasing_price')
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{trans('content.itemsellingprice')}}</label>
                                                    <input type="number" name="item_unit_price[{{$index}}][selling_price]" class="selling form-control" placeholder="{{trans('content.enterItemSellingPrice')}}" min="0" value="{{@$_item->selling_price}}">
                                                    @error('item_unit_price.' . $index . '.selling_price')
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{trans('content.itemwholesaleprice')}}</label>
                                                    <input type="number" name="item_unit_price[{{$index}}][wholesale_price]" class="wholesale form-control" placeholder="{{trans('content.enterItemWholesalePrice')}}" min="0" value="{{@$_item->wholesale_price}}">
                                                    @error('item_unit_price.' . $index . '.wholesale_price')
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{trans('content.itemwholesale2price')}}</label>
                                                    <input type="number" name="item_unit_price[{{$index}}][wholesale2_price]" class="wholesale2 form-control" placeholder="{{trans('content.enterItemWholesale2Price')}}" min="0" value="{{@$_item->wholesale2_price}}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endisset
                        </div>
                        <div class="store_quantity">
                            <div class="add-store-sec">
                                <button class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></button>
                                <h2 class="d-inline-block">{{trans('content.storesAndQuantities')}}</h2>
                            </div>
                            @isset($item_stores)
                                @foreach($item_stores as $j => $item_store)
                                    <div class="sec">
                                        <h6>{{trans('content.storeQuantities')}}</h6>
                                        <button class='close'><i class='fas fa-times'></i></button>
                                        <div class="row">
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>{{trans('content.branch')}}</label>
                                                    <select name="store_quantity[{{$j}}][branch]" class="branch form-select">
                                                        <optgroup label="{{trans('content.enterBranch')}}"></optgroup>
                                                        <option selected disabled></option>
                                                        @foreach($branches as $branch)
                                                            <option value="{{$branch->id}}" @if($branch->id == $item_store->branch_id) selected @endif>{{$branch->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('store_quantity.' . $j . '.branch')
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>{{trans('content.store')}}</label>
                                                    <select name="store_quantity[{{$j}}][store]" class="store form-select">
                                                        <optgroup label="{{trans('content.enterStore')}}"></optgroup>
                                                        <option selected disabled></option>
                                                        @foreach($stores as $store)
                                                            <option value="{{$store->id}}" @if($store->id == $item_store->store_id) selected @endif>{{$store->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('store_quantity.' . $j . '.store')
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>{{trans('content.unit')}}</label>
                                                    <select name="store_quantity[{{$j}}][unit]" class="form-select">
                                                        <optgroup label="{{trans('content.enterUnit')}}"></optgroup>
                                                        <option selected disabled></option>
                                                        @foreach($units as $unit)
                                                            <option value="{{$unit->id}}" @if(isset($small_unit) && $unit->id == $small_unit->id) selected @endif>{{$unit->name}}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('store_quantity.' . $j . '.unit')
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-4">
                                                <div class="form-group">
                                                    <label>{{trans('content.itemQuantity')}}</label>
                                                    <input type="number" name="store_quantity[{{$j}}][quantity]" class="form-control" placeholder="{{trans('content.enterItemQuantity')}}" min="0" value="{{@$item_store->quantity}}">
                                                    @error('store_quantity.' . $j . '.quantity')
                                                    <small class="text-danger">{{$message}}</small>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endisset
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
                                                <span>{{trans('content.chooseNewItemPhoto')}}</span>
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
                                    <input type="checkbox" name="active" @if($item->active == 1) checked @endif data-toggle="toggle" data-on="{{trans('content.enabled')}}" data-off="{{trans('content.disabled')}}" data-onstyle="success" data-offstyle="danger">
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

@section('script')
    <script>
        let item_price_index = @if(isset($index)) {{++$index}} @else 0 @endif;
        let store_quantity_index = @if(isset($j)) {{++$j}} @else 0 @endif;
        $('.add-store-sec button').click(function (e) {
            e.preventDefault();
            let sec =
                "<div class='sec'>\
                    <h6>{{trans('content.storeQuantities')}}</h6>\
                    <button class='close'><i class='fas fa-times'></i></button>\
                    <div class='row'>\
                        <div class='col-md-4'>\
                            <div class='form-group'>\
                                <label>{{trans('content.branch')}}</label>\
                                <select name='store_quantity[" + store_quantity_index + "][branch]' class='branch form-select'>\
                                    <optgroup label='{{trans('content.enterStore')}}'></optgroup>\
                                    <option selected disables></option>\
                                    @foreach($branches as $branch)
                                    <option value='{{$branch->id}}'>{{$branch->name}}</option>\
                                    @endforeach
                                    </select>\
                                </div>\
                            </div>\
                             <div class='col-md-4'>\
                                 <div class='form-group'>\
                                  <label>{{trans('content.store')}}</label>\
                                <select name='store_quantity[" + store_quantity_index + "][store]' class='store form-select'>\
                                    <optgroup label='{{trans('content.enterStore')}}'></optgroup>\
                                    <option selected disables></option>\
                                    @foreach($stores as $store)
                                    <option value='{{$store->id}}'>{{$store->name}}</option>\
                                    @endforeach
                                </select>\
                            </div>\
                        </div>\
                        <div class='col-md-4'>\
                            <div class='form-group'>\
                                <label>{{trans('content.unit')}}</label>\
                                <select name='store_quantity[" + store_quantity_index + "][unit]' class='form-select'>\
                                    <optgroup label='{{trans('content.enterUnit')}}'></optgroup>\
                                    <option selected disables></option>\
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
        $('.add-price-sec button').click(function (e) {
            e.preventDefault();
            let sec =
                "<div class='sec'>\
                    <h6>{{trans('content.itemprice')}}</h6>\
                    <button class='close'><i class='fas fa-times'></i></button>\
                    <div class='row'>\
                        <div class='col-md-6'>\
                            <div class='form-group'>\
                                <label>{{trans('content.unit')}}</label>\
                                <select name='item_unit_price[" + item_price_index + "][unit]' class='choose-unit form-select'>\
                                    <optgroup label='{{trans('content.enterUnit')}}''></optgroup>\
                                    <option selected disabled></option>\
                                    @foreach($units as $unit)
                                    <option value='{{$unit->id}}'>{{$unit->name}}</option>\
                                    @endforeach
                                </select>\
                            </div>\
                        </div>\
                        <div class='col-md-6'>\
                            <div class='form-group'>\
                                <label>{{trans('content.count')}}</label>\
                                <input type='number' name='item_unit_price[" + item_price_index + "][count]' class='count form-control' placeholder='{{trans('content.enterCount')}}' min='0'>\
                            </div>\
                        </div>\
                        <div class='col-md-6'>\
                            <div class='form-group'>\
                                <label>{{trans('content.itempurchaseprice')}}</label>\
                                <input type='number' name='item_unit_price[" + item_price_index + "][purchasing_price]' class='purchase form-control' placeholder='{{trans('content.enterItemPurchasePrice')}}' min='0'>\
                            </div>\
                        </div>\
                        <div class='col-md-6'>\
                            <div class='form-group'>\
                                <label>{{trans('content.itemsellingprice')}}</label>\
                                <input type='number' name='item_unit_price[" + item_price_index + "][selling_price]' class='selling form-control' placeholder='{{trans('content.enterItemSellingPrice')}}' min='0'>\
                            </div>\
                        </div>\
                        <div class='col-md-6'>\
                            <div class='form-group'>\
                                <label>{{trans('content.itemwholesaleprice')}}</label>\
                                <input type='number' name='item_unit_price[" + item_price_index + "][wholesale_price]' class='wholesale form-control' placeholder='{{trans('content.enterItemWholesalePrice')}}' min='0'>\
                            </div>\
                        </div>\
                        <div class='col-md-6'>\
                            <div class='form-group'>\
                                <label>{{trans('content.itemwholesale2price')}}</label>\
                                <input type='number' name='item_unit_price[" + item_price_index + "][wholesale2_price]' class='wholesale2 form-control' placeholder='{{trans('content.enterItemWholesale2Price')}}' min='0'>\
                            </div>\
                        </div>\
                    \</div>\
                </div>";
            $(".item_prices").append(sec);
            item_price_index++;
        });
        $("body").on("click", 'button.close',function (e) {
            e.preventDefault();
            $(this).parent().remove();
        });
        $("body").on("blur", ".purchase", function () {
            $val = parseInt($(this).val());
            $sec = $(this).parents(".sec");
            $selling = $sec.find(".selling");
            $wholesale = $sec.find(".wholesale");
            $wholesale2 = $sec.find(".wholesale2");
            $maincat = $(".maincat").val();
            if ($maincat > 0 && $val > 0)
            {
                $url = "{{route('items.getMainCatDetail', ":id")}}";
                $url = $url.replace(":id", $maincat);
                $.ajax({
                    method: "POST",
                    url: $url,
                    data: {_token: "{{csrf_token()}}", maincat: $maincat},
                    success: function (resTxt) {
                        $selling.val(($val + ($val * (resTxt.maincat.sectoral_sale_rate / 100))));
                        $wholesale.val($val + ($val * (resTxt.maincat.whole_sale_rate / 100)));
                        $wholesale2.val($val + ($val * (resTxt.maincat.whole_sale2_rate / 100)));
                    },
                    error: function (resTxt) {}
                });
            }
        });
        $("body").on("focus", ".purchase", function () {
            $sec = $(this).parents(".sec");
            $sec.find(".selling").val("");
            $sec.find(".wholesale").val("");
            $sec.find(".wholesale2").val("");
        });
        $(".maincat").change(function () {
            $(".subcats option").not(".disabled-option").remove();
            $maincat_id = $(this).val();
            $url = '{{route('items.get_sub_categories', ':id')}}';
            $url = $url.replace(":id", $maincat_id);
            $.ajax({
                method: 'POST',
                url: $url,
                data: {_token: "{{csrf_token()}}", id: $maincat_id},
                success: function (response) {
                    for(let i = 0; i < response.subcats.length; i++)
                    {
                        $(".subcats").append("<option value=" + response.subcats[i].id + ">" + response.subcats[i].name[response.lang] + "</option>");
                    }
                },
                error: function (resErr) {
                }
            });
        });
        $("body").on("change", ".branch", function () {
            $(this).parents(".sec").find(".store option").not(".disabled-option").remove()
            $store = $(this).parents(".sec").find(".store");
            $branch_id = $(this).val();
            $url = '{{route('items.get_branch_stores', ':id')}}';
            $url = $url.replace(":id", $branch_id);
            $.ajax({
                method: 'POST',
                url: $url,
                data: {_token: "{{csrf_token()}}", id: $branch_id},
                success: function (response) {
                    for(let i = 0; i < response.stores.length; i++)
                    {
                        $store.append("<option value=" + response.stores[i].id + ">" + response.stores[i].name[response.lang] + "</option>");
                    }
                },
                error: function (resErr) {
                }
            });
        });
    </script>
@stop
