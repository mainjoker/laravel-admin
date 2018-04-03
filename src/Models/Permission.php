<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/3/9
 * Time: 14:40
 * Function:
 */

namespace Tanmo\Admin\Models;


use Illuminate\Database\Eloquent\Model;
use Tanmo\Search\Traits\Search;

class Permission extends Model
{
    use Search;

    protected $table = 'admin_permissions';

    protected $fillable = [
        'module', 'name', 'level', 'method', 'uri', 'controller', 'action', 'route_name'
    ];

    public function toPermissions()
    {
        $methods = explode('|', $this->method);

        $permissions = [];
        foreach ($methods as $method) {
            $permissions[$method] = $this->uri;
        }

        return $permissions;
    }
}