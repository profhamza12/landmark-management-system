<?php

namespace App\Models\Admin;

use App\Observers\Admin\StoreObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class PerishableDetail extends Model
{
    use HasFactory;
    protected $table = "perishables_details";
    protected $fillable = ['perishable_id', 'item_id', 'unit_id', 'quantity'];
    public $timestamps = false;

    /* Start Scopes */
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
    public function Perishable()
    {
        return $this->belongsTo(Perishable::class, 'perishable_id', 'id');
    }
    public function Item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }
    public function Unit()
    {
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }
    /* End Relations */
}
