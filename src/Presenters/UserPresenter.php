<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/4/8
 * Time: 16:17
 * Function:
 */

namespace Tanmo\Admin\Presenters;


use Illuminate\Support\Collection;
use Tanmo\Admin\Models\Administrator;

class UserPresenter
{
    public function getStateLabel($state)
    {
        $color = array_get(Administrator::$stateColors, $state, 'grey');
        $word = $state == 1 ? '正常' : '锁定';

        return "<span class=\"badge bg-$color\">$word</span>";
    }

    public function getRolesLabel(Collection $roles)
    {
        $res = $roles->map(function ($role) {
            return "<span class='label label-primary'>$role</span>";
        })->implode('&nbsp;');

        return $res;
    }
}