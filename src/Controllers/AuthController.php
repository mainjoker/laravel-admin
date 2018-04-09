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
use Tanmo\Admin\Models\Administrator;
use Tanmo\Admin\Traits\AdminAuth;
use Tanmo\Admin\Traits\AdminRedirect;
use Illuminate\Http\Request;

/**
 * Class AuthController
 * @package Tanmo\Admin\Controllers
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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(Request $request)
    {
        $username = $request->username;
        $password = $request->password;
        $remember = $request->has('remember');
        if ($this->guard()->attempt(['username' => $username, 'password' => $password], $remember)) {
            if ($this->user()->state == Administrator::$STATE_LOCK) {
                $this->guard()->logout();
                session()->invalidate();
                return redirect()->back()->withErrors('该用户已被锁定');
            }

            $permissions = Admin::user()->allPermissions();
            session()->put('permissions', $permissions);
            return $this->redirectToMain();
        }
        else {
            redirect()->back()->withInput()->withErrors('用户名或密码错误');
        }

        return $this->redirectToLogin();
    }

    /**
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