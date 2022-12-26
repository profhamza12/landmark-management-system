@extends('layouts.admin.template')
@section('maincontent')
    <div class="main-content content-large">
        <div class="wraper-content">
            <div class="row">
                <div class="col-sm-12 page-info">
                    <h2>{{trans('content.permissions')}}</h2>
                    <div>
                        <a href="">{{trans('content.home')}}</a> -
                        <span>{{trans('content.permissions')}}</span>
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
                                <th>{{trans('content.permissionname')}}</th>
                                <th>{{trans('content.permissiondisplayname')}}</th>
                                <th>{{trans('content.permissiondescription')}}</th>
                                <th>{{trans('content.status')}}</th>
                                <th>{{trans('content.createdat')}}</th>
                                <th>{{trans('content.control')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($permissions)
                                @foreach($permissions as $permission)
                                    <tr class="tr_{{$permission->id}}">
                                        <td>{{$permission->name}}</td>
                                        <td>{{$permission->display_name}}</td>
                                        <td>{{$permission->description}}</td>
                                        <td class="active_{{$permission->id}}">{{$permission->getActive()}}</td>
                                        <td>{{$permission->created_at}}</td>
                                        <td>
                                            <a href="{{route('permissions.edit', $permission->id)}}" class="btn btn-outline-primary">{{trans('content.edit')}}</a>
                                            <a href="{{route('permissions.destroy', $permission->id)}}" class="permission-delete btn btn-outline-danger" data-id="{{$permission->id}}">{{trans('content.delete')}}</a>
                                            <a href="{{route('permissions.activate', $permission->id)}}" data-id="{{$permission->id}}" data-active="{{$permission->active}}" class="permission-activate btn btn-outline-info">
                                                @if($permission->active == 1)
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
                        "filename": "{{trans('content.permisssions')}}",
                        autoPrint: true,
                        exportOptions: {
                            columns: [ 0, 1, 2 ]
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
                        "filename": "{{trans('content.permissions')}}",
                        exportOptions: {
                            columns: [ 0, 1, 2 ]
                        }
                    },
                    {
                        "charset": "utf-8",
                        "extend": "csv",
                        "text": "{{trans('content.csv')}}",
                        "filename": "{{trans('content.permissions')}}",
                        exportOptions: {
                            columns: [ 0, 1, 2 ]
                        }
                    },
                    {
                        "charset": "utf-8",
                        "extend": "copy",
                        "text": "{{trans('content.copy')}}",
                        exportOptions: {
                            columns: [ 0, 1, 2 ]
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
            $(".permission-delete").click(function (e) {
                e.preventDefault();
                $(".success, .ajax-success").hide();
                $(".error, .ajax-error").hide();
                if (window.confirm("{{trans('content.permissiondeletepromptmsg')}}"))
                {
                    let permissionId = $(this).data('id');
                    let url = "{{route('permissions.destroy', ":id")}}";
                    url = url.replace(":id", permissionId);
                    $.ajax({
                        method: 'DELETE',
                        url: url,
                        data: {_token: "{{csrf_token()}}", id: permissionId},
                        success: function (response) {
                            $(".ajax-success").show().text(response.msg);
                            $(".tr_" + response.id).hide();
                        },
                        error: function (resErr) {
                            err = JSON.parse(resErr.responseText);
                            $(".ajax-error").show().text(err.msg);
                        }
                    });
                }
            });

            $(".permission-activate").click(function (e) {
                e.preventDefault();
                let btn = $(this);
                let status = btn.data("active");
                let msg = (status === 1) ? "{{trans('content.unactivepermissionpromptmsg')}}" : "{{trans('content.activepermissionpromptmsg')}}";
                $(".success, .ajax-success").hide();
                $(".error, .ajax-error").hide();
                if (window.confirm(msg)) {
                    let permissionId = btn.data('id');
                    let url = "{{route('permissions.activate', ":id")}}";
                    url = url.replace(":id", permissionId);
                    $.ajax({
                        method: 'POST',
                        url: url,
                        data: {_token: "{{csrf_token()}}", id: permissionId},
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
                            $(".ajax-error").show().text(err.msg);
                        }
                    });
                }
            });
        });
    </script>
@stop
