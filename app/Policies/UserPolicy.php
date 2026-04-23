<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function managePrivilegedAccounts(User $user): bool
    {
        return $user->hasRole('super admin');
    }

    public function updatePrivilegedAccount(User $user, User $managedUser): bool
    {
        return $user->hasRole('super admin') && $managedUser->hasAnyRole(['admin', 'super admin', 'hr team']);
    }

    public function deletePrivilegedAccount(User $user, User $managedUser): bool
    {
        return $user->hasRole('super admin')
            && $managedUser->hasAnyRole(['admin', 'super admin', 'hr team'])
            && ! $user->is($managedUser);
    }
}
