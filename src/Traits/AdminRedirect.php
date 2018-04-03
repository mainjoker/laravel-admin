<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/3/4
 * Time: 10:31
 * Function:
 */

namespace Tanmo\Admin\Traits;


trait AdminRedirect
{
    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectToMain()
    {
        return $this->redirectTo('admin::main');
    }

    /**
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectToLogin()
    {
        return $this->redirectTo('admin::login');
    }

    /**
     * @param $route
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function redirectTo($route)
    {
        return redirect()->route($route);
    }
}