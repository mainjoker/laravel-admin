<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/4/8
 * Time: 17:17
 * Function:
 */

namespace Tanmo\Admin\Middleware;

use Closure;

class Bootstrap
{
    /**
     * @param $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (file_exists($bootstrap = admin_path('bootstrap.php'))) {
            require $bootstrap;
        }

        return $next($request);
    }
}