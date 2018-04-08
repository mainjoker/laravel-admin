<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/3/17
 * Time: 15:15
 * Function:
 */

namespace Tanmo\Admin\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Tanmo\Search\Traits\Search;

class Role extends Model
{
    use Search;

    /**
     * @var array
     */
    protected $fillable = ['name', 'slug'];

    /**
     * Role constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('admin.database.role.table'));

        parent::__construct($attributes);
    }

    /**
     * @return BelongsToMany
     */
    public function admins() : BelongsToMany
    {
        return $this->belongsToMany(Administrator::class, 'admin_role_users', 'role_id', 'user_id');
    }

    /**
     * @return BelongsToMany
     */
    public function permissions() : BelongsToMany
    {
        return $this->belongsToMany(Permission::class, 'admin_role_permissions', 'role_id', 'permission_id');
    }
}