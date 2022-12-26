<?php

namespace App\Models\Admin;

use App\Observers\Admin\StoreObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Store extends Model
{
    use HasFactory, HasTranslations;
    protected $fillable = ['name', 'address', 'phone', 'store_keeper', 'company_branch', 'active', 'created_at', 'updated_at'];
    protected $hidden = ['updated_at'];
    public $translatable = ['name', 'address'];
    public $timestamps = true;

    public static function boot()
    {
        parent::boot();
        self::observe(StoreObserver::class);
    }

    /* Start Scopes */
    public function scopeSelection($query)
    {
        return $query->select('id', 'name', 'address', 'phone', 'store_keeper', 'company_branch', 'active', 'created_at');
    }
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
    public function storeKeeper()
    {
        return $this->belongsTo(User::class, 'store_keeper', 'id');
    }
    public function companyBranch()
    {
        return $this->belongsTo(CompanyBranch::class, 'company_branch', 'id');
    }
    /* End Relations */
}
