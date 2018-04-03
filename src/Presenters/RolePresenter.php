<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/3/24
 * Time: 16:23
 * Function:
 */

namespace Tanmo\Admin\Presenters;


use Illuminate\Support\Collection;

class RolePresenter
{
    public function getRolesLabel(Collection $roles)
    {
        $res = $roles->map(function ($role) {
            return "<span class='label label-primary'>$role</span>";
        })->implode('&nbsp;');

        return $res;
    }
}