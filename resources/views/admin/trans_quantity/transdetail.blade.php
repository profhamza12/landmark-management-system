@extends('layouts.admin.template')
@section('maincontent')
    <div class="main-content content-large">
        <div class="wraper-content">
            <div class="row">
                <div class="col-sm-12 page-info">
                    <h2>{{trans('content.trans_operations_detail')}}</h2>
                    <div>
                        <a href="">{{trans('content.home')}}</a> -
                        <span>{{trans('content.trans_operations_detail')}}</span>
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
                                <th>{{trans('content.transId')}}</th>
                                <th>{{trans('content.branch')}}</th>
                                <th>{{trans('content.src_store')}}</th>
                                <th>{{trans('content.dest_store')}}</th>
                                <th>{{trans('content.item')}}</th>
                                <th>{{trans('content.unit')}}</th>
                                <th>{{trans('content.quantity')}}</th>
                                <th>{{trans('content.date')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($operation_details)
                                @foreach($operation_details as $operation)
                                    <tr>
                                        <td>{{$store_trans_operation->id}}</td>
                                        <td>{{$store_trans_operation->Branch->name}}</td>
                                        <td>{{$store_trans_operation->SourceStore->name}}</td>
                                        <td>{{$store_trans_operation->DestStore->name}}</td>
                                        <td>{{$operation->Item->name}}</td>
                                        <td>{{$operation->Item->getSmallUnit()->Unit->name}}</td>
                                        <td>{{$operation->quantity}}</td>
                                        <td>{{$store_trans_operation->created_at}}</td>
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
            $customiseData =
                "<div class='payable-custom-data'>\
                    <div class='payable-branch'>\
                        <span>{{trans('content.branch') . " / " . $store_trans_operation->Branch->name}}</span>\
                    </div>\
                    <div class='payable-date'>\
                        <span>{{trans('content.date') . " / " . $store_trans_operation->created_at}}</span>\
                    </div>\
                    <div class='payable-code'>\
                        <span>{{trans('content.transId') . " / " . $store_trans_operation->id}}</span>\
                    </div>\
                </div>";
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
                        "title": "{{trans('content.transOperation')}}",
                        "text": "{{trans('content.print')}}",
                        "filename": "{{trans('content.transferQuantity')}}",
                        autoPrint: true,
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                        },
                        customize: function ( win ) {
                            $(win.document.body).prepend($customiseData); //after the table
                            $(win.document.body)
                                .css( 'font-size', '10pt' )
                                .prepend(
                                    '<img src="{{asset('/images/admin/logo/logo.jpg')}}" style="display: block; margin: 10px auto; width: 160px; height: 150px" />'
                                );
                            $(win.document.body).find( 'table' )
                                .addClass( 'compact' )
                                .css( 'font-size', '20px' );
                        }
                    },
                    {
                        "charset": "utf-8",
                        "extend": "excel",
                        "title": "{{trans('content.transOperation')}}",
                        "text": "{{trans('content.excel')}}",
                        "filename": "{{trans('content.transferQuantity')}}",
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                        }
                    },
                    {
                        "charset": "utf-8",
                        "extend": "csv",
                        "title": "{{trans('content.transOperation')}}",
                        "text": "{{trans('content.csv')}}",
                        "filename": "{{trans('content.transferQuantity')}}",
                        exportOptions: {
                            columns: [ 0, 1, 2, 3, 4, 5, 6 ]
                        }
                    },
                    {
                        "charset": "utf-8",
                        "extend": "copy",
                        "title": "{{trans('content.transOperation')}}",
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
