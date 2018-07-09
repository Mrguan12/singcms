<?php
/**
 * Created by PhpStorm.
 * User: Miu
 * Date: 2018/7/3
 * Time: 19:16
 */
namespace Platformadmin\Controller;
use Home\Controller\CommonController;
use Think\Controller;

class LessorController extends CommonController{
    public function index()
    {
        $where['admin_identity'] = array(array('like','lessor'),array('like','tenant'),'or');
        $select_id = $_GET['select_id'];

        $sel = array('status' => 1);
        $condition = D('condition')->where($sel)->select();
        if($_GET['title']) {
            $data1 = trim($_GET['title']);

            $data = D('condition')->where(array('name' => $select_id))->find();
            $where[$data['sqlname']] = $_GET['title'];

            $this->assign('title', $data1);
        }



        $users = D('admin')->where($where)->select();

        $this->assign('users',$users);
        $this->assign('nav','用户列表');
        $this->assign('condition',$condition);

        $this->display();
    }

    public function delete(){
        $data['id'] = $_GET['id'] ? $_GET['id'] : '';
        if($data['id']){
            $users = D('admin');
            $sel = array(
                'admin_id' => $data['id']
            );
            $x = $users->where($sel)->find();
            if ($x['status'] == 1){
                $data['status'] = -1;
                $users->where($sel)->save($data);
            }
            else{
                $data['status'] = 1;
                $users->where($sel)->save($data);
            }

            if ($x > 0){
                echo "<script language=\"JavaScript\">alert(\"更改成功\");location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
            }
            else if($x == 0){
                echo "<script language=\"JavaScript\">alert(\"不存在此条数据\");location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
            }
            else{
                echo "<script language=\"JavaScript\">alert(\"更改失败\");location.href='".$_SERVER["HTTP_REFERER"]."';</script>";
            }
        }
    }

    public function personal() {
        $res = $this->getLoginUser();
        $user = D("Admin")->getAdminByAdminId($res['admin_id']);
        $this->assign('vo',$user);
        $this->display();
    }

    public function save() {
        $user = $this->getLoginUser();
        if(!$user) {
            return show(0,'用户不存在');
        }

        $data['realname'] = $_POST['realname'];
        $data['email'] = $_POST['email'];

        try {
            $id = D("Admin")->updateByAdminId($user['admin_id'], $data);
            if($id === false) {
                return show(0, '配置失败');
            }
            return show(1, '配置成功');
        }catch(Exception $e) {
            return show(0, $e->getMessage());
        }
    }
}