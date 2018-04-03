<?php

namespace Tanmo\Admin\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Tanmo\Admin\Models\Administrator;

class AdministratorPolicy
{
    use HandlesAuthorization;

    public function update(Administrator $currentUser, Administrator $user)
    {
        return $currentUser->isAdmin() || $currentUser->id == $user->id;
    }

    public function destroy(Administrator $currentUser, Administrator $user)
    {
        return $currentUser->isAdmin() && $currentUser->id != $user->id;
    }
}
