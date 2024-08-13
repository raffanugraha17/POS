<?php

namespace App\Policies;

use App\Models\User;
use App\Models\CustomerList;
use Illuminate\Auth\Access\Response;
use Chiiya\FilamentAccessControl\Models\FilamentUser;

class CustomerListPolicy
{
    // /**
    //  * Determine whether the user can view any models.
    //  */
    // public function viewAny(FilamentUser $user): bool
    // {
    //     return $user->can('customerLists.viewAny');
    // }


    // /**
    //  * Determine whether the user can view the model.
    //  */
    public function view(FilamentUser $user, CustomerList $customerList): bool
    {
        return $user->can('customerLists.view');

    }

    /**
     * Determine whether the user can create models.
     */
    public function create(FilamentUser $user): bool
    {
        return $user->can('customerLists.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(FilamentUser $user, CustomerList $customerList): bool
    {
        return $user->can('customerLists.update');

    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(FilamentUser $user, CustomerList $customerList): bool
    {
        return $user->can('customerLists.delete');

    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(FilamentUser $user, CustomerList $customerList): bool
    {
        return $user->can('customerLists.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(FilamentUser $user, CustomerList $customerList): bool
    {
        return $user->can('customerLists.forceDelete');

    }
}
