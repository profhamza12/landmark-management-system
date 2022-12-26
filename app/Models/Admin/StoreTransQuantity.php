<?php

namespace App\Models\Admin;

use App\Observers\Admin\CompanyBranchObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class StoreTransQuantity extends Model
{
    use HasFactory;
    protected $fillable = ['branch_id', 'src_store', 'dest_store', 'relayed', 'created_at'];
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
    public function StoreTransQuantities()
    {
        return $this->hasMany(StoreTransQuantityDetail::class, 'trans_operation_id', 'id');
    }
    public function SourceStore()
    {
        return $this->belongsTo(Store::class, 'src_store');
    }
    public function DestStore()
    {
        return $this->belongsTo(Store::class, 'dest_store');
    }
    public function Branch()
    {
        return $this->belongsTo(CompanyBranch::class, 'branch_id');
    }
    /* End Relations */
}
