<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/3/24
 * Time: 16:06
 * Function:
 */

namespace Tanmo\Admin\Controllers\System;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Tanmo\Admin\Models\Administrator;
use Tanmo\Admin\Models\Role;
use Tanmo\Admin\Requests\AdministratorRequest;
use Tanmo\Admin\Traits\AdminAuth;
use Tanmo\Search\Facades\Search;
use Tanmo\Search\Query\Searcher;


/**
 * @module 用户管理
 * Class UserController
 * @package App\Http\Controllers\Admin\System
 */
class UserController extends Controller
{
    use AdminAuth;

    /**
     * @permission 用户列表
     */
    public function index()
    {
        $searcher = Search::build(function (Searcher $searcher) {
            $searcher->like('username');
            $searcher->like('name');
            $searcher->equal('roles.name', 'role');
            $searcher->between('created_at');
        });

        $users = (new Administrator())->search($searcher)->paginate(10);
        $header = '用户管理';
        $description = '列表';
        return view('admin::system.users', compact('users', 'header', 'description'));
    }

    /**
     * @permission 创建用户页面
     */
    public function create()
    {
        $roles = Role::all();
        $header = '用户管理';
        $description = '创建';
        return view('admin::system.user-create', compact('roles', 'header', 'description'));
    }

    /**
     * @permission 创建用户
     *
     * @param AdministratorRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(AdministratorRequest $request)
    {
        $administrator = [
            'username' => $request->get('username'),
            'password' => bcrypt($request->get('password')),
            'name' => $request->get('name'),
            'avatar' => $this->getAvatar($request)
        ];
        $user = Administrator::create($administrator);

        if ($user) {
            $roleIds = array_filter($request->get('roles'));
            $user->roles()->sync($roleIds);
        }

        return redirect()->route('admin::users.index');
    }

    /**
     * @permission 修改用户页面
     *
     * @param Administrator $user
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Administrator $user)
    {
        $this->authorizeForUser($this->user(), 'update', $user);

        $roles = Role::all();
        $header = '用户管理';
        $description = '修改';
        return view('admin::system.user-edit', compact('roles', 'header', 'description', 'user'));
    }

    /**
     * @permission 修改用户
     *
     * @param Administrator $user
     * @param AdministratorRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Administrator $user, AdministratorRequest $request)
    {
        $user->username = $request->username;
        $user->name = $request->name;

        if ($user->password != '' && $user->password != $request->password) {
            $user->password = bcrypt($request->password);
        }

        if ($avatar = $this->getAvatar($request)) {
            $user->avatar = $avatar;
        }

        $roleIds = array_filter($request->get('roles'));
        if (!empty($roleIds)) {
            $user->roles()->sync($roleIds);
        }

        $user->save() ? admin_toastr('修改成功') : admin_toastr('修改失败', 'danger');

        return redirect()->route('admin::users.index');
    }

    /**
     * @permission 删除用户
     * @param Administrator $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Administrator $user)
    {
        $user->roles()->detach();
        $user->delete();
        return response()->json(['status' => 1, 'message' => '成功']);
    }

    /**
     * @param Request $request
     * @return false|null|string
     */
    protected function getAvatar(Request $request)
    {
        if ($request->hasFile('avatar')) {
            return $avatar = $request->file('avatar')->store('avatar', config('admin.upload.disk.avatar'));
        }

        return null;
    }
}