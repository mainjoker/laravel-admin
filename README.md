# tanmo/laravel-admin

基于PHP反射的权限控制的系统管理后台，由 [`encore/laravel-admin`](https://github.com/z-song/laravel-admin) 包精简及修改

安装
---

> 当前版本(1.0.0)需要安装PHP 7+和Laravel 5.5+

首先确保安装好了 `laravel 5.5` 以上的版本，并且数据库连接设置正确。

```
composer require tanmo/laravel-admin
```

然后运行下面的命令来发布资源：

```
php artisan vendor:publish --provider="Tanmo\Admin\AdminServiceProvider"
```

运行下面的命令完成安装：

```
php artisan admin:install
```

访问后台： `http://youdomain.com/admin`
默认用户： `admin`
默认密码： `admin`