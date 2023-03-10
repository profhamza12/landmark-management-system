@extends('layouts.admin.template')
@section('maincontent')
    <div class="main-content content-large">
        <div class="wraper-content">
            <div class="row">
                <div class="col-sm-12 page-info">
                    <h2>{{trans('content.vendor') . " : " . $vendor->name}}</h2>
                    <div>
                        <a href="">{{trans('content.home')}}</a> -
                        <span>{{trans('content.show_vendor_activity')}}</span>
                        <button class="print btn btn-primary
                                @if(\Mcamara\LaravelLocalization\Facades\LaravelLocalization::getCurrentLocale() == "en") float-right @else float-left @endif"
                                onclick="window.print()">{{trans("content.print")}}</button>
                    </div>
                </div>
                <div class="col-sm-12 table-data">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th colspan="6">{{trans('content.vendor_amount')}}</th>
                            </tr>
                            <tr>
                                <th>{{trans('content.vendorid')}}</th>
                                <th>{{trans('content.creditor_amount')}}</th>
                                <th>{{trans('content.debtor_amount')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($vendor)
                                <tr>
                                    <td>{{$vendor->id}}</td>
                                    <td>{{$vendor->creditor_amount}}</td>
                                    <td>{{$vendor->debtor_amount}}</td>
                                </tr>
                            @endisset
                        </tbody>
                    </table>
                </div>
                <div class="col-sm-12 table-data" style="margin: 55px 0">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <th colspan="10">{{trans('content.purchases_invoices')}}</th>
                        </tr>
                        <tr>
                            <th>{{trans('content.invoice_id')}}</th>
                            <th>{{trans('content.total_amount')}}</th>
                            <th>{{trans('content.paid_amount')}}</th>
                            <th>{{trans('content.remaining_amount')}}</th>
                            <th>{{trans('content.discount')}}</th>
                            <th>{{trans('content.date')}}</th>
                        </tr>
                        </thead>
                        <tbody>
                        @isset($purchases_invoices)
                            @foreach($purchases_invoices as $invoice)
                                <tr class="tr_{{$invoice->id}}">
                                    <td>{{$invoice->id}}</td>
                                    <td>{{$invoice->total_amount}}</td>
                                    <td>{{$invoice->paid_amount}}</td>
                                    <td>{{$invoice->remaining_amount}}</td>
                                    <td>{{$invoice->discount}}</td>
                                    <td>{{$invoice->created_at}}</td>
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
            });
        });
    </script>
@stop
