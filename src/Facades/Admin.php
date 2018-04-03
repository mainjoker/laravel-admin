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
 */
class Admin extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Tanmo\Admin\Admin::class;
    }
}
