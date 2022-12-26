@extends('layouts.admin.template')
@section('maincontent')
    <div class="main-content content-large">
        <div class="wraper-content">
            <div class="row">
                <div class="col-sm-12 page-info">
                    <h2>{{trans('content.vendors')}}</h2>
                    <div>
                        <a href="">{{trans('content.home')}}</a> -
                        <span>{{trans('content.vendors')}}</span>
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
                                <th>{{trans('content.vendorid')}}</th>
                                <th>{{trans('content.vendorname')}}</th>
                                <th>{{trans('content.vendorphoto')}}</th>
                                <th>{{trans('content.vendoremail')}}</th>
                                <th>{{trans('content.vendorphone')}}</th>
                                <th>{{trans('content.vendoraddress')}}</th>
                                <th>{{trans('content.creditor_amount')}}</th>
                                <th>{{trans('content.debtor_amount')}}</th>
                                <th>{{trans('content.InvoiceType')}}</th>
                                <th>{{trans('content.vendorgender')}}</th>
                                <th>{{trans('content.vendoractive')}}</th>
                                <th>{{trans('content.vendorcreatedat')}}</th>
                                <th>{{trans('content.control')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($vendors)
                                @foreach($vendors as $vendor)
                                    <tr class="tr_{{$vendor->id}}">
                                        <td>{{$vendor->id}}</td>
                                        <td>{{$vendor->name}}</td>
                                        <td>
                                            <img src="{{$vendor->getPhoto($vendor->photo)}}" width="60" height="60" />
                                        </td>
                                        <td>{{$vendor->email}}</td>
                                        <td>{{$vendor->phone}}</td>
                                        <td>{{$vendor->address}}</td>
                                        <td>{{$vendor->creditor_amount}}</td>
                                        <td>{{$vendor->debtor_amount}}</td>
                                        <td>{{$vendor->InvoiceType->display_name}}</td>
                                        <td>{{$vendor->getGender($vendor->gender)}}</td>
                                        <td class="active_{{$vendor->id}}">{{$vendor->getActive()}}</td>
                                        <td>{{$vendor->created_at}}</td>
                                        <td>
                                            <a href="{{route('vendors.show', $vendor->id)}}" class="btn btn-outline-primary">{{trans('content.show_vendor_activity')}}</a>
                                            <a href="{{route('vendors.edit', $vendor->id)}}" class="btn btn-outline-primary">{{trans('content.edit')}}</a>
                                            <a href="{{route('vendors.destroy', $vendor->id)}}" class="vendor-delete btn btn-outline-danger" data-id="{{$vendor->id}}">{{trans('content.delete')}}</a>
                                            <a href="{{route('vendors.activate', $vendor->id)}}" data-id="{{$vendor->id}}" data-active="{{$vendor->active}}" class="vendor-activate btn btn-outline-info">
                                                @if($vendor->active == 1)
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
                        "filename": "{{trans('content.vendors')}}",
                        autoPrint: true,
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6 ]
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
                        "filename": "{{trans('content.vendors')}}",
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                        }
                    },
                    {
                        "charset": "utf-8",
                        "extend": "csv",
                        "text": "{{trans('content.csv')}}",
                        "filename": "{{trans('content.vendors')}}",
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                        }
                    },
                    {
                        "charset": "utf-8",
                        "extend": "copy",
                        "text": "{{trans('content.copy')}}",
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6 ]
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
            $(".vendor-delete").click(function (e) {
                e.preventDefault();
                $(".success, .ajax-success").hide();
                $(".error, .ajax-error").hide();
                if (window.confirm("{{trans('content.vendordeletepromptmsg')}}"))
                {
                    let vendorId = $(this).data('id');
                    let url = "{{route('vendors.destroy', ":id")}}";
                    url = url.replace(":id", vendorId);
                    $.ajax({
                        method: 'DELETE',
                        url: url,
                        data: {_token: "{{csrf_token()}}", id: vendorId},
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

            $(".vendor-activate").click(function (e) {
                e.preventDefault();
                let btn = $(this);
                let status = btn.data("active");
                let msg = (status === 1) ? "{{trans('content.unactivevendorpromptmsg')}}" : "{{trans('content.activevendorpromptmsg')}}";
                $(".success, .ajax-success").hide();
                $(".error, .ajax-error").hide();
                if (window.confirm(msg)) {
                    let vendorId = btn.data('id');
                    let url = "{{route('vendors.activate', ":id")}}";
                    url = url.replace(":id", vendorId);
                    $.ajax({
                        method: 'POST',
                        url: url,
                        data: {_token: "{{csrf_token()}}", id: vendorId},
                        success: function (response) {
                            $(".ajax-success").show().text(response.msg);
                            btn.data("active", response.active);
                            if (response.active === 1) {
                                btn.text("{{trans('content.unactivate')}}");
                                $(".active_" + response.id).text("{{trans('content.enabled')}}");
                            } else {
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
