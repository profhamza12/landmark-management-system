<?php

namespace App\Observers\Admin;

use App\Models\Admin\Permission;

class PermissionObserver
{
    /**
     * Handle the Permission "created" event.
     *
     * @param  \App\Models\Admin\Permission  $permission
     * @return void
     */
    public function created(Permission $permission)
    {
        //
    }

    /**
     * Handle the Permission "updated" event.
     *
     * @param  \App\Models\Admin\Permission  $permission
     * @return void
     */
    public function updated(Permission $permission)
    {
        //
    }

    /**
     * Handle the Permission "deleted" event.
     *
     * @param  \App\Models\Admin\Permission  $permission
     * @return void
     */
    public function deleted(Permission $permission)
    {
    }

    /**
     * Handle the Permission "restored" event.
     *
     * @param  \App\Models\Admin\Permission  $permission
     * @return void
     */
    public function restored(Permission $permission)
    {
        //
    }

    /**
     * Handle the Permission "force deleted" event.
     *
     * @param  \App\Models\Admin\Permission  $permission
     * @return void
     */
    public function forceDeleted(Permission $permission)
    {
        //
    }
}
