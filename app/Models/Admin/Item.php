<?php

namespace App\Models\Admin;

use App\Observers\Admin\StoreObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Item extends Model
{
    use HasFactory, HasTranslations;
    public $table = "items";
    protected $fillable = ['name', 'description', 'photo', 'maincat_id', 'subcat_id', 'coin_id', 'max_discount_rate', 'max_quantity', 'min_quantity', 'active', 'created_at', 'updated_at'];
    protected $hidden = ['updated_at'];
    public $translatable = ['name', 'description'];
    public $timestamps = true;

    /* Start Scopes */
    public function scopeSelection($query)
    {
        return $query->select('id', 'name', 'description', 'photo', 'maincat_id', 'subcat_id', 'coin_id', 'max_discount_rate', 'max_quantity', 'min_quantity', 'active', 'created_at');
    }
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
    /* End Scopes */

    /* Start Accessors and Mutators */
    public function getPhoto($photo)
    {
        return asset("/images/admin/items/" . $photo);
    }
    public function getActive()
    {
        return $this->attributes['active'] == 1 ? trans("content.enabled") : trans("content.disabled");
    }
    public function getSmallUnit()
    {
        $small_unit = ItemUnitDetail::where('item_id', $this->id)->where('unit_item_count', 1)->first();
        return $small_unit;
    }
    /* End Accessors and Mutators */

    /* Start Relations */
    public function MainCategory()
    {
        return $this->belongsTo(MainCategory::class, 'maincat_id', 'id');
    }
    public function SubCategory()
    {
        return $this->belongsTo(SubCategory::class, 'subcat_id', 'id');
    }
    public function ItemUnitPrices()
    {
        return $this->hasMany(ItemUnitDetail::class, 'item_id', 'id');
    }
    public function Stores()
    {
        return $this->belongsToMany(Store::class, 'store_quantities', 'item_id', 'store_id');
    }
    public function StoreQuantities()
    {
        return $this->hasMany(StoreQuantity::class, 'item_id');
    }
    public function Coin()
    {
        return $this->belongsTo(Coin::class, 'coin_id', 'id');
    }
    public function PurchasesInvoices()
    {
        return $this->belongsToMany(PurchaseInvoice::class, 'purchases_invoice_items', 'item_id', 'purchases_invoice_id');
    }
    public function SalesInvoices()
    {
        return $this->belongsToMany(SalesInvoice::class, 'sales_invoice_items', 'item_id', 'sales_invoice_id');
    }
    /* End Relations */
}
