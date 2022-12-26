@extends('layouts.admin.template')
@section('maincontent')
    <div class="main-content content-large">
        <div class="wraper-content">
            <div class="row">
                <div class="col-sm-12 page-info">
                    <h2>{{trans('content.return_sales_invoices')}}</h2>
                    <div>
                        <a href="">{{trans('content.home')}}</a> -
                        <a href="">{{trans('content.return_sales_invoices')}}</a> -
                        <span>{{trans('content.addReturnInvoice')}}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-data">
                    @if (\Illuminate\Support\Facades\Session::has('error'))
                        <button class="error btn btn-outline-danger btn-lg">{{\Illuminate\Support\Facades\Session::get('error')}}</button>
                    @endif
                    <form class="" name="add-return-sales-invoice" action="{{route('return_sales_invoices.store')}}" method="POST" enctype="multipart/form-data">
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
                                    <label>{{trans('content.store')}}</label>
                                    <select name="store" class="store form-select">
                                        <optgroup label="{{trans('content.enterStore')}}"></optgroup>
                                        <option value="" disabled selected class="disabled-option"></option>
                                    </select>
                                    @error('store')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{trans('content.client')}}</label>
                                    <select name="client" class="client form-select">
                                        <optgroup label="{{trans('content.enterClient')}}"></optgroup>
                                        <option value="" disabled selected class="disabled-option"></option>
                                        @foreach($clients as $client)
                                            <option value="{{$client->id}}">{{$client->name}}</option>
                                        @endforeach
                                    </select>
                                    @error('client')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{trans('content.sales_invoice')}}</label>
                                    <select name="invoice_id" class="invoice form-select">
                                        <optgroup label="{{trans('content.enterInvoice')}}"></optgroup>
                                        <option value="" disabled selected class="disabled-option"></option>
                                    </select>
                                    @error('invoice_id')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="store_quantity">
                                <div class="add-sec">
                                    <button class="btn btn-primary btn-sm"><i class="fas fa-plus"></i></button>
                                    <h2 class="d-inline-block">{{trans('content.sales_invoice_quantities')}}</h2>
                                </div>
                                <div class="sec">
                                    <h6>{{trans('content.sales_invoice_quantity')}}</h6>
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
                                                <select name="store_quantity[0][unit]" class="unit form-select">
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
                                                <input type="number" name="store_quantity[0][quantity]" class="quantity form-control" placeholder="{{trans('content.enterItemQuantity')}}" min="0">
                                                @error('store_quantity.0.quantity')
                                                <small class="text-danger">{{$message}}</small>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="form-group">
                                                <label>{{trans('content.selling_price')}}</label>
                                                <input type="number" name="store_quantity[0][selling_price]" class="selling_price form-control" readonly value='0'>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{trans('content.total_amount')}}</label>
                                    <input type="number" name="total_amount" class="total_amount form-control" readonly>
                                    @error('total_amount')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{trans('content.return_amount')}}</label>
                                    <input type="number" name="return_amount" class="return_amount form-control" readonly>
                                    @error('return_amount')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{trans('content.remaining_amount')}}</label>
                                    <input type="number" name="remaining_amount" class="remaining_amount form-control" readonly>
                                    @error('remaining_amount')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
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
                    <h6>{{trans('content.sales_invoice_quantity')}}</h6>\
                    <button class='close'><i class='fas fa-times'></i></button>\
                    <div class='row'>\
                        <div class='col-md-4'>\
                            <div class='form-group'>\
                                <label>{{trans('content.item')}}</label>\
                                <select name='store_quantity[" + store_quantity_index + "][item]' class='item form-select'>\
                                    <optgroup label='{{trans('content.enterItem')}}'></optgroup>\
                                    <option disabled selected></option>\
                                    @foreach($items as $item)
                                     <option value='{{$item->id}}'>{{$item->name}}</option>\
                                    @endforeach
                                </select>\
                            </div>\
                        </div>\
                        <div class='col-md-4'>\
                            <div class='form-group'>\
                                <label>{{trans('content.unit')}}</label>\
                                <select name='store_quantity[" + store_quantity_index + "][unit]' class='unit form-select'>\
                                    <optgroup label='{{trans('content.enterUnit')}}'></optgroup>\
                                    <option disabled selected></option>\
                                    @foreach($units as $unit)
                                    <option value='{{$unit->id}}'>{{$unit->name}}</option>\
                                    @endforeach
                                </select>\
                            </div>\
                        </div>\
                        <div class='col-md-4'>\
                            <div class='form-group'>\
                                <label>{{trans('content.itemQuantity')}}</label>\
                                <input type='number' name='store_quantity[" + store_quantity_index + "][quantity]' class='quantity form-control' placeholder='{{trans('content.enterItemQuantity')}}' min='0'>\
                                @error('store_quantity.0.quantity')
                                <small class='text-danger'>{{$message}}</small>\
                                @enderror
                    </div>\
                </div>\
            <div class='col-md-4'>\
                <div class='form-group'>\
                    <label>{{trans('content.selling_price')}}</label>\
                    <input type='number' name='store_quantity[" + store_quantity_index + "][selling_price]' class='selling_price form-control' readonly value='0'>\
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
            $url = '{{route('return_sales_invoices.get_branch_stores', ':id')}}';
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
            $url = '{{route('return_sales_invoices.get_store_items', ':id')}}';
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
        $(".client").change(function () {
            $(".invoice option").not(".disabled-option").remove();
            $client_id = $(this).val();
            $url = '{{route('return_sales_invoices.get_client_invoices', ':id')}}';
            $url = $url.replace(":id", $client_id);
            $.ajax({
                method: 'POST',
                url: $url,
                data: {_token: "{{csrf_token()}}", id: $client_id},
                success: function (response) {
                    for(let i = 0; i < response.invoices.length; i++)
                    {
                        $(".invoice").append("<option value=" + response.invoices[i]['id'] + ">" + response.invoices[i]['id'] + "</option>");
                    }
                },
                error: function (resErr) {
                }
            });
        });
        $(".invoice").change(function () {
            $invoice_id = $(this).val();
            $url = '{{route('return_sales_invoices.get_invoice_detail', ':id')}}';
            $url = $url.replace(":id", $invoice_id);
            $.ajax({
                method: 'POST',
                url: $url,
                data: {_token: "{{csrf_token()}}", id: $invoice_id},
                success: function (response) {
                    $(".total_amount").val(response.total_amount);
                    $(".remaining_amount").val(response.remaining_amount);
                },
                error: function (resErr) {
                }
            });
        });
        $("body").on("blur", ".quantity", function () {
            $quantity = $(this).val();
            $unit_id = $(this).parents(".sec").find(".unit").val();
            $item_id = $(this).parents(".sec").find(".item").val();
            $selling_price = $(this).parents(".sec").find(".selling_price");
            $total_amount = $(".total_amount").val();
            $remaining_amount = $(".remaining_amount").val();
            $total = 0;
            if ($quantity !== "" && $unit_id !== "" && $item_id !== "")
            {
                $.ajax({
                    method: 'POST',
                    url: "{{route('return_sales_invoices.get_unit_detail')}}",
                    data: {_token: "{{csrf_token()}}", unit_id: $unit_id, item_id: $item_id, quantity: $quantity},
                    success: function (response) {
                        $selling_price.val(response.selling_price);
                        $(".sec .selling_price").each(function ($index) {
                            $total += parseInt($(this).val());
                        });
                        if ($total_amount > $total)
                        {
                            $(".return_amount").val($total);
                            $(".remaining_amount").val($total_amount - $total);
                        }
                        else
                        {
                            $(".total_amount").val($total_amount);
                            $(".remaining_amount").val($remaining_amount);
                        }
                    },
                    error: function (resErr) {
                    }
                });
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
