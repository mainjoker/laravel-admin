<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/3/30
 * Time: 15:42
 * Function:
 */

namespace Tanmo\Admin\Controllers;


use App\Http\Controllers\Controller;
use Tanmo\Admin\Requests\AdministratorRequest;
use Tanmo\Admin\Traits\AdminAuth;

/**
 * @module 个人中心
 *
 * Class ProfileController
 * @package App\Http\Controllers\Admin
 */
class ProfileController extends Controller
{
    use AdminAuth;

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('admin::profile', ['user' => $this->user()]);
    }

    /**
     * @param AdministratorRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AdministratorRequest $request)
    {
        $user = $this->user();
        $user->username = $request->username;
        $user->name = $request->name;

        if ($user->password != '' && $user->password != $request->password) {
            $user->password = bcrypt($request->password);
        }

        if ($request->hasFile('avatar')) {
            $user->avatar = $request->file('avatar')->store('avatar', config('admin.upload.disk.avatar'));
        }

        $user->save() ? admin_toastr('修改成功') : admin_toastr('修改失败', 'danger');
        return redirect()->back();
    }
}