<?php

namespace App\Observers\Admin;

use App\Models\Admin\Item;

class ItemObserver
{
    /**
     * Handle the Item "created" event.
     *
     * @param  \App\Models\Admin\Item  $item
     * @return void
     */
    public function created(Item $item)
    {
        //
    }

    /**
     * Handle the Item "updated" event.
     *
     * @param  \App\Models\Admin\Item  $item
     * @return void
     */
    public function updated(Item $item)
    {
        //
    }

    /**
     * Handle the Item "deleted" event.
     *
     * @param  \App\Models\Admin\Item  $item
     * @return void
     */
    public function deleted(Item $item)
    {
        // remove item photo
        $img_path = public_path() . '/images/admin/items/' . $item->photo;
        if (is_file($img_path))
        {
            unlink($img_path);
        }
    }

    /**
     * Handle the Item "restored" event.
     *
     * @param  \App\Models\Admin\Item  $item
     * @return void
     */
    public function restored(Item $item)
    {
        //
    }

    /**
     * Handle the Item "force deleted" event.
     *
     * @param  \App\Models\Admin\Item  $item
     * @return void
     */
    public function forceDeleted(Item $item)
    {
        //
    }
}
