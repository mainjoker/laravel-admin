<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/3/16
 * Time: 23:37
 * Function:
 */

namespace Tanmo\Admin\Presenters;


class MethodPresenter
{
    public function getMethodsLabel($methods)
    {
        $methods = collect(explode('|', $methods))->map(function ($method) {
            return "<span class='label label-primary'>$method</span>";
        })->implode('&nbsp;');

        return $methods;
    }
}