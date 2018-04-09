<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/4/2
 * Time: 10:05
 * Function:
 */

namespace Tanmo\Admin\Controllers\System;


use Tanmo\Admin\Models\OperationLog;
use Tanmo\Search\Facades\Search;
use Tanmo\Search\Query\Searcher;

/**
 * @module 操作日志
 * Class LogController
 * @package Tanmo\Admin\Controllers\System
 */
class LogController
{
    /**
     * @permission 日志列表
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $searcher = Search::build(function (Searcher $searcher) {
            $searcher->like('user.name', 'name');
            $searcher->equal('method');
            $searcher->equal('ip');
        });

        $logs = (new OperationLog())->search($searcher)->orderBy('id', 'desc')->paginate(10);
        $header = '操作日志';
        $description = '列表';
        return view('admin::system.logs', compact('logs', 'header', 'description'));
    }
}