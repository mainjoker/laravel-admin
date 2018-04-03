<?php
/**
 * Created by PhpStorm.
 * User: Hong
 * Date: 2018/3/9
 * Time: 10:58
 * Function:
 */

namespace Tanmo\Admin\Classes;


use Illuminate\Routing\Route;
use Illuminate\Routing\Router;

class Permissions
{
    /**
     * @var \Illuminate\Routing\RouteCollection
     */
    protected $routes;

    /**
     * @var string
     */
    protected $filterNamespace;

    /**
     * @var string
     */
    protected $moduleTag;

    /**
     * @var string
     */
    protected $permissionTag;

    /**
     * PermissionController constructor.
     * @param Router $router
     */
    public function __construct(Router $router)
    {
        $this->routes = $router->getRoutes();
        $this->filterNamespace = config('admin.namespace');
        $this->moduleTag = '@module';
        $this->permissionTag = '@permission';
    }

    /**
     * @return array
     */
    public function getAllPermissions()
    {
        $routes = $this->getRoutes();

        $res = [];
        foreach ($routes as &$route) {
            $ref = new \ReflectionClass($route['controller']);
            $classDoc = $ref->getDocComment();
            if ($classDoc != false && $module = $this->getModule($classDoc)) {
                if ($ref->hasMethod($route['action'])) {
                    $methodDoc = $ref->getMethod($route['action'])->getDocComment();
                    if ($methodDoc != false && ($name = $this->getPermission($methodDoc))) {
                        ///
                        $permission = $route;
                        $permission['module'] = $module;
                        $permission['name'] = $name;

                        ///
                        $res[] = $permission;
                    }
                }
            }
        }

        return $res;
    }

    /**
     * @param $doc
     * @return null|string
     */
    protected function getModule($doc)
    {
        return $this->getTag($doc, $this->moduleTag);
    }

    /**
     * @param $doc
     * @return null|string
     */
    protected function getPermission($doc)
    {
        return $this->getTag($doc, $this->permissionTag);
    }

    /**
     * @param $doc
     * @return null|string
     */
    protected function getLevel($doc)
    {
        return $this->getTag($doc, $this->levelTag);
    }

    /**
     * @return array
     */
    protected function getRoutes()
    {
        $routes = collect($this->routes)->filter(function (Route $route) {
            return starts_with($route->getActionName(), $this->filterNamespace);
        })->map(function (Route $route) {
            $item = [
                'method' => implode('|', $route->methods()),
                'uri'    => $route->uri(),
                'route_name'   => $route->getName(),
            ];

            $ac = $this->getControllerAndAction(ltrim($route->getActionName(), '\\'));

            return array_merge($item, $ac);
        })->all();

        return $routes;
    }

    /**
     * @param $actionName
     * @return array
     */
    protected function getControllerAndAction($actionName)
    {
        list($class, $action) = explode('@', $actionName);

        return ['controller' => $class, 'action' => $action];
    }

    /**
     * @param $str
     * @param string $tag
     * @return null|string
     */
    protected function getTag($str, $tag = '')
    {
        if (empty($tag))
            return null;

        //
        $matches = array();
        if (preg_match("/" . $tag . "(.*)(\\r\\n|\\r|\\n)/U", $str, $matches)) {
            return trim($matches[1]);
        }

        //
        return null;
    }
}