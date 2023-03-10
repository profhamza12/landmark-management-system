@extends('layouts.admin.template')
@section('maincontent')
    <div class="main-content content-large">
        <div class="wraper-content">
            <div class="row">
                <div class="col-sm-12 page-info">
                    <h2>{{trans('content.payable_entries')}}</h2>
                    <div>
                        <a href="">{{trans('content.home')}}</a> -
                        <span>{{trans('content.payable_entries')}}</span>
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
                                <th>{{trans('content.payableEntryId')}}</th>
                                <th>{{trans('content.payableEntryClient')}}</th>
                                <th>{{trans('content.date')}}</th>
                                <th>{{trans('content.control')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($payable_entries)
                                @foreach($payable_entries as $entry)
                                    <tr class="tr_{{$entry->id}}">
                                        <td>{{$entry->id}}</td>
                                        <td>{{$entry->Client->name}}</td>
                                        <td>{{$entry->created_at}}</td>
                                        <td>
                                            <a href="{{route('payable_entries.show', $entry->id)}}" class="btn btn-outline-info">{{trans('content.showPayableEntry')}}</a>
                                            @if($entry->relayed == 0)
                                                <a href="{{route('payable_entries.edit', $entry->id)}}" class="edit btn btn-outline-primary">{{trans('content.edit')}}</a>
                                                <a href="" data-id="{{$entry->id}}" class="delete payable-delete btn btn-outline-danger">{{trans('content.delete')}}</a>
                                                <a href="" data-id="{{$entry->id}}" class="relay payable-relay btn btn-outline-info">{{trans('content.relay')}}</a>
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
                        "filename": "{{trans('content.payable_entries')}}",
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
                        "filename": "{{trans('content.payable_entries')}}",
                        exportOptions: {
                            columns: [ 0, 1, 2 ]
                        }
                    },
                    {
                        "charset": "utf-8",
                        "extend": "csv",
                        "text": "{{trans('content.csv')}}",
                        "filename": "{{trans('content.payable_entries')}}",
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
            $(".payable-delete").click(function (e) {
                e.preventDefault();
                $(".success, .ajax-success").hide();
                $(".error, .ajax-error").hide();
                if (window.confirm("{{trans('content.entrydeletepromptmsg')}}"))
                {
                    let entryId = $(this).data('id');
                    let url = "{{route('payable_entries.destroy', ":id")}}";
                    url = url.replace(":id", entryId);
                    $.ajax({
                        method: 'DELETE',
                        url: url,
                        data: {_token: "{{csrf_token()}}", id: entryId},
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
            $(".payable-relay").click(function (e) {
                e.preventDefault();
                $(".success, .ajax-success").hide();
                $(".error, .ajax-error").hide();
                if (window.confirm("{{trans('content.entryrelaypromptmsg')}}"))
                {
                    let payableId = $(this).data('id');
                    let url = "{{route('payable_entries.relay', ":id")}}";
                    url = url.replace(":id", payableId);
                    $.ajax({
                        method: 'POST',
                        url: url,
                        data: {_token: "{{csrf_token()}}", id: payableId},
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
