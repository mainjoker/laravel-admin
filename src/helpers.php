<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/3/23
 * Time: 16:36
 * Function:
 */

if (! function_exists('admin_asset')) {
    /**
     * @param $path
     * @return string
     */
    function admin_asset($path) {
        $prefix = 'vendor/laravel-admin/';
        return asset($prefix . ltrim($path, '/'), config('admin.secure'));
    }
}

if (! function_exists('admin_toastr')) {

    /**
     * Flash a toastr message bag to session.
     *
     * @param string $message
     * @param string $type
     * @param array  $options
     */
    function admin_toastr($message = '', $type = 'success', $options = [])
    {
        $toastr = new \Illuminate\Support\MessageBag(get_defined_vars());

        \Illuminate\Support\Facades\Session::flash('toastr', $toastr);
    }
}

if (!function_exists('admin_path')) {

    /**
     * Get admin path.
     *
     * @param string $path
     *
     * @return string
     */
    function admin_path($path = '')
    {
        return ucfirst(config('admin.directory')).($path ? DIRECTORY_SEPARATOR.$path : $path);
    }
}