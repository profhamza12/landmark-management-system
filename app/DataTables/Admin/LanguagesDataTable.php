<?php

namespace App\DataTables\Admin;

use App\Models\Admin\Language;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;
use \Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class LanguagesDataTable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('action', 'languages.action')
            ->setRowId('id')
            ->addColumn('name', function ($data) {
                return $data->name;
            })
            ->addColumn('action', 'admin.language.actions');
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Language $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Language $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        $ar_lang = [
            "sProcessing" => "جارٍ التحميل...",
            "sLengthMenu"=> "أظهر _MENU_ مدخلات",
            "sZeroRecords"=> "لم يعثر على أية سجلات",
            "sInfo"=> "إظهار _START_ إلى _END_ من أصل _TOTAL_ مدخل",
            "sSearch"=> "  :ابحث",
            "oPaginate"=> [
                "sFirst"=> "الأول",
                "sPrevious"=> "السابق",
                "sNext"=> "التالي",
                "sLast"=> "الأخير"
            ],
            "oAria"=> [
                "sSortAscending"=> "=> تفعيل لترتيب العمود تصاعدياً",
                "sSortDescending"=> "=> تفعيل لترتيب العمود تنازلياً"
            ],
            "sEmptyTable"=> "لا يوجد بيانات متاحة في الجدول",
            "sInfoEmpty"=> "يعرض 0 إلى 0 من أصل 0 مُدخل",
        ];
        $translation = [];
        if (LaravelLocalization::getCurrentLocale() == "ar")
            $translation = $ar_lang;
        return $this->builder()
                    ->setTableId('languages-table')
                    ->columns($this->getColumns())
                    ->parameters([
                        'dom'          => 'Bfrtip',
                        'buttons'      => [
                            [   'extend' => 'print',
                                'text' => '<i class="fa-solid fa-print"></i>',
                            ],
                            [   'extend' => 'excel',
                                'text' => '<i class="fa-solid fa-file-export"></i>',
                            ],
                            [   'extend' => 'csv',
                                'text' => '<i class="fa-solid fa-file-csv"></i>',
                            ],
                            [   'extend' => 'reset',
                                'text' => '<i class="fa-solid fa-window-restore"></i>',
                            ],
                            [   'extend' => 'reload',
                                'text' => '<i class="fa-solid fa-rotate-right"></i>',
                            ]
                        ],
                        "language" => $translation
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->title('#ID'),
            Column::make('name')->title(__('admin.lang_name')),
            Column::make('abbr')->title(__('admin.lang_abbr')),
            Column::make('direction')->title(__('admin.lang_direction')),
            Column::make('active')->title(__('admin.active')),
            Column::computed('action')
            ->addClass('text-center')->title(__('admin.control')),
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Languages_' . date('YmdHis');
    }
}
