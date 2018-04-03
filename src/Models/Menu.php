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
     * @var string
     */
    protected $table = 'admin_menu';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['parent_id', 'order', 'title', 'icon', 'uri', 'permission_id'];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function permission()
    {
        return $this->hasOne(Permission::class, 'id', 'permission_id');
    }
}