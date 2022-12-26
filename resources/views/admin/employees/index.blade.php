@extends('layouts.admin.template')
@section('maincontent')
    <div class="main-content content-large">
        <div class="wraper-content">
            <div class="row">
                <div class="col-sm-12 page-info">
                    <h2>{{trans('content.employees')}}</h2>
                    <div>
                        <a href="">{{trans('content.home')}}</a> -
                        <span>{{trans('content.employees')}}</span>
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
                                <th>{{trans('content.employeeid')}}</th>
                                <th>{{trans('content.employeename')}}</th>
                                <th>{{trans('content.photo')}}</th>
                                <th>{{trans('content.employeeaddress')}}</th>
                                <th>{{trans('content.employeephone')}}</th>
                                <th>{{trans('content.salary')}}</th>
                                <th>{{trans('content.employeetarget')}}</th>
                                <th>{{trans('content.employeeCommission')}}</th>
                                <th>{{trans('content.national_id')}}</th>
                                <th>{{trans('content.insurance_number')}}</th>
                                <th>{{trans('content.qualification')}}</th>
                                <th>{{trans('content.branch')}}</th>
                                <th>{{trans('content.employeegender')}}</th>
                                <th>{{trans('content.joined_date')}}</th>
                                <th>{{trans('content.date_of_birth')}}</th>
                                <th>{{trans('content.employeeactive')}}</th>
                                <th>{{trans('content.control')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($employees)
                                @foreach($employees as $employee)
                                    <tr class="tr_{{$employee->id}}">
                                        <td>{{$employee->id}}</td>
                                        <td>{{$employee->name}}</td>
                                        <td>
                                            <img src="{{$employee->getPhoto($employee->photo)}}" width="60" height="60" />
                                        </td>
                                        <td>{{$employee->address}}</td>
                                        <td>{{$employee->phone}}</td>
                                        <td>{{$employee->salary}}</td>
                                        <td>{{$employee->target}}</td>
                                        <td>{{$employee->commission . "%"}}</td>
                                        <td>{{$employee->national_id}}</td>
                                        <td>{{$employee->insurance_number}}</td>
                                        <td>{{$employee->qualification}}</td>
                                        <td>{{$employee->Branch->name}}</td>
                                        <td>{{$employee->getGender($employee->gender)}}</td>
                                        <td>{{$employee->created_at}}</td>
                                        <td>{{$employee->date_of_birth}}</td>
                                        <td class="active_{{$employee->id}}">{{$employee->getActive()}}</td>
                                        <td>
                                            <a href="{{route('employees.edit', $employee->id)}}" class="btn btn-outline-primary">{{trans('content.edit')}}</a>
                                            <a href="{{route('employees.destroy', $employee->id)}}" class="employee-delete btn btn-outline-danger" data-id="{{$employee->id}}">{{trans('content.delete')}}</a>
                                            <a href="{{route('employees.activate', $employee->id)}}" data-id="{{$employee->id}}" data-active="{{$employee->active}}" class="employee-activate btn btn-outline-info">
                                                @if($employee->active == 1)
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
                        "title" : "{{trans('content.employees')}}",
                        "text": "{{trans('content.print')}}",
                        "filename": "{{trans('content.employees')}}",
                        autoPrint: true,
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ]
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
                        "title" : "{{trans('content.employees')}}",
                        "text": "{{trans('content.excel')}}",
                        "filename": "{{trans('content.employees')}}",
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ]
                        }
                    },
                    {
                        "charset": "utf-8",
                        "extend": "csv",
                        "text": "{{trans('content.csv')}}",
                        "title" : "{{trans('content.employees')}}",
                        "filename": "{{trans('content.employees')}}",
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ]
                        }
                    },
                    {
                        "charset": "utf-8",
                        "extend": "copy",
                        "title" : "{{trans('content.employees')}}",
                        "text": "{{trans('content.copy')}}",
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6, 7, 8 ]
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
            $(".employee-delete").click(function (e) {
                e.preventDefault();
                $(".success, .ajax-success").hide();
                $(".error, .ajax-error").hide();
                if (window.confirm("{{trans('content.employeedeletepromptmsg')}}"))
                {
                    let employeeId = $(this).data('id');
                    let url = "{{route('employees.destroy', ":id")}}";
                    url = url.replace(":id", employeeId);
                    $.ajax({
                        method: 'DELETE',
                        url: url,
                        data: {_token: "{{csrf_token()}}", id: employeeId},
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

            $(".employee-activate").click(function (e) {
                e.preventDefault();
                let btn = $(this);
                let status = btn.data("active");
                let msg = (status === 1) ? "{{trans('content.unactiveemployeepromptmsg')}}" : "{{trans('content.activeemployeepromptmsg')}}";
                $(".success, .ajax-success").hide();
                $(".error, .ajax-error").hide();
                if (window.confirm(msg)) {
                    let employeeId = btn.data('id');
                    let url = "{{route('employees.activate', ":id")}}";
                    url = url.replace(":id", employeeId);
                    $.ajax({
                        method: 'POST',
                        url: url,
                        data: {_token: "{{csrf_token()}}", id: employeeId},
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
