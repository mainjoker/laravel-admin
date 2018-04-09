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
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Tanmo\Search\Traits\Search;

class Permission extends Model
{
    use Search;

    /**
     * @var array
     */
    protected $fillable = [
        'module', 'name', 'level', 'method', 'uri', 'controller', 'action', 'route_name'
    ];

    /**
     * Permission constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('admin.database.permission.table'));

        parent::__construct($attributes);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles() : BelongsToMany
    {
        return $this->belongsToMany(Role::class, config('admin.database.role_permission.table'), 'permission_id', 'role_id');
    }

    /**
     * @return array
     */
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