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
        $permissions = $this->permissions->getAllPermissions();

        foreach ($permissions as $permission) {
            Permission::updateOrCreate([
                'controller' => $permission['controller'],
                'action' => $permission['action']
            ], [
                'module' => $permission['module'],
                'name' => $permission['name'],
                'method' => $permission['method'],
                'uri' => $permission['uri'],
                'controller' => $permission['controller'],
                'action' => $permission['action'],
                'route_name' => $permission['route_name']
            ]);

            $str = "导入或刷新权限 [{$permission['module']}] - [{$permission['name']}]";
            $this->flusher->output($str);
        }

        return $this->flusher->end();
    }
}