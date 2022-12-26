<?php

namespace App\Observers\Admin;

use App\Models\Admin\CompanyBranch;

class CompanyBranchObserver
{
    /**
     * Handle the CompanyBranch "created" event.
     *
     * @param  \App\Models\Admin\CompanyBranch  $companyBranch
     * @return void
     */
    public function created(CompanyBranch $companyBranch)
    {
        //
    }

    /**
     * Handle the CompanyBranch "updated" event.
     *
     * @param  \App\Models\Admin\CompanyBranch  $companyBranch
     * @return void
     */
    public function updated(CompanyBranch $companyBranch)
    {
        //
    }

    /**
     * Handle the CompanyBranch "deleted" event.
     *
     * @param  \App\Models\Admin\CompanyBranch  $companyBranch
     * @return void
     */
    public function deleted(CompanyBranch $companyBranch)
    {
        //
    }

    /**
     * Handle the CompanyBranch "restored" event.
     *
     * @param  \App\Models\Admin\CompanyBranch  $companyBranch
     * @return void
     */
    public function restored(CompanyBranch $companyBranch)
    {
        //
    }

    /**
     * Handle the CompanyBranch "force deleted" event.
     *
     * @param  \App\Models\Admin\CompanyBranch  $companyBranch
     * @return void
     */
    public function forceDeleted(CompanyBranch $companyBranch)
    {
        //
    }
}
