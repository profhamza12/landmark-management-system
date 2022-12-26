@extends('layouts.admin.template')
@section('maincontent')
    <div class="main-content content-large">
        <div class="wraper-content">
            <div class="row">
                <div class="col-sm-12 page-info">
                    <h2>{{trans('content.users')}}</h2>
                    <div>
                        <a href="">{{trans('content.home')}}</a> -
                        <span>{{trans('content.users')}}</span>
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
                                <th>{{trans('content.username')}}</th>
                                <th>{{trans('content.userphoto')}}</th>
                                <th>{{trans('content.useremail')}}</th>
                                <th>{{trans('content.userphone')}}</th>
                                <th>{{trans('content.useraddress')}}</th>
                                <th>{{trans('content.usergroup')}}</th>
                                <th>{{trans('content.usergender')}}</th>
                                <th>{{trans('content.useractive')}}</th>
                                <th>{{trans('content.usercreatedat')}}</th>
                                <th>{{trans('content.control')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($users)
                                @foreach($users as $user)
                                    <tr class="tr_{{$user->id}}">
                                        <td>{{$user->name}}</td>
                                        <td>
                                            <img src="{{$user->getPhoto($user->photo)}}" width="60" height="60" />
                                        </td>
                                        <td>{{$user->email}}</td>
                                        <td>{{$user->phone}}</td>
                                        <td>{{$user->address}}</td>
                                        <td>
                                            @foreach($user->roles as $index => $role)
                                                @if ($index < (count($user->roles) - 1))
                                                    {{$role->display_name . " , "}}
                                                @else
                                                    {{$role->display_name}}
                                                @endif
                                            @endforeach
                                        </td>
                                        <td>{{$user->getGender($user->gender)}}</td>
                                        <td class="active_{{$user->id}}">{{$user->getActive()}}</td>
                                        <td>{{$user->created_at}}</td>
                                        <td>
                                            <a href="{{route('users.edit', $user->id)}}" class="btn btn-outline-primary">{{trans('content.edit')}}</a>
                                            <a href="" class="user-delete btn btn-outline-danger" data-id="{{$user->id}}">{{trans('content.delete')}}</a>
                                            <a href="" data-id="{{$user->id}}" data-active="{{$user->active}}" class="user-activate btn btn-outline-info">
                                                @if($user->active == 1)
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
                        "filename": "{{trans('content.users')}}",
                        autoPrint: true,
                        exportOptions: {
                            columns: [ 0, 2, 3, 4, 5, 6, 7, 8, 9 ]
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
                        "filename": "{{trans('content.users')}}",
                        exportOptions: {
                            columns: [ 0, 2, 3, 4, 5, 6, 7, 8, 9 ]
                        }
                    },
                    {
                        "charset": "utf-8",
                        "extend": "csv",
                        "text": "{{trans('content.csv')}}",
                        "filename": "{{trans('content.users')}}",
                        exportOptions: {
                            columns: [ 0, 2, 3, 4, 5, 6, 7, 8, 9 ]
                        }
                    },
                    {
                        "charset": "utf-8",
                        "extend": "copy",
                        "text": "{{trans('content.copy')}}",
                        exportOptions: {
                            columns: [ 0, 2, 3, 4, 5, 6, 7, 8, 9 ]
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
            $(".user-delete").click(function (e) {
                e.preventDefault();
                $(".success, .ajax-success").hide();
                $(".error, .ajax-error").hide();
                if (window.confirm("{{trans('content.userdeletepromptmsg')}}"))
                {
                    let empId = $(this).data('id');
                    let url = "{{route('users.destroy', ":id")}}";
                    url = url.replace(":id", empId);
                    $.ajax({
                        method: 'DELETE',
                        url: url,
                        data: {_token: "{{csrf_token()}}", id: empId},
                        success: function (response) {
                            $(".ajax-success").show().text(response.message);
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
                                $(".ajax-error").show().text(err.message);
                            }                        }
                    });
                }
            });

            $(".user-activate").click(function (e) {
                e.preventDefault();
                let btn = $(this);
                let status = btn.data("active");
                let msg = (status === 1) ? "{{trans('content.unactiveuserpromptmsg')}}" : "{{trans('content.activeuserpromptmsg')}}";
                $(".success, .ajax-success").hide();
                $(".error, .ajax-error").hide();
                if (window.confirm(msg)) {
                    let userId = btn.data('id');
                    let url = "{{route('users.activate', ":id")}}";
                    url = url.replace(":id", userId);
                    $.ajax({
                        method: 'POST',
                        url: url,
                        data: {_token: "{{csrf_token()}}", id: userId},
                        success: function (response) {
                            $(".ajax-success").show().text(response.message);
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
                                $(".ajax-error").show().text(err.message);
                            }
                        }
                    });
                }
            });
        });
    </script>
@stop
