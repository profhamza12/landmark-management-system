<?php

namespace App\Models\Admin;

use App\Observers\Admin\CompanyBranchObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class CompanyBranch extends Model
{
    use HasFactory, HasTranslations;
    protected $table = "company_branches";
    protected $fillable = ['name', 'address', 'country', 'governorate', 'center', 'phone', 'website', 'email', 'photo', 'activity', 'finance_year', 'active', 'created_at', 'updated_at'];
    protected $hidden = ['updated_at'];
    public $translatable = ['name', 'address', 'country', 'governorate', 'center', 'activity'];
    public $timestamps = true;

    public static function boot()
    {
        parent::boot();
        self::observe(CompanyBranchObserver::class);
    }

    /* Start Scopes */
    public function scopeSelection($query)
    {
        return $query->select('id', 'name', 'address', 'country', 'governorate', 'position', 'phone', 'website', 'email', 'photo', 'activity', 'finance_year', 'active', 'created_at');
    }
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
    /* End Scopes */

    /* Start Accessors and Mutators */
    public function getPhoto($photo)
    {
        return asset("/images/admin/company_branches/" . $photo);
    }
    public function getActive()
    {
        return $this->attributes['active'] == 1 ? trans("content.enabled") : trans("content.disabled");
    }
    /* End Accessors and Mutators */

    /* Start Relations */
    public function Stores()
    {
        return $this->hasMany(Store::class, 'company_branch', 'id');
    }
    /* End Relations */
}
