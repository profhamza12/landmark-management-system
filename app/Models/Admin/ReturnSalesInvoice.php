<?php

namespace App\Models\Admin;

use App\Observers\Admin\StoreObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ReturnSalesInvoice extends Model
{
    use HasFactory;
    protected $table = "return_sales_invoices";
    protected $fillable = ['branch_id', 'store_id', 'client_id', 'invoice_id', 'total_amount', 'return_amount', 'remaining_amount', 'relayed', 'created_at', 'updated_at'];
    public $timestamps = true;

    /* Start Scopes */
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
    /* End Scopes */

    /* Start Accessors and Mutators */
    public function getActive()
    {
        return $this->attributes['active'] == 1 ? trans("content.enabled") : trans("content.disabled");
    }
    /* End Accessors and Mutators */

    /* Start Relations */
    public function Client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
    public function Branch()
    {
        return $this->belongsTo(CompanyBranch::class, 'branch_id', 'id');
    }
    public function Store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }
    public function ReturnSalesInvoiceItems()
    {
        return $this->hasMany(ReturnSalesInvoiceItem::class, 'invoice_id', 'id');
    }
    public function SalesInvoice()
    {
        return $this->belongsTo(SalesInvoice::class, 'invoice_id', 'id');
    }
    /* End Relations */
}
