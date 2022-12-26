<?php

namespace App\Models\Admin;

use App\Observers\Admin\StoreObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SalesInvoice extends Model
{
    use HasFactory;
    protected $fillable = ['branch_id', 'store_id', 'client_id', 'invoice_type', 'discount', 'total_amount', 'paid_amount', 'remaining_amount', 'relayed', 'created_at', 'updated_at'];
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
    public function InvoiceType()
    {
        return $this->belongsTo(InvoiceType::class, 'invoice_type', 'id');
    }
    public function SalesInvoiceItems()
    {
        return $this->hasMany(SalesInvoiceItem::class, 'sales_invoice_id', 'id');
    }
    /* End Relations */
}
