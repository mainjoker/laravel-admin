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
     * @var string
     */
    protected $table = 'admin_roles';

    /**
     * @var array
     */
    protected $fillable = ['name', 'slug'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
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