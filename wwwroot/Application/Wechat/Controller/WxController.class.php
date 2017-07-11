<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/11 0011
 * Time: 9:32
 */

namespace Wechat\Controller;


use EasyWeChat\Foundation\Application;
use Think\Controller;

class WxController extends Controller
{
    public $app;
    public function _initialize(){
        vendor("autoload");
        $options =C('WX_CONFIG');
        $this->app = new Application($options);
        $this->app;
    }
}