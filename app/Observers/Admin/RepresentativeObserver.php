<?php

namespace App\Observers\Admin;

use App\Models\Admin\Employee;

class RepresentativeObserver
{
    /**
     * Handle the Employee "created" event.
     *
     * @param  \App\Models\Admin\Employee  $representative
     * @return void
     */
    public function created(Employee $representative)
    {
        //
    }

    /**
     * Handle the Employee "updated" event.
     *
     * @param  \App\Models\Admin\Employee  $representative
     * @return void
     */
    public function updated(Employee $representative)
    {
        //
    }

    /**
     * Handle the Employee "deleted" event.
     *
     * @param  \App\Models\Admin\Employee  $representative
     * @return void
     */
    public function deleted(Employee $representative)
    {
    }

    /**
     * Handle the Employee "restored" event.
     *
     * @param  \App\Models\Admin\Employee  $representative
     * @return void
     */
    public function restored(Employee $representative)
    {
        //
    }

    /**
     * Handle the Employee "force deleted" event.
     *
     * @param  \App\Models\Admin\Employee  $representative
     * @return void
     */
    public function forceDeleted(Employee $representative)
    {
        //
    }
}
