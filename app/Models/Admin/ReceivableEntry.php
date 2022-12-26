<?php

namespace App\Models\Admin;

use App\Observers\Admin\StoreObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ReceivableEntry extends Model
{
    use HasFactory;
    protected $fillable = ['branch_id', 'store_id', 'vendor_id', 'relayed', 'created_at'];
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
    public function Vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id', 'id');
    }
    public function Branch()
    {
        return $this->belongsTo(CompanyBranch::class, 'branch_id', 'id');
    }
    public function Store()
    {
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }
    public function ReceivableEntryDetails()
    {
        return $this->hasMany(ReceivableEntryDetail::class, 'receivable_entry_id', 'id');
    }

    /* End Relations */
}
