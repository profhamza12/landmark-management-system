<?php

namespace App\Models\Admin;
use App\Observers\Admin\RoleObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laratrust\Models\LaratrustRole;
use Laratrust\Traits\LaratrustRoleTrait;
use Spatie\Translatable\HasTranslations;

class EmployeeGroup extends Model
{
    use HasFactory, HasTranslations;
    protected $table = "groups";
    protected $fillable = ['name', 'display_name', 'description', 'active', 'created_at'];
    public $translatable = ['display_name', 'description'];
    public $timestamps = true;

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
    public function Employees()
    {
        return $this->belongsToMany(Employee::class, 'employees_groups', 'group_id', 'emp_id',);
    }
    /* End Relations */
}
