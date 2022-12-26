<?php

namespace App\Models\Admin;

use App\Observers\Admin\PermissionObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Laratrust\Models\LaratrustPermission;
use Spatie\Translatable\HasTranslations;

class Permission extends LaratrustPermission
{
    use HasFactory;
    use HasTranslations;
    protected $table = "permissions";
    protected $fillable = ['name', 'display_name', 'description', 'active', 'created_at', 'updated_at'];
    public $translatable = ['display_name', 'description'];
    public $timestamps = true;

    public static function boot()
    {
        parent::boot();
        self::observe(PermissionObserver::class);
    }

    /* Start Accessors and Mutators */
    public function getActive()
    {
        return $this->attributes['active'] == 1 ? trans("content.enabled") : trans("content.disabled");
    }
    /* End Accessors and Mutators */

    /* Start Scopes */
    public function scopeActive($query)
    {
        return $query->where("active", 1);
    }
    /* End Scopes */

    /* Start Relations */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'permission_role', 'permission_id', 'role_id', 'id', 'id');
    }
    /* End Relations */
}
