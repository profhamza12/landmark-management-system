<?php

namespace App\Observers\Admin;

use App\Models\Admin\Role;

class RoleObserver
{
    /**
     * Handle the Role "created" event.
     *
     * @param  \App\Models\Admin\Role  $group
     * @return void
     */
    public function created(Role $group)
    {
        //
    }

    /**
     * Handle the Role "updated" event.
     *
     * @param  \App\Models\Admin\Role  $group
     * @return void
     */
    public function updated(Role $group)
    {
        //
    }

    /**
     * Handle the Role "deleted" event.
     *
     * @param  \App\Models\Admin\Role  $role
     * @return void
     */
    public function deleted(Role $role)
    {

    }

    /**
     * Handle the Role "restored" event.
     *
     * @param  \App\Models\Admin\Role  $group
     * @return void
     */
    public function restored(Role $group)
    {
        //
    }

    /**
     * Handle the Role "force deleted" event.
     *
     * @param  \App\Models\Admin\Role  $group
     * @return void
     */
    public function forceDeleted(Role $group)
    {
        //
    }
}
