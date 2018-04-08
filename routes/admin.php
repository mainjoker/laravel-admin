<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/3/9
 * Time: 10:10
 * Function:
 */
Admin::registerAdminRoutes();

Route::group([
    'namespace' => 'App\Admin\Controllers',
    'prefix' => 'admin',
    'middleware' => ['web', 'admin']
], function () {
    Route::get('/', 'HomeController@index')->name('admin::main');
});
