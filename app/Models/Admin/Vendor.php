<?php

namespace App\Models\Admin;

use App\Observers\Admin\UserObserver;
use App\Observers\Admin\VendorObserver;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Translatable\HasTranslations;

class Vendor extends Authenticatable implements CanResetPassword
{
    use HasFactory, Notifiable, HasTranslations;
    protected $table = "vendors";
    protected $fillable = ['name', 'email', 'password', 'address', 'governorate', 'position', 'phone', 'gender', 'photo', 'creditor_amount', 'debtor_amount', 'invoice_type', 'active', 'latitude', 'longitude', 'created_at', 'updated_at'];
    public $translatable = ['name', 'address', 'governorate', 'position'];
    protected $hidden = ['password', 'remember_token'];
    public $timestamps = true;

    public static function boot()
    {
        parent::boot();
        self::observe(VendorObserver::class);
    }

    /* Start Scopes */
    public function scopeSelection($query)
    {
        return $query->select("id", 'name', 'email', 'address', 'governorate', 'position', 'password', 'phone', 'gender', 'photo', 'creditor_amount', 'debtor_amount', 'invoice_type', 'latitude', 'longitude', 'active', 'created_at', 'updated_at');
    }
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
    /* End Scopes */

    /* Start Accessors and Mutators */
    public function getPhoto($photo)
    {
        return asset("/images/admin/vendors/" . $photo);
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
    public function InvoiceType()
    {
        return $this->belongsTo(InvoiceType::class, 'invoice_type', 'id');
    }
    public function PurchasesInvoices()
    {
        return $this->hasMany(PurchaseInvoice::class, 'vendor_id');
    }
    /* End Relations */
}
