<?php

namespace App\Models\Admin;

use App\Observers\Admin\StoreObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class StoreQuantity extends Model
{
    use HasFactory;
    public $table = "store_quantities";
    protected $fillable = ['branch_id', 'item_id', 'store_id', 'quantity'];
    public $timestamps = false;

    /* Start Scopes */
    public function scopeSelection($query)
    {
        return $query->select('id', 'branch_id', 'item_id', 'store_id', 'quantity');
    }
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
    /* End Scopes */

    /* Start Relations */
    public function Item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }
    public function Branch()
    {
        return $this->belongsTo(CompanyBranch::class, 'branch_id', 'id');
    }
    public function Store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }
    /* End Relations */
}
