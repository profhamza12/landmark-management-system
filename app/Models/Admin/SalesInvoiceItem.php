<?php

namespace App\Models\Admin;

use App\Observers\Admin\StoreObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SalesInvoiceItem extends Model
{
    use HasFactory;
    protected $table = "sales_invoice_items";
    protected $fillable = ['sales_invoice_id', 'item_id', 'quantity'];
    public $timestamps = false;

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
    public function SalesInvoice()
    {
        return $this->belongsTo(SalesInvoice::class, 'sales_invoice_id', 'id');
    }
    public function Item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }
    /* End Relations */
}
