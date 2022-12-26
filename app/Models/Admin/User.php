<?php

namespace App\Models\Admin;

use App\Observers\Admin\UserObserver;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;
use Spatie\Translatable\HasTranslations;

class User extends Authenticatable implements CanResetPassword
{
    use HasFactory, Notifiable, LaratrustUserTrait, HasTranslations;
    protected $table = "users";
    protected $fillable = ['name', 'email', 'password', 'address', 'phone', 'gender', 'photo', 'active', 'created_at', 'updated_at'];
    public $translatable = ['name', 'address'];
    protected $hidden = ['password', 'remember_token'];
    public $timestamps = true;

    public static function boot()
    {
        parent::boot();
        self::observe(UserObserver::class);
    }

    /* Start Scopes */
    public function scopeSelection($query)
    {
        return $query->select("id", 'name', 'email', 'address', 'password', 'phone', 'gender', 'photo', 'active', 'created_at');
    }
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
    /* End Scopes */

    /* Start Accessors and Mutators */
    public function getPhoto($photo)
    {
        return asset("/images/admin/users/" . $photo);
    }
    public function getGender($val)
    {
        return $val == 1 ? trans("content.male") : trans("content.female");
    }
    public function getActive()
    {
        return $this->attributes['active'] == 1 ? trans("content.enabled") : trans("content.disabled");
    }
    /* End Accessors and Mutators */

    /* Start Relations */
    public function roles()
    {
        return $this->morphToMany(Role::class, 'user', 'role_user', 'user_id', 'role_id');
    }
    /* End Relations */
}
