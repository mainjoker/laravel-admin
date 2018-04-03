<?php

namespace Tanmo\Admin;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Tanmo\Admin\Models\Administrator;
use Tanmo\Admin\Models\Role;
use Tanmo\Admin\Policies\AdministratorPolicy;
use Tanmo\Admin\Policies\RolePolicy;

class AdminServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Administrator::class => AdministratorPolicy::class,
        Role::class => RolePolicy::class
    ];

    /**
     * @var array
     */
    protected $routeMiddleware = [
        'admin.auth' => \Tanmo\Admin\Middleware\Authenticate::class,
        'admin.pjax' => \Tanmo\Admin\Middleware\Pjax::class,
        'admin.check_permission' => \Tanmo\Admin\Middleware\CheckPermission::class,
        'admin.operation_log' => \Tanmo\Admin\Middleware\OperationLog::class
    ];

    /**
     * The application's route middleware groups.
     *
     * @var array
     */
    protected $middlewareGroups = [
        'admin' => [
            'admin.auth',
            'admin.pjax',
            'admin.operation_log'
        ],
    ];

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {

        $this->loadRoutesFrom(base_path('routes/admin.php'));
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'admin');

        if ($this->app->runningInConsole()) {
            $this->commands([
                \Tanmo\Admin\Commands\AdminCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
//        $this->mergeConfigFrom(
//            __DIR__ . '/Config/admin.php', 'admin'
//        );
        $this->bindRouteModel();

        $this->loadAdminAuthConfig();

        $this->registerRouteMiddleware();

        $this->registerPolicies();
    }

    /**
     * 绑定路由模型
     */
    public function bindRouteModel()
    {
        \Route::model('admin_user', Administrator::class);
    }

    /**
     * Setup auth configuration.
     *
     * @return void
     */
    protected function loadAdminAuthConfig()
    {
        config(array_dot(config('admin.auth', []), 'auth.'));
    }

    /**
     * Register the application's policies.
     *
     * @return void
     */
    protected function registerPolicies()
    {
        foreach ($this->policies as $key => $value) {
            Gate::policy($key, $value);
        }
    }

    /**
     * Register the route middleware.
     *
     * @return void
     */
    protected function registerRouteMiddleware()
    {
        // register route middleware.
        foreach ($this->routeMiddleware as $key => $middleware) {
            app('router')->aliasMiddleware($key, $middleware);
        }

        // register middleware group.
        foreach ($this->middlewareGroups as $key => $middleware) {
            app('router')->middlewareGroup($key, $middleware);
        }
    }
}
