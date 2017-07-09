<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2017/7/6 0006
 * Time: 13:12
 */

namespace Admin\Controller;


use Think\Upload;

class SaleController extends AdminController
{
    public function index(){
        $all_sale = M('Sale'); // 实例化User对象
        $count      = $all_sale->count();// 查询满足要求的总记录数
        $Page       = new \Think\Page($count,2);// 实例化分页类 传入总记录数和每页显示的记录数(25)
        $show       = $Page->show();// 分页显示输出
// 进行分页数据查询 注意limit方法的参数要使用Page类的属性
        $list = $all_sale->order('create_time')->limit($Page->firstRow.','.$Page->listRows)->select();
        $this->assign('list',$list);// 赋值数据集
        $this->assign('page',$show);// 赋值分页输出
        $this->display(); // 输出模板
    }
    public function add(){
        if(IS_POST){
            $Model=M('Sale');
            $data=$Model->create();
            if($data){
                $id=$Model->add();
                if($id){
                    $this->success('新增成功', Cookie('__forward__'));
                }else{
                    $this->error('新增失败');
                }
            } else {
                $this->error($Model->getError());
            }
        }else{
            $this->meta_title = '新增租售';
            $this->display('edit');
        }
    }
    public function edit($id){
        if(IS_POST){
            $Model=D('Sale');
            $data=$Model->create();
            if($data){
                if($Model->save()!=false){
                    $this->success('修改成功', Cookie('__forward__'));
                }else{
                    $this->error('修改失败');
                }
            } else {
                $this->error($Model->getError());
            }
        }else{
            $info = D('Sale')->field(true)->find($id);
            $this->assign('info', $info);
            $this->meta_title = '修改租售';
            $this->display('edit');
        }
    }
    public function del(){
        $id = array_unique((array)I('id',0));//array_unique移除重复值
        if (empty($id) ) {
            $this->error('未选择删除的记录');
        }
        $map = array('id' => array('in', $id) );
        if(M('Sale')->where($map)->delete()){
            $this->success('删除成功');
        } else {
            $this->error('删除失败！');
        }
    }
    public function toogleHide(){

    }


    public function uploadify(){
        if (!empty($_FILES)) {
            import("@.Think.UploadFile");
            $upload = new \Think\Upload();
            $upload->rootPath  = './Uploads/upload/';//根路径
            $upload->savePath = date('Y').'/'.date('m').'/'.date('d').'/';//子路径，文件夹自动分级好点，不然文件太多了数量大了以后不好找图片
            $upload->exts = array('jpg', 'gif', 'png', 'jpeg', 'bmp', 'doc', 'xls', 'mp4', 'avi', 'docx', 'xlsx');//可以上传的文件类型
            $upload->autoSub = false;
            $upload->saveRule = uniqid; //上传规则，文件名会自动重新获取，这样保证文件不会被覆盖
            $info = $upload->upload();
            if(!$info){
                echo $this->error($upload->getError());//获取失败信息
            } else {
                //成功
                $fileArray = "";
                foreach ($info as $file) {
                    //返回文件在服务器上的路径
                    $fileArray = $upload->rootPath . $file['savepath'] . $file['savename'];
                }
                echo trim(substr($fileArray,1));
            }
        }
    }
}