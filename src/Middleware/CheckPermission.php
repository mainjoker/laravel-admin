<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/3/17
 * Time: 10:54
 * Function:
 */

namespace Tanmo\Admin\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\MessageBag;
use Tanmo\Admin\Facades\Admin;

class CheckPermission
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        $method = $request->method();
        $uri = $request->route()->uri();

        if (!$this->check($method, $uri)) {
            // TODO:验证后操作
            if ($request->ajax() && ! $request->pjax()) {
                return response()->json(['message' => '您没有权限操作']);
            }

            session()->flash('error', new MessageBag(['title' => 'No Permission', 'message' => '您没有权限访问该页面']));
            return redirect()->route('admin::main');
        }

        return $next($request);
    }

    /**
     * @param $method
     * @param $uri
     * @return bool
     */
    protected function check($method, $uri)
    {
        if (Admin::user()->isAdmin()) {
            return true;
        }

        ///
        $permissions = session('permissions');
        return isset($permissions[$method]) && in_array($uri, $permissions[$method]);
    }
}