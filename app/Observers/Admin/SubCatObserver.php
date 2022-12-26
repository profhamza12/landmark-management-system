<?php

namespace App\Observers\Admin;

use App\Models\Admin\SubCategory;

class SubCatObserver
{
    /**
     * Handle the SubCategory "created" event.
     *
     * @param  \App\Models\Admin\SubCategory  $subCategory
     * @return void
     */
    public function created(SubCategory $subCategory)
    {
        //
    }

    /**
     * Handle the SubCategory "updated" event.
     *
     * @param  \App\Models\Admin\SubCategory  $subCategory
     * @return void
     */
    public function updated(SubCategory $subCategory)
    {
    }

    /**
     * Handle the SubCategory "deleted" event.
     *
     * @param  \App\Models\Admin\SubCategory  $subCategory
     * @return void
     */
    public function deleted(SubCategory $subCategory)
    {
        // remove subCategory photo
        $img_path = public_path() . '/images/admin/sub-categories/' . $subCategory->photo;
        if (is_file($img_path))
        {
            unlink($img_path);
        }
        // remove descendants of subCategory
        if (count($subCategory->descendants) > 0)
        {
            foreach ($subCategory->descendants as $subCat)
            {
                $subCat->delete();
                $img_path = public_path() . '/images/admin/sub-categories/' . $subCat->photo;
                if (is_file($img_path))
                {
                    unlink($img_path);
                }
            }
        }
    }

    /**
     * Handle the SubCategory "restored" event.
     *
     * @param  \App\Models\Admin\SubCategory  $subCategory
     * @return void
     */
    public function restored(SubCategory $subCategory)
    {
        //
    }

    /**
     * Handle the SubCategory "force deleted" event.
     *
     * @param  \App\Models\Admin\SubCategory  $subCategory
     * @return void
     */
    public function forceDeleted(SubCategory $subCategory)
    {
        //
    }
}
