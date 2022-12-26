<?php

namespace App\Models\Admin;

use App\Observers\Admin\CompanyBranchObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class StoreTransQuantityDetail extends Model
{
    use HasFactory;
    protected  $table = "store_trans_quantities_detail";
    protected $fillable = ['trans_operation_id', 'item_id', 'unit_id', 'quantity'];
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
    public function Unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id');
    }
    public function Item()
    {
        return $this->belongsTo(Item::class, 'item_id');
    }
    /* End Relations */
}
