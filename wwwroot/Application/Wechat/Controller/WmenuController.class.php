<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/8 0008
 * Time: 14:41
 */

namespace Wechat\Controller;

use EasyWeChat\Foundation\Application;
use Think\Controller;

class WmenuController extends  Controller
{
    public function create(){
        vendor("autoload");
        $options = [
            'debug'  => true,
            'app_id' => 'wxee66b44dd891e157',
            'secret' => 'cc001899a8861a3f19abc84d4d7ea65c',
            'token'  => 'qwert',
            // 'aes_key' => null, // 可选
            'log' => [
                'level' => 'debug',
                'file'  => ROOT_PATH.'/tmp/easywechat.log', // XXX: 绝对路径！！！！
            ],
            //...
        ];
        $app = new Application($options);
        $response = $app->server->serve();
// 将响应输出
        $response->send(); // Laravel 里请使用：return $response;

        $menu = $app->menu;
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

    }
}