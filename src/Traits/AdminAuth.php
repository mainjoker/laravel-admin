<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/3/2
 * Time: 17:20
 * Function:
 */
namespace Tanmo\Admin\Traits;

use Illuminate\Support\Facades\Auth;
use Tanmo\Admin\Models\Administrator;

trait AdminAuth
{
    public function guard()
    {
        return Auth::guard('admin');
    }

    /**
     * @return \Tanmo\Admin\Models\Administrator
     */
    public function user() : Administrator
    {
        return $this->guard()->user();
    }
}