<?php

namespace App\Models\Admin;

use App\Observers\Admin\ClientGroupObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class InvoiceType extends Model
{
    use HasFactory, HasTranslations;
    protected $table = "invoice_types";
    protected $fillable = ['name', 'display_name', 'description', 'active', 'created_at', 'updated_at'];
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
    public function clients()
    {
        return $this->hasMany(Client::class, 'invoice_type', 'id');
    }
    /* End Relations */
}
