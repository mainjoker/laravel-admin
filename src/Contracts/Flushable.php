<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/3/12
 * Time: 16:10
 * Function:
 */
namespace Tanmo\Admin\Contracts;

interface Flushable
{
    public function output($msg);
    public function end();
}