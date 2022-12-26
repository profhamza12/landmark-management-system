@extends('layouts.admin.template')
@section('maincontent')
    <div class="main-content content-large">
        <div class="wraper-content">
            <div class="row">
                <div class="col-sm-12 page-info">
                    <h2>{{trans('content.sales_invoices')}}</h2>
                    <div>
                        <a href="">{{trans('content.home')}}</a> -
                        <a href="">{{trans('content.sales_invoices')}}</a> -
                        <span>{{trans('content.addSaleInvoice')}}</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="form-data">
                    @if (\Illuminate\Support\Facades\Session::has('error'))
                        <button class="error btn btn-outline-danger btn-lg">{{\Illuminate\Support\Facades\Session::get('error')}}</button>
                    @endif
                    <form class="" name="add-sales-invoice" action="{{route('sales_invoices.store')}}" method="POST" enctype="multipart/form-data">
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
                                    <select name="client" class="form-select">
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
                                    <label>{{trans('content.InvoiceType')}}</label>
                                    <select name="invoice_type" class="invoice_type form-select">
                                        <optgroup label="{{trans('content.enterInvoiceType')}}"></optgroup>
                                        <option value="" disabled selected class="disabled-option"></option>
                                        @foreach($invoice_types as $invoice_type)
                                            <option value="{{$invoice_type->id}}" data-name="{{$invoice_type->name}}">{{$invoice_type->display_name}}</option>
                                        @endforeach
                                    </select>
                                    @error('invoice_type')
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
                                                <input type="number" name="selling_price" class="selling_price form-control" readonly value='0'>
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
                                    <label>{{trans('content.discount')}}</label>
                                    <input type="number" name="discount" class="discount form-control">
                                    @error('discount')
                                    <small class="text-danger">{{$message}}</small>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label>{{trans('content.paid_amount')}}</label>
                                    <input type="number" name="paid_amount" class="paid_amount form-control">
                                    @error('paid_amount')
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
                    <input type='number' name='selling_price' class='selling_price form-control' readonly value='0'>\
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
            $url = '{{route('sales_invoices.get_branch_stores', ':id')}}';
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
            $url = '{{route('sales_invoices.get_store_items', ':id')}}';
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
        $("body").on("blur", ".quantity", function () {
            $quantity = $(this).val();
            $unit_id = $(this).parents(".sec").find(".unit").val();
            $item_id = $(this).parents(".sec").find(".item").val();
            $selling_price = $(this).parents(".sec").find(".selling_price");
            $total_amount = 0;
            if ($quantity !== "" && $unit_id !== "" && $item_id !== "")
            {
                $.ajax({
                    method: 'POST',
                    url: "{{route('sales_invoices.get_unit_detail')}}",
                    data: {_token: "{{csrf_token()}}", unit_id: $unit_id, item_id: $item_id, quantity: $quantity},
                    success: function (response) {
                        $selling_price.val(response.selling_price);
                        $(".sec .selling_price").each(function ($index) {
                            $total_amount += parseInt($(this).val());
                        });
                        $(".total_amount").val($total_amount);
                        $(".remaining_amount").val($total_amount);
                        $invoice_type = $(".invoice_type").find("option:selected").data("name");
                        if ($invoice_type === "cach")
                        {
                            $(".paid_amount").val($total_amount);
                            $(".remaining_amount").val(0);
                        }
                    },
                    error: function (resErr) {
                    }
                });
            }
        });
        $(".discount").blur(function () {
            $discount_rate = $(this).val();
            $total_amount = $(".total_amount").val();
            $remaining_amount = $(".remaining_amount").val();
            $invoice_type = $(".invoice_type").find("option:selected").data("name");
            if ($discount_rate !== "" && $total_amount !== "")
            {
                if ($discount_rate <= 100)
                {
                    if ($invoice_type === "cach")
                    {
                        $remaining = $total_amount - (($total_amount * $discount_rate) / 100)
                        $(".paid_amount").val($remaining);
                    }
                    else
                    {
                        if ($remaining_amount === "")
                        {
                            $remaining = $total_amount - (($total_amount * $discount_rate) / 100)
                            $(".remaining_amount").val($remaining);
                        }
                        else
                        {
                            $remaining = $remaining_amount - (($remaining_amount * $discount_rate) / 100)
                            $(".remaining_amount").val($remaining);
                        }
                    }
                }
                else
                {
                    $(".remaining_amount").val(0);
                }
            }
        });
        $(".paid_amount").blur(function () {
            $paid_amount = $(this).val();
            $total_amount = $(".total_amount").val();
            $remaining_amount = $(".remaining_amount").val();
            if ($paid_amount !== "" && $total_amount !== "")
            {
                if (parseInt($total_amount) >= parseInt($paid_amount))
                {
                    if ($remaining_amount === "")
                    {
                        $remaining = $total_amount - $paid_amount;
                        $(".remaining_amount").val($remaining);
                    }
                    else
                    {
                        if (parseInt($remaining_amount) >= parseInt($paid_amount))
                        {
                            $remaining = $remaining_amount - $paid_amount;
                            $(".remaining_amount").val($remaining);
                        }
                    }
                }
                else
                {
                    $(".remaining_amount").val(0);
                    $(this).val($total_amount);
                }
            }
        });
        $(document).on("focus", ".quantity", function () {
            if ($(this).val() !== "")
            {
                $(".paid_amount").val("");
                $(".discount").val("");
                $(".remaining_amount").val("");
            }
        });
        $(".discount").focus(function () {
            if ($(this).val() !== "")
            {
                $(this).val("");
                $(".paid_amount").val("");
                $(".remaining_amount").val("");
            }
        });
        $(".paid_amount").focus(function () {
            if ($(this).val() !== "")
            {
                $(this).val("");
                $(".discount").val("");
                $(".remaining_amount").val("");
            }
        });
        $(".invoice_type").change(function () {
            $invoice_type = $(this).find("option:selected").data("name");
            if ($invoice_type === "cach")
            {
                $(".paid_amount").val($(".total_amount").val());
                $(".paid_amount").attr("disabled", "disabled");
                $(".remaining_amount").val(0);
                $(".remaining_amount").attr("disabled", "disabled");
                $(".discount").val("");
            }
            else
            {
                $(".paid_amount").val("");
                $(".paid_amount").removeAttr("disabled");
                $(".remaining_amount").val($(".total_amount").val());
                $(".remaining_amount").removeAttr("disabled");
                $(".discount").val("");
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
