<?php

namespace App\Observers\Admin;

use App\Models\Admin\User;

class UserObserver
{
    /**
     * Handle the User "created" event.
     *
     * @param  \App\Models\Admin\User  $user
     * @return void
     */
    public function created(User $user)
    {
        //
    }

    /**
     * Handle the User "updated" event.
     *
     * @param  \App\Models\Admin\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        //
    }

    /**
     * Handle the User "deleted" event.
     *
     * @param  \App\Models\Admin\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        // remove user photo
        $img_path = public_path() . '/images/admin/users/' . $user->photo;
        if (is_file($img_path))
        {
            unlink($img_path);
        }
    }

    /**
     * Handle the User "restored" event.
     *
     * @param  \App\Models\Admin\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the User "force deleted" event.
     *
     * @param  \App\Models\Admin\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
