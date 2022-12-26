<?php

namespace App\Models\Admin;

use App\Observers\Admin\StoreObserver;
use App\Observers\Admin\SubCatObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class SubCategory extends Model
{
    use HasFactory, HasTranslations;
    use \Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;
    public $table = "sub_categories";
    protected $fillable = ['name', 'description', 'photo', 'parent_id', 'cat_id', 'active', 'created_at', 'updated_at'];
    protected $hidden = ['updated_at'];
    public $translatable = ['name', 'description'];
    public $timestamps = true;

    public static function boot()
    {
        parent::boot();
        self::observe(SubCatObserver::class);
    }

    /* Start Scopes */
    public function scopeSelection($query)
    {
        return $query->select('id', 'name', 'description', 'photo', 'active', 'parent_id', 'cat_id', 'created_at');
    }
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
    /* End Scopes */

    /* Start Accessors and Mutators */
    public function getPhoto($photo)
    {
        return asset("/images/admin/sub-categories/" . $photo);
    }
    public function getActive()
    {
        return $this->attributes['active'] == 1 ? trans("content.enabled") : trans("content.disabled");
    }
    /* End Accessors and Mutators */

    /* Start Relations */
    public function MainCategory()
    {
        return $this->belongsTo(MainCategory::class, 'cat_id', 'id');
    }
    public function DirectSubCategories()
    {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }
    public function parentSubCategory()
    {
        return $this->belongsTo(self::class, 'parent_id', 'id');
    }
    /* End Relations */
}
