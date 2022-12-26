<?php

namespace App\Observers\Admin;

use App\Models\Admin\ClientGroup;

class ClientGroupObserver
{
    /**
     * Handle the ClientGroup "created" event.
     *
     * @param  \App\Models\Admin\ClientGroup  $clientGroup
     * @return void
     */
    public function created(ClientGroup $clientGroup)
    {
        //
    }

    /**
     * Handle the ClientGroup "updated" event.
     *
     * @param  \App\Models\Admin\ClientGroup  $clientGroup
     * @return void
     */
    public function updated(ClientGroup $clientGroup)
    {
        //
    }

    /**
     * Handle the ClientGroup "deleted" event.
     *
     * @param  \App\Models\Admin\ClientGroup  $clientGroup
     * @return void
     */
    public function deleted(ClientGroup $clientGroup)
    {
    }

    /**
     * Handle the ClientGroup "restored" event.
     *
     * @param  \App\Models\Admin\ClientGroup  $clientGroup
     * @return void
     */
    public function restored(ClientGroup $clientGroup)
    {
        //
    }

    /**
     * Handle the ClientGroup "force deleted" event.
     *
     * @param  \App\Models\Admin\ClientGroup  $clientGroup
     * @return void
     */
    public function forceDeleted(ClientGroup $clientGroup)
    {
        //
    }
}
