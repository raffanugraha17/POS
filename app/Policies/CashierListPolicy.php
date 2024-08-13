<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CashierList;
use Illuminate\Auth\Access\Response;
use Chiiya\FilamentAccessControl\Models\FilamentUser;

class CashierListPolicy
{
    // /**
    //  * Determine whether the user can view any models.
    //  */
    // public function viewAny(FilamentUser $user): bool
    // {
    //     return $user->can('cashierLists.viewAny');
    // }

    /**
     * Determine whether the user can view the model.
     */
    public function view(FilamentUser $user, CashierList $cashierList): bool
    {
        return $user->can('cashierLists.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(FilamentUser $user): bool
    {
        return $user->can('cashierLists.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(FilamentUser $user, CashierList $cashierList): bool
    {
        return $user->can('cashierLists.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(FilamentUser $user, CashierList $cashierList): bool
    {
        return $user->can('cashierLists.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(FilamentUser $user, CashierList $cashierList): bool
    {
        return $user->can('cashierLists.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(FilamentUser $user, CashierList $cashierList): bool
    {
        return $user->can('cashierLists.forceDelete');
    }
}
