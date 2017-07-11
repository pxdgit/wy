<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/8 0008
 * Time: 14:41
 */

namespace Wechat\Controller;


class WmenuController extends  WxController
{
    public function index(){
    }
    public function echostr(){
        echo $_GET['echostr'];
    }
    public function create(){
        $response = $this->app->server->serve();
// 将响应输出
        $response->send(); // Laravel 里请使用：return $response;
        $menu = $this->app->menu;
        $buttons = [
            [
                "type" => "click",
                "name" => "首页",
                "key"  => "index"
            ],
            [
                "type" => "click",
                "name" => "服务",
                "key"  => "server"
            ],
            [
                "type" => "click",
                "name" => "我的",
                "key"  => "mine"
            ],
        ];
        $menu->add($buttons);
        echo '菜单设置成功';
    }
    public function getAll(){
        $menu = $this->app->menu;
        var_dump($menu->all());
    }
}