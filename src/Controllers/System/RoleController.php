<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/3/24
 * Time: 15:33
 * Function:
 */

namespace Tanmo\Admin\Controllers\System;
use Tanmo\Admin\Models\Permission;
use Tanmo\Admin\Models\Role;
use Tanmo\Admin\Requests\RoleRequest;
use Tanmo\Search\Facades\Search;
use Tanmo\Search\Query\Searcher;


/**
 * @module 角色管理
 * Class RoleController
 * @package App\Http\Controllers\Admin\System
 */
class RoleController
{
    /**
     * @permission 角色列表
     */
    public function index()
    {
        $searcher = Search::build(function (Searcher $searcher) {
            $searcher->equal('slug');
            $searcher->like('name');
        });

        $roles = (new Role())->search($searcher)->paginate(10);
        $header = '角色管理';
        $description = '列表';
        return view('admin::system.roles', compact('roles', 'header', 'description'));
    }

    /**
     * @permission 创建角色页面
     */
    public function create()
    {
        $permissions = Permission::all();
        $header = '角色管理';
        $description = '创建';
        return view('admin::system.role-create', compact('permissions', 'header', 'description'));
    }

    /**
     * @permission 创建角色
     *
     * @param RoleRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(RoleRequest $request)
    {
        $data = [
            'slug' => $request->get('slug'),
            'name' => $request->get('name')
        ];

        $role = Role::create($data);

        if ($role) {
            $permissionIds = array_filter($request->get('permissions'));
            $role->permissions()->sync($permissionIds);
        }

        return redirect()->route('admin::roles.index');
    }

    public function edit(Role $role)
    {
        $permissions = Permission::all();
        $header = '角色管理';
        $description = '编辑';

        return view('admin::system.role-edit', compact('permissions', 'role', 'header', 'description'));
    }

    public function update(RoleRequest $request, Role $role)
    {
        $role->slug = $request->get('slug');
        $role->name = $request->get('name');

        $permissionIds = array_filter($request->get('permissions'));
        if (!empty($permissionIds)) {
            $role->permissions()->sync($permissionIds);
        }

        $role->save() ? admin_toastr('修改成功') : admin_toastr('修改失败', 'danger');

        return redirect()->route('admin::roles.index');
    }

    /**
     * @permission 删除角色
     *
     * @param Role $role
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Role $role)
    {
        $role->permissions()->detach();
        $role->admins()->detach();
        $role->delete();

        return response()->json(['status' => 1, 'message' => '成功']);
    }
}