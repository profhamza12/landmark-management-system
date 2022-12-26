<?php

namespace App\Models\Admin;

use App\Observers\Admin\EmployeeObserver;
use App\Observers\Admin\UserObserver;
use App\Observers\Admin\RepresentativeObserver;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Translatable\HasTranslations;

class Employee extends Authenticatable implements CanResetPassword
{
    use HasFactory, Notifiable, HasTranslations;
    protected $table = "employees";
    protected $fillable = ['name', 'address', 'governorate', 'center', 'phone', 'target', 'commission', 'gender', 'active', 'latitude', 'longitude', 'photo', 'created_at', 'date_of_birth', 'salary', 'national_id', 'insurance_number', 'qualification', 'branch_id'];
    public $translatable = ['name', 'address', 'governorate', 'center', 'qualification'];
    public $timestamps = false;


    public static function boot()
    {
        parent::boot();
        self::observe(EmployeeObserver::class);
    }

    /* Start Scopes */
    public function scopeSelection($query)
    {
        return $query->select("id", 'name', 'address', 'governorate', 'position', 'phone', 'target', 'commission', 'gender', 'active', 'latitude', 'longitude', 'photo', 'created_at', 'date_of_birth', 'salary', 'national_id', 'insurance_number', 'qualification', 'branch_id');
    }
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
    /* End Scopes */

    /* Start Accessors and Mutators */
    public function getPhoto($photo)
    {
        return asset("/images/admin/employees/" . $photo);
    }
    public function getGender($val)
    {
        return $val == 1 ? __("content.male") : __("content.female");
    }
    public function getActive()
    {
        return $this->attributes['active'] == 1 ? trans("content.enabled") : trans("content.disabled");
    }
    /* End Accessors and Mutators */

    /* Start Relations */
    public function Groups()
    {
        return $this->belongsToMany(EmployeeGroup::class, 'employees_groups', 'emp_id', 'group_id');
    }
    public function Branch()
    {
        return $this->belongsTo(CompanyBranch::class, 'branch_id');
    }
    /* End Relations */
}
