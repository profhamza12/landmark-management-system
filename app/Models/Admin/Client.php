<?php

namespace App\Models\Admin;

use App\Observers\Admin\ClientObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Spatie\Translatable\HasTranslations;

class Client extends Model
{
    use HasFactory, Notifiable, HasTranslations;
    protected $table = "clients";
    protected $fillable = ['name', 'email', 'address', 'phone', 'governorate', 'position', 'gender', 'active', 'group_id', 'creditor_amount', 'debtor_amount', 'credit_limit', 'invoice_type', 'created_at', 'updated_at'];
    public $translatable = ['name', 'address', 'governorate', 'position'];
    public $timestamps = true;

    public static function boot()
    {
        parent::boot();
        self::observe(ClientObserver::class);
    }

    /* Start Scopes */
    public function scopeSelection($query)
    {
        return $query->select("id", 'name', 'email', 'address', 'phone', 'governorate', 'position', 'gender', 'active', 'group_id', 'creditor_amount', 'debtor_amount', 'credit_limit', 'invoice_type', 'created_at', 'updated_at');
    }
    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }
    /* End Scopes */

    /* Start Accessors and Mutators */
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
    public function group()
    {
        return $this->belongsTo(ClientGroup::class, 'group_id', 'id');
    }
    public function InvoiceType()
    {
        return $this->belongsTo(InvoiceType::class, 'invoice_type', 'id');
    }
    public function SalesInvoices()
    {
        return $this->hasMany(SalesInvoice::class, 'client_id');
    }
    /* End Relations */

}
