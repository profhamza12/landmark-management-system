<?php

namespace App\Models\Admin;
use App\Observers\Admin\RoleObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laratrust\Models\LaratrustRole;
use Laratrust\Traits\LaratrustRoleTrait;
use Spatie\Translatable\HasTranslations;

class Role extends LaratrustRole
{
    use HasFactory, HasTranslations;
    protected $table = "roles";
    protected $fillable = ['name', 'display_name', 'description', 'active', 'created_at', 'updated_at'];
    public $translatable = ['display_name', 'description'];
    public $timestamps = true;

    public static function boot()
    {
        parent::boot();
        self::observe(RoleObserver::class);
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
    public function users()
    {
        return $this->belongsToMany(User::class, 'role_user', 'role_id', 'user_id');
    }
    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'permission_role', 'role_id', 'permission_id');
    }
    /* End Relations */
}
