<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/7 0007
 * Time: 19:47
 */

namespace Wechat\Controller;


use Think\Controller;

class WechatController extends Controller
{
    public function index(){
        $this->display('index');
    }
    public function my(){
        if($this->login()){
            $this->display();
        }
    }
    public function sale(){
        $sale=M('Sale');
        $sale_list  = $sale->where('type=1')->field(true)->select();
        $ssale=M('Sale');
        $hire_list  = $ssale->where('type=0')->field(true)->select();
        $this->assign('sale_list',$sale_list);// 赋值数据集
        $this->assign('hire_list',$hire_list);// 赋值数据集
        $this->meta_title = '租售列表';
        $this->display('zushou');
//                $sale=M('Sale');
//                $sale_list  = $sale->field(true)->select();
//                $this->assign('sale_list',$sale_list);// 赋值数据集
//                $this->meta_title = '租售列表';
//                $this->display('zushou');

    }
    public function zdetail($id){
        $detail=M('Sale');
        $list  = $detail->where("id=$id")->field(true)->find();
        $this->assign('list',$list);// 赋值数据集
        $this->meta_title = '房屋信息';
        $this->display('zushou-detail');
    }
    public function notice(){
        $data = M('Document')->where(['category_id'=>40])->select();
        $this->assign('list',$data);
        $this->meta_title = '小区通知';
        $this->display();
    }
    public function ndetail($id){
        $data = M('Document  as  d')->join('`onethink_document_article` as a on d.id=a.id')->join('`onethink_member`  as  m  on d.uid = m.uid')->where(['d.id'=>$id])->find();
        $this->assign('list',$data);
        $this->display('notice-detail');
    }
    /* 用户登录检测 */
    protected function login(){
        /* 用户登录检测 */
        is_login() || $this->error('您还没有登录，请先登录！', U('User/login'));
    }
}