<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/3/19
 * Time: 11:05
 * Function:
 */

namespace Tanmo\Admin\Controllers\System;
use Illuminate\Http\Request;
use Tanmo\Admin\Facades\Admin;
use Tanmo\Admin\Models\Menu;
use Tanmo\Admin\Models\Permission;


/**
 * @module 菜单管理
 * Class MenuController
 * @package App\Http\Controllers\Admin\System
 */
class MenuController
{
    /**
     * @permission 菜单列表
     * @return \Tanmo\Admin\Content
     */
    public function index()
    {
        view()->share([
            'editRoute' => 'admin::menu.edit',
            'keyName' => 'id',
            'branchView' => 'admin::widgets.branch',
            'id' => 'tree-' . uniqid(),
        ]);

        $header = '菜单管理';
        $description = '列表';

        return view('admin::system.menu', [
            'items' => Admin::menu(),
            'options' => Menu::selectOptions(),
            'permissions' => Permission::all(),
            'header' => $header,
            'description' => $description
        ]);
    }

    /**
     * @permission 创建菜单页面
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        $header = '菜单管理';
        $description = '创建';
        return view('admin::system.menu-create', [
            'options' => Menu::selectOptions(),
            'permissions' => Permission::all(),
            'header' => $header,
            'description' => $description
        ]);
    }

    /**
     * @permission 创建菜单
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store()
    {
        $data = request()->all(['parent_id', 'title', 'icon', 'permission_id']);
        $menu = Menu::create($data);

        if ($menu && !empty($data['permission_id'])) {
            $menu->uri = $menu->permission->uri;
            $menu->save();
        }

        admin_toastr('创建成功');

        return redirect()->route('admin::menu.index');
    }

    /**
     * @permission 修改菜单页面
     *
     * @param Menu $menu
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit(Menu $menu)
    {
        $header = '菜单管理';
        $description = '编辑';
        return view('admin::system.menu-edit', [
            'menu' => $menu,
            'options' => Menu::selectOptions(),
            'permissions' => Permission::all(),
            'header' => $header,
            'description' => $description
        ]);
    }

    /**
     * @permission 修改菜单
     *
     * @param Request $request
     * @param Menu $menu
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, Menu $menu)
    {
        $menu->parent_id = $request->get('parent_id');
        $menu->title = $request->get('title');
        $menu->icon = $request->get('icon');
        $menu->permission_id = $request->get('permission_id');

        if ($menu->permission_id == null) {
            $menu->uri = null;
        }

        $menu->save() ? admin_toastr('修改成功') : admin_toastr('修改失败', 'danger');

        return redirect()->route('admin::menu.index');
    }

    /**
     * @permission 删除菜单
     *
     * @param Menu $menu
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Menu $menu)
    {
        $menu->delete();

        return response()->json(['status' => 1, 'message' => '删除成功']);
    }

    /**
     * @permission 调整菜单顺序
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function order()
    {
        if (request()->ajax()) {
            $_order = request()->get('_order');
            $order = json_decode($_order, true);

            if (json_last_error() != JSON_ERROR_NONE) {
                throw new \InvalidArgumentException(json_last_error_msg());
            }

            Menu::saveOrder($order);
            return response()->json(['status' => 1, 'message' => 'success']);
        }

        return response()->json(['message' => '调整失败']);
    }
}