<?php

namespace App\Models\Admin;

use App\Observers\Admin\StoreObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class InventoryEntry extends Model
{
    use HasFactory;
    protected $table = "inventory_entries";
    protected $fillable = ['branch_id', 'store_id', 'created_at'];
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
    public function Store()
    {
        return $this->belongsTo(Store::class, 'store_id');
    }
    public function Branch()
    {
        return $this->belongsTo(CompanyBranch::class, 'branch_id');
    }
    public function InventoryEntryDetails()
    {
        return $this->hasMany(InventoryEntryDetail::class, 'inventory_entry_id', 'id');
    }
    /* End Relations */
}
