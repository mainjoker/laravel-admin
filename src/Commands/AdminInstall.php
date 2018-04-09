<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/4/8
 * Time: 18:02
 * Function:
 */

namespace Tanmo\Admin\Commands;


use Illuminate\Console\Command;

class AdminInstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install the admin package';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->line('Installing tanmo/laravel-admin');
    }
}