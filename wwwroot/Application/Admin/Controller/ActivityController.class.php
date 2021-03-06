<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/6 0006
 * Time: 13:12
 */

namespace Admin\Controller;
class ActivityController extends AdminController
{
    public function index(){
        $all_act = M('Actsign'); // 实例化User对象
        $map['status']  = array('neq',-1);
        $count      = $all_act->where($map)->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,2);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出
// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $all_act->where($map)->order('sign_time')->limit($Page->firstRow.','.$Page->listRows)->select();
        $data=[];
        foreach ($list as $k=>$v){
            $data[$k]=M('Document')->where(['id'=>$v['act_id']])->field('title,description,deadline')->find();
            $data[$k][]=M('Member')->where(['uid'=>$v['uid']])->field('nickname')->find();
            $data[$k][]=$v['id'];
            $data[$k][]=$v['status'];
            $data[$k][]=$v['sign_time'];
        }
        $this->assign('list',$data);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出
        $this->display(); // 输出模板
    }
    public function edit(){
        $id=I('post.id');
        $act=I('post.act');
        $re=M('Actsign')->where(['id'=>$id])->setField('status',$act);
    }
}