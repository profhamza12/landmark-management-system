<?php

namespace App\Models\Admin;

use App\Observers\Admin\MainCatObserver;
use App\Observers\Admin\StoreObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class MainCategory extends Model
{
    use HasFactory, HasTranslations;
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
    public $table = "main_categories";
    protected $fillable = ['name', 'description', 'photo', 'sectoral_sale_rate', 'whole_sale_rate', 'whole_sale2_rate', 'active', 'created_at', 'updated_at'];
    protected $hidden = ['updated_at'];
    public $translatable = ['name', 'description'];
    public $timestamps = true;

    public static function boot()
    {
        parent::boot();
        self::observe(MainCatObserver::class);
    }

    /* Start Scopes */
    public function scopeSelection($query)
    {
        return $query->select('id', 'name', 'description', 'photo', 'sectoral_sale_rate', 'whole_sale_rate', 'whole_sale2_rate', 'active', 'created_at');
    }
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
    /* End Scopes */

    /* Start Accessors and Mutators */
    public function getPhoto($photo)
    {
        return asset("/images/admin/main-categories/" . $photo);
    }
    public function getActive()
    {
        return $this->attributes['active'] == 1 ? trans("content.enabled") : trans("content.disabled");
    }
    /* End Accessors and Mutators */

    /* Start Relations */
    public function SubCategories()
    {
        return $this->hasMany(SubCategory::class, 'cat_id', 'id');
    }
    /* End Relations */
}
