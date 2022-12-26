<?php

namespace App\Models\Admin;

use App\Observers\Admin\StoreObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ReceivableEntryDetail extends Model
{
    use HasFactory;
    protected $table = "receivable_entries_details";
    protected $fillable = ['receivable_entry_id', 'item_id', 'unit_id', 'quantity'];
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
    public function ReceivableEntry()
    {
        return $this->belongsTo(ReceivableEntry::class, 'receivable_entry_id', 'id');
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
