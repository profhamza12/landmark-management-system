<?php

namespace App\Observers\Admin;

use App\Models\Admin\Store;

class StoreObserver
{
    /**
     * Handle the Store "created" event.
     *
     * @param  \App\Models\Admin\Store  $store
     * @return void
     */
    public function created(Store $store)
    {
        //
    }

    /**
     * Handle the Store "updated" event.
     *
     * @param  \App\Models\Admin\Store  $store
     * @return void
     */
    public function updated(Store $store)
    {
        //
    }

    /**
     * Handle the Store "deleted" event.
     *
     * @param  \App\Models\Admin\Store  $store
     * @return void
     */
    public function deleted(Store $store)
    {
        //
    }

    /**
     * Handle the Store "restored" event.
     *
     * @param  \App\Models\Admin\Store  $store
     * @return void
     */
    public function restored(Store $store)
    {
        //
    }

    /**
     * Handle the Store "force deleted" event.
     *
     * @param  \App\Models\Admin\Store  $store
     * @return void
     */
    public function forceDeleted(Store $store)
    {
        //
    }
}
