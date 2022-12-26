<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Unit extends Model
{
    use HasFactory, HasTranslations;
    protected $table = "units";
    protected $fillable = ['name', 'active', 'created_at', 'updated_at'];
    protected $hidden = ['updated_at'];
    public $translatable = ['name'];
    public $timestamps = true;

    /* Start Scopes */
    public function scopeSelection($query)
    {
        return $query->select('id', 'name', 'active', 'created_at');
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
    /* End Relations */
}
