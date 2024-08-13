<?php

namespace App\Policies;

use App\Models\User;
use App\Models\PaymentMethod;
use Illuminate\Auth\Access\Response;
use Chiiya\FilamentAccessControl\Models\FilamentUser;

class PaymentMethodPolicy
{
    // /**
    //  * Determine whether the user can view any models.
    //  */
    // public function viewAny(FilamentUser $user): bool
    // {
    //     return $user->can('paymentMethods.viewAny');
    // }

    // /**
    //  * Determine whether the user can view the model.
    //  */
    public function view(FilamentUser $user, PaymentMethod $paymentMethod): bool
    {
        return $user->can('paymentMethods.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(FilamentUser $user): bool
    {
        return $user->can('paymentMethods.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(FilamentUser $user, PaymentMethod $paymentMethod): bool
    {
        return $user->can('paymentMethods.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(FilamentUser $user, PaymentMethod $paymentMethod): bool
    {
        return $user->can('paymentMethods.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(FilamentUser $user, PaymentMethod $paymentMethod): bool
    {
        return $user->can('paymentMethods.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(FilamentUser $user, PaymentMethod $paymentMethod): bool
    {
        return $user->can('paymentMethods.forceDelete');
    }
}
