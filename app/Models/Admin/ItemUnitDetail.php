<?php

namespace App\Models\Admin;

use App\Observers\Admin\StoreObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ItemUnitDetail extends Model
{
    use HasFactory;
    public $table = "item_unit_detail";
    protected $fillable = ['item_id', 'unit_id', 'unit_item_count', 'selling_price', 'purchasing_price', 'wholesale_price', 'wholesale2_price'];
    public $timestamps = false;

    /* Start Scopes */
    public function scopeSelection($query)
    {
        return $query->select('id', 'item_id', 'unit_id', 'unit_item_count', 'selling_price', 'purchasing_price', 'wholesale_price', 'wholesale2_price');
    }
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
    /* End Scopes */

    /* Start Relations */
    public function Unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }
    /* End Relations */
}
