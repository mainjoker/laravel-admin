<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/3/30
 * Time: 21:06
 * Function:
 */

namespace Tanmo\Admin\Policies;


use Illuminate\Auth\Access\HandlesAuthorization;
use Tanmo\Admin\Models\Administrator;
use Tanmo\Admin\Models\Role;

class RolePolicy
{
    use HandlesAuthorization;

    public function update(Administrator $user)
    {
        return $user->isAdmin();
    }

    public function destroy(Administrator $user, Role $role)
    {
        return $user->isAdmin() && $role->id != 1;
    }
}