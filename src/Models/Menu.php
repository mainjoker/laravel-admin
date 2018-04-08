<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/3/19
 * Time: 9:50
 * Function:
 */

namespace Tanmo\Admin\Models;


use Illuminate\Database\Eloquent\Model;
use Tanmo\Admin\Traits\ModelTree;

class Menu extends Model
{
    use ModelTree;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['parent_id', 'order', 'title', 'icon', 'uri', 'permission_id'];

    /**
     * Menu constructor.
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        $connection = config('admin.database.connection') ?: config('database.default');

        $this->setConnection($connection);

        $this->setTable(config('admin.database.menu.table'));

        parent::__construct($attributes);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function permission()
    {
        return $this->hasOne(Permission::class, 'id', 'permission_id');
    }
}