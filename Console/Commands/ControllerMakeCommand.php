<?php

namespace Qianfangzhifeng\LaravelWechat\Console\Commands;

use Illuminate\Routing\Console\ControllerMakeCommand as Command;
use Illuminate\Support\Str;

/*
因为在框架中,就是laravel自带的 make:controller已经提供了项目的基本功能

自定功能只是对于其原有的功能进行一步改变和补充 -> 就可以采用继承的思想 ; 重写方法
 */
class ControllerMakeCommand extends Command
{

    protected $name = 'swechat-make:controller';

    protected $description = '组件中创建控制器的命令';

    protected $rootnamespace = "Qianfangzhifeng\LaravelWechat\\";

    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return app()->basePath().'\\vendor\qianfangzhifeng\laravel-wechat\\'.str_replace('\\', '/', $name).'.php';
    }

    public function rootNamespace()
    {
        return $this -> rootnamespace;
    }
}
