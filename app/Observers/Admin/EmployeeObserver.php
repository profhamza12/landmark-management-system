<?php

namespace App\Observers\Admin;

use App\Models\Admin\Employee;

class EmployeeObserver
{
    /**
     * Handle the Employee "created" event.
     *
     * @param  \App\Models\Admin\Employee  $employee
     * @return void
     */
    public function created(Employee $employee)
    {
        //
    }

    /**
     * Handle the Employee "updated" event.
     *
     * @param  \App\Models\Admin\Employee  $employee
     * @return void
     */
    public function updated(Employee $employee)
    {
        //
    }

    /**
     * Handle the Employee "deleted" event.
     *
     * @param  \App\Models\Admin\Employee  $employee
     * @return void
     */
    public function deleted(Employee $employee)
    {
        // remove user photo
        $img_path = public_path() . '/images/admin/employees/' . $employee->photo;
        if (is_file($img_path))
        {
            unlink($img_path);
        }
    }

    /**
     * Handle the Employee "restored" event.
     *
     * @param  \App\Models\Admin\Employee  $employee
     * @return void
     */
    public function restored(Employee $employee)
    {
        //
    }

    /**
     * Handle the Employee "force deleted" event.
     *
     * @param  \App\Models\Admin\Employee  $employee
     * @return void
     */
    public function forceDeleted(Employee $employee)
    {
        //
    }
}
