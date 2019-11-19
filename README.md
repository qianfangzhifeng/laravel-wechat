<h1 align="center"> laravel-wechat </h1>

<p align="center"> this is a laravel wechat.</p>


## 描述

这是基于laravel框架编辑的,微信公众号的组件

## 安装

```shell
$ composer require qianfangzhifeng/laravel-wechat
```


## 配置文件发布

```shell
php artisan vendor:publish --provider="Qianfangzhifeng\LaravelWechat\Providers\WechatServiceProvider"
```

## 配置

Laravel 应用
在 config/app.php 注册 ServiceProvider 和 Facade (Laravel 5.5 无需手动注册)
```
'providers' => [
    // ...
    Qianfangzhifeng\LaravelWechat\Providers\WechatServiceProvider::class,
]
```
然后在浏览器中访问的路由如下 http://localhost/swechat/wechat
```
Route::prefix('wechat')->group(function () {
		Route::any('/','WechatController@index')-> middleware('swechat.check');
});
```