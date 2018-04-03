<?php

namespace Tanmo\Admin\Controllers;

use Tanmo\Admin\Traits\AdminAuth;
use App\Http\Controllers\Controller;

/**
 * @module 主界面
 * Class WelcomeController
 * @package App\Http\Controllers\Admin
 */
class MainController extends Controller
{
    use AdminAuth;

    /**
     * @permission 欢迎页
     * @level public
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $envs = [
            ['name' => 'PHP version',       'value' => 'PHP/'.PHP_VERSION],
            ['name' => 'Laravel version',   'value' => app()->version()],
            ['name' => 'CGI',               'value' => php_sapi_name()],
            ['name' => 'Uname',             'value' => php_uname()],
            ['name' => 'Server',            'value' => array_get($_SERVER, 'SERVER_SOFTWARE')],

            ['name' => 'Cache driver',      'value' => config('cache.default')],
            ['name' => 'Session driver',    'value' => config('session.driver')],
            ['name' => 'Queue driver',      'value' => config('queue.default')],

            ['name' => 'Timezone',          'value' => config('app.timezone')],
            ['name' => 'Locale',            'value' => config('app.locale')],
            ['name' => 'Env',               'value' => config('app.env')],
            ['name' => 'URL',               'value' => config('app.url')],
        ];

        $header = '欢迎回来';

        return view('admin::welcome', compact('envs', 'header'));
    }
}
