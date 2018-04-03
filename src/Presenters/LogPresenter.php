<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/4/2
 * Time: 10:12
 * Function:
 */

namespace Tanmo\Admin\Presenters;


use Tanmo\Admin\Models\OperationLog;

class LogPresenter
{
    public function getMethod($method)
    {
        $color = array_get(OperationLog::$methodColors, $method, 'grey');

        return "<span class=\"badge bg-$color\">$method</span>";
    }

    public function getInput($input)
    {
        $input = json_decode($input, true);
        $input = array_except($input, ['_pjax', '_token', '_method', '_previous_']);
        if (empty($input)) {
            return '<code>{}</code>';
        }

        return '<pre>'.json_encode($input, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE).'</pre>';
    }
}