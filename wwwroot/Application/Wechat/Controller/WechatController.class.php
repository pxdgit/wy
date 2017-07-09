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
//        $this->login();
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
//小区通知
    public function notice(){
        if(IS_GET){
            $data = M('Document'); // 实例化User对象
            $data = $data->where(['category_id'=>40])->order('create_time')->limit(0,2)->select();
            $this->assign('list',$data);// 赋值数据集
            $this->assign('page',[0,2]);// 赋值分页输出
            $this->meta_title = '小区通知';
            $this->display(); // 输出模板
        }else{
            $start=I('post.start');
            $data = M('Document  as  d')->join('`onethink_picture` as p on d.cover_id=p.id')->where(['category_id'=>40])->order('d.create_time')->limit($start,2)->select();
            $this->ajaxReturn($data);
        }
    }
    public function nview(){
        $id=I('post.id');
        M('Document')->where(["id"=>$id])->setInc('view');
    }
    public function ndetail($id){
        $data = M('Document  as  d')->join('`onethink_document_article` as a on d.id=a.id')->join('`onethink_member`  as  m  on d.uid = m.uid')->where(['d.id'=>$id])->find();
        $this->assign('list',$data);
        $this->display('notice-detail');
    }
//便民服务
    public function service(){
        if(IS_GET){
            $data = M('Document'); // 实例化User对象
            $data = $data->where(['category_id'=>41])->order('create_time')->limit(0,2)->select();
            $this->assign('list',$data);// 赋值数据集
            $this->assign('page',[0,2]);// 赋值分页输出
            $this->meta_title = '便民服务';
            $this->display(); // 输出模板
        }else{
            $start=I('post.start');
            $data = M('Document  as  d')->join('`onethink_picture` as p on d.cover_id=p.id')->where(['category_id'=>41])->order('d.create_time')->limit($start,2)->select();
            $this->ajaxReturn($data);
        }
    }
    public function sview(){
        $id=I('post.id');
        M('Document')->where(["id"=>$id])->setInc('view');
    }
    public function sdetail($id){
        $data = M('Document  as  d')->join('`onethink_document_article` as a on d.id=a.id')->join('`onethink_member`  as  m  on d.uid = m.uid')->where(['d.id'=>$id])->find();
        $this->assign('list',$data);
        $this->display('service-detail');
    }
//商家活动
    public function shop(){
        if(IS_GET){
            $data = M('Document'); // 实例化User对象
            $data = $data->where(['category_id'=>42,'status'=>1])->order('create_time')->limit(0,2)->select();
            foreach ($data as $k=>$v){
                if($v['deadline']<time()){
                    $over = M('Document');
//                    $over->where(['id'=>$v['id']])->delete();
                   $over->where(["id"=>$v['id']])->setField('status',-1);
                    unset($data[$k]);
                }
            }
            $this->assign('list',$data);// 赋值数据集
            $this->assign('page',[0,2]);// 赋值分页输出
            $this->meta_title = '商家活动';
            $this->display(); // 输出模板
        }else{
            $start=I('post.start');
            $data = M('Document  as  d')->join('`onethink_picture` as p on d.cover_id=p.id')->where(['category_id'=>42,'d.status'=>1])->order('d.create_time')->limit($start,2)->select();
            $this->ajaxReturn($data);
        }
    }
    public function spview(){
        $id=I('post.id');
        M('Document')->where(["id"=>$id])->setInc('view');
    }
    public function spdetail($id){
        $data = M('Document  as  d')->join('`onethink_document_article` as a on d.id=a.id')->join('`onethink_member`  as  m  on d.uid = m.uid')->where(['d.id'=>$id])->find();
        $this->assign('list',$data);
        $this->display('shop-detail');
    }
//小区活动
    public function village(){
        if(IS_GET){
            $data = M('Document'); // 实例化User对象
            $data = $data->where(['category_id'=>43,'status'=>1])->order('create_time')->limit(0,2)->select();
            foreach ($data as $k=>$v){
                if($v['deadline']<time()){
                    $over = M('Document');
//                    $over->where(['id'=>$v['id']])->delete();
                    $over->where(["id"=>$v['id']])->setField('status',-1);
                    unset($data[$k]);
                }
            }
            $this->assign('list',$data);// 赋值数据集
            $this->assign('page',[0,2]);// 赋值分页输出
            $this->meta_title = '商家活动';
            $this->display(); // 输出模板
        }else{
            $start=I('post.start');
            $data = M('Document  as  d')->join('`onethink_picture` as p on d.cover_id=p.id')->where(['category_id'=>43,'d.status'=>1])->order('d.create_time')->limit($start,2)->select();
            $this->ajaxReturn($data);
        }
    }
    public function viview(){
        $id=I('post.id');
        M('Document')->where(["id"=>$id])->setInc('view');
    }
    public function videtail($id){
        $data = M('Document  as  d')->join('`onethink_document_article` as a on d.id=a.id')->join('`onethink_member`  as  m  on d.uid = m.uid')->where(['d.id'=>$id])->find();
        $this->assign('list',$data);
        $this->display('village-detail');
    }
    public function sign(){
        $id=I('post.id');
        if($uid=is_login()){
            $data=M('Actsign')->where(['act_id'=>$id,'uid'=>$uid])->find();
            if($data){
                $this->ajaxReturn('signed');
            }else{
               $data['act_id']=$id;
               $data['uid']=$uid;
               $data['sign_time']=time();
               M('Actsign')->add($data);
               $this->ajaxReturn('success');
            }
        }else{
            $this->ajaxReturn('false');
        }
    }
    /* 用户登录检测 */
    protected function login(){
        /* 用户登录检测 */
        if(is_login()){
            return 1;
        }else{
            $this->error('您还没有登录，请先登录！', U('User/login'));
        }
    }
}