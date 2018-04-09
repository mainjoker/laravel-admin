<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/3/9
 * Time: 22:28
 * Function:
 */

namespace Tanmo\Admin;


use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class Admin
{
    /**
     * @var array
     */
    public static $css = [];

    /**
     * @var array
     */
    public static $js = [];

    /**
     * @return string
     */
    public function title()
    {
        return config('admin.title', '后台管理系统');
    }

    /**
     * @return \Tanmo\Admin\Models\Administrator|null
     */
    public function user()
    {
        return Auth::guard('admin')->user();
    }

    /**
     * @return array
     */
    public function menu()
    {
        return $this->user()->menu();
    }

    /**
     * @param null $css
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function css($css = null)
    {
        if (!is_null($css)) {
            self::$css = array_merge(self::$css, (array) $css);

            return;
        }

        return view('admin::partials.css', ['css' => array_unique(self::$css)]);
    }

    /**
     * @param null $js
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void
     */
    public function js($js = null)
    {
        if (!is_null($js)) {
            self::$js = array_merge(self::$js, (array) $js);

            return;
        }

        return view('admin::partials.js', ['js' => array_unique(static::$js)]);
    }

    /**
     * 注册管理后台路由
     */
    public function registerAdminRoutes()
    {
        Route::group([
            'prefix' => 'admin',
            'namespace' => 'Tanmo\Admin\Controllers',
            'middleware' => ['web'],
            'as' => 'admin::'
        ], function () {
            /// 游客权限
            Route::get('auth/login', 'AuthController@index')->name('login');
            Route::post('auth/login', 'AuthController@login')->name('login');
            Route::any('auth/logout', 'AuthController@logout')->name('logout');

            /// 登录权限
            Route::group(['middleware' => ['admin']], function () {
                Route::get('/profile', 'ProfileController@index')->name('profile');
                Route::put('/profile', 'ProfileController@update')->name('profile');

                /// 验证权限
                Route::group([
                    'middleware' => ['admin.check_permission']
                ], function () {
                    Route::group([
                        'prefix' => 'system',
                        'namespace' => 'System'
                    ], function () {
                        /// 权限
                        Route::get('/permissions', 'PermissionController@index')->name('permissions.index');
                        Route::any('/permissions/import', 'PermissionController@import')->name('permissions.import');

                        /// 菜单管理
                        Route::post('/menu/order', 'MenuController@order')->name('menu.order');
                        Route::resource('menu', 'MenuController')->except('show');

                        /// 角色管理
                        Route::resource('roles', 'RoleController')->except('show');

                        /// 用户管理
                        Route::resource('users', 'UserController')->parameter('users', 'admin_user')->except(['show']);

                        /// 操作日志
                        Route::get('/logs', 'LogController@index')->name('logs.index');
                    });
                });
            });
        });
    }
}