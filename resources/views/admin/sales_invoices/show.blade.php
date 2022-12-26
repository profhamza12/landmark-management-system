@extends('layouts.admin.template')
@section('maincontent')
    <div class="main-content content-large">
        <div class="wraper-content">
            <div class="row">
                <div class="col-sm-12 page-info">
                    <h2>{{trans('content.sales_invoices')}}</h2>
                    <div>
                        <a href="">{{trans('content.home')}}</a> -
                        <span>{{trans('content.saleInvoice')}}</span>
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
                                <th>{{trans('content.item_code')}}</th>
                                <th>{{trans('content.item')}}</th>
                                <th>{{trans('content.unit')}}</th>
                                <th>{{trans('content.quantity')}}</th>
                                <th>{{trans('content.unit_price')}}</th>
                                <th>{{trans('content.all_price')}}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @isset($invoice_items)
                                @foreach($invoice_items as $_item)
                                    <tr>
                                        <td>{{$_item->Item->id}}</td>
                                        <td>{{$_item->Item->name}}</td>
                                        <td>{{$_item->Item->getSmallUnit()->Unit->name}}</td>
                                        <td>{{$_item->quantity}}</td>
                                        <td>{{$_item->Item->getSmallUnit()->selling_price . " " . $_item->Item->Coin->name}}</td>
                                        <td>{{($_item->Item->getSmallUnit()->selling_price * $_item->quantity) . " " . $_item->Item->Coin->name}}</td>
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
                        <span>{{trans('content.branch') . " / " . $invoice->Branch->name}}</span>\
                    </div>\
                    <div class='payable-store'>\
                        <span>{{trans('content.store') . " / " . $invoice->Store->name}}</span>\
                    </div>\
                    <div class='payable-client'>\
                        <span>{{trans('content.client') . " / " . $invoice->Client->name}}</span>\
                    </div>\
                    <div class='payable-date'>\
                        <span>{{trans('content.date') . " / " . $invoice->created_at}}</span>\
                    </div>\
                    <div class='payable-code'>\
                        <span>{{trans('content.invoiceId') . " / " . $invoice->id}}</span>\
                    </div>\
                    <div class='payable-type'>\
                        <span>{{trans('content.invoiceType') . " / " . $invoice->InvoiceType->display_name}}</span>\
                    </div>\
                </div>";
            $invoice_price_details =
                "<div class='payable-custom-data'>\
                    <div class='payable-total_amount'>\
                        <span>{{trans('content.total_amount') . " / " . $invoice->total_amount}}</span>\
                    </div>\
                    <div class='payable-discount'>\
                        <span>{{trans('content.discount') . " / " . $invoice->discount}}</span>\
                    </div>\
                    <div class='payable-paid_amount'>\
                        <span>{{trans('content.paid_amount') . " / " . $invoice->paid_amount}}</span>\
                    </div>\
                    <div class='payable-remaining_amount'>\
                        <span>{{trans('content.remaining_amount') . " / " . $invoice->remaining_amount}}</span>\
                    </div>\
                </div>";
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
                        "title": "{{trans('content.saleInvoice')}}",
                        "text": "{{trans('content.print')}}",
                        "filename": "{{trans('content.saleInvoice')}}",
                        autoPrint: true,
                        exportOptions: {
                            columns: [ 0, 1, 3, 4, 5 ]
                        },
                        customize: function ( win ) {
                            $(win.document.body).prepend($customiseData); //after the table
                            $(win.document.body).append($invoice_price_details);
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
                        "title": "{{trans('content.saleInvoice')}}",
                        "text": "{{trans('content.excel')}}",
                        "filename": "{{trans('content.saleInvoice')}}",
                        exportOptions: {
                            columns: [ 0, 1, 3, 4, 5 ]
                        }
                    },
                    {
                        "charset": "utf-8",
                        "extend": "csv",
                        "title": "{{trans('content.saleInvoice')}}",
                        "messageTop": "{{trans('content.date') . " / " . ($invoice->created_at)}}",
                        "text": "{{trans('content.csv')}}",
                        "filename": "{{trans('content.saleInvoice')}}",
                        exportOptions: {
                            columns: [ 0, 1, 3, 4, 5 ]
                        }
                    },
                    {
                        "charset": "utf-8",
                        "extend": "copy",
                        "title": "{{trans('content.saleInvoice')}}",
                        "messageTop": "{{trans('content.date') . " / " . ($invoice->created_at)}}",
                        "text": "{{trans('content.copy')}}",
                        exportOptions: {
                            columns: [ 0, 1, 3, 4, 5 ]
                        }
                    },
                ]
            });
        });
    </script>
@stop
