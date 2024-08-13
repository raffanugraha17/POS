<?php

namespace App\Policies;

use App\Models\Bank;
use App\Models\User;
use Illuminate\Auth\Access\Response;
use Chiiya\FilamentAccessControl\Models\FilamentUser;

class BankPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    // public function viewAny(FilamentUser $user): bool
    // {
    //     return $user->can('banks.view');
    // }

    /**
     * Determine whether the user can view the model.
     */
    public function view(FilamentUser  $user, Bank $bank): bool
    {
        return $user->can('banks.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(FilamentUser  $user): bool
    {
        return $user->can('banks.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(FilamentUser  $user, Bank $bank): bool
    {
        return $user->can('banks.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(FilamentUser  $user, Bank $bank): bool
    {
        return $user->can('banks.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(FilamentUser  $user, Bank $bank): bool
    {
        return $user->can('banks.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(FilamentUser  $user, Bank $bank): bool
    {
        return $user->can('banks.forceDelete');
    }
}
