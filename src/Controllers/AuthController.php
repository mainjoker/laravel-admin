<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/3/2
 * Time: 17:58
 * Function:
 */

namespace Tanmo\Admin\Controllers;


use App\Http\Controllers\Controller;
use Tanmo\Admin\Facades\Admin;
use Tanmo\Admin\Traits\AdminAuth;
use Tanmo\Admin\Traits\AdminRedirect;
use Illuminate\Http\Request;

/**
 * @module 登录认证
 * Class AuthController
 * @package App\Http\Controllers\Administrator
 */
class AuthController extends Controller
{
    use AdminAuth, AdminRedirect;

    /**
     * AuthController constructor.
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * @permission 登录页
     * @level public
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function index()
    {
        if (! $this->guard()->check()) {
            return view('admin::login');
        }

        return $this->redirectToMain();
    }

    /**
     * @permission 登录
     * @level public
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;
        if ($this->guard()->attempt(['username' => $username, 'password' => $password])) {
            $permissions = Admin::user()->allPermissions();
            session()->put('permissions', $permissions);
            return $this->redirectToMain();
        }

        return $this->redirectToLogin();
    }

    /**
     * @permission 退出登录
     * @level public
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return $this->redirectToLogin();
    }
}