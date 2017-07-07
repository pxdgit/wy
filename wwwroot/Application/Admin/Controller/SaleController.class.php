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
        $all_sale=M('Sale')->field(true)->select();
        $this->assign('list',$all_sale);
        Cookie('__forward__',$_SERVER['REQUEST_URI']);
        $this->meta_title = '租售列表';
        $this->display();
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
                echo trim($fileArray);
            }
        }
    }
}