@extends('layouts.admin.template')
@section('maincontent')
    <div class="main-content content-large">
        <div class="wraper-content">
            <div class="row">
                <div class="col-sm-12 page-info">
                    <h2>{{trans('content.items')}}</h2>
                    <div>
                        <a href="">{{trans('content.home')}}</a> -
                        <span>{{trans('content.items')}}</span>
                    </div>
                </div>
                <div class="col-sm-12 table-data">
                    @if (\Illuminate\Support\Facades\Session::has('success'))
                        <button class="success btn btn-outline-success btn-lg">{{\Illuminate\Support\Facades\Session::get('success')}}</button>
                    @endif
                    @if (\Illuminate\Support\Facades\Session::has('error'))
                        <button class="error btn btn-outline-danger btn-lg">{{\Illuminate\Support\Facades\Session::get('error')}}</button>
                    @endif
                    <!-- success and error messages showed by ajax -->
                    <button class="ajax-success btn btn-outline-success btn-lg"></button>
                    <button class="ajax-error btn btn-outline-danger btn-lg"></button>
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>{{trans('content.itemId')}}</th>
                                <th>{{trans('content.itemName')}}</th>
                                <th>{{trans('content.itemDescription')}}</th>
                                <th>{{trans('content.photo')}}</th>
                                <th>{{trans('content.itemMainCat')}}</th>
                                <th>{{trans('content.itemSubCat')}}</th>
                                <th>{{trans('content.itemMaxDiscountRate')}} ( % )</th>
                                <th>{{trans('content.itemMaxQuantity')}}</th>
                                <th>{{trans('content.itemMinQuantity')}}</th>
                                <th>{{trans('content.createdat')}}</th>
                                <th>{{trans('content.status')}}</th>
                                <th>{{trans('content.control')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($items)
                                @foreach($items as $item)
                                    <tr class="tr_{{$item->id}}">
                                        <td>{{$item->id}}</td>
                                        <td>{{$item->name}}</td>
                                        <td>
                                            @if(!empty($item->description))
                                                {{$item->description}}
                                            @else
                                                ----
                                            @endif
                                        </td>
                                        <td>
                                            <img src="{{$item->getPhoto($item->photo)}}" width="60" height="60">
                                        </td>
                                        <td>{{$item->MainCategory->name}}</td>
                                        <td>
                                            @if(!empty($item->SubCategory))
                                                {{$item->SubCategory->name}}
                                            @else
                                                ----
                                            @endif
                                        </td>
                                        <td>{{$item->max_discount_rate}}</td>
                                        <td>{{$item->max_quantity}}</td>
                                        <td>{{$item->max_quantity}}</td>
                                        <td>{{$item->created_at}}</td>
                                        <td class="active_{{$item->id}}">{{$item->getActive()}}</td>
                                        <td>
                                            <a href="{{route('items.show', $item->id)}}" class="btn btn-outline-info">{{trans('content.show_item_activity')}}</a>
                                            <a href="{{route('items.edit', $item->id)}}" class="btn btn-outline-primary">{{trans('content.edit')}}</a>
                                            <a href="" class="item-delete btn btn-outline-danger" data-id="{{$item->id}}">{{trans('content.delete')}}</a>
                                            <a href="" class="item-activate btn btn-outline-info" data-id="{{$item->id}}" data-active="{{$item->active}}">
                                                @if($item->active == 1)
                                                    {{trans('content.unactivate')}}
                                                @else
                                                    {{trans('content.activate')}}
                                                @endif
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @endisset
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@stop

@section('script_datatables')
    <script type="text/javascript" src="{{asset('/plugins/DataTables-1.10.23/js/datatables.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/plugins/DataTables-1.10.23/js/datatables_buttons.js')}}"></script>
    <script type="text/javascript" src="{{asset('/plugins/DataTables-1.10.23/js/jsZIP.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/plugins/DataTables-1.10.23/js/pdfMake.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/plugins/DataTables-1.10.23/js/vfs_fonts.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/plugins/DataTables-1.10.23/js/buttons_html.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/plugins/DataTables-1.10.23/js/buttons_print.min.js')}}"></script>
    <script>
        $(document).ready( function () {
            let language_ar = {
                "emptyTable": "ليست هناك بيانات متاحة في الجدول",
                "loadingRecords": "جارٍ التحميل...",
                "processing": "جارٍ التحميل...",
                "lengthMenu": "أظهر _MENU_ مدخلات",
                "zeroRecords": "لم يعثر على أية سجلات",
                "info": "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
                "infoEmpty": "يعرض 0 إلى 0 من أصل 0 سجل",
                "infoFiltered": "(منتقاة من مجموع _MAX_ مُدخل)",
                "search": "ابحث:",
                "paginate": {
                    "first": "الأول",
                    "previous": "السابق",
                    "next": "التالي",
                    "last": "الأخير"
                },
                "aria": {
                    "sortAscending": ": تفعيل لترتيب العمود تصاعدياً",
                    "sortDescending": ": تفعيل لترتيب العمود تنازلياً"
                },
                "buttons": {
                    "copyTitle": "نسخ البيانات",
                    "copySuccess": {
                        "_": "تم نسخ البيانات الى الحافظه"
                    },
                }
            };
            @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en")
                setLanguage = "";
            @else
                setLanguage = language_ar;
            @endif
            $('table').DataTable({
                "scrollX": true,
                "language": setLanguage,
                dom: 'lBfrtip',
                buttons:  [
                    {
                        "charset": "utf-8",
                        "extend": "print",
                        "text": "{{trans('content.print')}}",
                        "filename": "{{trans('content.subCategories')}}",
                        autoPrint: true,
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5 ]
                        },
                        customize: function ( win ) {
                            $(win.document.body)
                                .css( 'font-size', '10pt' )
                                .prepend(
                                    '<img src="{{asset('/images/admin/logo/logo.jpg')}}" style="display: block; margin: 30px auto; width: 180px; height: 150px" />'
                                );
                            $(win.document.body).find( 'table' )
                                .addClass( 'compact' )
                                .css( 'font-size', '20px' );
                        }
                    },
                    {
                        "charset": "utf-8",
                        "extend": "excel",
                        "text": "{{trans('content.excel')}}",
                        "filename": "{{trans('content.subCategories')}}",
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5 ]
                        }
                    },
                    {
                        "charset": "utf-8",
                        "extend": "csv",
                        "text": "{{trans('content.csv')}}",
                        "filename": "{{trans('content.subCategories')}}",
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5 ]
                        }
                    },
                    {
                        "charset": "utf-8",
                        "extend": "copy",
                        "text": "{{trans('content.copy')}}",
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5 ]
                        }
                    },
                ]
            });
        });
    </script>
