<?php

namespace Tanmo\Admin\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Administrator.
 *
 * @method static string title()
 * @method static \Tanmo\Admin\Models\Administrator|null user()
 * @method static array menu()
 * @method static void registerAdminRoutes()
 * @method static \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void js($js = null)
 * @method static \Illuminate\Contracts\View\Factory|\Illuminate\View\View|void css($css = null)
 */
class Admin extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Tanmo\Admin\Admin::class;
    }
}
