<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/3/12
 * Time: 11:35
 * Function:
 */

namespace Tanmo\Admin\Controllers\System;


use App\Http\Controllers\AdminController;
use Tanmo\Admin\Classes\Importer;
use Tanmo\Admin\Models\Permission;
use Tanmo\Search\Facades\Search;
use Tanmo\Search\Query\Searcher;

/**
 * @module 权限管理
 *
 * Class PermissionController
 * @package App\Http\Controllers\Administrator\System
 */
class PermissionController extends AdminController
{
    /**
     * @var Importer
     */
    protected $importer;

    /**
     * PermissionController constructor.
     * @param Importer $importer
     */
    public function __construct(Importer $importer)
    {
        $this->importer = $importer;
    }

    /**
     * @permission 权限列表
     * @level auth
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $searcher = Search::build(function (Searcher $searcher) {
            $searcher->like('name');
            $searcher->like('module');
        });

        $permissions = (new Permission())->search($searcher)->paginate(10);
        $header = '权限管理';
        $description = '列表';
        return view('admin::system.permissions', compact('permissions', 'header', 'description'));
    }

    /**
     * @permission 导入权限
     * @level admin
     * @return bool|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function import()
    {
        if (request()->method() == 'GET')
            return view('admin::system.permissions_import', [
                'pageTitle' => '权限导入 - 后台管理',
                'header' => '权限管理',
                'description' => '导入'
            ]);

        if (request()->method() == 'POST') {
            $this->importer->handle();
            return '';
        }

        return response('Method Not Allowed', 403);
    }
}