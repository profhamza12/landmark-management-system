<?php

namespace App\Models\Admin;

use App\Observers\Admin\ClientGroupObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class ClientGroup extends Model
{
    use HasFactory, HasTranslations;
    protected $table = "clients_groups";
    protected $fillable = ['name', 'display_name', 'description', 'active', 'created_at', 'updated_at'];
    public $translatable = ['display_name', 'description'];
    public $timestamps = true;

    public static function boot()
    {
        parent::boot();
        self::observe(ClientGroupObserver::class);
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
    public function clients()
    {
        return $this->hasMany(Client::class, 'group_id', 'id');
    }
    /* End Relations */
}