@stop

@section('ajaxscript')
    <script>
        // ajax request for deleting the language
        $(function () {
            $(".item-delete").click(function (e) {
                e.preventDefault();
                $(".success, .ajax-success").hide();
                $(".error, .ajax-error").hide();
                if (window.confirm("{{trans('content.itemdeletepromptmsg')}}"))
                {
                    let itemid = $(this).data('id');
                    let url = "{{route('items.destroy', ":id")}}";
                    url = url.replace(":id", itemid);
                    $.ajax({
                        method: 'DELETE',
                        url: url,
                        data: {_token: "{{csrf_token()}}", id: itemid},
                        success: function (response) {
                            $(".ajax-success").show().text(response.msg);
                            $(".tr_" + response.id).hide();
                        },
                        error: function (resErr) {
                            err = JSON.parse(resErr.responseText);
                            if (resErr.status === 403)
                            {
                                $(".ajax-error").show().text("{{trans('content.autherizeMsg')}}");
                            }
                            else
                            {
                                $(".ajax-error").show().text(err.msg);
                            }
                        }
                    });
                }
            });

            // ajax request for activating the language
            $(".item-activate").click(function (e) {
                e.preventDefault();
                let btn = $(this);
                let status = btn.data("active");
                let msg = (status === 1) ? "{{trans('content.unactiveitempromptmsg')}}" : "{{trans('content.activeitempromptmsg')}}";
                $(".success, .ajax-success").hide();
                $(".error, .ajax-error").hide();
                if (window.confirm(msg))
                {
                    let itemid = btn.data('id');
                    let url = "{{route('items.activate', ":id")}}";
                    url = url.replace(":id", itemid);
                    $.ajax({
                        method: 'POST',
                        url: url,
                        data: {_token: "{{csrf_token()}}", id: itemid},
                        success: function (response) {
                            $(".ajax-success").show().text(response.msg);
                            btn.data("active", response.active);
                            if (response.active === 1)
                            {
                                btn.text("{{trans('content.unactivate')}}");
                                $(".active_" + response.id).text("{{trans('content.enabled')}}");
                            }
                            else
                            {
                                btn.text("{{trans('content.activate')}}");
                                $(".active_" + response.id).text("{{trans('content.disabled')}}");
                            }
                        },
                        error: function (resErr) {
                            err = JSON.parse(resErr.responseText);
                            if (resErr.status === 403)
                            {
                                $(".ajax-error").show().text("{{trans('content.autherizeMsg')}}");
                            }
                            else
                            {
                                $(".ajax-error").show().text(err.msg);
                            }
                        }
                    });
                }
            });
        });
    </script>
@stop
