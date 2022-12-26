@extends('layouts.admin.template')
@section('maincontent')
    <div class="main-content content-large">
        <div class="wraper-content">
            <div class="row">
                <div class="col-sm-12 page-info">
                    <h2>{{trans('content.trans_quantities_operations')}}</h2>
                    <div>
                        <a href="">{{trans('content.home')}}</a> -
                        <span>{{trans('content.trans_quantities_operations')}}</span>
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
                                <th>{{trans('content.storeTransId')}}</th>
                                <th>{{trans('content.date')}}</th>
                                <th>{{trans('content.control')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($store_trans_operations)
                                @foreach($store_trans_operations as $operation)
                                    <tr class="tr_{{$operation->id}}">
                                        <td>{{$operation->id}}</td>
                                        <td>{{$operation->created_at}}</td>
                                        <td>
                                            <a href="{{route('trans_quantity.trans_detail', $operation->id)}}" class="btn btn-outline-info">{{trans('content.operationDetail')}}</a>
                                            @if($operation->relayed == 0)
                                                <a href="{{route('trans_quantity.edit', $operation->id)}}" class="edit btn btn-outline-primary">{{trans('content.edit')}}</a>
                                                <a href="" data-id="{{$operation->id}}" class="delete trans-delete btn btn-outline-danger">{{trans('content.delete')}}</a>
                                                <a href="" data-id="{{$operation->id}}" class="relay trans-relay btn btn-outline-info">{{trans('content.relay')}}</a>
                                            @endif
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
                        "filename": "{{trans('content.transferQuantity')}}",
                        autoPrint: true,
                        exportOptions: {
                            columns: [ 0, 1, 2, 3 ]
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
                        "filename": "{{trans('content.transferQuantity')}}",
                        exportOptions: {
                            columns: [ 0, 1, 2, 3 ]
                        }
                    },
                    {
                        "charset": "utf-8",
                        "extend": "csv",
                        "text": "{{trans('content.csv')}}",
                        "filename": "{{trans('content.transferQuantity')}}",
                        exportOptions: {
                            columns: [ 0, 1, 2, 3 ]
                        }
                    },
                    {
                        "charset": "utf-8",
                        "extend": "copy",
                        "text": "{{trans('content.copy')}}",
                        exportOptions: {
                            columns: [ 0, 1, 2, 3 ]
                        }
                    },
                ]
            });
        });
    </script>
@stop
@section('ajaxscript')
    <script>
        $(function () {
            $(".trans-delete").click(function (e) {
                e.preventDefault();
                $(".success, .ajax-success").hide();
                $(".error, .ajax-error").hide();
                if (window.confirm("{{trans('content.transdeletepromptmsg')}}"))
                {
                    let transId = $(this).data('id');
                    let url = "{{route('trans_quantity.destroy', ":id")}}";
                    url = url.replace(":id", transId);
                    $.ajax({
                        method: 'DELETE',
                        url: url,
                        data: {_token: "{{csrf_token()}}", id: transId},
                        success: function (response) {
                            $(".ajax-success").show().text(response.msg);
                            $(".tr_" + response.id).hide();
                        },
                        error: function (resErr) {
                            err = JSON.parse(resErr.responseText);
                            if(resErr.status === 403)
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
            $(".trans-relay").click(function (e) {
                e.preventDefault();
                $(".success, .ajax-success").hide();
                $(".error, .ajax-error").hide();
                if (window.confirm("{{trans('content.transrelaypromptmsg')}}"))
                {
                    let transId = $(this).data('id');
                    let url = "{{route('trans_quantity.relay', ":id")}}";
                    url = url.replace(":id", transId);
                    $.ajax({
                        method: 'POST',
                        url: url,
                        data: {_token: "{{csrf_token()}}", id: transId},
                        success: function (response) {
                            $(".tr_" + response.id).find(".edit, .delete, .relay").remove();
                            $(".ajax-success").show().text(response.msg);
                        },
                        error: function (resErr) {
                            err = JSON.parse(resErr.responseText);
                            if(resErr.status === 403)
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
