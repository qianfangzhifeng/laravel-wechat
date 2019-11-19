<?php

namespace Qianfangzhifeng\LaravelWechat\Providers;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class WechatServiceProvider extends ServiceProvider
{

    /**
     * 路由加载的命名空间
     * @var string
     */
    private $namespace = 'Qianfangzhifeng\LaravelWechat\Http\Controllers';
    /**
     * 分组中间件
     * @var array
     */
    private $middlewareGroups = [];
    /**
     * 路由中间件
     * @var array
     */
    private $routeMiddleware  = [
        'swechat.check'  => \Qianfangzhifeng\LaravelWechat\Http\Middleware\SwechatCheck::class,
    ];
    /**
     * 控制台命令
     * @var array
     */
    private $commands = [
        \Qianfangzhifeng\LaravelWechat\Console\Commands\ControllerMakeCommand::class
    ];



    public function register()
    {
        //合并配置文件
        $this -> mergeConfigFrom(
            __DIR__ . '/../Config/swechat.php', 'swechat'
        );
        //注册中间件
        $this -> registerRouteMiddleware();
        $this -> registerPubishing();
        $this -> commands($this -> commands);
    }

    public function boot()
    {
        //加载路由
        $this -> mapSwechatRoutes();
        //加载视图文件
        $this -> loadViewsFrom(
            __DIR__.'/../Resources/views', 'swechat'
        );
    }

    /**
     * 发布配置文件
     * php artisan vendor:publish --provider="Qianfangzhifeng\LaravelWechat\Providers\WechatServiceProvider"
     */
    private function registerPubishing(){
        //判断是不是控制台运行
        if ($this -> app -> runningInConsole()){
            $this -> publishes([__DIR__.'/../Config' => config_path()],'swechat');
        }
    }

    /**
     * 注册中间件
     */
    private function registerRouteMiddleware(){
        foreach ($this->middlewareGroups as $key => $middleware) {
            Route::middlewareGroup($key, $middleware);
        }
        foreach ($this->routeMiddleware as $key => $middleware) {
            Route::aliasMiddleware($key, $middleware);
        }
    }

    /**
     * 加载路由
     */
    private function mapSwechatRoutes()
    {
        Route::prefix('swechat')
            ->namespace($this->namespace)
            ->group(function (){
                $this->loadRoutesFrom(__DIR__.'/../Http/routes.php');
            });
    }
}
