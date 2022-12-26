<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laratrust\Traits\LaratrustUserTrait;
use Spatie\Translatable\HasTranslations;

class Language extends Model
{
    use HasFactory, LaratrustUserTrait, HasTranslations;
    protected $table = 'languages';
    protected $fillable = ["name", "abbr", "direction", "active"];
    public $translatable = ['name'];
    public $timestamps = false;

    /* Start Scopes */
    public function scopeSelection($query)
    {
        return $query->select('name', 'abbr', 'direction', 'active');
    }
    public function scopeActive($query)
    {
        return $query->where("active", 1);
    }
    /* End Scopes */

    /* Start Accessors and Mutators */
    public function getActive()
    {
        return ($this->active == 1) ? __('admin.enabled') : __('admin.disabled');
    }
    /* End Accessors and Mutators */

    /* Start Relations */
    /* End Relations */

}
