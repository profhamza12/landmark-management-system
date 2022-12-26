<?php

namespace App\Observers\Admin;

use App\Models\Admin\Vendor;

class VendorObserver
{
    /**
     * Handle the Vendor "created" event.
     *
     * @param  \App\Models\Admin\Vendor  $vendor
     * @return void
     */
    public function created(Vendor $vendor)
    {
        //
    }

    /**
     * Handle the Vendor "updated" event.
     *
     * @param  \App\Models\Admin\Vendor  $vendor
     * @return void
     */
    public function updated(Vendor $vendor)
    {
        //
    }

    /**
     * Handle the Vendor "deleted" event.
     *
     * @param  \App\Models\Admin\Vendor  $vendor
     * @return void
     */
    public function deleted(Vendor $vendor)
    {
        // remove vendor photo
        $img_path = public_path() . '/images/admin/vendors/' . $vendor->photo;
        if (file_exists($img_path))
        {
            unlink($img_path);
        }
    }

    /**
     * Handle the Vendor "restored" event.
     *
     * @param  \App\Models\Admin\Vendor  $vendor
     * @return void
     */
    public function restored(Vendor $vendor)
    {
        //
    }

    /**
     * Handle the Vendor "force deleted" event.
     *
     * @param  \App\Models\Admin\Vendor  $vendor
     * @return void
     */
    public function forceDeleted(Vendor $vendor)
    {
        //
    }
}
