<?php

namespace App\Observers\Admin;

use App\Models\Admin\MainCategory;

class MainCatObserver
{
    /**
     * Handle the MainCategory "created" event.
     *
     * @param  \App\Models\Admin\MainCategory  $mainCategory
     * @return void
     */
    public function created(MainCategory $mainCategory)
    {
        //
    }

    /**
     * Handle the MainCategory "updated" event.
     *
     * @param  \App\Models\Admin\MainCategory  $mainCategory
     * @return void
     */
    public function updated(MainCategory $mainCategory)
    {
        //
    }

    /**
     * Handle the MainCategory "deleted" event.
     *
     * @param  \App\Models\Admin\MainCategory  $mainCategory
     * @return void
     */
    public function deleted(MainCategory $mainCategory)
    {
        // remove main category photo
        $img_path = public_path() . '/images/admin/main-categories/' . $mainCategory->photo;
        if (is_file($img_path))
        {
            unlink($img_path);
        }
    }

    /**
     * Handle the MainCategory "restored" event.
     *
     * @param  \App\Models\Admin\MainCategory  $mainCategory
     * @return void
     */
    public function restored(MainCategory $mainCategory)
    {
        //
    }

    /**
     * Handle the MainCategory "force deleted" event.
     *
     * @param  \App\Models\Admin\MainCategory  $mainCategory
     * @return void
     */
    public function forceDeleted(MainCategory $mainCategory)
    {
        //
    }
}
