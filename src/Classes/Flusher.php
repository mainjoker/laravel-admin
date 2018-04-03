<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/3/12
 * Time: 16:09
 * Function:
 */

namespace Tanmo\Admin\Classes;


use Tanmo\Admin\Contracts\Flushable;

class Flusher implements Flushable
{
    /**
     * @var
     */
    protected $usleep = 10000;

    /**
     * @param $microSeconds
     * @return $this
     */
    public function usleep($microSeconds)
    {
        $this->usleep = $microSeconds;

        return $this;
    }

    /**
     * Flush Data
     *
     * @param $msg
     */
    public function output($msg)
    {
        echo "<script>parent.displayMsg(\"{$msg}\");</script>";
        ob_flush();
        flush();
        usleep($this->usleep);
    }

    /**
     * End Flush
     */
    public function end()
    {
        return ob_end_flush();
    }
}