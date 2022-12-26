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
                        <span>{{trans('content.addItem')}}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-data">
                    @if (\Illuminate\Support\Facades\Session::has('error'))
                        <button class="error btn btn-outline-danger btn-lg">{{\Illuminate\Support\Facades\Session::get('error')}}</button>
                    @endif
                    <form class="" name="add-item" action="{{route('items.store')}}" method="POST" enctype="multipart/form-data">
                        @csrf
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
                                                        <input type="text" name="item[name][{{$lang->abbr}}]" class="form-control" placeholder="{{trans('content.enterItemName')}}">
                                                        @error('item.name.' . $lang->abbr)
                                                        <small class="text-danger">{{$message}}</small>
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label>{{trans('content.itemdescription_'.$lang->abbr)}}</label>
                                                        <input type="text" name="item[description][{{$lang->abbr}}]" class="form-control" placeholder="{{trans('content.enterItemDescription')}}">
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
                                            <option value="{{$mainCat->id}}">{{$mainCat->name}}</option>
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
                                    <select name="subcat_id" class="subcats form-select">
                                        <optgroup label="{{trans('content.entersubCategory')}}"></optgroup>
                                        <option selected class="disabled-option"></option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.itemMaxDiscountRate')}} ( % )</label>
                                    <input type="number" name="max_discount_rate" class="form-control" min="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.itemMaxQuantity')}}</label>
                                    <input type="number" name="max_quantity" class="form-control" min="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.itemMinQuantity')}}</label>
                                    <input type="number" name="min_quantity" class="form-control" min="0">
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{trans('content.coin')}}</label>
                                    <select name="coin" class="form-select">
                                        <optgroup label="{{trans('content.enterCoinName')}}"></optgroup>
                                        <option selected disabled></option>
                                        @foreach($coins as $coin)
                                            <option value="{{$coin->id}}">{{$coin->name}}</option>
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
                            <div class="sec">
                                <h6>{{trans('content.itemprice')}}</h6>
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{trans('content.smallUnit')}}</label>
                                            <select name="item_unit_price[0][unit]" class="choose-unit form-select">
                                                <optgroup label="{{trans('content.enterSmallUnit')}}"></optgroup>
                                                <option selected disabled></option>
                                                @foreach($units as $unit)
                                                    <option value="{{$unit->id}}">{{$unit->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('item_unit_price.0.unit')
                                            <small class="text-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{trans('content.count')}}</label>
                                            <input type="number" name="item_unit_price[0][count]" value="1" readonly class="count form-control" placeholder="{{trans('content.enterCount')}}" min="0">
                                            @error('item_unit_price.0.count')
                                            <small class="text-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{trans('content.itempurchaseprice')}}</label>
                                            <input type="number" name="item_unit_price[0][purchasing_price]" class="purchase form-control" placeholder="{{trans('content.enterItemPurchasePrice')}}" min="0">
                                            @error('item_unit_price.0.purchasing_price')
                                            <small class="text-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{trans('content.itemsellingprice')}}</label>
                                            <input type="number" name="item_unit_price[0][selling_price]" class="selling form-control" placeholder="{{trans('content.enterItemSellingPrice')}}" min="0">
                                            @error('item_unit_price.0.selling_price')
                                            <small class="text-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{trans('content.itemwholesaleprice')}}</label>
                                            <input type="number" name="item_unit_price[0][wholesale_price]" class="wholesale form-control" placeholder="{{trans('content.enterItemWholesalePrice')}}" min="0">
                                            @error('item_unit_price.0.wholesale_price')
                                            <small class="text-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{trans('content.itemwholesale2price')}}</label>
                                            <input type="number" name="item_unit_price[0][wholesale2_price]" class="wholesale2 form-control" placeholder="{{trans('content.enterItemWholesale2Price')}}" min="0">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="store_quantity">
                            <div class="add-store-sec">
                                <button class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></button>
                                <h2 class="d-inline-block">{{trans('content.storesAndQuantities')}}</h2>
                            </div>
                            <div class="sec">
                                <h6>{{trans('content.storeQuantities')}}</h6>
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{trans('content.branch')}}</label>
                                            <select name="store_quantity[0][branch]" class="branch form-select">
                                                <optgroup label="{{trans('content.enterBranch')}}"></optgroup>
                                                <option selected disabled></option>
                                                @foreach($branches as $branch)
                                                    <option value="{{$branch->id}}">{{$branch->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('store_quantity.0.branch')
                                            <small class="text-danger">{{$message}}</small>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label>{{trans('content.store')}}</label>
                                            <select name="store_quantity[0][store]" class="store form-select">
                                                <optgroup label="{{trans('content.enterStore')}}"></optgroup>
                                                <option selected disabled></option>
                                                @foreach($stores as $store)
                                                    <option value="{{$store->id}}">{{$store->name}}</option>
                                                @endforeach
                                            </select>
                                            @error('store_quantity.0.store')
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <div class="custom-file-upload">
                                        <div class="main-file">
                                            <input type="file" class="form-control" name="photo">
                                        </div>
                                        <div class="custom-file">
                                            <div class="sec1">
                                                <span>{{trans('content.chooseItemPhoto')}}</span>
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

@section('script')
    <script>
        let store_quantity_index = 1;
        let itme_price_index = 1;
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
                                    <optgroup label='{{trans('content.enterBranch')}}'></optgroup>\
                                    <option selected disabled></option>\
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
                                    <option selected disabled></option>\
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
                                    <option selected disabled></option>\
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
                                <select name='item_unit_price[" + itme_price_index + "][unit]' class='choose-unit form-select'>\
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
                                <input type='number' name='item_unit_price[" + itme_price_index + "][count]' class='count form-control' placeholder='{{trans('content.enterCount')}}' min='0'>\
                            </div>\
                        </div>\
                        <div class='col-md-6'>\
                            <div class='form-group'>\
                                <label>{{trans('content.itempurchaseprice')}}</label>\
                                <input type='number' name='item_unit_price[" + itme_price_index + "][purchasing_price]' class='purchase form-control' placeholder='{{trans('content.enterItemPurchasePrice')}}' min='0'>\
                            </div>\
                        </div>\
                        <div class='col-md-6'>\
                            <div class='form-group'>\
                                <label>{{trans('content.itemsellingprice')}}</label>\
                                <input type='number' name='item_unit_price[" + itme_price_index + "][selling_price]' class='selling form-control' placeholder='{{trans('content.enterItemSellingPrice')}}' min='0'>\
                            </div>\
                        </div>\
                        <div class='col-md-6'>\
                            <div class='form-group'>\
                                <label>{{trans('content.itemwholesaleprice')}}</label>\
                                <input type='number' name='item_unit_price[" + itme_price_index + "][wholesale_price]' class='wholesale form-control' placeholder='{{trans('content.enterItemWholesalePrice')}}' min='0'>\
                            </div>\
                        </div>\
                        <div class='col-md-6'>\
                            <div class='form-group'>\
                                <label>{{trans('content.itemwholesale2price')}}</label>\
                                <input type='number' name='item_unit_price[" + itme_price_index + "][wholesale2_price]' class='wholesale2 form-control' placeholder='{{trans('content.enterItemWholesale2Price')}}' min='0'>\
                            </div>\
                        </div>\
                    \</div>\
                </div>";
            $(".item_prices").append(sec);
            itme_price_index++;
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
@section('select2script')
    <script>
        // using select2 jquery plugin
        $("select").select2({
            dir: "{{\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocaleDirection()}}"
        });
    </script>
@stop
