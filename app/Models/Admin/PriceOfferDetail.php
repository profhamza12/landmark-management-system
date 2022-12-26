<?php

namespace App\Models\Admin;

use App\Observers\Admin\StoreObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class PriceOfferDetail extends Model
{
    use HasFactory;
    protected $table = "prices_offers_details";
    protected $fillable = ['price_offer_id', 'item_id'];
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
    public function PriceOffer()
    {
        return $this->belongsTo(PriceOffer::class, 'price_offer_id', 'id');
    }
    public function Item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }
    /* End Relations */
}
