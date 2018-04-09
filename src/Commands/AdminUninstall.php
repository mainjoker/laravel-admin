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
use Tanmo\Admin\Database\AdminTableSeeder;
use Tanmo\Admin\Models\Administrator;

class AdminUninstall extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'admin:uninstall';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uninstall the admin package';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if (!$this->confirm('Are you sure to uninstall laravel-admin?')) {
            return;
        }

        $this->line('Uninstalling tanmo/laravel-admin');

        $this->removeFilesAndDirectories();

        $this->line('<info>Uninstalled!</info>');
    }

    /**
     * Remove files and directories.
     *
     * @return void
     */
    protected function removeFilesAndDirectories()
    {
        $this->laravel['files']->deleteDirectory(config('admin.directory'));
        $this->laravel['files']->deleteDirectory(public_path('vendor/laravel-admin/'));
        $this->laravel['files']->deleteDirectory(resource_path('admin-views'));
        $this->laravel['files']->delete(config_path('admin.php'));
    }
}