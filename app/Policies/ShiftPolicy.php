<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Shift;
use Illuminate\Auth\Access\Response;
use Chiiya\FilamentAccessControl\Models\FilamentUser;

class ShiftPolicy
{
    // /**
    //  * Determine whether the user can view any models.
    //  */
    // public function viewAny(FilamentUser $user): bool
    // {
    //     return $user->can('shifts.viewAny');
    // }


    // /**
    //  * Determine whether the user can view the model.
    //  */
    public function view(FilamentUser $user, Shift $shift): bool
    {
        return $user->can('shifts.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(FilamentUser $user): bool
    {
        return $user->can('shifts.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(FilamentUser $user, Shift $shift): bool
    {
        return $user->can('shifts.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(FilamentUser $user, Shift $shift): bool
    {
        return $user->can('shifts.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(FilamentUser $user, Shift $shift): bool
    {
        return $user->can('shifts.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(FilamentUser $user, Shift $shift): bool
    {
        return $user->can('shifts.forceDelete');
    }
}
