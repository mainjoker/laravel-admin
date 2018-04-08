<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/3/9
 * Time: 17:09
 * Function:
 */

namespace Tanmo\Admin\Classes;


use Tanmo\Admin\Models\Permission;

class Importer
{
    /**
     * @var Permissions
     */
    protected $permissions;

    /**
     * @var Flusher
     */
    protected $flusher;

    /**
     * Import constructor.
     * @param Permissions $permissions
     * @param Flusher $flusher
     */
    public function __construct(Permissions $permissions, Flusher $flusher)
    {
        $this->permissions = $permissions;
        $this->flusher = $flusher;
    }

    /**
     *
     */
    public function handle()
    {
        $existAction = Permission::all()->pluck('action')->toArray();

        ///
        $scan = $this->permissions->getAllPermissions();
        $permissions = [];
        $actions = [];
        foreach ($scan as &$permission) {
            $action = implode('@', [$permission['controller'], $permission['action']]);
            $permissions[$action] = $permission;

            $actions[] = $action;
        }

        /// 删除权限
        $actionsToDel = array_diff($existAction, $actions);
        $this->deletePermissions($actionsToDel);


        /// 导入权限
        $this->importPermission($permissions);

        return $this->flusher->end();
    }

    /**
     * @param array $permissions
     */
    protected function importPermission(array $permissions)
    {
        foreach ($permissions as $action => $permission) {
            Permission::updateOrCreate([
                'action' => $action
            ], [
                'module' => $permission['module'],
                'name' => $permission['name'],
                'method' => $permission['method'],
                'uri' => $permission['uri'],
                'action' => $action,
                'route_name' => $permission['route_name']
            ]);

            $str = "导入或刷新权限 [{$permission['module']}] - [{$permission['name']}]";
            $this->flusher->output($str);
        }
    }

    /**
     * @param array $permissions
     */
    protected function deletePermissions(array $permissions)
    {
        foreach ($permissions as $item) {
            $permissionToDel = Permission::where('action', $item)->first();
            $permissionToDel->roles()->detach();
            $str = "删除权限 [{$permissionToDel['module']}] - [{$permissionToDel['name']}]";
            $permissionToDel->delete();

            $this->flusher->output($str);
        }
    }
}