@extends('layouts.admin.template')
@section('maincontent')
    <div class="main-content content-large">
        <div class="wraper-content">
            <div class="row">
                <div class="col-sm-12 page-info">
                    <h2>{{trans('content.client_groups')}}</h2>
                    <div>
                        <a href="">{{trans('content.home')}}</a> -
                        <span>{{trans('content.client_groups')}}</span>
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
                                <th>{{trans('content.groupname')}}</th>
                                <th>{{trans('content.groupdisplayname')}}</th>
                                <th>{{trans('content.groupdescription')}}</th>
                                <th>{{trans('content.status')}}</th>
                                <th>{{trans('content.createdat')}}</th>
                                <th>{{trans('content.control')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($groups)
                                @foreach($groups as $group)
                                    <tr class="tr_{{$group->id}}">
                                        <td>{{$group->name}}</td>
                                        <td>{{$group->display_name}}</td>
                                        <td>{{$group->description}}</td>
                                        <td class="active_{{$group->id}}">{{$group->getActive()}}</td>
                                        <td>{{$group->created_at}}</td>
                                        <td>
                                            <a href="{{route('clients_groups.edit', $group->id)}}" class="btn btn-outline-primary">{{trans('content.edit')}}</a>
                                            <a href="{{route('clients_groups.destroy', $group->id)}}" class="group-delete btn btn-outline-danger" data-id="{{$group->id}}">{{trans('content.delete')}}</a>
                                            <a href="{{route('clients_groups.activate', $group->id)}}" data-id="{{$group->id}}" data-active="{{$group->active}}" class="group-activate btn btn-outline-info">
                                                @if($group->active == 1)
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
                "emptyTable": "???????? ???????? ???????????? ?????????? ???? ????????????",
                "loadingRecords": "???????? ??????????????...",
                "processing": "???????? ??????????????...",
                "lengthMenu": "???????? _MENU_ ????????????",
                "zeroRecords": "???? ???????? ?????? ?????? ??????????",
                "info": "?????????? _START_ ?????? _END_ ???? ?????? _TOTAL_ ????????",
                "infoEmpty": "???????? 0 ?????? 0 ???? ?????? 0 ??????",
                "infoFiltered": "(???????????? ???? ?????????? _MAX_ ??????????)",
                "search": "????????:",
                "paginate": {
                    "first": "??????????",
                    "previous": "????????????",
                    "next": "????????????",
                    "last": "????????????"
                },
                "aria": {
                    "sortAscending": ": ?????????? ???????????? ???????????? ????????????????",
                    "sortDescending": ": ?????????? ???????????? ???????????? ????????????????"
                },
                "buttons": {
                    "copyTitle": "?????? ????????????????",
                    "copySuccess": {
                        "_": "???? ?????? ???????????????? ?????? ??????????????"
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
                        "filename": "{{trans('content.client_groups')}}",
                        autoPrint: true,
                        exportOptions: {
                            columns: [ 0, 1 ]
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
                        "filename": "{{trans('content.client_groups')}}",
                        exportOptions: {
                            columns: [ 0, 1 ]
                        }
                    },
                    {
                        "charset": "utf-8",
                        "extend": "csv",
                        "text": "{{trans('content.csv')}}",
                        "filename": "{{trans('content.client_groups')}}",
                        exportOptions: {
                            columns: [ 0, 1 ]
                        }
                    },
                    {
                        "charset": "utf-8",
                        "extend": "copy",
                        "text": "{{trans('content.copy')}}",
                        exportOptions: {
                            columns: [ 0, 1 ]
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
            $(".group-delete").click(function (e) {
                e.preventDefault();
                $(".success, .ajax-success").hide();
                $(".error, .ajax-error").hide();
                if (window.confirm("{{trans('content.groupdeletepromptmsg')}}"))
                {
                    let groupId = $(this).data('id');
                    let url = "{{route('clients_groups.destroy', ":id")}}";
                    url = url.replace(":id", groupId);
                    $.ajax({
                        method: 'DELETE',
                        url: url,
                        data: {_token: "{{csrf_token()}}", id: groupId},
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

            $(".group-activate").click(function (e) {
                e.preventDefault();
                let btn = $(this);
                let status = btn.data("active");
                let msg = (status === 1) ? "{{trans('content.unactivegrouppromptmsg')}}" : "{{trans('content.activegrouppromptmsg')}}";
                $(".success, .ajax-success").hide();
                $(".error, .ajax-error").hide();
                if (window.confirm(msg)) {
                    let groupId = btn.data('id');
                    let url = "{{route('clients_groups.activate', ":id")}}";
                    url = url.replace(":id", groupId);
                    $.ajax({
                        method: 'POST',
                        url: url,
                        data: {_token: "{{csrf_token()}}", id: groupId},
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
