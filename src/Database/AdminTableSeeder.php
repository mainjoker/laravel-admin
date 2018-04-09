<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/4/9
 * Time: 10:20
 * Function:
 */

namespace Tanmo\Admin\Database;


use Illuminate\Database\Seeder;
use Tanmo\Admin\Models\Administrator;
use Tanmo\Admin\Models\Menu;
use Tanmo\Admin\Models\Role;

class AdminTableSeeder extends Seeder
{
    /**
     * 初始化数据
     */
    public function run()
    {
        // create a user.
        Administrator::truncate();
        Administrator::create([
            'username' => 'admin',
            'password' => bcrypt('admin'),
            'name'     => 'Administrator',
        ]);

        // create a role.
        Role::truncate();
        Role::create([
            'name' => '系统管理员',
            'slug' => 'administrator',
        ]);

        // add role to user.
        Administrator::first()->roles()->save(Role::first());

        // add default menus.
        Menu::truncate();
        Menu::insert([
            [
                'parent_id' => 0,
                'order'     => 1,
                'title'     => '首页',
                'icon'      => 'fa-link',
                'uri'       => 'admin',
            ],
            [
                'parent_id' => 0,
                'order'     => 2,
                'title'     => '系统管理',
                'icon'      => 'fa-cog',
                'uri'       => '',
            ],
            [
                'parent_id' => 2,
                'order'     => 3,
                'title'     => '用户管理',
                'icon'      => 'fa-users',
                'uri'       => 'admin/system/users',
            ],
            [
                'parent_id' => 2,
                'order'     => 4,
                'title'     => '角色管理',
                'icon'      => 'fa-user',
                'uri'       => 'admin/system/roles',
            ],
            [
                'parent_id' => 2,
                'order'     => 5,
                'title'     => '权限列表',
                'icon'      => 'fa-ban',
                'uri'       => 'admin/system/permissions',
            ],
            [
                'parent_id' => 2,
                'order'     => 6,
                'title'     => '菜单管理',
                'icon'      => 'fa-bars',
                'uri'       => 'admin/system/menu',
            ],
            [
                'parent_id' => 2,
                'order'     => 7,
                'title'     => '操作日志',
                'icon'      => 'fa-history',
                'uri'       => 'admin/system/logs',
            ]
        ]);
    }
}